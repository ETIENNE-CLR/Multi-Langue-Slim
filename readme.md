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