<?php
// Utilisation de Monolog pour gérer les logs
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Inclusion du fichier autoload de Composer pour charger les dépendances nécessaires
require __DIR__ . '/../vendor/autoload.php';

// Création d'une instance du logger, ici nommé 'soupstraction'
$log = new Logger('soupstraction');

// Ajout d'un handler pour écrire les logs dans un fichier 'app.log' situé dans le dossier 'logs'
// Le niveau de log est défini sur 'DEBUG', ce qui signifie que tous les logs avec un niveau DEBUG ou supérieur seront enregistrés
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG));

// Retourne l'objet $log afin qu'il puisse être utilisé ailleurs dans le projet
return $log;
