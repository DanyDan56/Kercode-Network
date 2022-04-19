<?php 

namespace Knetwork\Models;

class User extends \Knetwork\Libs\ORM
{
    private static $instance = null;

    private int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $job;
    private string $address;
    private string $birthdayDate;
    private int $gender;
    private string $profileImage;
    private string $coverImage;
    private string $createdAt;
    private string $updatedAt;
    private bool $admin;

    public static function getInstance()
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }

        throw new \Exception("Erreur lors de la récupération de l'instance de l'utilisateur", 3);
    }

    public static function login(string $email, string $password): User
    {
        // TODO: Passer par l'ORM
        $pdo = self::connect();
        $req = $pdo->prepare("SELECT id, firstname, lastname, email, password, address, job, birthday_date, gender, image_profile, image_cover, created_at, updated_at, admin
                              FROM user WHERE email = :email");
        $req->execute(['email' => $email]);
        $user = $req->fetch();

        // On vérifie que le compte existe bien
        if($user) {
            // Si le mot de passe ne correspond pas
            if(!password_verify($password, $user['password'])){
                throw new \Exception("Le mot de passe ne correspond pas", 3);
            }
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
        // TODO: Passer par l'ORM
        try {
        $pdo = self::connect();
        $req = $pdo->prepare("INSERT INTO user(lastname, firstname, email, password, birthday_date, created_at, updated_at)
                             VALUES (:lastname, :firstname, :email, :password, :birthday, NOW(), NOW())");
        
        return $req->execute([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'birthday' => $data['birthday']
        ]);
    } catch (\Exception $e) {
        throw new \Exception($e->getMessage());
    }
    }

    public static function find(int $id): self
    {
        $data = ['id', 'firstname', 'lastname', 'email', 'password', 'address', 'job', 'birthday_date', 'gender', 'image_profile', 'image_cover', 'created_at', 'updated_at', 'admin'];

        return new self(self::findById($id, $data));
    }

    public static function getAll(): array
    {
        $data = ['id', 'firstname', 'lastname', 'email', 'address', 'job', 'birthday_date', 'gender', 'image_profile', 'image_cover', 'created_at', 'updated_at', 'admin'];

        return parent::last($data, 'created_at', 100);
    }

    /**
     * Récupère le nombre de comptes créés en fonction des dates envoyées
     *
     * @param array $dates - Tableau de dates pour lesquelles on veut récupérer les statistiques
     * @return void
     */
    // public static function chart(array $dates)
    // {
    //     $data = [];
    //     $first = true;

    //     for ($i = 0; $i < count($dates); $i++) {
    //         if ($first) {
    //             $data[$dates[$i]] = self::countBetween('created_at', date('Y-m-d H:i:s', strtotime('2000-01-01')), date('Y-m-d H:i:s', strtotime($dates[$i])));
    //             $first = false;
    //         } else {
    //             $data[$dates[$i]] = self::countBetween('created_at', date('Y-m-d H:i:s', strtotime($dates[$i-1])),
    //                                 date('Y-m-d H:i:s', $i != 6 ? strtotime($dates[$i]) : time()));
    //         }
    //     }

    //     return $data;
    // }

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

        // On créé la session
        if (!isset($_SESSION['id'])) {
            $this->createSession();
        }
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
            default:
                throw new \Exception('Propriété invalide !', 3);
        }
    }

    private function createSession(): void
    {
        // On setup la session
        $_SESSION['id'] = $this->id;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }
}
