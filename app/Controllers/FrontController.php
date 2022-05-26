<?php

namespace Knetwork\Controllers;

use Knetwork\Models\User;
use Knetwork\Models\Article;

class FrontController extends Controller
{
    public function home(): void
    {
        $user = User::find($_SESSION['id']);
        $articles = Article::getAll(null, 'created_at', true, 10);

        var_dump($_SERVER['DOCUMENT_ROOT']);
        
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

    public function profile(int $id): void
    {
        $user = User::find($id);
        $articles = Article::getAll($id, 'created_at', true);

        include $this->view('profile');
    }
}
