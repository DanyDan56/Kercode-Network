<?php

namespace Knetwork\Controllers;

class FrontController
{
    public function home(int $id): void
    {
        $user = \Knetwork\Models\User::find($id);

        $data = ['user_id', 'content', 'images', 'created_at', 'updated_at'];
        $articles = \Knetwork\Models\Article::last($data, 'created_at', 10);

        require 'app/views/front/home.php';
    }

    public function login(): void
    {
        require 'app/views/front/login.php';
    }

    public function register(): void
    {
        require 'app/views/front/register.php';
    }
}
