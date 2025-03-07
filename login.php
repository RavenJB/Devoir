<?php
require 'db.php'; // Inclure les fonctions utilitaires pour la base de données

session_start(); // Démarre une session PHP pour la gestion de l'utilisateur connecté

// Vérification si la requête est de type POST (utilisée pour l'envoi du formulaire de connexion)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name']; // Récupère le nom d'utilisateur depuis le formulaire
    $password = $_POST['password']; // Récupère le mot de passe depuis le formulaire

    // Connexion à la base de données
    $db = getDatabaseConnection();
    // Préparer la requête SQL pour chercher l'utilisateur avec le nom d'utilisateur fourni
    $stmt = $db->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->execute([$name]); // Exécute la requête avec le nom d'utilisateur en paramètre
    $user = $stmt->fetch(); // Récupère l'utilisateur de la base de données

    // Vérifie si l'utilisateur existe et si le mot de passe fourni correspond à celui stocké dans la base de données
    if ($user && password_verify($password, $user['password'])) {
        // Si les informations sont valides, stocke l'ID de l'utilisateur dans la session et redirige vers le profil
        $_SESSION['user_id'] = $user['id'];
        header('Location: profile.php'); // Redirige vers la page du profil
        exit(); // Assure que le script s'arrête après la redirection
    } else {
        // Si les informations sont incorrectes, affiche un message d'erreur
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!-- Formulaire HTML pour la connexion -->
<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<header>
    <nav>
        <center>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="profile.php">Profil</a>
                <a href="logout.php">Se déconnecter</a>
            <?php else : ?>
                <a href="index.php">Accueil</a>
                <a href="register.php">S'inscrire</a>
                <a href="login.php">Se connecter</a>
            <?php endif; ?>
        </center>
    </nav>
</header>
<body>
    <h1>Connexion</h1>
    <form method="post" action="login.php"> <!-- Le formulaire envoie une requête POST à la page login.php -->
        <label for="name">Nom d'utilisateur :</label> <!-- Champ pour le nom d'utilisateur -->
        <input type="text" id="name" name="name" required> <!-- Champ pour entrer le nom d'utilisateur -->
        <br>
        <label for="password">Mot de passe :</label> <!-- Champ pour le mot de passe -->
        <input type="password" id="password" name="password" required> <!-- Champ pour entrer le mot de passe -->
        <br>
        <button type="submit">Se connecter</button> <!-- Bouton pour soumettre le formulaire -->
    </form>
</body>
</html>
