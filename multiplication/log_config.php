<?php
// Utilisation des namespaces pour importer les classes Monolog
use Monolog\Logger;  // Classe principale pour gérer les logs
use Monolog\Handler\StreamHandler;  // Gestionnaire de flux qui écrit les logs dans un fichier

// Chargement de l'autoloader généré par Composer (pour autoloading des classes)
require __DIR__ . '/../vendor/autoload.php';

// Création d'une instance du logger avec un nom 'multiplication'
$log = new Logger('multiplication');

// Ajout d'un handler pour écrire les logs dans un fichier app.log
// Le niveau de log est défini à Logger::DEBUG, ce qui signifie que tous les logs de niveau DEBUG et au-dessus seront enregistrés.
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG));

// Retourne l'instance du logger créée, pour qu'elle puisse être utilisée ailleurs dans le code.
return $log;
