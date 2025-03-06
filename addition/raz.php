<?php
@ob_start(); // Active la mise en tampon de sortie pour éviter des erreurs d'affichage

include 'utils.php'; // Inclusion du fichier utils.php contenant des fonctions utiles

// Enregistre l'adresse IP de l'utilisateur dans le fichier log spécifié
log_adresse_ip("logs/log.txt", "raz.php");

// Détruit complètement la session en cours
session_destroy(); // Supprime toutes les données de la session
session_unset();   // Efface les variables de session

// Supprime les données envoyées via la méthode POST
unset($_POST);

// Redirige l'utilisateur vers la page d'accueil après la réinitialisation
header('Location: ./index.php');
?>
