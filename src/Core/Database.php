<?php

// 1. Namespace statement
namespace App\Core;

// 2. Importing classes
use PDO;

// 3. Database class creation
class Database
{

    /**
     * Containing PDO object
     */
    private PDO $pdo;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->pdo = $this->getPDOConnection();
    }

    /**
     * Connexion à la base de données
     */
    function getPDOConnection()
    {

        // Construction du Data Source Name
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=utf8';

        // Tableau d'options pour la connexion PDO
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        // Création de la connexion PDO (création d'un objet PDO)
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        $pdo->exec('SET NAMES UTF8');

        return $pdo;
    }

    /**
     * Prépare et exécute une requête SL
     */
    function prepareAndExecute(string $sql, array $values = [])
    {
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute($values);
        return $pdoStatement;
    }

    // Execute une requête de sélection et retourne un résultat
    function getOneResult(string $sql, array $values = [])
    {
        $pdoStatement = $this->prepareAndExecute($sql, $values);
        $result = $pdoStatement->fetch();
        return $result;
    }

    // Execute une requête de sélection et retourne tous les résultats
    function getAllResults(string $sql, array $values = [])
    {
        $pdoStatement = $this->prepareAndExecute($sql, $values);
        $result = $pdoStatement->fetchAll();
        return $result;
    }

    function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }


    function insert(string $sql, array $values = [])
    {
        $this->prepareAndExecute($sql, $values);

        return $this->lastInsertId();
    }
}
