<?php

namespace Knetwork\Controllers;

use \Knetwork\Models\Article;

class ArticleController extends Controller
{
    public function addArticle(string $content, array $files): void
    {
        $article = Article::save([
            'content' => $content,
            'images' => $files['size'][0] > 0 ? 1 : 0
        ]);

        if ($files['size'][0] > 0) {
            $names = $this::uploadImages($article->__get('user_id'), $article->__get('id'), $files);
            $article->saveImages($names);
        }

        header('location: index.php');
    }

    public function deleteArticle(int $id): void
    {
        $article = Article::find($id);

        if ($article->haveImages()) {
            self::deleteDirArticle($_SESSION['id'], $id);
        }

        Article::delete($id) ?? new \Exception("Erreur lors de la supression de l'article dans la base de donnée", 3);

        header('location: index.php');
    }
}