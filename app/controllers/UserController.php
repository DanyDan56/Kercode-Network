<?php

namespace Knetwork\Controllers;

use \Knetwork\Models\User;

class UserController extends Controller
{
    private $user = null;

    private static function createDirUser(int $id): void
    {
        if(!mkdir('app/private/images/users/' . $id . "/articles", 0644, true)) {
            throw new \Exception("Création de l'espace de stockage dédié échoué", 3);
        }
    }

    public function __get(string $property): mixed
    {
        switch ($property) {
            case 'user':
                return $this->user ? $this->user : null;
                break;
            default:
                throw new \Exception('Propriété invalide !', 3);
        }
    }

    public function login(string $email, string $password): void
    {
        // On essai de connecter l'utilisateur
        // Si tout se passe bien, on redirige vers la page d'accueil
        // Sinon on gère les exceptions
        try {
            $this->user = User::login($email, $password);

            if($this->user) {
                if ($this->user->isAdmin()) header("location: indexadmin.php");
                else header("location: indexadmin.php");
            }
        } catch (\Exception $e) {
            require 'app/views/front/login.php';
        }
    }

    public function auth(bool $admin = false): void
    {
        // On check l'utilisateur
        if (!User::check($_SESSION['id'], $_SESSION['password'], $admin)) throw new \Exception("L'utilisateur n'est pas valide", 3);
    }

    public function register(array $data): void
    {
        // On enregistre le nouveau compte
        // On gère les exceptions si une erreur se produit
        try {
            // On vérifie que tous les champs sont bien remplis
            foreach ($data as $res) {
                if (empty($res)) {
                    throw new \Exception("Tous les champs sont requis", 3); 
                }
            }

            // On vérifie que l'adresse email est au bon format
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("L'email n'est pas valide", 3);
            }

            // On check si les mots de passe sont identique
            if ($data['password'] != $data['confirmPassword']) {
                throw new \Exception("Les mots de passe ne sont pas identiques", 3);
            }

            // Si le compte existe déjà
            if (User::exist(['email' => $data['email']])) {
                throw new \Exception("Ce compte existe déjà", 3);
            }
            
            // On enregistre le nouveau compte
            if (!User::register($data)) {
                throw new \Exception("Il y a eu une erreur lors de la création de votre compte.<br>Veuillez réessayer plus tard.", 3);
            }

            // Si tout se passe bien, on créé un espace utilisateur dédié sur le serveur
            $id = User::getId(['email' => $data['email']]);
            self::createDirUser($id);

            // Si une image de profil a été sélectionnée, on l'enregistre
            if ($data['imageProfile']['name'] != "") {
                // Upload
                $name = $this::uploadImage($id, $data['imageProfile']);

                // Sauvegarde dans la base de donnée
                if (!User::updateById($id, ['image_profile' => $name])) {
                    throw new \Exception("Erreur lors de l'enregistrement de l'image sur le serveur", 3);
                }
            }

            // On redirige l'utilisateur vers la page de login avec un message informatif (code = 0)
            throw new \Exception("Votre compte a été créé avec succès", 0);
        } catch (\Exception $e) {
            // On redirige en fonction du code d'erreur
            switch($e->getCode()) {
                // Code 0 = Message informatif
                case 0:
                    require 'app/views/front/login.php';
                    break;
                // Code 3 = Message d'erreur
                case 3:
                    require 'app/views/front/register.php';
                    break;
                default:
                    require 'app/views/front/register.php';
            }
        }
    }
}
