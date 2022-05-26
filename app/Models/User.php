<?php 

namespace Knetwork\Models;

class User extends Model
{
    private static ?User $instance = null;
    private static array $data =
    ['User.id as id', 'firstname', 'lastname', 'email', 'address', 'job', 'birthday_date', 'gender', 'image_profile', 'image_cover', 'admin', 'User.created_at as created_at', 'User.updated_at as updated_at'];

    private int $id;
    private string $firstname;
    private string $lastname;
    private string $password;
    private string $email;
    private string $job;
    private string $address;
    private string $birthdayDate;
    private int $gender;
    private ?string $profileImage;
    private ?string $coverImage;
    private bool $admin;
    private string $createdAt;
    private string $updatedAt;
    
    private int $countArticles;
    private int $countComments;

    // FIXME: Erreur avec le singleton - Ne reste pas setter durant le cycle de vie de l'app - Cause header redirection ??
    public static function getInstance()
    {
        // On vérifie que l'instance existe et on la retourne
        if (isset(self::$instance)) return self::$instance;

        throw new \Exception("Erreur lors de la récupération de l'instance de l'utilisateur", 3);
    }

    public static function login(string $email, string $password): User
    {
        $data = array_slice(self::$data, 0);
        array_push($data, 'password');

        $query = parent::select($data) . parent::where(['email']);
        $user = parent::result($query, false, ['email' => $email]);
        

        // On vérifie que le compte existe bien
        if($user) {
            // Si le mot de passe ne correspond pas
            if(!password_verify($password, $user['password'])) throw new \Exception("Le mot de passe ne correspond pas", 3);
        } else {
            // Si le compte n'existe pas
            throw new \Exception("Le compte n'existe pas", 3);
        }

        // On instancie
        self::$instance = new User($user);

        return self::$instance;
    }

    public static function register(array $data): bool
    {
        try {
            $data = [
                'lastname' => $data['lastname'],
                'firstname' => $data['firstname'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'birthday_date' => $data['birthday']
            ];
            
            return parent::insert($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 3);
        }
    }

    public static function find(int $id): self
    {
        $query = parent::select(self::$data) . parent::where(['id']);

        return parent::execute($query, false, ['id' => $id]);
    }

    public static function getAll(int $limit = 0): array
    {
        $query = parent::select(self::$data).
                 parent::order('created_at', true);
        
        if ($limit) parent::limit($limit);

        return parent::execute($query, true);
    }

    public static function getAllWithStats(int $limit = 0): array
    {
        // On copie le tableau de correspondance et on lui ajoute les stats qu'on veut récupérer en plus
        $data = array_slice(self::$data, 0);
        array_push($data, 'COUNT(article.id) as countArticles', 'req.comment_id as countComments');

        $subQuery = parent::select(['COUNT(comment.id) as comment_id', 'user_id'], 'comment').
                    parent::rightJoin('user', 'comment.user_id', 'user.id').
                    parent::groupBy('user.id');

        $query = parent::select($data).
                 parent::leftJoin('article', 'user.id', 'article.user_id').
                 parent::leftJoinSubQuery($subQuery, 'req', 'req.user_id', 'user.id').
                 parent::groupBy('user.id').
                 parent::order('user.created_at', true);
        
        if ($limit) parent::limit($limit);
        
        return parent::execute($query, true);
    }

    public static function check(int $id, string $password, bool $admin): bool
    {
        $data = ['password' => $password, 'id' => $id];
        
        if ($admin) $data['admin'] = 1;
        
        return parent::exist($data);
    }

    protected function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];
        $this->job = $data['job'];
        $this->address = $data['address'];
        $this->birthdayDate = $data['birthday_date'];
        $this->gender = $data['gender'];
        $this->profileImage = $data['image_profile'];
        $this->coverImage = $data['image_cover'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
        $this->admin = $data['admin'];
        if (isset($data['password'])) $this->password = $data['password'];/*  : $this->password = ""; */
        if (isset($data['countArticles'])) $this->countArticles = $data['countArticles'];/*  : $this->countArticles = 0; */
        if (isset($data['countComments'])) $this->countComments = $data['countComments'];/*  : $this->countComments = 0; */

        // On créé la session
        if (!isset($_SESSION['id'])) $this->createSession();
    }

    public function __get(string $property): mixed
    {
        switch ($property) {
            case 'id':
                return $this->id;
            case 'firstname':
                return $this->firstname;
            case 'lastname':
                return $this->lastname;
            case 'password':
                return $this->password;
            case 'email':
                return $this->email;
            case 'job':
                return $this->job;
            case 'address':
                return $this->address;
            case 'birthdayDate':
                return $this->birthdayDate;
            case 'gender':
                return $this->gender;
            case 'profileImage':
                return $this->profileImage;
            case 'coverImage':
                return $this->coverImage;
            case 'createdAt':
                return $this->createdAt;
            case 'updatedAt':
                return $this->updatedAt;
            case 'countArticles':
                return $this->countArticles();
            case 'countComments':
                return $this->countComments();
            default:
                throw new \Exception('Propriété invalide !', 3);
        }
    }

    private function createSession(): void
    {
        // On setup la session
        $_SESSION['id'] = $this->id;
        $_SESSION['password'] = $this->password;
        $_SESSION['admin'] = $this->admin;
    }

    public function getDirPath(): string
    {
        return $_ENV['PATHDIRUSER'] . $this->id;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function getNames(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getProfileImage(): string
    {
        isset($this->profileImage) ?
            $path = "app/private/images/users/" . $this->id . '/' . $this->profileImage :
            $path = "app/public/images/examples/img_avatar2.png";
        
        return $path;
    }

    private function countArticles(): int
    {
        // Si la valeur existe déjà, on la retourne
        if (isset($this->countArticles)) return $this->countArticles;

        $query = Article::count('id') . parent::where(['user_id']);
        
        $this->countArticles = parent::result($query, false, ['user_id' => $this->id])[0];
        
        return $this->countArticles;
    }

    private function countComments(): int
    {
        // Si la valeur existe déjà, on la retourne
        if (isset($this->countComments)) return $this->countComments;

        $query = Comment::count('id') . parent::where(['user_id']);
        
        $this->countComments = parent::result($query, false, ['user_id' => $this->id])[0];

        return $this->countComments;
    }
}
