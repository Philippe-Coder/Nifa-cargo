<?php

namespace App\Helpers;

class LocaleHelper
{
    /**
     * Ajoute le paramètre locale actuel à une URL
     *
     * @param string $url
     * @return string
     */
    public static function addLocaleToUrl(string $url): string
    {
        $currentLocale = app()->getLocale();
        $defaultLocale = config('app.locale', 'fr');
        
        // Si c'est la langue par défaut, on n'ajoute pas le paramètre
        if ($currentLocale === $defaultLocale) {
            return $url;
        }
        
        // Ajouter ou remplacer le paramètre locale
        $separator = (strpos($url, '?') !== false) ? '&' : '?';
        
        // Vérifier si locale existe déjà dans l'URL
        if (strpos($url, 'locale=') !== false) {
            // Remplacer le paramètre existant
            $url = preg_replace('/locale=[a-zA-Z_]+/', "locale={$currentLocale}", $url);
        } else {
            // Ajouter le nouveau paramètre
            $url .= "{$separator}locale={$currentLocale}";
        }
        
        return $url;
    }

    /**
     * Obtient le paramètre de locale pour les liens
     *
     * @return string
     */
    public static function getLocaleParam(): string
    {
        $currentLocale = app()->getLocale();
        $defaultLocale = config('app.locale', 'fr');
        
        return ($currentLocale !== $defaultLocale) ? "?locale={$currentLocale}" : '';
    }
}