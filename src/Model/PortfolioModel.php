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
}
