![image de démo](/app/public/images/demo.jpg)

[![Maintainability](https://api.codeclimate.com/v1/badges/0f806d33a98fd3f007de/maintainability)](https://codeclimate.com/github/DanyDan56/Kercode-Network/maintainability)

# Kercode-Network
Projet de fin d'année pour la formation **Développeur Web BAC +2** Kercode 2022 du GRETA de Vannes.

Un site de démo est accessible à [knetwork.dgoulard.fr](http://knetwork.dgoulard.fr).

## Objectif du projet
L'objectif du projet de fin d'année est de créer un site de A à Z en langage natif (*HTML, CSS, JS, PHP*), donc sans utiliser aucunes technos qui pourraient faciliter la création du projet comme bootstrap ou autres.
Le site doit être dans le modèle MVC (*Model - View - Controller*).
Le site doit exploiter une base de données pour le stockage des informations et avoir un CRUD (*Create - Read - Update - Delete*). Il doit aussi avoir au minimum une requête SQL avec une jointure.

## Présentation du projet
Pour mon projet, je me suis lancé sur la création d'un réseau social à la façon de Facebook. Le site a été développé avec la version de PHP 8.1.

Pour me faciliter le développement du site, j'ai créé quelques outils maison comme un mini bootstrap pour me faciliter la mise en page et le responsive design. J'ai aussi créé un petit ORM pour faciliter les requêtes SQL et la connexion à la base données.

***Fonctionnalités utilisateurs***
- Les utilisateurs peuvent publier des posts contenant ou pas des images/photos avec les autres utilisateurs. La disposition des images/photos varie en fonction du nombre posté (jusqu'à 5 maximum par post).
- Les utilisateurs peuvent cliquer sur les images/photos pour les afficher en plus grand par dessus la page actuelle.
- Les utilisateurs peuvent voir les publications des autres utilisateurs.
- Les utilisateurs peuvent sélectionner une image de profil lors de la création de leur compte.
- Les utilisateurs peuvent commenter/liker tous les posts.
- Les utilisateurs peuvent editer ou supprimer tous leurs contenus précédemment créés (publications, commantaires).
- Chaque utilisateur a sa page de profil dédiée où ils peuvent retrouver toutes leurs publications précédemment créées.

***Fonctionnalités administration***
- Les administrateurs ont accès au dashboard d'administration. Celui-ci contient diverses courbes de statistiques d'évolutions sur l'utilisation du site.
- Les administrateurs ont accès à un aperçu rapide de table de tout le contenu du site (utilisateurs, publications, commentaires, etc...) et peuvent modifier et supprimer ceux-ci.

***Fonctionnalités pas encore implémentées***
- Possibilité de modifier les informations et des images de profil/couverture pour les utilisateurs.
- Gestion des amis. Actuellement les utilisateurs ont accès au publications de tous les autres utilisateurs.
- Système de notifications.
- Gestion des évènements à venir.
- Messagerie / Chat interne.

## Installation

### 1. Enregistrer le dépot
Télécharger le [dossier compressé](https://github.com/DanyDan56/Kercode-Network/archive/refs/heads/main.zip) du projet et décompressé le dans le dossier de votre choix ou cloner le dépot avec la commande
```
git clone https://github.com/DanyDan56/Kercode-Network.git
```

### 2. Installer les dépendances
Pour installer les dépendances, vous aurez besoin de Composer trouvable à cette adresse [Composer](https://getcomposer.org/download/). Une fois installé, ouvrez un terminal à la racine du dossier du projet et faite :
```
composer install
```

### 3. Importer la base de données
Importer le fichier ***dump.sql*** dans votre gestionnaire de base de données (phpmyadmin ou autres).

### 4. Paramétrer les variables d'environnements
Renommer le fichier ***.env.example*** en ***.env*** et ouvrez-le avec votre éditeur de texte préféré. Il y a 5 variables à paraméter :
  - **DB_HOST** : l'addresse de votre base de données (localhost si vous êtes en local)
  - **DB_PORT** : le port d'accès à votre base de données (3306 en général)
  - **DB_NAME** : le nom de la base de données
  - **DB_USERNAME** : le nom d'utilisateur pour l'accès à la base de données
  - **DB_PASSWORD** : le mot de passe pour l'accès à la base de données

## Contact
Daniel Goulard - [dgd.contact@gmail.com](mailto:dgd.contact@gmail.com)

Lien du site de démo - [knetwork.dgoulard.fr](http://knetwork.dgoulard.fr)
