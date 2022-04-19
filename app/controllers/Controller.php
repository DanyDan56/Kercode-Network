<?php 

namespace Knetwork\Controllers;

use Knetwork\Models\User;

class Controller 
{
    public function view(string $name): string
    {
        return 'app/views/front/' . $name . '.php';
    }

    public function viewAdmin(string $name): string
    {
        return 'app/views/back/' . $name . '.php';
    }

    public static function uploadImage(int $id, array $image): string
    {
        // On vérifie si il y a eu une erreur
        if ($image['error']) {
            switch ($image['error']) {
                case 1: // UPLOAD_ERR_INIT_SIZE
                    throw new \Exception("Le fichier dépasse la taille autorisée par le serveur", 3);
                    break;
                case 2: // UPLOAD_ERR_FORM_SIZE
                    throw new \Exception("Le fichier dépasse la taille autorisée par le formulaire", 3);
                    break;
                case 3: // UPLOAD_ERR_PARTIAL
                    throw new \Exception("L'envoi du fichier a été interrompu pendant le transfert", 3);
                    break;
                case 4: // UPLOAD_ERR_NO_FILE
                    throw new \Exception("Le fichier que vous envoyé a une taille nulle", 3);
                    break;
            }
        }

        // On enregistre l'image dans l'espace de l'ulisateur si tout va bien
        $name = "";
        if (isset($image['tmp_name'])) {
            $dest = 'app/private/images/users/' . $id . "/";
            $name = time() . ".png";

            // On enregistre l'image dans le dossier de l'utilisateur
            move_uploaded_file($image['tmp_name'], $dest . $name);
        }

        return $name;
    }

    public static function uploadImages(int $userId, int $articleId, array $images): array
    {
        // On vérifie si il y a eu une erreur
        for ($i = 0; $i < count($images['error']); $i++) {
            if ($images['error'][$i]) {
                switch ($images['error'][$i]) {
                    case 1: // UPLOAD_ERR_INIT_SIZE
                        throw new \Exception("Le fichier " . $images['name'][$i] . " dépasse la taille autorisée par le serveur", 3);
                        break;
                    case 2: // UPLOAD_ERR_FORM_SIZE
                        throw new \Exception("Le fichier " . $images['name'][$i] . " dépasse la taille autorisée par le formulaire", 3);
                        break;
                    case 3: // UPLOAD_ERR_PARTIAL
                        throw new \Exception("L'envoi du fichier " . $images['name'][$i] . " a été interrompu pendant le transfert", 3);
                        break;
                    case 4: // UPLOAD_ERR_NO_FILE
                        throw new \Exception("Le fichier " . $images['name'][$i] . " que vous envoyé a une taille nulle", 3);
                        break;
                }
            }
        }

        // Création du dossier pour la sauvegarde
        $dest = 'app/private/images/users/' . $userId . "/articles/" . $articleId . "/";
        if (!mkdir($dest, 0644, true)) {
            throw new \Exception("Création de l'espace de stockage dédié échoué", 3);
        }

        // On enregistre l'image dans l'espace de l'ulisateur si tout va bien
        $names = [];
        for ($i = 0; $i < count($images['tmp_name']); $i++) {
            if ($i == $_ENV['MAX_FILES_UPLOADS']) { break; }

            if (isset($images['tmp_name'][$i])) {
                $name = time() . "_" . $i;

                switch ($images['type'][$i]) {
                    case 'image/jpeg':
                        $name .= '.jpeg';
                        break;
                    case 'image/png':
                        $name .= '.png';
                        break;
                    default:
                        $name .= '.jpeg';
                }

                array_push($names, $name);

                // On enregistre l'image dans le dossier de l'utilisateur
                move_uploaded_file($images['tmp_name'][$i], $dest . $names[$i]);
            }
        }

        return $names;
    }

    public static function dateToFrench(string $date, string $format = "d F Y"): string
    {
        $englishMonths = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $frenchMonths = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

        return str_replace($englishMonths, $frenchMonths, date($format, strtotime($date)));
    }

    public static function dateDiff($date1, $date2): array
    {
        $diff = abs($date1 - strtotime($date2));
        $result = array();

        $tmp = $diff;
        $result['second'] = $tmp % 60;

        $tmp = floor(($tmp - $result['second']) / 60);
        $result['minute'] = $tmp % 60;

        $tmp = floor(($tmp - $result['minute']) / 60);
        $result['hour'] = $tmp % 24;

        $tmp = floor(($tmp - $result['hour'])  / 24 );
        $result['day'] = $tmp;

        return $result;
    }

    public static function dateLastWeek(): array
    {
        $dates = [];

        for ($i = 6; $i >= 0; $i--) {
            array_push($dates, date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')-$i, date('Y'))));
        }

        return $dates;
    }

    public static function deleteDirArticle($userId, $articleId): void
    {
        $dest = 'app/private/images/users/' . $userId . "/articles/" . $articleId . "/";

        // On efface tous les fichiers contenus dans le dossier
        foreach (glob($dest . '/*') as $file) {
            unlink($file) ?? new \Exception("Erreur lors de la supression du fichier", 3);
        }

        rmdir(($dest)) ?? new \Exception("Erreur lors de la supression du dossier", 3);
    }

    public static function folderSize($path): int
    {
        $totalSize = 0;
        $files = scandir($path);

        foreach ($files as $file) {
            if (is_dir(rtrim($path, '/') . '/' . $file)) {
                if ($file != "." && $file != "..") {
                    $size = self::folderSize(rtrim($path, '/') . '/' . $file);
                    $totalSize += $size;
                }
            } else {
                $size = filesize(rtrim($path, '/') . '/' . $file);
                $totalSize += $size;
            }
        }

        return $totalSize;
    }

    public static function formatSize($size) : string
    {
        $mod = 1024;
        $units = explode(" ", 'o Ko Mo Go To Po');
        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }

        return round($size, 2) . ' ' . $units[$i];
    }
}