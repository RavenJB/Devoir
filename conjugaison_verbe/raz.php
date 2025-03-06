<?php
// Démarre la mise en tampon de sortie (output buffering) pour éviter les problèmes d'affichage avant les redirections
@ob_start();

// Inclut le fichier utilitaire qui contient probablement des fonctions réutilisables
include 'utils.php';

// Log l'adresse IP de l'utilisateur et la page "raz.php" (qui semble être une page de réinitialisation ou de déconnexion)
log_adresse_ip("logs/log.txt", "raz.php");

// Détruit toutes les variables de session et nettoie la session en cours
session_destroy();  // Détruit la session en cours
session_unset();    // Supprime toutes les variables de session stockées

// Supprime toutes les données envoyées par le formulaire via POST
unset($_POST);

// Redirige l'utilisateur vers la page d'accueil (index.php)
header('Location: ./index.php');
?>
