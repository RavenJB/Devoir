<?php
// Démarre le tampon de sortie pour éviter les sorties avant une redirection
@ob_start();

// Inclusion du fichier utils.php qui contient des fonctions utilitaires
include 'utils.php';

// Récupère le nom du fichier à partir de l'URL (via la méthode GET)
$nomFichier = $_GET['nomFichier'];

// Log l'adresse IP et l'action de suppression avec le nom du fichier concerné
log_adresse_ip("logs/log.txt", "supprime_resultat.php - ".$nomFichier);

// Renomme (déplace) le fichier vers le répertoire "supprime" pour le supprimer
rename('./resultats/'.$nomFichier, './supprime/'.$nomFichier);

// Fait une pause d'environ 0.1 seconde avant de rediriger
usleep(100000); // Délai de 0.1 seconde

// Redirige l'utilisateur vers la page "affiche_resultat.php" avec le prénom en paramètre GET
header('Location: ./affiche_resultat.php?prenomRes='.$_GET['prenomRes']);
?>
