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
     * Constructor
     */
    public function __construct()
    {
        $this->pdo = $this->getPDOConnection();
    }

    /**
     * BDB connexion
     */
    function getPDOConnection()
    {

        // Data Source Name construction
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=utf8';

        // Tableau d'options pour la connexion PDO
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        //  PDO connexion (PDO object)
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        $pdo->exec('SET NAMES UTF8');

        return $pdo;
    }

    /**
     * Prepare and execute  a SQL request
     */
    function prepareAndExecute(string $sql, array $values = [])
    {
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute($values);
        return $pdoStatement;
    }

    // Execute a selection request and return a result
    function getOneResult(string $sql, array $values = [])
    {
        $pdoStatement = $this->prepareAndExecute($sql, $values);
        $result = $pdoStatement->fetch();
        return $result;
    }

    // Execute a selection request and return all results
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
