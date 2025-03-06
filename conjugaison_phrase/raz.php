<?php
// Début du code PHP. Utilisation de @ob_start() pour démarrer un tampon de sortie (évite l'affichage direct avant redirection)
@ob_start();

// Inclusion du fichier utils.php qui contient des fonctions utilitaires
include 'utils.php';

// Log de l'adresse IP et de la page d'accès (ici "raz.php")
log_adresse_ip("logs/log.txt", "raz.php");

// Détruire toutes les données de session
session_destroy();  // Cela détruit la session courante

// Supprimer toutes les variables de session
session_unset();  // Cela vide toutes les variables de session

// Vider la variable $_POST pour nettoyer les données envoyées via un formulaire
unset($_POST);  // Supprime toutes les données de la variable $_POST

// Redirection vers la page d'accueil (index.php)
header('Location: ./index.php');
?>
