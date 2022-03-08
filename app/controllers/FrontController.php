<?php

namespace Knetwork\Controllers;

class FrontController
{
    public function home(): void
    {
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
