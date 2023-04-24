<?php

namespace App\Model;

use App\Core\AbstractModel;
use App\Entity\Skill;

class SkillModel extends AbstractModel


{
    function getAllSkills()
    {
        $sql = 'SELECT *
            FROM skills';
        $results = $this->db->getAllResults($sql);
        $skills = [];
        foreach ($results as $result) {
            $skills[] = new Skill($result);
        }
        return $skills;
    }

    function getOneSkill(int $idSkill)
    {
        $sql = 'SELECT *
                FROM skills';
        $results = $this->db->getOneResult($sql, [$idSkill]);
        $skills = [];
        foreach ($results as $result) {
            $skills[] = new Skill($result);
        }
        return $skills;
    }
}
