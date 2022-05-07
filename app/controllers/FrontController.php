<?php

namespace Knetwork\Controllers;

use Knetwork\Models\User;
use Knetwork\Models\Article;

class FrontController extends Controller
{
    public function home(): void
    {
        $user = User::find($_SESSION['id']);

        $data = ['id', 'user_id', 'content', 'images', 'created_at', 'updated_at'];
        $articles = Article::last($data, 'created_at', 10);

        include $this->view('home');
    }

    public function login(\Exception $e = null): void
    {
        include $this->view('login');
    }

    public function register(): void
    {
        include $this->view('register');
    }

    public function profile(): void
    {
        $user = User::find($_SESSION['id']);
        $articles = Article::getAllByUser($_SESSION['id']);

        include $this->view('profile');
    }
}
