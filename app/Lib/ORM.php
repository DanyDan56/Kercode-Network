<?php 

namespace Knetwork\Libs;

//TODO: changer l'url
if ($_SERVER['HTTP_HOST'] != "kercode-network.herokuapp.com") {
    $dotenv = \Dotenv\Dotenv::createImmuTable("./");
    $dotenv->load();
}

abstract class ORM
{
    // Singleton
    private static $pdo = null;

    #region MAIN

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
    #endregion

    /************************ CONSTRUCTEUR DE REQUËTES SIMPLES ********************************/

    #region CREATE

    /**
     * Enregistre les données dans la base de donnée.
     *
     * @param array $data Tableau associatif des données à enregistrer
     * @param string|null $table Nom de la table dans laquelle les données doivent être enregistrées
     * @return boolean Retourne true si l'enregistrement se passe bien; false sinon.
     */
    public static function insert(array $data, ?string $table = null): bool
    {
        $table ? $child = $table : $child = self::getTableName(get_called_class());

        // Mise en forme des données
        $columns = join(",", array_keys($data));
        $values = "";
        foreach(array_keys($data) as $value) {
            $values .= ':' . $value . ',';
        }
        // On supprime la dernière virgule
        $values = substr($values, !strlen($values), -1);

        $query = "INSERT INTO {$child}({$columns}) VALUES ({$values})";

        return self::executeSimple($query, $data);
    }
    #endregion

    #region READ
    
    public static function select(array $columns, ?string $table = null): string
    {
        $table ? $child = $table : $child = self::getTableName(get_called_class());

        $names = join(',', $columns);

        return "SELECT {$names} FROM {$child}";
    }

    public static function count(string $column, ?string $table = null): string
    {
        $table ? $child = $table : $child = self::getTableName(get_called_class());

        return "SELECT COUNT({$column}) FROM {$child}";
    }
    #endregion

    #region UPDATE

    public static function update(array $columns, ?string $table = null): string
    {
        $table ? $child = $table : $child = self::getTableName(get_called_class());

        // Mise en forme
        $names = "";
        foreach($columns as $column) {
            $names .= $column . ' = :' . $column . ',';
        }
        // On supprime la dernière virgule
        $names = substr($names, !strlen($names), -1);

        return "UPDATE {$child} SET {$names}";
    }

    public static function updateById(int $id, array $data): bool
    {
        $child = self::getTableName(get_called_class());

        // Création de la requête
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
    #endregion

    #region DELETE

    public static function delete(array $data, ?string $table = null): bool
    {
        $table ? $child = $table : $child = self::getTableName(get_called_class());

        $query = "DELETE FROM {$child}" . self::where(array_keys($data));

        return self::executeSimple($query, $data);
    }
    #endregion

    #region CONDITIONS

    public static function where(array $columns): string
    {
        $query = " WHERE ";

        foreach($columns as $column) {
            $query .= $column . " = :" . $column . " AND ";
        }

        // On supprime le dernier " AND "
        $query = substr($query, !strlen($query), -5);

        return $query;
    }

    public static function between(string $column, mixed $value1, mixed $value2): string
    {
        return " WHERE {$column} BETWEEN '{$value1}' AND '{$value2}'";
    }

    public static function order(string $column, bool $desc = false): string
    {
        $query = " ORDER BY {$column}";
        
        if ($desc) $query .= " DESC ";
        
        return  $query;
    }

    public static function groupBy(string $column): string
    {
        return " GROUP BY {$column}";
    }

    public static function limit(int $limit): string
    {
        return " LIMIT {$limit}";
    }
    #endregion

    #region JOINTURES

    public static function innerJoin(string $table, string $column1, string $column2): string
    {
        return " INNER JOIN {$table} ON {$column1} = {$column2}";
    }

    public static function leftJoin(string $table, string $column1, string $column2): string
    {
        return " LEFT JOIN {$table} ON {$column1} = {$column2}";
    }

    public static function leftJoinSubQuery(string $subQuery, string $name, $column1, $column2): string
    {
        return " LEFT JOIN ({$subQuery}) as {$name} ON {$column1} = {$column2}";
    }

    public static function rightJoin(string $table, string $column1, string $column2): string
    {
        return " RIGHT JOIN {$table} ON {$column1} = {$column2}";
    }
    #endregion

    #region EXECUTIONS

    /**
     * Exécute la requête et retourne un ou des objets de la classe appelante
     *
     * @param string $query La reqûete à exécuter
     * @param boolean $many [optionnel] - Détermine si un ou plusieurs objets sont attendus
     * @param array|null $data [optionnel] - Données de liaison pour la requête
     * @return mixed
     */
    public static function execute(string $query, bool $many = false, ?array $data = null): mixed
    {
        $pdo = self::connect();
        $req = $pdo->prepare($query);
        $req->execute($data);

        // Instanciation des objets
        $child = get_called_class();
        if ($many) {
            $objects = [];

            foreach ($req->fetchAll() as $result) {
                array_push(
                    $objects,
                    new $child($result)
                );
            }

            return $objects;
        } else {
            return new $child($req->fetch());
        }
    }

    /**
     * Exécute simplement la fonction. Sert pour les insert, delete et update.
     *
     * @param string $query La reqûete à exécuter
     * @param array|null $data [optionnel] - Données de liaison pour la requête
     * @return boolean
     */
    public static function executeSimple(string $query, ?array $data = null): bool
    {
        $pdo = self::connect();
        $req = $pdo->prepare($query);

        return $req->execute($data);
    }

    /**
     * Exécute une simple requête et retourne un simple résultat
     *
     * @param string $query La requête à exécuter
     * @param boolean $many [optionnel] - Détermine si un ou plusieurs objets sont attendus
     * @param array|null $data [optionnel] - Tableau associatif servant pour la liaison des clés / valeurs
     * @return mixed
     */
    public static function result(string $query, bool $many = false, ?array $data = null): mixed
    {
        $pdo = self::connect();
        $req = $pdo->prepare($query);
        $req->execute($data);

        return $many ? $req->fetchAll() : $req->fetch();
    }
    #endregion

    /**************************** REQUËTES COMBINÉES ********************************/
    
    #region READ
    /**
     * Vérifie la concordance des données dans la base de donnée
     *
     * @param array $data Tableau associatif des données
     * @return boolean
     */
    public static function exist(array $data): bool
    {
        $child = self::getTableName(get_called_class());
        $columns = array_keys($data);

        $query = self::select($columns, $child) . self::where($columns);

        return empty(self::result($query, false, $data)) ? false : true;
    }

    public static function getId(array $data): int
    {
        $child = self::getTableName(get_called_class());
        $columns = array_keys($data);
        
        $query = self::select(['id'], $child) . self::where($columns);

        return self::result($query, false, $data)['id'];
    }
    #endregion
}
