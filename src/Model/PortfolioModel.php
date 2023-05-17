<?php

namespace App\Model;

use App\Entity\Category;
use App\Entity\Portfolio;
use App\Core\AbstractModel;


class PortfolioModel extends AbstractModel
{
    function getAllPortfolio()
    {
        $sql = 'SELECT *
            FROM portfolio AS P
            INNER JOIN category AS C
            ON P.categoryId = C.idCategory';
        $results = $this->db->getAllResults($sql);
        $portfolio = [];
        foreach ($results as $result) {
            $result['category'] = new Category($result);
            $portfolio[] = new Portfolio($result);
        }
        return $portfolio;
    }

    function getOnePortfolio(int $idPortfolio)
    {
        $sql = 'SELECT *
                FROM portfolio AS P
                INNER JOIN category AS C
                ON P.categoryId = C.idCategory
                WHERE id = ?';
        $result = $this->db->getOneResult($sql, [$idPortfolio]);

        if (!$result) {
            return null;
        }
        $result['category'] = new Category($result);
        $portfolio = new Portfolio($result);

        return $portfolio;
    }

    function addPortfolio(string $image, string $content, int $categoryId)
    {

        $sql = 'INSERT INTO portfolio
        (image, content, categoryId)
        VALUES (?,?,?)';

        $this->db->prepareAndExecute($sql, [$image, $content, $categoryId]);
    }

    function removePortfolio($id)
    {
        $sql = 'DELETE FROM portfolio
                WHERE id = ?';

        $this->db->prepareAndExecute($sql, [$id]);
    }

    function updatePortfolio(string $image, string $content, int $categoryId, int $id)
    {
        $sql = 'UPDATE portfolio
                SET image = ?,
                    content = ?,
                    categoryId = ?
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$image, $content, $categoryId, $id]);
    }
}
