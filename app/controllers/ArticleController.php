<?php

namespace Knetwork\Controllers;

use \Knetwork\Models\Article;

class ArticleController 
{
    public static function dateDiff($date1, $date2): array
    {
        $diff = abs($date1 - strtotime($date2));
        $result = array();

        $tmp = $diff;
        $result['second'] = $tmp % 60;

        $tmp = floor(($tmp - $result['second']) / 60);
        $result['minute'] = $tmp % 60;

        $tmp = floor(($tmp - $result['minute']) / 60);
        $result['hour'] = $tmp % 24;

        $tmp = floor(($tmp - $result['hour'])  / 24 );
        $result['day'] = $tmp;

        return $result;
    }
     
    public function addArticle(string $content): void
    {
        Article::save(['content' => $content, 'images' => 0]);

        header('location: index.php');
    }
}