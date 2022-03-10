<?php

namespace Knetwork\Controllers;

class FrontController
{
    public function home(int $id): void
    {
        $user = \Knetwork\Models\User::find($id);
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
