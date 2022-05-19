<?php

namespace Knetwork\Controllers;

use Knetwork\Models\Comment;

class CommentController extends Controller
{
    public function addComment(string $content, int $articleId): void
    {
        Comment::save($content, $articleId);

        header('location: index.php');
    }

    public function modifyComment(int $id, string $content): void
    {
        $comment = Comment::find($id);

        if (!$comment->modify($content)) throw new \Exception("Erreur lors de la modification du commentaire dans la base de donnée", 3);

        header('location: index.php');
    }

    public function deleteComment(int $id): void
    {
        $comment = Comment::find($id);

        if (!Comment::delete($id)) throw new \Exception("Erreur lors de la supression du commentaire dans la base de donnée", 3);

        header('location: index.php');
    }
}