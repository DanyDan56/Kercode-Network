<?php 

namespace Knetwork\Models;

use Knetwork\Libs\ORM;

abstract class Model extends ORM
{
    public static function total(string $column = 'id', ?string $table = null, ?array $datesBetween = null): int
    {
        $query = parent::count($column, $table);

        if ($datesBetween) $query .= parent::between($column, $datesBetween[0], $datesBetween[1]);
        
        return parent::result($query)[0];
    }

    /**
     * Récupère le nombre de données créés en fonction des dates envoyées
     *
     * @param array $dates - Tableau de dates pour lesquelles on veut récupérer les statistiques
     * @return array
     */
    public static function chart(array $dates, ?string $table = null): array
    {
        $data = [];
        $first = true;
        $query = parent::count('created_at', $table);
        
        for ($i = 0; $i < count($dates); $i++) {
            $q = $query;

            if ($first) {
                $first = false;
                $q .= parent::between('created_at', '2000-01-01', $dates[$i]);
            } else {
                $q .= parent::between('created_at', $dates[$i-1], $i != 6 ? $dates[$i] : date('Y-m-d H:i:s', time()));
            }
            
            $data[$dates[$i]] = parent::result($q)[0];
        }

        return $data;
    }
}