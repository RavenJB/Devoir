<?php
// Démarre la mise en tampon de sortie (output buffering) pour éviter les problèmes d'affichage avant les redirections
@ob_start();

// Inclut un fichier utilitaire qui contient probablement des fonctions réutilisables
include 'utils.php';

// Récupère le nom du fichier passé en paramètre dans l'URL via la méthode GET
$nomFichier = $_GET['nomFichier'];

// Log l'adresse IP de l'utilisateur et la page "supprime_resultat.php" avec le nom du fichier supprimé
log_adresse_ip("logs/log.txt", "supprime_resultat.php - " . $nomFichier);

// Déplace le fichier de son emplacement actuel (dossier "resultats") vers un dossier "supprime"
rename('./resultats/' . $nomFichier, './supprime/' . $nomFichier);

// Pause l'exécution du script pendant 0.1 seconde pour permettre au système de traiter les actions
usleep(100000);  // 100000 microsecondes = 0.1 seconde

// Redirige l'utilisateur vers la page "affiche_resultat.php" avec le prénom passé en paramètre GET
header('Location: ./affiche_resultat.php?prenomRes=' . $_GET['prenomRes']);
?>
