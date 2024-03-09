<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function setLocale($locale)
    {
        // Verifica si el idioma es válido usando los locales definidos en config/translatables.php
        $locales = config('translatable.locales');
        if (in_array($locale, $locales)) {
            // Establece el idioma en la aplicación
            \App::setLocale($locale);

            // Crea una cookie con el idioma preferido del usuario
            $cookie = cookie('o_locale', $locale, 60 * 24 * 30); // 30 días

            // Devuelve una respuesta con la cookie establecida
            return back()->withCookie($cookie);
        }

        // Si el idioma no es válido, redirige o realiza otra acción adecuada
    }


}
