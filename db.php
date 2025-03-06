<?php
// db.php

// Fonction pour obtenir la connexion à la base de données
function getDatabaseConnection() {
    // Paramètres de connexion à la base de données
    $host = 'localhost'; // Hôte de la base de données
    $db = 'sae_devoir';  // Nom de la base de données
    $user = 'root';      // Utilisateur de la base de données
    $pass = 'root';      // Mot de passe de l'utilisateur
    $charset = 'utf8mb4'; // Jeu de caractères utilisé pour la connexion

    // DSN (Data Source Name) pour la connexion à MySQL
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset"; 
    // Options pour la gestion des erreurs et des résultats de la base de données
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active la gestion des erreurs par exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Définit le mode de récupération des résultats (ici sous forme de tableau associatif)
        PDO::ATTR_EMULATE_PREPARES   => false,                   // Désactive la simulation des requêtes préparées pour plus de sécurité
    ];

    // Essai de connexion à la base de données
    try {
        // Création de la connexion PDO et retour de l'objet
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        // Si une exception est levée (erreur de connexion), on la relance avec le message d'erreur
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}
?>
