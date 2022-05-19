<?php

namespace Knetwork\Models;

use Exception;

class Comment extends \Knetwork\Libs\ORM
{
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

        parent::insert($data) ?? throw new Exception("Erreur lors de la sauvegarde du commentaire dans la base de donnée", 3);

        return new self($data);
    }

    public static function getLastByArticle(int $id): array
    {
        $data = ['id', 'article_id', 'user_id', 'content', 'created_at', 'updated_at'];

        return array_reverse(parent::last($data, 'created_at', 2, true, 'article_id', $id));
    }

    public static function getAll(int $id = null): array
    {
        $data = ['id', 'article_id', 'user_id', 'content', 'created_at', 'updated_at'];

        return $id ? parent::all($data, 'article_id', $id) : parent::all($data);
    }

    public static function find(int $id): self
    {
        $data = ['id', 'article_id', 'user_id', 'content', 'created_at', 'updated_at'];

        return new self(self::findById($id, $data));
    }

    public static function countByArticle(int $id): int
    {
        $query = parent::countNew() . parent::where('article_id', $id);

        return parent::result($query);
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
        return self::updateById($this->id, ['content' => $content]);
    }
}