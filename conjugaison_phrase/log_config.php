<?php
use Monolog\Logger;  // Importation de la classe Logger de Monolog
use Monolog\Handler\StreamHandler;  // Importation du gestionnaire de flux pour écrire les logs

require __DIR__ . '/../vendor/autoload.php';  // Chargement de l'autoloader généré par Composer

// Création d'un nouvel objet Logger avec le nom 'verbes'
$log = new Logger('verbes');

// Ajout d'un gestionnaire de flux qui écrit les logs dans le fichier 'logs/app.log'
// Les logs de niveau DEBUG ou supérieur seront enregistrés
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG));

// Retour de l'objet Logger configuré
return $log;
