<?php

namespace Knetwork\Controllers;

use Knetwork\Helpers\Helper;
use Knetwork\Controllers\Controller;
use Knetwork\Models\User;
use Knetwork\Models\Article;
use Knetwork\Models\Comment;

class AdminController extends Controller
{
    public function home(): void
    {
        $user = User::find($_SESSION['id']);

        // Statistique = total
        $nbUsers = User::total();
        $nbArticles = Article::total();
        $nbComments = Comment::total();
        $nbImages = Article::total('id', 'article_image');

        // Statistique = Nouveau depuis hier
        $betweenYesterday = [Helper::yesterday(), date('Y-m-d H:i:s', time())];
        $newUsers = User::total('created_at', null, $betweenYesterday);
        $newArticles = Article::total('created_at', null, $betweenYesterday);
        $newComments = Comment::total('created_at', null, $betweenYesterday);
        $newImages = Article::totalImages($betweenYesterday);

        // Graphique des statistiques pour la dernière semaine
        $chartUsers = User::chart(Helper::dateLastWeek());
        $chartArticles = Article::chart(Helper::dateLastWeek());
        $chartComments = Comment::chart(Helper::dateLastWeek());
        $chartInteractions = Article::chart(Helper::dateLastWeek(), 'article_user_interaction');

        include $this->viewAdmin('home');
    }

    public function users(): void
    {
        $user = User::find($_SESSION['id']);
        $users = User::getAllWithStats();
        $nbUsers = count($users);
        $nbArticles = Article::total();
        $nbComments = Comment::total();
        $nbImages = Article::total('id', 'article_image');

        include $this->viewAdmin('home');
    }

    public function articles(): void
    {
        $user = User::find($_SESSION['id']);
        $articles = Article::getAll(null, 'created_at', true);
        $nbUsers = User::total();
        $nbArticles = count($articles);
        $nbComments = Comment::total();
        $nbImages = Article::total('id', 'article_image');

        include $this->viewAdmin('home');
    }

    public function comments(): void
    {
        $user = User::find($_SESSION['id']);
        $comments = Comment::getAll();
        $nbUsers = User::total();
        $nbArticles = Article::total();
        $nbComments = count($comments);
        $nbImages = Article::total('id', 'article_image');

        include $this->viewAdmin('home');
    }

    public function editUser(int $userId, \Exception $e = null): void
    {
        $user = User::find($_SESSION['id']);
        $userToEdit = User::find($userId);

        include $this->viewAdmin('home');
    }

    public function editUserPost(int $userId, array $data): void
    { 
        try {
            throw User::updateById($userId, $data) ?
                new \Exception("L'utilisateur a été mis à jour", 0) :
                new \Exception("Erreur lors de la mise à jour de l'utilisateur", 3);
        } catch (\Exception $e) {
            $this->editUser($userId, $e);
        }
    }

    public function editArticle(int $articleId, \Exception $e = null): void
    {
        $user = User::find($_SESSION['id']);
        $article = Article::find($articleId);
        $articleUser = User::find($article->__get('user_id'));

        include $this->viewAdmin('home');
    }

    public function editArticlePost(int $id, string $content): void
    { 
        try {
            $article = Article::find($id);
            throw $article->modify($content) ? 
                new \Exception("L'article a été mis à jour", 0) :
                new \Exception("Erreur lors de la mise à jour de l'article", 3);
        } catch (\Exception $e) {
            $this->editArticle($id, $e);
        }
    }

    public function deleteArticle(int $id): void
    {
        $user = User::find($_SESSION['id']);
        $article = Article::find($id);

        if ($article->havePictures()) {
            Helper::deleteDir($article->getDirPath());
        }

        if (!Article::delete(['id' => $id])) throw new \Exception("Erreur lors de la supression de l'article dans la base de donnée", 3);

        header('Location: indexadmin.php?action=articles');
    }

    public function editComment(int $commentId, \Exception $e = null): void
    {
        $user = User::find($_SESSION['id']);
        $comment = Comment::find($commentId);
        $commentUser = User::find($comment->__get('user_id'));

        include $this->viewAdmin('home');
    }

    public function editCommentPost(int $commentId, array $data): void
    { 
        try {
            throw Comment::updateById($commentId, $data) ? 
                new \Exception("Le commentaire a été mis à jour", 0) :
                new \Exception("Erreur lors de la mise à jour du commentaire", 3);
        } catch (\Exception $e) {
            $this->editComment($commentId, $e);
        }
    }

    public function deleteComment(int $id): void
    {
        $user = User::find($_SESSION['id']);

        if (!Comment::delete(['id' => $id])) throw new \Exception("Erreur lors de la supression du commentaire dans la base de donnée", 3);

        header('Location: indexadmin.php?action=comments');
    }
}