# Kercode-Network
Projet de fin d'annee pour la formation **Développeur Web BAC +2** Kercode 2022.

## Objectif du projet
L'objectif du projet de fin d'année est de créer un site de A à Z en langage natif (*HTML, CSS, JS, PHP*), donc sans utiliser aucunes technos qui pourraient faciliter la création du projet comme bootstrap ou autres.
Le site doit exploiter une base de données pour le stockage des informations et avoir un CRUD. Il doit aussi avoir au minimum une requête SQL avec une jointure.

## Présentation du projet
Pour mon projet, je me suis lancé sur la création d'un réseau social à la façon Facebook.

***Front***
- Les utilisateurs peuvent publier des posts contenant ou pas des iamges/photos avec les autres utilisateurs.
- Les utilisateurs peuvent voir les publications des autres utilisateurs.
- Les utilisateurs peuvent commenter/liker tous les posts.
- Les utilisateurs peuvent editer ou supprimer tous leurs contenus précédemment créés (publications, commantaires).
- Chaque utilisateur a sa page de profil dédiée où ils peuvent retrouver toutes leurs publications précédemment créées.

***Administration***
- Les administrateurs ont accès au dashboard d'administration. Celui-ci contient diverses courbes de statistiques d'évolutions sur l'utilisation du site.
- Les administrateurs ont accès à un aperçu rapide de table de tout le contenu du site (utilisateurs, publications, commentaires, etc...) et peuvent modifier et supprimer ceux-ci.

![image de démo](/app/public/images/demo.jpg)

## Installation

1. Enregistrer le dépot
Télécharger le [dossier compressé](https://github.com/DanyDan56/Kercode-Network/archive/refs/heads/main.zip) du projet et décompressé le dans le dossier de votre choix ou cloner le dépot avec la commande
```
git clone https://github.com/DanyDan56/Kercode-Network.git
```

2. Importer la base de données
Importer le fichier ***dump.sql*** dans votre gestionnaire de base de données (phpmyadmin ou autres).

3. Paramétrer les variables d'environnements
Renommer le fichier ***.env.example*** en ***.env*** et ouvrez-le avec votre éditeur de texte préféré. Il y a 5 variables à paraméter :
  - **DB_HOST** : l'addresse de votre base de données (localhost si vous êtes en local)
  - **DB_PORT** : le port d'accès à votre base de données (3306 en général)
  - **DB_NAME** : le nom de la base de données
  - **DB_USERNAME** : le nom d'utilisateur pour l'accès à la base de données
  - **DB_PASSWORD** : le mot de passe pour l'accès à la base de données
