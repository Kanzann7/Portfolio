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
            return $users;
        }
    }

    function getOneUser(int $idUser)
    {
        $sql = 'SELECT *
                FROM users';
        $results = $this->db->getOneResult($sql, [$idUser]);
        $users = [];
        foreach ($results as $result) {
            $users[] = new User($result);
            return $users;
        }
    }
}
