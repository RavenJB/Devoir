<?php
// Utilisation des namespaces de Monolog pour la gestion des logs
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Chargement de l'autoloader de Composer pour gérer les dépendances (Monolog dans ce cas)
require __DIR__ . '/../vendor/autoload.php';

// Création d'une instance du logger, nommé 'conjugaison_verbe'
$log = new Logger('conjugaison_verbe');

// Ajout d'un handler qui envoie les logs dans un fichier, avec le niveau de log "DEBUG"
// Les logs seront stockés dans le fichier 'app.log' dans le dossier 'logs'
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG));

// Retour de l'objet logger pour qu'il puisse être utilisé dans d'autres fichiers
return $log;
