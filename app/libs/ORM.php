<?php 

namespace Knetwork\Libs;

if ($_SERVER['HTTP_HOST'] != "coffee-k6.herokuapp.com") {
    $dotenv = \Dotenv\Dotenv::createImmuTable("./");
    $dotenv->load();
}

abstract class ORM
{
    // Singleton
    private static $pdo = null;

    private static function getTableName(string $calledClass): string
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $table = explode("\\", $calledClass);
        return $table[array_key_last($table)];
    }

    protected static function connect(): \PDO
    {
        if (isset(self::$pdo)) {
            return self::$pdo;
        }

        $servername = "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8";
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        self::$pdo = new \PDO($servername, $username, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));

        return self::$pdo;
    }

    public static function insert(array $data, string $table = null): bool
    {
        $table ? $child = $table : $child = self::getTableName(get_called_class());

        // Préparation des données
        $keys = array_keys($data);
        $columns = join(",", $keys);

        $values = array_values($data);
        $datas = join("','", $values);

        // Création de la requête
        $sqlQuery = "INSERT INTO {$child}({$columns}) VALUES ('{$datas}')";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);

        return $req->execute();
    }

    public static function all(array $data): array
    {
        $child = self::getTableName(get_called_class());

        // Création de la requête
        $columns = join(",", $data);
        $sqlQuery = "SELECT {$columns} FROM {$child}";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute();

        // Instanciation des objets
        $objects = [];
        $child = get_called_class();
        foreach ($req->fetchAll() as $data) {
            array_push(
                $objects,
                new $child($data)
            );
        }

        return $objects;
    }

    public static function last(array $data, string $order, int $limit): array
    {
        $child = self::getTableName(get_called_class());

        // Création de la requête
        $columns = array_values($data);
        $columns = join(",", $columns);
        $sqlQuery = "SELECT {$columns} FROM {$child} ORDER BY {$order} DESC LIMIT {$limit}";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute();

        // Instanciation des objets
        $objects = [];
        $child = get_called_class();
        foreach ($req->fetchAll() as $result) {
            array_push(
                $objects,
                new $child($result)
            );
        }

        return $objects;
    }

    public static function findById(int $id, array $data): array 
    {
        $child = self::getTableName(get_called_class());

        // Création de la requête
        $columns = join(",", $data);
        $sqlQuery = "SELECT {$columns} FROM {$child} WHERE id = :id";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute(['id' => $id]);
        
        return $req->fetch();
    }

    public static function findAllById(int $id, array $data, string $table = null): array 
    {
        $table ? $child = $table : $child = self::getTableName(get_called_class());

        // Création de la requête
        $columns = join(",", $data);
        $sqlQuery = "SELECT {$columns} FROM {$child} WHERE id = :id";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute(['id' => $id]);
        
        return $req->fetchAll();
    }

    public static function updateById(int $id, array $data): bool
    {
        $child = self::getTableName(get_called_class());

        // Création de la requête
        // $column = join("", array_keys($data));
        // $value = join("", array_values($data));
        // $sqlQuery = "UPDATE $child SET $column = :value, updated_at = NOW() WHERE id = :id";
        $sqlQuery = "UPDATE $child SET ";
        foreach ($data as $key => $value) {
            $sqlQuery .= $key . "=:" . $key . ",";
        }
        $sqlQuery .= "updated_at = NOW() WHERE id = :id";
        $data['id'] = $id;

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        return $req->execute($data);
    }

    public static function exist(array $data): bool 
    {
        $child = self::getTableName(get_called_class());

        // Création de la requête
        $columns = join(", ", array_keys($data));
        // $value = join("", array_values($data));
        $sqlQuery = "SELECT {$columns} FROM {$child} WHERE ";
        // $sqlQuery = "SELECT ";
        foreach ($data as $key => $value) {
            $sqlQuery .= $key . "=:" . $key . " AND ";
        }
        $sqlQuery = substr($sqlQuery, !strlen($sqlQuery), -5);
        // $sqlQuery .= " FROM {$child} WHERE id = :id";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute($data);

        return empty($req->fetch()) ? false : true;
    }

    public static function getId(array $data): int
    {
        $child = self::getTableName(get_called_class());

        // Création de la requête
        $columns = array_keys($data);
        $sqlQuery = "SELECT id FROM $child WHERE $columns[0] = :value0";
        for ($i = 1; $i < count($columns); $i++) {
            $sqlQuery .= " && " . $columns[$i] . " = :value" . $i;
        }
        $values = array_values($data);
        $assoc = ['value0' => $values[0]];
        for ($i = 1; $i < count($values); $i++) {
            $assoc['value' . $i] = $values[$i];
        }

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute($assoc);

        return $req->fetch()['id'];
    }

    // public static function limit(int $limit): mixed
    // {
    //     // On récupère le nom de la classe appelante et on lui enlève son namespace
    //     $child = explode("\\", get_called_class());
    //     $child = $child[array_key_last($child)];

    //     // Création de la requête
    //     $sqlQuery = "SELECT id, name FROM $child LIMIT :limit";

    //     // Excécution de la requête
    //     $pdo = self::connect();
    //     $req = $pdo->prepare($sqlQuery);
    //     $req->execute(['limit' => $limit]);

    //     return new $child($req->fetch());
    // }

    public static function delete(int $id): bool
    {
        $child = self::getTableName(get_called_class());

        // Création de la requête
        $sqlQuery = "DELETE FROM $child WHERE id = :id";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        
        return $req->execute(['id' => $id]);
    }

    public static function count(string $table = null): int
    {
        $table ? $child = $table : $child = self::getTableName(get_called_class());

        // Création de la requête
        $sqlQuery = "SELECT COUNT(*) FROM {$child}";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute();
        
        return $req->fetch()[0];
    }

    public static function countBetween(string $column, string $value1, string $value2): int
    {
        $child = self::getTableName(get_called_class());

        // Création de la requête
        $sqlQuery = "SELECT COUNT(*) FROM {$child} WHERE {$column} BETWEEN '{$value1}' AND '{$value2}'";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute();
        
        return $req->fetch()[0];
    }

    public static function countWhere(string $column, mixed $value): int
    {
        $child = self::getTableName(get_called_class());

        // Création de la requête
        $sqlQuery = "SELECT COUNT(*) FROM {$child} WHERE {$column} = :value";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute([
            'value' => $value
        ]);

        return  $req->fetch()[0];
    }

    /**
     * Récupère le nombre de données créés en fonction des dates envoyées
     *
     * @param array $dates - Tableau de dates pour lesquelles on veut récupérer les statistiques
     * @return void
     */
    public static function chart(array $dates)
    {
        $data = [];
        $first = true;

        for ($i = 0; $i < count($dates); $i++) {
            if ($first) {
                $data[$dates[$i]] = self::countBetween('created_at', date('Y-m-d H:i:s', strtotime('2000-01-01')), date('Y-m-d H:i:s', strtotime($dates[$i])));
                $first = false;
            } else {
                $data[$dates[$i]] = self::countBetween('created_at', date('Y-m-d H:i:s', strtotime($dates[$i-1])),
                                    date('Y-m-d H:i:s', $i != 6 ? strtotime($dates[$i]) : time()));
            }
        }

        return $data;
    }
}
