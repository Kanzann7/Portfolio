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


    function addUser(User $user)
    {
        $role = "user";
        $sql = 'INSERT INTO users
        (pseudo, email, password, role)
        VALUES (?,?,?, ?)';

        $this->db->prepareAndExecute($sql, [$user->getPseudo(), $user->getEmail(), $user->getPassword(), $user->getRole()]);
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
    function getUserByEmailAndPseudo($email, $pseudo)
    {

        $sql = 'SELECT *
                FROM users
                WHERE email = ?
                AND pseudo = ?';
        $result = $this->db->getOneResult($sql, [$email, $pseudo]);

        if ($result) {
            return new User($result);
        }
        return null;
    }
}
