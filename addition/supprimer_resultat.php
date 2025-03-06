<?php
@ob_start(); // Démarre la gestion du tampon de sortie (output buffering). L'@ permet de supprimer les éventuels messages d'erreur qui pourraient être générés.
include 'utils.php'; // Inclut le fichier utils.php. Cela peut contenir des fonctions ou des variables utiles au script.

$nomFichier = $_GET['nomFichier']; // Récupère la valeur du paramètre 'nomFichier' dans l'URL (via GET) et la stocke dans la variable $nomFichier.

log_adresse_ip("logs/log.txt", "supprime_resultat.php - ".$nomFichier); // Appelle une fonction log_adresse_ip définie dans utils.php pour enregistrer l'adresse IP et le nom du fichier supprimé dans un fichier de log ('logs/log.txt').

rename('./resultats/'.$nomFichier, './supprime/'.$nomFichier); // Déplace (ou renomme) le fichier spécifié par $nomFichier du dossier 'resultats' vers 'supprime'. Cela semble être une opération de suppression (le fichier est déplacé et non effacé).

usleep(100000); // Met le script en pause pendant 100 000 microsecondes (0,1 seconde), ce qui permet de simuler un délai avant de rediriger l'utilisateur.

header('Location: ./affiche_resultat.php?prenomRes='.$_GET['prenomRes']); // Redirige l'utilisateur vers la page 'affiche_resultat.php', en passant le paramètre 'prenomRes' via l'URL.
?>
