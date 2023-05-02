<?php

namespace App\Model;

use App\Core\AbstractModel;
use App\Entity\User;

class UserModel extends AbstractModel


{
    function getAllUsers()
    {
        $sql = 'SELECT *
            FROM users';
        $results = $this->db->getAllResults($sql);
        $users = [];
        foreach ($results as $result) {
            $users[] = new User($result);
        }
        return $users;
    }

    function getOneUser(int $idUser)
    {
        $sql = 'SELECT *
                FROM users
                WHERE id = ?';
        $result = $this->db->getOneResult($sql, [$idUser]);
        if (!$result) {
            return null;
        }

        $users = new User($result);
        return $users;
    }


    function addUser(string $pseudo, string $email, string $password)
    {
        $role = "user";
        $sql = 'INSERT INTO users
        (pseudo, email, password, role)
        VALUES (?,?,?, ?)';

        $this->db->prepareAndExecute($sql, [$pseudo, $email, $password, $role]);
    }

    function emailExists($email)
    {

        $sql = 'SELECT *
                FROM users
                WHERE email = ?';
        $result = $this->db->getOneResult($sql, [$email]);

        if ($result) {
            return true;
        }
        return false;
    }
    function getUserByEmail($email)
    {

        $sql = 'SELECT *
                FROM users
                WHERE email = ?';
        $result = $this->db->getOneResult($sql, [$email]);

        if ($result) {
            return $result;
        }
        return [];
    }
}
