# Multi-langue - SLIM PHP
## 1. Prérequis - Installation des packages de langues sur la machine
1. Executer dans un premier temps cette commande :
```bash
sudo dpkg-reconfigure locales
```
2. Ensuite cochez les langues que vous voulez (dans notre cas : français, anglais, allemand).
3. Sélectionnez la langue par défaut `fr_FR.utf8`.
4. Quand vous êtes de nouveau sur la console, quittez votre WSL avec `exit`
5. Dans *Windows Powershell* en **administrateur**, fermez complétement votre WSL avec cette commande :
```powershell
wsl --shutdown
``` 
6. Redémarrer votre WSL et normalement, tout devrait être bon.

## 2. Adaptation dans le code
Avant de commencer à créer les langues, vérifier bien que vous avez ajouté cette partie de code dans le fichier `index.php` en **slim** avant le **`$app->run();`** :
```php
// Multi-langues
$lg = 'en_US';
$charset = 'UTF-8';
$locale = "$lg.$charset";
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain('messages', __DIR__ . '/../locales');
bind_textdomain_codeset('messages', $charset);
textdomain('messages');
```

De plus, vérifier bien que vous avez **adapté votre code** en respectant ce 'schema' à chaque fois que vous mettez du texte :
```php
<?= _("votre texte de base") ?>
```
Pour que le domaine (le choix de la langue) reconnaisse quel texte changer/afficher.

## 3. Ajouter/Modifier les langues
Pour pouvoir gérer les langues, j'ai utilisé [Poedit](https://poedit.net/).

Au démarrage de Poedit, il va falloir faire `Fichier > Nouveau...`. Il va falloir choisir sa langue. Ensuite pensez bien **à sauvegarder le fichier** (îcone en haut à gauche). Ensuite faire `extraire depuis les sources`. Ajouter dans **les chemins,** les dossiers `src/` et `views/`.

> Pour **la traduction**, vous n'êtes **pas obligé de payer** la version premium, vous pouvez indiquer **manuellement** la traduction de chaque mot !


## 4. Changement de la langue via le site
Pour nous faciliter la tâche, voici une petite classe php `LanguageController` qui va nous aider à définir/changer la langue :
```php
class LanguageController
{
    private const SESSION_KEY = 'language';
    private const LANGUAGES = [
        'fr' => 'fr_FR',
        'en' => 'en_US'
        // le reste de vos langues...
    ];
    public const LANGUAGES_TEXT = [
        'fr' => 'Français',
        'en' => 'English'
        // le reste de vos langues...
    ];

    // Fonction qui permet de récupérer la langue active
    public static function getLanguage(): string
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            self::setLanguage('fr'); // Valeur par défaut
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
```
Ensuite, on va modifier un peu la structure de `index.php` comme ceci :
```php
// Multi-langues
session_start();
if (isset($_GET['lang'])) {
    LanguageController::setLanguage($_GET['lang']);
}

// Définition de la langue
$lg = LanguageController::getLanguage();
$charset = 'UTF-8';
$locale = "$lg.$charset";
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain('messages', __DIR__ . '/../locales');
bind_textdomain_codeset('messages', $charset);
textdomain('messages');
```

### Dernière étape !
Pour finaliser le multi-langue sur votre site, il suffit de faire un lien comprenant la clé `lang` dans l'URL avec comme valeur la langue voulu.

Exemple :
```html
<div class="d-flex justify-content-start gap-1">
    <a class="btn btn-link" href="?lang=fr">fr</a>
    <a class="btn btn-link" href="?lang=en">en</a>
</div>
```