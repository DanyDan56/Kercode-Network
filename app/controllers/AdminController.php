<?php

namespace Knetwork\Controllers;

use Knetwork\Controllers\Controller;

class AdminController extends Controller
{
    public function home(int $id): void
    {
        $user = \Knetwork\Models\User::find($id);

        include $this->viewAdmin('home');
    }

    public function users(int $id): void
    {
        $user = \Knetwork\Models\User::find($id);
        $users = \Knetwork\Models\User::getAll();

        include $this->viewAdmin('home');
    }

    public function articles(int $id): void
    {
        $user = \Knetwork\Models\User::find($id);
        $articles = \Knetwork\Models\Article::getAll();

        include $this->viewAdmin('home');
    }

    public function editUser(int $id, int $userId, \Exception $e = null): void
    {
        $user = \Knetwork\Models\User::find($id);
        $userToEdit = \Knetwork\Models\User::find($userId);
        $nbArticles = \Knetwork\Models\Article::countWhere('user_id', $userToEdit->__get('id'));

        include $this->viewAdmin('home');
    }

    public function editUserPost(int $id, int $userId, array $data): void
    { 
        try {
            \Knetwork\Models\User::updateById($userId, $data) ? 
                throw new \Exception("L'utilisateur a été mis à jour", 0) :
                throw new \Exception("Erreur lors de la mise à jour de l'utilisateur", 3);
        } catch (\Exception $e) {
            $this->editUser($id, $userId, $e);
        }
    }
}