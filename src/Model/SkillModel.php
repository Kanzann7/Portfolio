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
                FROM skills
                WHERE id = ?';
        $result = $this->db->getOneResult($sql, [$idSkill]);
        if (!$result) {
            return null;
        }

        $skills = new Skill($result);
        return $skills;
    }
}
