<?php

namespace Controllers;

use Exception;

class LanguageController
{
    public const SESSION_KEY = 'language';
    private const LANGUAGES = [
        'fr' => 'fr_FR',
        'en' => 'en_US',
    ];

    public static function getLanguage(): string
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            self::setLanguage('fr');
        }
        return self::LANGUAGES[$_SESSION[self::SESSION_KEY]] ?? '';
    }

    public static function setLanguage(string $langId): void
    {
        if (!array_key_exists($langId, self::LANGUAGES)) {
            throw new Exception("Invalid language ID: $langId");
        }
        $_SESSION[self::SESSION_KEY] = $langId;
    }

    // Bonus : méthode utilitaire pour avoir toutes les langues disponibles
    public static function getAvailableLanguages(): array
    {
        return self::LANGUAGES;
    }
}
