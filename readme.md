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
## Côté base de données MySQL
Créer une table qui contient toutes les langues serait plus pratiques ! Voici un exemple :
```sql
-- Création de la table
CREATE TABLE Langue (
    `lang` VARCHAR(2) PRIMARY KEY, -- fr, en, es
    `locale` VARCHAR(5), -- fr_FR, en_US, es_ES
    `nom` VARCHAR(50) -- Français, English, Espanõl
);
```
Insérer des données à la table :
```sql
-- Insertion des données
INSERT INTO Langue (`lang`, `locale`, `nom`) VALUES
('fr', 'fr_FR', 'Français'),
('en', 'en_US', 'English'),
('es', 'es_ES', 'Español');
```

## Côté PHP
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
### Dans l'arborescance
Dans le dossier `src/`, pensez à créer un dossier `locales/`. Voici comment vous aller stocker les langues du site :
```
/src/locales/.
    ├── en_US 
    │   └── LC_MESSAGES
    │       ├── messages.mo
    │       └── messages.po
    ├── es_ES
    │   └── LC_MESSAGES
    │       ├── messages.mo
    │       └── messages.po
    ├── fr_FR
    │   └── LC_MESSAGES
    │       ├── messages.mo
    │       └── messages.po
    ├── it_IT
    │   └── LC_MESSAGES
    │       ├── messages.mo
    │       └── messages.po
    └── ja_JP
        └── LC_MESSAGES
            ├── messages.mo
            └── messages.po
```

### Dans Poedit
Pour pouvoir gérer les langues, j'ai utilisé [Poedit](https://poedit.net/).

Au démarrage de Poedit, il va falloir faire `Fichier > Nouveau...`. Il va falloir choisir sa langue. Ensuite pensez bien **à sauvegarder le fichier** (îcone en haut à gauche). Ensuite faire `extraire depuis les sources`. Ajouter dans **les chemins,** les dossiers `src/`.

> Pour **la traduction**, vous n'êtes **pas obligé de payer** la version premium, vous pouvez indiquer **manuellement** la traduction de chaque mot !

#### Mettre à jour les traductions
Si vous avez rajouté du texte après avoir sauvegardé le fichier `.po`, il suffit d'ouvrir votre fichier `.po` dans l'éditeur puis de
**mettre à jour depuis le code**. C'est un des boutons du menu principal.

## 4. Changement de la langue via le site
Pour nous faciliter la tâche, voici une petite classe php `LanguageController` qui va nous aider à définir/changer la langue :
```php
class LanguageController
{
    public const DEFAULT_LANGUAGE = 'fr';
    private const SESSION_KEY = 'language';

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
Pour finaliser le multi-langue sur votre site, il suffit de faire un lien comprenant la clé `lang` dans l'URL avec **comme valeur la langue voulu**.

```html
<!-- Exemple : -->
<div class="d-flex justify-content-start gap-1">
    <a class="btn btn-link" href="?lang=fr">fr</a>
    <a class="btn btn-link" href="?lang=en">en</a>
</div>
```
#### Exemple plus poussé
Exemple dynamique utilisant **Bootstrap** et la classe `LanguageController`
```html
<!-- Choix de la langue -->
<div class="dropdown nav-item">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?= _("Langue") ?>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <?php foreach (LanguageController::LANGUAGES_TEXT() as $key => $value): ?>
            <?php if (!LanguageController::isThisKeyCurrentLanguage($key)): ?>
                <li>
                    <a class="dropdown-item" href="?lang=<?= $key ?>"><?= $value ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
```