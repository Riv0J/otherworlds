<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OHelper extends Model
{
    use HasFactory;

    public static function makeUrlFriendly(string $filename) {
        // Reemplazar caracteres especiales con guiones medios
        $filename = preg_replace('/[\/?%*:|"<>\\.]/', '-', $filename);

        // Reemplazar espacios en blanco con guiones bajos
        $filename = str_replace(' ', '_', $filename);

        // Reemplazar comillas simples con un string vacío
        $filename = str_replace("'", '', $filename);

        // Convertir todo a minúsculas
        $filename = strtolower($filename);

        return $filename;
    }
}
