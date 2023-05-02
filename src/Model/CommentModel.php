<?php

namespace App\Model;

use App\Entity\User;
use App\Core\AbstractModel;
use App\Entity\Comment;

class CommentModel extends AbstractModel
{
    function addComment(string $content, int $usersId, int $portfolioId)
    {
        $sql = 'INSERT INTO comments
        (content, usersId, createdAt, portfolioId)
        VALUES (?,?, NOW(), ?)';
        $this->db->prepareAndExecute($sql, [$content, $usersId, $portfolioId]);
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
            $comment = new Comment($result);
            $userModel = new UserModel();
            $user = $userModel->getOneUser($result['usersId']);
            $comment->setUser($user);
            $comments[] = $comment;
        }
        return $comments;
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
