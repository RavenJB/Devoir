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
$stmt = $db->prepare("SELECT * FROM exercises WHERE user_id = ?");
$stmt->execute([$user_id]);
$exercises = $stmt->fetchAll();

// Récupérer les informations supplémentaires en fonction du rôle
if ($user['role'] == 'parent' || $user['role'] == 'teacher') {
    $stmt = $db->prepare("SELECT * FROM users WHERE parent_id = ? OR teacher_id = ?");
    $stmt->execute([$user_id, $user_id]);
    $students = $stmt->fetchAll();
} elseif ($user['role'] == 'student') {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ? OR id = ?");
    $stmt->execute([$user['parent_id'], $user['teacher_id']]);
    $related_users = $stmt->fetchAll();
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
    
    <?php if ($user['role'] == 'parent' || $user['role'] == 'teacher'): ?>
        <h3>Liste des élèves</h3>
        <ul>
            <?php foreach ($students as $student): ?>
                <li><?php echo htmlspecialchars($student['name']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($user['role'] == 'student'): ?>
        <h3>Parents et Professeurs</h3>
        <ul>
            <?php foreach ($related_users as $related_user): ?>
                <li><?php echo htmlspecialchars($related_user['name']); ?> (<?php echo htmlspecialchars($related_user['role']); ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Statistiques des exercices</h2>
    <ul>
        <?php foreach ($exercises as $exercise): ?>
            <li><?php echo htmlspecialchars($exercise['exercise_name']); ?> : <?php echo htmlspecialchars($exercise['score']); ?> (<?php echo htmlspecialchars($exercise['date_completed']); ?>)</li>
        <?php endforeach; ?>
    </ul>
    <a href="logout.php">Se déconnecter</a>
    <a href="index.php">Revenir à l'accueil</a>
</body>
</html>