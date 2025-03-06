<?php
use Monolog\Logger; // Charge la classe Logger de Monolog
use Monolog\Handler\StreamHandler; // Charge le handler pour écrire les logs dans un fichier

require __DIR__ . '/../vendor/autoload.php'; // Charge automatiquement les dépendances via Composer

$log = new Logger('dictee'); // Crée un nouveau logger avec le nom 'dictee'

$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG)); // Configure un handler pour écrire les logs dans un fichier 'app.log' avec un niveau DEBUG

return $log; // Retourne l'instance du logger
