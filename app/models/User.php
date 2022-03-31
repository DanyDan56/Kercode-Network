<?php 

namespace Knetwork\Models;

class User extends \Knetwork\Libs\ORM
{
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

    public static function login(string $email, string $password): self
    {
        $pdo = self::connect();
        $req = $pdo->prepare("SELECT id, firstname, lastname, email, password, address, job, birthday_date, gender, image_profile, image_cover
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

        return new self($user);
    }

    public static function register(array $data): bool
    {
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
    }

    public static function find(int $id): self
    {
        $data = ['id', 'firstname', 'lastname', 'email', 'password', 'address', 'job', 'birthday_date', 'gender', 'image_profile', 'image_cover'];

        return new self(self::findById($id, $data));
    }

    public static function dateToFrench(string $date, string $format): string
    {
        $englishMonths = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $frenchMonths = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

        return str_replace($englishMonths, $frenchMonths, date($format, strtotime($date)));
    }

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];
        $this->job = $data['job'];
        $this->address = $data['address'];
        $this->birthdayDate = $this::dateToFrench($data['birthday_date'], "d F Y");
        $this->profileImage = $data['image_profile'];
        $this->coverImage = $data['image_cover'];

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
            default:
                throw new \Exception('Propriété invalide !', 3);
        }
    }

    private function createSession(): void
    {
        // On setup la session
        $_SESSION['id'] = $this->id;
    }
}
