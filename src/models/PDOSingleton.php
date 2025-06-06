<?php

namespace Models;

use PDO;
use PDOException;

class PDOSingleton
{
    // Instance unique
    private static ?PDO $instance = null;

    // Configuration de la base de données
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'PersonneActivities';
    private const DB_USER = 'root';
    private const DB_PASS = 'Super';
    private const DB_CHARSET = 'utf8mb4';

    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct() {}

    // Méthode pour obtenir l'instance unique
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=' . self::DB_CHARSET;
                self::$instance = new PDO($dsn, self::DB_USER, self::DB_PASS);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }
        return self::$instance;
    }

    // Empêcher le clonage de l'objet
    public function __clone() {}

    // Empêcher la désérialisation de l'objet
    public function __wakeup() {}
}
