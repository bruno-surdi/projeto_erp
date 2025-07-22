<?php
declare(strict_types=1);
namespace Config;

use PDO;
use PDOException;

class Database
{
    public static function connect(): PDO
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=mini_erp;charset=utf8", "root", "mysql");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Testa uma query simples
            $pdo->query("SELECT 1");

            return $pdo;
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
}
