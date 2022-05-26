<?php

namespace Knetwork\Models;

use Exception;

class Comment extends Model
{
    private static array $data = ['id', 'article_id', 'user_id', 'content', 'created_at', 'updated_at'];

    private int $id;
    private int $article_id;
    private int $user_id;
    private string $content;
    private string $created_at;
    private string $updated_at;

    public static function save(string $content, int $articleId): self
    {
        $data = [
            'article_id' => $articleId,
            'user_id' => $_SESSION['id'],
            'content' => $content,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if(!parent::insert($data)) throw new Exception("Erreur lors de la sauvegarde du commentaire dans la base de donnée", 3);

        return new self($data);
    }

    public static function getLastByArticle(int $id, int $limit = 2): array
    {
        $query = parent::select(self::$data) . parent::where(['article_id']) . parent::order('created_at', true) . parent::limit($limit);

        return parent::execute($query, true, ['article_id' => $id]);
    }

    public static function getAll(int $article_id = 0): array
    {
        $query = parent::select(self::$data);
        if ($article_id) $query .= parent::where(['article_id']);

        return $article_id ? parent::execute($query, true, ['article_id' => $article_id]) : parent::execute($query, true);
    }

    public static function find(int $id): self
    {
        $query = parent::select(self::$data) . parent::where(['id']);
        
        return new self(parent::result($query, false, ['id' => $id]));
    }

    public static function countByArticle(int $id): int
    {
        $query = parent::count('id') . parent::where(['article_id']);

        return parent::result($query, false, ['article_id' => $id])[0];
    }

    public function __construct(array $data)
    {
        $this->article_id = $data['article_id'];
        $this->user_id = $data['user_id'];
        $this->content = $data['content'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->id = parent::getId(get_object_vars($this));
    }

    public function __get(string $property): mixed
    {
        switch ($property) {
            case 'id':
                return $this->id;
            case 'article_id':
                return $this->article_id;   
            case 'user_id':
                return $this->user_id;
            case 'content':
                return $this->content;
            case 'created_at':
                return $this->created_at;
            case 'updated_at':
                return $this->updated_at;
            default:
                throw new Exception('Propriété invalide !', 3);
        }
    }

    public function modify(string $content): bool
    {
        $query = parent::update(['content']) . parent::where(['id']);

        return parent::executeSimple($query, ['content' => $content, 'id' => $this->id]);
    }

    public function getUser(): User
    {
        return User::find($this->user_id);
    }
}