<?php
// Indiquer les classes à utiliser

use Controllers\LanguageController;
use Slim\Factory\AppFactory;

// Activer le chargement automatique des classes
require __DIR__ . '/../../vendor/autoload.php';

// Créer l'application
$app = AppFactory::create();

// Ajouter certains traitements d'erreurs
$app->addErrorMiddleware(true, true, true);

// Définir les routes
require __DIR__ . '/../routes/web.php';

// Multi-langues
session_start();
if (isset($_GET['lang'])) {
    LanguageController::setLanguage($_GET['lang']);
}

// Définition de la langue
$lg = LanguageController::getLanguage();
$charset = LanguageController::CHARSET;
$locale = "$lg.$charset";
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain('messages', __DIR__ . '/../locales');
bind_textdomain_codeset('messages', $charset);
textdomain('messages');

// Lancer l'application
$app->run();
