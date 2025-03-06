<?php
// Inclusion du fichier de connexion à la base de données
require 'db.php'; // Inclure les fonctions utilitaires pour la base de données

// Démarrer la session pour accéder aux informations de session de l'utilisateur
session_start();

// Vérification si l'utilisateur est connecté. Si non, rediriger vers la page de connexion.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirection vers la page de login
    exit(); // Fin de l'exécution du script
}

// Récupération de l'ID utilisateur à partir de la session
$user_id = $_SESSION['user_id'];

// Connexion à la base de données
$db = getDatabaseConnection();

// Préparation de la requête pour récupérer les informations de l'utilisateur à partir de l'ID
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(); // Exécution de la requête et récupération des résultats

// Récupération des statistiques des exercices de l'utilisateur
$stmt = $db->prepare("SELECT * FROM exercices WHERE user_id = ?");
$stmt->execute([$user_id]);
$exercices = $stmt->fetchAll(); // Récupération de tous les résultats des exercices

// Si l'utilisateur est un parent ou un enseignant, récupérer la liste des élèves associés
if ($user['role'] == 'parent' || $user['role'] == 'enseignant') {
    $stmt = $db->prepare("SELECT users.name, users.role FROM users 
                          JOIN role ON (role.parent_id = ? OR role.teacher_id = ?) 
                          WHERE role.child_id = users.id");
    $stmt->execute([$user_id, $user_id]);
    $students = $stmt->fetchAll(); // Récupération des élèves associés à ce parent ou enseignant
} elseif ($user['role'] == 'enfant') {
    // Si l'utilisateur est un enfant, récupérer les informations de ses parents et de son enseignant
    $stmt = $db->prepare("SELECT users.name, users.role FROM users WHERE users.id = ? OR users.id = ?");
    $stmt->execute([$user['parent_id'], $user['teacher_id']]);
    $related_users = $stmt->fetchAll(); // Récupération des informations des parents et enseignants
}

// Lecture des fichiers de résultats dans le dossier 'resultats/' pour récupérer les résultats d'exercices
$results_folder = './mulpitplication/resultats/';
$files = glob($results_folder . '*.txt'); // Récupère tous les fichiers texte du dossier 'resultats/'
$results = []; // Tableau pour stocker les résultats des exercices

foreach ($files as $file) {
    // Lecture du contenu de chaque fichier de résultats
    $content = file_get_contents($file);
    
    // Extraction des données à partir du fichier texte (format prédéfini)
    $lines = explode("\n", $content); // Divise le contenu en lignes
    $prenom = trim(str_replace("Nom: ", "", $lines[0])); // Extrait le prénom de l'élève
    $nbBonneReponse = trim(str_replace("Nombre de bonnes réponses: ", "", $lines[1])); // Nombre de bonnes réponses
    $nbQuestion = trim(str_replace("Nombre total de questions: ", "", $lines[2])); // Nombre total de questions
    $date = date('Y-m-d H:i:s', filemtime($file)); // Date de la dernière modification du fichier, utilisée comme la date du test
    
    // Ajout des résultats au tableau
    $results[] = [
        'prenom' => $prenom,
        'note' => $nbBonneReponse . '/' . $nbQuestion, // Affichage sous forme de "nbBonneReponse/nbQuestion"
        'date' => $date, // Date du test
    ];
}
?>

<!-- Code HTML pour afficher les informations du profil de l'utilisateur -->
<!DOCTYPE html>
<html>
<head>
    <title>Profil</title> <!-- Titre de la page -->
</head>
<body>
    <h1>Profil de <?php echo htmlspecialchars($user['name']); ?></h1> <!-- Affiche le nom de l'utilisateur -->
    <h2>Rôle : <?php echo htmlspecialchars($user['role']); ?></h2> <!-- Affiche le rôle de l'utilisateur -->
    
    <!-- Si l'utilisateur est un parent ou un enseignant, afficher la liste des élèves associés -->
    <?php if ($user['role'] == 'parent' || $user['role'] == 'enseignant'): ?>
        <h3>Liste des élèves</h3>
        <ul>
            <?php foreach ($students as $student): ?>
                <li><?php echo htmlspecialchars($student['name']); ?></li> <!-- Affichage du nom de chaque élève -->
            <?php endforeach; ?>
        </ul>
    <?php elseif ($user['role'] == 'enfant'): ?>
        <!-- Si l'utilisateur est un enfant, afficher ses parents et enseignants -->
        <h3>Parents et Professeurs</h3>
        <ul>
            <?php foreach ($related_users as $related_user): ?>
                <li><?php echo htmlspecialchars($related_user['name']); ?> (<?php echo htmlspecialchars($related_user['role']); ?>)</li> <!-- Affichage du nom et rôle des parents et enseignants -->
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Affichage des statistiques des exercices -->
    <h2>Statistiques des exercices</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nom de la matière</th>
                <th>Note</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <!-- Affichage des résultats extraits des fichiers -->
            <?php foreach ($results as $result): ?>
                <tr>
                    <td><?php echo htmlspecialchars($result['prenom']); ?></td> <!-- Nom de l'élève -->
                    <td><?php echo htmlspecialchars($result['note']); ?></td> <!-- Note de l'exercice -->
                    <td><?php echo htmlspecialchars($result['date']); ?></td> <!-- Date du test -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Liens pour se déconnecter et revenir à l'accueil -->
    <a href="logout.php">Se déconnecter</a>
    <a href="index.php">Revenir à l'accueil</a>
</body>
</html>
