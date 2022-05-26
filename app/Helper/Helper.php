<?php 

namespace Knetwork\Helpers;

abstract class Helper
{
    #region DATES

    public static function dateToFrench(string $date, string $format = "d F Y"): string
    {
        $englishMonths = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $frenchMonths = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

        return str_replace($englishMonths, $frenchMonths, date($format, strtotime($date)));
    }

    public static function dateDiff($date1, $date2): string
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
        
        return self::dateDiffToFrench($result);
    }

    private static function dateDiffToFrench(array $time): string
    {
        $str = "";

        if ($time['day'] > 0) {
            $str .= $time['day'] . " jour";
            $time['day'] > 1 ? $str .= "s" : "";
        } elseif ($time['minute'] < 1 && $time['hour'] < 1 && $time['day'] < 1) {
            $str = "À l'instant";
        } elseif ($time['hour'] < 1) {
            $time['minute'] > 0 ? $str .= $time['minute'] . " min" : "";
        } else {
            $time['hour'] > 0 ? $str .= $time['hour'] . " h " : "";
        }

        return $str;
    }

    public static function yesterday(string $format = 'Y-m-d'): string
    {
        $date = date($format, mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));

        return $date;
    }

    public static function getDates(int $days, string $format = 'Y-m-d'): array
    {
        $dates = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            array_push($dates, date($format, mktime(0, 0, 0, date('m'), date('d') - $i, date('Y'))));
        }

        return $dates;
    }
    #endregion

    #region FOLDERS

    public static function createDir($path): void
    {
        if(!mkdir($path, 0644, true)) throw new \Exception("Erreur lors de la création du dossier '" . $path . "'", 3);
    }

    public static function deleteDir($path): void
    {
        // On efface tous les fichiers contenus dans le dossier
        foreach (glob($path . '/*') as $file) {
            if (!unlink($file)) throw new \Exception("Erreur lors de la supression du fichier '" . $file . "'", 3);
        }

        if (!rmdir(($path))) throw new \Exception("Erreur lors de la supression du dossier '" . $path . "'", 3);
    }

    private static function folderSize($path): string
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

    public static function formatSize($path) : string
    {
        // Si aucun dossier n'est détecté
        if (!is_dir($path)) return "0 o";

        $size = self::folderSize($path);

        $mod = 1024;
        $units = explode(" ", 'o Ko Mo Go To Po');
        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }

        return round($size, 2) . ' ' . $units[$i];
    }
    #endregion

    #region UPLOADS

    public static function uploadImage(string $path, array $image): string
    {
        // On vérifie si il y a eu une erreur
        if ($image['error']) self::checkUploadError($image['error']);

        // On enregistre l'image dans l'espace de l'utilisateur
        $name = "";
        if (isset($image['tmp_name'])) {
            $name = time() . ".png";

            // On enregistre l'image dans le dossier de l'utilisateur
            move_uploaded_file($image['tmp_name'], $path . '/' . $name);
        }

        return $name;
    }

    public static function uploadImages(string $path, array $images): array
    {
        // On vérifie si il y a une erreur
        for ($i = 0; $i < count($images['error']); $i++) {
            if ($images['error'][$i]) self::checkUploadError($images['error'][$i]);
        }

        // Création du dossier pour la sauvegarde
        if (!mkdir($path, 0644, true)) throw new \Exception("Erreur lors de la création du dossier '" . $path . "'", 3);

        // On enregistre les images dans l'espace de l'utilisateur
        $names = [];
        for ($i = 0; $i < count($images['tmp_name']); $i++) {
            // Si le nombre de fichier max est atteint, on sort
            if ($i == $_ENV['MAX_FILES_UPLOADS']) break;

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
                move_uploaded_file($images['tmp_name'][$i], $path . '/' . $names[$i]);
            }
        }

        return $names;
    }

    private static function checkUploadError(int $errorCode): void
    {
        switch ($errorCode) {
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
            case 6: // UPLOAD_ERR_NO_TMP_DIR
                throw new \Exception("Un dossier temporaire est manquant", 3);
                break;
            case 7: // UPLOAD_ERR_CANT_WRITE
                throw new \Exception("Échec de l'écriture du fichier sur le disque", 3);
                break;
        }
    }
    #endregion
}