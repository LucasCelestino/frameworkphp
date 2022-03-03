<?php

namespace App\Helpers;
use PDO;

class Connection
{
    private static $pdo;

    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    public static function getConnection(): PDO
    {
        if(empty(self::$pdo))
        {
            try
            {
                self::$pdo = new PDO("mysql:dbname=".DB_NAME.";host=".DB_HOST, DB_USER, DB_PASS, self::OPTIONS);
            }
            catch (\PDOException $th)
            {
                die('Ocorreu um erro ao acessar o banco de dados. '.$th->getCode());
            }
        }

        return self::$pdo;
    }
}