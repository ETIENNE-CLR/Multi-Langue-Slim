<?php
// Indiquer les classes à utiliser
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
$lg = 'fr_FR';
$lg = 'en_US';
$charset = 'UTF-8';
$locale = "$lg.$charset";
putenv("LC_ALL=$locale");
$xx = setlocale(LC_ALL, $locale);
echo $xx;
$xx = bindtextdomain('messages', __DIR__ . '/../locales');
$xx = bind_textdomain_codeset('messages', $charset);
$xx = textdomain('messages');

// Lancer l'application
$app->run();
