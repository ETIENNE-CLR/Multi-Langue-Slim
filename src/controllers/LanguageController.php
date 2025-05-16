<?php

namespace Controllers;

use Exception;

class LanguageController
{
    private const SESSION_KEY = 'language';
    private const LANGUAGES = [
        'fr' => 'fr_FR',
        'en' => 'en_US',
    ];

    // Fonction qui permet de récupérer la langue active
    public static function getLanguage(): string
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            self::setLanguage('fr');
        }
        return self::LANGUAGES[$_SESSION[self::SESSION_KEY]] ?? '';
    }

    // Fonction qui permet de définir la langue
    public static function setLanguage(string $langId): void
    {
        if (!array_key_exists($langId, self::LANGUAGES)) {
            throw new Exception("Invalid language ID: $langId");
        }
        $_SESSION[self::SESSION_KEY] = $langId;
    }

    // Fonction bonus pour récupérer 
    public static function getAvailableLanguages(): array
    {
        return self::LANGUAGES;
    }
}
