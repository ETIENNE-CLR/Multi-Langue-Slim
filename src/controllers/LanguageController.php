<?php

namespace Controllers;

use Exception;

class LanguageController
{
    private const SESSION_KEY = 'language';
    private const LANGUAGES = [
        'fr' => 'fr_FR',
        'en' => 'en_US',
        'es' => 'es_ES',
        'it' => 'it_IT',
        'ja' => 'ja_JP',
    ];
    public const LANGUAGES_TEXT = [
        'fr' => 'Français',
        'en' => 'English',
        'es' => 'Espanõl',
        'it' => 'Italian',
        'ja' => '日本語',
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

    // Fonction bonus pour récupérer les langues disponibles
    public static function getAvailableLanguages(): array
    {
        return self::LANGUAGES;
    }

    // Fonction qui dit si la clé de la langue entré en paramètre est celle qui est active
    public static function isThisKeyCurrentLanguage(string $key): bool
    {
        return self::LANGUAGES[$key] == self::getLanguage();
    }
}
