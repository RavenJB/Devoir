<?php
require 'db.php'; // Inclure les fonctions utilitaires pour la base de données

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur
$db = getDatabaseConnection();
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Récupérer les statistiques des exercices
$stmt = $db->prepare("SELECT * FROM exercices WHERE user_id = ?");
$stmt->execute([$user_id]);
$exercices = $stmt->fetchAll();

// Récupérer les informations supplémentaires en fonction du rôle
if ($user['role'] == 'parent' || $user['role'] == 'enseignant') {
    $stmt = $db->prepare("SELECT users.name, users.role FROM users 
                          JOIN role ON (role.parent_id = ? OR role.teacher_id = ?) 
                          WHERE role.child_id = users.id");
    $stmt->execute([$user_id, $user_id]);
    $students = $stmt->fetchAll();
} elseif ($user['role'] == 'enfant') {
    $stmt = $db->prepare("SELECT users.name, users.role FROM users WHERE users.id = ? OR users.id = ?");
    $stmt->execute([$user['parent_id'], $user['teacher_id']]);
    $related_users = $stmt->fetchAll();
}

// Lire les fichiers de résultats dans le dossier 'resultats/'
$results_folder = './mulpitplication/resultats/';
$files = glob($results_folder . '*.txt');
$results = [];

foreach ($files as $file) {
    // Lire le contenu du fichier
    $content = file_get_contents($file);
    
    // Extraire les données du fichier (nom de la matière, note, et date)
    // Le format du fichier est supposé être le suivant :
    // Nom: [prenom]
    // Nombre de bonnes réponses: [bonne_reponse]
    // Nombre total de questions: [nb_question]
    // Historique des réponses: [historique]
    
    $lines = explode("\n", $content);
    $prenom = trim(str_replace("Nom: ", "", $lines[0]));
    $nbBonneReponse = trim(str_replace("Nombre de bonnes réponses: ", "", $lines[1]));
    $nbQuestion = trim(str_replace("Nombre total de questions: ", "", $lines[2]));
    $date = date('Y-m-d H:i:s', filemtime($file)); // Utiliser la date de modification du fichier comme date du test
    
    // Ajouter les résultats dans le tableau
    $results[] = [
        'prenom' => $prenom,
        'note' => $nbBonneReponse . '/' . $nbQuestion,
        'date' => $date,
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
</head>
<body>
    <h1>Profil de <?php echo htmlspecialchars($user['name']); ?></h1>
    <h2>Rôle : <?php echo htmlspecialchars($user['role']); ?></h2>
    
    <?php if ($user['role'] == 'parent' || $user['role'] == 'enseignant'): ?>
        <h3>Liste des élèves</h3>
        <ul>
            <?php foreach ($students as $student): ?>
                <li><?php echo htmlspecialchars($student['name']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($user['role'] == 'enfant'): ?>
        <h3>Parents et Professeurs</h3>
        <ul>
            <?php foreach ($related_users as $related_user): ?>
                <li><?php echo htmlspecialchars($related_user['name']); ?> (<?php echo htmlspecialchars($related_user['role']); ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

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
            <?php foreach ($results as $result): ?>
                <tr>
                    <td><?php echo htmlspecialchars($result['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($result['note']); ?></td>
                    <td><?php echo htmlspecialchars($result['date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="logout.php">Se déconnecter</a>
    <a href="index.php">Revenir à l'accueil</a>
</body>
</html>