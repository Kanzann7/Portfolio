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

    function addSkill(string $image, string $content)
    {

        $sql = 'INSERT INTO skills
        (image, content)
        VALUES (?,?)';

        $this->db->prepareAndExecute($sql, [$image, $content]);
    }

    function removeSkill($id)
    {
        $sql = 'DELETE FROM skills
                WHERE id = ?';

        $this->db->prepareAndExecute($sql, [$id]);
    }

    // function updateSkill($skill)
    // {
    //     $sql = 'UPDATE skills
    //             SET image = ?,
    //                 content = ?
    //             WHERE id = ?';
    //     $this->db->prepareAndExecute($sql, [$skill->getImage(), $skill->getContent(), $skill->getId()]);

    // }


    function updateSkill(string $image, string $content, int $id)
    {
        $sql = 'UPDATE skills
                SET image = ?,
                    content = ?
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$image, $content, $id]);
    }
}
