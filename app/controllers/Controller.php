<?php 

namespace Knetwork\Controllers;

use Knetwork\Models\User;

class Controller 
{
    public function view(string $name): string
    {
        return 'app/views/front/' . $name . '.php';
    }

    public function viewAdmin(string $name): string
    {
        return 'app/views/back/' . $name . '.php';
    }
}