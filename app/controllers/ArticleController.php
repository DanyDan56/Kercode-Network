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
}