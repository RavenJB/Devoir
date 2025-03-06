<?php
// Importation des classes nécessaires de Monolog
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Chargement automatique des dépendances avec Composer
require __DIR__ . '/../vendor/autoload.php';

// Création d'un nouveau logger avec le nom "addition"
$log = new Logger('addition');

// Ajout d'un gestionnaire de logs qui écrit les messages dans le fichier "logs/app.log"
// avec un niveau de journalisation défini à DEBUG (tous les niveaux de logs seront enregistrés)
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG));

// Retourne l'objet logger pour être utilisé dans d'autres fichiers PHP
return $log;
