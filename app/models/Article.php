<?php 

namespace Knetwork\Models;

class Article extends \Knetwork\Libs\ORM
{
    private int $user_id;
    private string $content;
    private bool $images;
    private string $created_at;
    private string $updated_at;

    public static function save(array $temp): void
    {
        $data = [
            'user_id' => $_SESSION['id'],
            'content' => $temp['content'],
            'images' => $temp['images'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        self::insert($data);
    }

    public function __construct(array $data)
    {
        $this->user_id = $data['user_id'];
        $this->content = $data['content'];
        $this->images = $data['images'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }

    public function __get(string $property): mixed
    {
        switch ($property) {
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
                throw new \Exception('Propriété invalide !', 3);
        }
    }

    public function haveImages(): bool
    {
        return $this->images;
    }
}