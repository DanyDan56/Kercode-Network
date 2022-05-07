<?php

namespace Knetwork\Controllers;

use Knetwork\Models\Comment;
use \Knetwork\Models\Article;

class ArticleController extends Controller
{
    public function addArticle(string $content, array $files): void
    {
        $article = Article::save([
            'content' => $content,
            'images' => $files['size'][0] > 0 ? 1 : 0
        ]);

        // Si il il y a des images, on les traîte
        if ($files['size'][0] > 0) {
            $names = $this::uploadImages($article->__get('user_id'), $article->__get('id'), $files);
            $article->saveImages($names);
        }

        header('location: index.php');
    }

    public function modifyArticle(int $id, string $content): void
    {
        $article = Article::find($id);

        if ($content == "" && !$article->haveImages()) {
            $this->deleteArticle($id);
        }

        $article->modify($content) ?? throw new \Exception("Erreur lors de la modification de l'article dans la base de donnée", 3);

        header('location: index.php');
    }

    public function deleteArticle(int $id): void
    {
        $article = Article::find($id);

        if ($article->haveImages()) {
            self::deleteDirArticle($_SESSION['id'], $id);
        }

        Article::delete($id) ?? throw new \Exception("Erreur lors de la supression de l'article dans la base de donnée", 3);

        header('location: index.php');
    }

    public function addComment(string $content, int $articleId): void
    {
        Comment::save($content, $articleId);

        header('location: index.php');
    }

    public function modifyComment(int $id, string $content): void
    {
        $comment = Comment::find($id);

        $comment->modify($content) ?? throw new \Exception("Erreur lors de la modification du commentaire dans la base de donnée", 3);

        header('location: index.php');
    }

    public function deleteComment(int $id): void
    {
        $comment = Comment::find($id);

        Comment::delete($id) ?? throw new \Exception("Erreur lors de la supression du commentaire dans la base de donnée", 3);

        header('location: index.php');
    }
}