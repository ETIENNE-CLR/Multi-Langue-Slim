<?php
phpinfo();

/*

echo "<pre>";

// 1. Locale système
echo "=== locale -a (shell) ===\n";
echo shell_exec('locale -a');

// 2. Environnement du processus PHP
echo "\n=== getenv() ===\n";
echo "LANG: " . getenv('LANG') . "\n";
echo "LC_ALL: " . getenv('LC_ALL') . "\n";

// 3. Test setlocale()
echo "\n=== Test setlocale() ===\n";a
$locales = ['en_US.UTF-8', 'en_US.utf8', 'en_US', 'C'];
$result = setlocale(LC_ALL, $locales);
echo "Résultat setlocale: ";
var_dump($result);

// 4. Valeurs actuelles des constantes locales
echo "\n=== Valeurs actuelles ===\n";
echo "LC_ALL: " . setlocale(LC_ALL, 0) . "\n";
echo "LC_MESSAGES: " . setlocale(LC_MESSAGES, 0) . "\n";
echo "LC_TIME: " . setlocale(LC_TIME, 0) . "\n";

// 5. bindtextdomain
echo "\n=== gettext ===\n";
bindtextdomain('messages', __DIR__ . '/../locales');
bind_textdomain_codeset('messages', 'UTF-8');
textdomain('messages');
echo "Exemple de traduction : " . _('Hello world') . "\n";

// 6. phpinfo de base
echo "\n=== PHP info court ===\n";
echo "PHP version: " . PHP_VERSION . "\n";
echo "Server API: " . php_sapi_name() . "\n";

echo "</pre>";
*/