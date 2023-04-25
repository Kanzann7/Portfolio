<?php

namespace App\Model;

use App\Core\AbstractModel;
use App\Entity\Comment;

class CommentModel extends AbstractModel
{
    function addComment(int $content, string $pseudo, int $usersId, int $portfolioId)
    {
        $sql = 'INSERT INTO comments
        (content, pseudo, usersId, createdAt)
        VALUES (?,?,?, NOW())';
        $this->db->prepareAndExecute($sql, [$content, $pseudo, $usersId, $portfolioId]);
    }

    function getCommentsByPortfolioId(int $idPortfolio)
    {
        $sql = 'SELECT *
               FROM comments
               WHERE portfolioId = ?
               ORDER BY createdAt DESC';
        $results = $this->db->getAllResults($sql, [$idPortfolio]);
        $comments = [];
        foreach ($results as $result) {
            $comments[] = new Comment($result);
            return $comments;
        }
    }

    function getCommentsByUsersId(int $idUsers)
    {
        $sql = 'SELECT *
               FROM comments
               WHERE usersId = ?
               ORDER BY createdAt DESC';
        $results = $this->db->getAllResults($sql, [$idUsers]);
        $comments = [];
        foreach ($results as $result) {
            $comments[] = new Comment($result);
            return $comments;
        }
    }
}
