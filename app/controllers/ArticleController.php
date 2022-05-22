<?php

namespace Knetwork\Controllers;

use Knetwork\Helpers\Helper;
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
            $names = Helper::uploadImages($article->getDirPath(), $files);
            $article->savePictures($names);
        }

        header('location: index.php');
    }

    public function modifyArticle(int $id, string $content): void
    {
        $article = Article::find($id);

        // Si l'article est vide, on le supprime
        if ($content == "" && !$article->havePictures()) $this->deleteArticle($id);

        if (!$article->modify($content)) throw new \Exception("Erreur lors de la modification de l'article dans la base de donnée", 3);

        header('location: index.php');
    }

    public function deleteArticle(int $id): void
    {
        $article = Article::find($id);

        // Si il y a des images liées à l'article, on les supprime
        if ($article->havePictures()) Helper::deleteDir($article->getDirPath());

        if (!Article::delete(['id' => $id])) throw new \Exception("Erreur lors de la supression de l'article dans la base de donnée", 3);

        header('location: index.php');
    }

    public function like(int $id): void
    {
        $article = Article::find($id);

        if (!$article->like($_SESSION['id'])) throw new \Exception("Erreur interne de la fonction like", 3);

        header('location: index.php');
    }
}