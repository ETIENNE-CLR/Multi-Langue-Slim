<?php

namespace Controllers;

use Exception;
use Models\PDOSingleton;
use PDO;

class LanguageController
{
    public const DEFAULT_LANGUAGE = 'fr';
    private const SESSION_KEY = 'language';
    public const CHARSET = 'UTF-8';

    /**
     * Fonction qui permet de récupérer la langue active
     * @param bool $getKey Option qui permet de retourner la langue active de différente manière :
     * - false (par défaut) : retourne le nom du package de la langue installée sur le serveur (exemple `fr_FR`, `en_US`)
     * - true : retourne la clé de la langue (exemple `fr`, `en`)
     * @return string La langue active du site sous le format demandé
     */
    public static function getLanguage(bool $getKey = false): string
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            self::setLanguage(self::DEFAULT_LANGUAGE);
        }

        return ($getKey) ?
            $_SESSION[self::SESSION_KEY] :
            self::LANGUAGES()[$_SESSION[self::SESSION_KEY]];
    }

    /**
     * Fonction qui permet de définir la langue
     * @param string $langId La langue à définir (exemple : `fr`, `en`)
     */
    public static function setLanguage(string $langId): void
    {
        if (!array_key_exists($langId, self::LANGUAGES())) {
            throw new Exception("Invalid language ID: $langId");
        }
        $_SESSION[self::SESSION_KEY] = $langId;
    }

    /**
     * Fonction pour récupérer les langues disponibles
     * @return array les langues disponibles
     * - Exemple de retour : `['en' => 'en_US', 'fr' => 'fr_FR']`
     */
    private static function LANGUAGES(): array
    {
        static $LANGUAGES = null;

        if ($LANGUAGES == null) {
            try {
                // Init
                $db = PDOSingleton::getInstance();
                $sqlQuery = "SELECT * FROM Langue";
                $stmt = $db->prepare($sqlQuery);

                // Execution du query
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Sortie
                $LANGUAGES = [];
                foreach ($results as $record) {
                    $LANGUAGES[$record['lang']] = $record['locale'];
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 1);
            }
        }
        return $LANGUAGES;
    }

    /**
     * Fonction pour récupérer les langues en texte disponibles
     * @return array les langues en texte disponibles
     * - Exemple de retour : `['en' => 'English', 'fr' => 'Français']`
     */
    public static function LANGUAGES_TEXT(): array
    {
        static $LANGUAGES = null;

        if ($LANGUAGES == null) {
            try {
                // Init
                $db = PDOSingleton::getInstance();
                $sqlQuery = "SELECT * FROM Langue";
                $stmt = $db->prepare($sqlQuery);

                // Execution du query
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Sortie
                $LANGUAGES = [];
                foreach ($results as $record) {
                    $LANGUAGES[$record['lang']] = $record['nom'];
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), 1);
            }
        }
        return $LANGUAGES;
    }

    /**
     * Fonction qui dit si la clé de la langue entré en paramètre est celle qui est active
     * @param string $key Clé à vérifier
     * @return bool Si la clé passée en paramètre correspond à la langue actuelle
     */
    public static function isThisKeyCurrentLanguage(string $key): bool
    {
        return self::LANGUAGES()[$key] == self::getLanguage();
    }
}
