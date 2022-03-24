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
        // Si on lui a passé le nom d'une table en paramètre
        if ($table) {
            $child = $table;
        } else {
            // On récupère le nom de la classe appelante et on lui enlève son namespace
            $child = explode("\\", get_called_class());
            $child = $child[array_key_last($child)];
        }

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
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

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
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

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

    public static function findById(int $id, array $data): mixed 
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

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
        if ($table) {
            $child = $table;
        } else {
            // On récupère le nom de la classe appelante et on lui enlève son namespace
            $child = explode("\\", get_called_class());
            $child = $child[array_key_last($child)];
        }

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
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

        // Création de la requête
        $column = join("", array_keys($data));
        $value = join("", array_values($data));
        $sqlQuery = "UPDATE $child SET $column = :value WHERE id = :id";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        return $req->execute(['value' => $value, 'id' => $id]);
    }

    public static function exist(array $data): bool 
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

        // Création de la requête
        $column = join("", array_keys($data));
        $value = join("", array_values($data));
        $sqlQuery = "SELECT $column FROM $child WHERE $column = :value";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute(['value' => $value]);

        return empty($req->fetch()) ? false : true;
    }

    public static function getId(array $data): int
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

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

    public static function limit(int $limit): mixed
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

        // Création de la requête
        $sqlQuery = "SELECT id, name FROM $child LIMIT :limit";

        // Excécution de la requête
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute(['id' => $limit]);

        return new $child($req->fetch());
    }
}
