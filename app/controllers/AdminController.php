<?php

namespace Knetwork\Controllers;

use Knetwork\Models\User;
use Knetwork\Models\Article;
use Knetwork\Controllers\Controller;

class AdminController extends Controller
{
    public function home(): void
    {
        $user = User::find($_SESSION['id']);

        include $this->viewAdmin('home');
    }

    public function users(): void
    {
        $user = User::find($_SESSION['id']);
        $users = User::getAll();

        include $this->viewAdmin('home');
    }

    public function articles(): void
    {
        $user = User::find($_SESSION['id']);
        $articles = Article::getAll();

        include $this->viewAdmin('home');
    }

    public function editUser(int $userId, \Exception $e = null): void
    {
        $user = User::find($_SESSION['id']);
        $userToEdit = User::find($userId);
        $nbArticles = Article::countWhere('user_id', $userToEdit->__get('id'));

        include $this->viewAdmin('home');
    }

    public function editArticle(int $articleId, \Exception $e = null): void
    {
        $user = User::find($_SESSION['id']);
        $article = Article::find($articleId);
        $articleUser = User::find($article->__get('user_id'));

        include $this->viewAdmin('home');
    }

    public function editUserPost(int $userId, array $data): void
    { 
        try {
            User::updateById($userId, $data) ? 
                throw new \Exception("L'utilisateur a été mis à jour", 0) :
                throw new \Exception("Erreur lors de la mise à jour de l'utilisateur", 3);
        } catch (\Exception $e) {
            $this->editUser($userId, $e);
        }
    }

    public function editArticlePost(int $articleId, array $data): void
    { 
        try {
            Article::updateById($articleId, $data) ? 
                throw new \Exception("L'article a été mis à jour", 0) :
                throw new \Exception("Erreur lors de la mise à jour de l'article", 3);
        } catch (\Exception $e) {
            $this->editArticle($articleId, $e);
        }
    }
}