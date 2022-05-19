<?php

namespace Knetwork\Models;

use Exception;

class Article extends \Knetwork\Libs\ORM
{
    private int $id;
    private int $user_id;
    private string $content;
    private bool $images;
    private string $created_at;
    private string $updated_at;

    public static function save(array $data): self
    {
        $data = [
            'user_id' => $_SESSION['id'],
            'content' => $data['content'],
            'images' => $data['images'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        parent::insert($data) ?? throw new Exception("Erreur lors de la sauvegarde de l'article dans la base de donnée", 3);

        return new self($data);
    }

    public static function find(int $id): self
    {
        $data = ['id', 'user_id', 'content', 'images', 'created_at', 'updated_at'];

        return new self(self::findById($id, $data));
    }

    public static function getAll(): array
    {
        $data = ['id', 'user_id', 'content', 'images', 'created_at', 'updated_at'];

        return parent::last($data, 'created_at', 100);
    }

    public static function getAllByUser(int $id): array
    {
        $data = ['id', 'user_id', 'content', 'images', 'created_at', 'updated_at'];
        $pdo = parent::select($data) . parent::where('user_id', $id) . parent::order('created_at', true);
        
        $pdo = parent::execute($pdo, true);

        // return parent::last($data, 'created_at', 100);
        return $pdo;
    }

    public function __construct(array $data)
    {
        $this->user_id = $data['user_id'];
        $this->content = $data['content'];
        $this->images = $data['images'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->id = parent::getId(get_object_vars($this));
    }

    public function __get(string $property): mixed
    {
        switch ($property) {
            case 'id':
                return $this->id;
            case 'user_id':
                return $this->user_id;
            case 'content':
                return $this->content;
            case 'images':
                return $this->images;
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

    public function haveImages(): bool
    {
        return $this->images;
    }

    public function saveImages(array $names): void
    {
        for ($i = 0; $i < count($names); $i++) {
            $data = [
                'name' => $names[$i],
                'id' => $this->id
            ];
            self::insert($data, 'article_image');
        }
    }

    public function getImages(): array 
    {
        $images = $this::findAllById($this->id, ['name'], 'article_image');
        $names = [];
        $i = 0;
        foreach ($images as $image) {
            $names[$i] = 'app/private/images/users/' . $this->user_id . '/articles/' . $this->id . '/' . $image['name'];
            $i++;
        }

        return $names;
    }

    public function countComments(): int
    {
        return Comment::countByArticle($this->id);
    }

    public function getComments(): array
    {
        return Comment::getAll($this->id);
    }
}