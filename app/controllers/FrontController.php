<?php

namespace Knetwork\Controllers;

use Knetwork\Models\User;
use Knetwork\Controllers\UserController;

class FrontController extends Controller
{
    public function home(int $id): void
    {
        $user = \Knetwork\Models\User::find($id);

        $data = ['id', 'user_id', 'content', 'images', 'created_at', 'updated_at'];
        $articles = \Knetwork\Models\Article::last($data, 'created_at', 10);

        include $this->view('home');
    }

    public function login(): void
    {
        
        include $this->view('login');
    }

    public function register(): void
    {
        include $this->view('register');
    }

    public function profile(int $id): void
    {
        $user = \Knetwork\Models\User::find($id);

        include $this->view('profile');
    }
}
