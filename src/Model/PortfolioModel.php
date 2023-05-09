<?php

namespace App\Model;

use App\Core\AbstractModel;
use App\Entity\Portfolio;


class PortfolioModel extends AbstractModel
{
    function getAllPortfolio()
    {
        $sql = 'SELECT *
            FROM portfolio';
        $results = $this->db->getAllResults($sql);
        $portfolio = [];
        foreach ($results as $result) {
            $portfolio[] = new Portfolio($result);
        }
        return $portfolio;
    }

    function getOnePortfolio(int $idPortfolio)
    {
        $sql = 'SELECT *
                FROM portfolio
                WHERE id = ?';
        $result = $this->db->getOneResult($sql, [$idPortfolio]);

        if (!$result) {
            return null;
        }
        $portfolio = new Portfolio($result);

        return $portfolio;
    }

    function addPortfolio(string $image, string $content)
    {

        $sql = 'INSERT INTO portfolio
        (image, content)
        VALUES (?,?)';

        $this->db->prepareAndExecute($sql, [$image, $content]);
    }

    function removePortfolio($id)
    {
        $sql = 'DELETE FROM portfolio
                WHERE id = ?';

        $this->db->prepareAndExecute($sql, [$id]);
    }
}
