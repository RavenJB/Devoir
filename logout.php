<?php
session_start(); // Démarre une session ou reprend une session existante. Cela permet d'accéder aux variables de session.
session_unset(); // Supprime toutes les variables de session. Cela ne détruit pas la session, mais vide les données de session.
session_destroy(); // Détruit la session en cours, supprimant les données de session du serveur.
header('Location: index.html'); // Redirige l'utilisateur vers la page d'accueil (index.html) après la déconnexion.
exit(); // Arrête l'exécution du script après la redirection, afin de garantir qu'aucune autre donnée ne sera envoyée.
?>
