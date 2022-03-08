<?php

namespace Knetwork\Controllers;

class UserController
{
    public function login(string $email, string $password): void
    {
        // On essai de connecter l'utilisateur
        // Si tout se passe bien, on le redirige vers sa page d'accueil
        // Sinon on affiche un message d'erreur
        try {
            $user = \Knetwork\Models\UserModel::login($email, $password);

            if($user) {
                require 'app/views/front/home.php';
            }
        } catch (\Exception $e) {
            require 'app/views/front/login.php';
        }
    }
}