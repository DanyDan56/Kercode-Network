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

    public static function all(): array
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

        $sqlQuery = "SELECT id, name FROM $child";
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute();

        $objects = [];

        foreach ($req->fetchAll() as $data) {
            array_push(
                $objects,
                new $child($data)
            );
        }

        return $objects;
    }

    public static function find(int $id): mixed 
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

        $pdo = self::connect();
        $sqlQuery = "SELECT id, firstname, lastname, email, password, address, job, birthday_date, gender, image_profile, image_cover
                     FROM user WHERE id = :id";
        $req = $pdo->prepare($sqlQuery);
        $req->execute(['id' => $id]);

        return $req->fetch();
    }

    public static function updateById(int $id, string $name, mixed $value): bool
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

        $sqlQuery = "UPDATE $child SET $name = :value WHERE id = :id";
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        return $req->execute([
            'value' => $value,
            'id' => $id
        ]);
    }

    public static function exist(string $name, mixed $value): bool 
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

        $sqlQuery = "SELECT $name FROM $child WHERE $name = :value";
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute(['value' => $value]);

        return empty($req->fetch()) ? false : true;
    }

    public static function getId(string $name, mixed $value): int
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

        $sqlQuery = "SELECT id FROM $child WHERE $name = :value";
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute(['value' => $value]);

        return $req->fetch()['id'];
    }

    public static function limit(int $limit): mixed
    {
        // On récupère le nom de la classe appelante et on lui enlève son namespace
        $child = explode("\\", get_called_class());
        $child = $child[array_key_last($child)];

        $sqlQuery = "SELECT id, name FROM $child LIMIT :limit";
        $pdo = self::connect();
        $req = $pdo->prepare($sqlQuery);
        $req->execute(['id' => $limit]);

        return new $child($req->fetch());
    }
}
