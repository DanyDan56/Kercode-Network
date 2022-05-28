<?php

namespace Knetwork\Models;

use Exception;

class Article extends Model
{
    private static array $data = ['id', 'user_id', 'content', 'images', 'created_at', 'updated_at'];

    private int $id;
    private int $user_id;
    private string $content;
    private bool $images;
    private string $created_at;
    private string $updated_at;

    #region Méthodes de classe
    public static function save(array $data): self
    {
        $data = [
            'user_id' => $_SESSION['id'],
            'content' => $data['content'],
            'images' => $data['images'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (!parent::insert($data)) throw new Exception("Erreur lors de la sauvegarde de l'article dans la base de donnée", 3);

        return new self($data);
    }

    public static function find(int $id): self
    {
        $query = parent::select(self::$data) . parent::where(['id']);

        return new self(parent::result($query, false, ['id' => $id]));
    }

    public static function getAll(?int $user_id = null, ?string $order = null, bool $desc = false, int $limit = 0): array
    {
        $data = null;
        $query = parent::select(self::$data);
        if (isset($user_id)) {
            $query .= parent::where(['user_id']);
            $data = ['user_id' => $user_id];
        }
        if (isset($order)) $query .= parent::order($order, $desc);
        if ($limit) $query .= parent::limit($limit);

        return parent::execute($query, true, $data);
    }

    public static function totalImages(array $dates): int
    {
        $query = parent::count('Article_Image.id', 'Article_Image') . parent::innerJoin('Article', 'Article.id', 'Article_Image.id') . parent::between('created_at', $dates[0], $dates[1]);
        
        return parent::result($query)[0];
    }
    #endregion

    #region Méthodes d'objet
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

    public function getDirPath(): string
    {
        return $_ENV['PATHDIRUSER'] . $this->user_id . '/articles/' . $this->id;
    }

    public function modify(string $content): bool
    {
        $query = parent::update(['content']) . parent::where(['id']);
        
        return parent::executeSimple($query, ['content' => $content, 'id' => $this->id]);
    }

    public function havePictures(): bool
    {
        return $this->images;
    }

    public function savePictures(array $names): void
    {
        foreach ($names as $name) {
            $data = [
                'name' => $name,
                'id' => $this->id
            ];
            parent::insert($data, 'Article_Image');
        }
    }

    public function getPictures(): ?array 
    {
        // Si il n'y a aucune images, on retourne null
        if (!$this->havePictures()) return null;

        $query = parent::select(['name'], 'Article_Image') . parent::where(['id']);
        $names = parent::result($query, true, ['id' => $this->id]);
        
        $paths = [];
        $i = 0;
        foreach ($names as $image) {
            $paths[$i] = $this->getDirPath() . '/' . $image['name'];
            $i++;
        }

        return $paths;
    }

    public function countComments(): int
    {
        return Comment::countByArticle($this->id);
    }

    public function getComments(): array
    {
        return Comment::getAll($this->id);
    }

    public function like(int $user_id): bool
    {
        $recLike = false;

        if (!$this->userHasLike($user_id)) {
            $recLike = parent::insert(['article_id' => $this->id,'user_id' => $user_id], 'Article_User_Like');
            $this->addInteraction($user_id, 'add_like');
        } else {
            $recLike = parent::delete(['user_id' => $user_id, 'article_id' => $this->id], 'Article_User_Like');
            $this->addInteraction($user_id, 'remove_like');
        }

        return $recLike;
    }

    public function countLikes(): int
    {
        $query = parent::count('user_id', 'Article_User_Like') . parent::where(['article_id']);
        
        return parent::result($query, false, ['article_id' => $this->id])[0];
    }

    public function getLikes(): array
    {
        $query = parent::select(['user_id'], 'Article_User_Like') . parent::where(['article_id']);
        
        return parent::result($query, true, ['article_id' => $this->id]);
    }

    public function userHasLike(int $user_id): bool
    {
        $query = parent::count('user_id', 'Article_User_Like') . parent::where(['article_id', 'user_id']);

        return parent::result($query, false, ['article_id' => $this->id, 'user_id' => $user_id])[0] == 1 ? true : false;
    }

    public function addInteraction(int $user_id, string $interactionName): void
    {
        // Try & Catch pour être sûr que le nom de l'intéraction soit bon
        try {
            // On récupère l'id pour le type de l'intéraction
            $query = parent::select(['id'], 'Article_Interaction_Type') . parent::where(['name']);
            $idInteraction = parent::result($query, false, ['name' => $interactionName])[0];
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 3);
        }

        $data = [
            'article_id' => $this->id,
            'user_id' => $user_id,
            'interaction_id' => $idInteraction
        ];

        if (!parent::insert($data, 'Article_User_Interaction'))
            throw new Exception("Erreur lors de l'enregistrement de l'intéraction (article_id:" . $this->id . ", user_id:" . $user_id . ", interaction_id:" . $idInteraction . ", interaction_name:" . $interactionName , 3);
    }

    public function countInteractions(): int
    {
        $query = parent::count('article_id', 'Article_User_Interaction') . parent::where(['article_id']);
        
        return parent::result($query, false, ['article_id' => $this->id])[0];
    }
    #endregion
}