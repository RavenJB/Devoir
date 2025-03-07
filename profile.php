<?php
// Inclusion du fichier de connexion
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$db = getDatabaseConnection();

// Récupération des informations de l'utilisateur
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Lecture des fichiers de résultats
$results_folder = 'resultats/';
$files = glob($results_folder . '*.txt');
$results = [];

foreach ($files as $file) {
    $content = file_get_contents($file);
    $lines = explode("\n", trim($content));

    if (count($lines) < 3) continue;

    $prenom = trim(str_replace("Nom: ", "", $lines[0]));
    $nbBonneReponse = trim(str_replace("Nombre de bonnes réponses: ", "", $lines[1]));
    $nbQuestion = trim(str_replace("Nombre total de questions: ", "", $lines[2]));

    $date = date('Y-m-d H:i:s', filemtime($file));
    
    // Extraction des réponses aux questions
    $questions = array_slice($lines, 3); // Prend toutes les lignes après la 3e

    $results[] = [
        'prenom' => $prenom ?: "",
        'note' => "$nbBonneReponse/$nbQuestion",
        'date' => $date,
        'questions' => $questions
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
        .details { display: none; padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd; margin-top: 10px; }
        .btn { padding: 5px 10px; cursor: pointer; background-color: #007bff; color: white; border: none; border-radius: 5px; }
        .btn:hover { background-color: #0056b3; }
    </style>
    <script>
        function toggleDetails(index) {
            var details = document.getElementById("details-" + index);
            if (details.style.display === "none") {
                details.style.display = "block";
            } else {
                details.style.display = "none";
            }
        }
    </script>
</head>
<body>

<h1>Profil de <?php echo htmlspecialchars($user['name']); ?></h1>
<h2>Rôle : <?php echo htmlspecialchars($user['role']); ?></h2>

<h2>Statistiques des exercices</h2>
<table>
    <thead>
        <tr>
            <th>Nom de l'élève</th>
            <th>Note</th>
            <th>Date</th>
            <th>Résultats</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($results)) : ?>
            <tr>
                <td colspan="4">Aucun résultat disponible</td>
            </tr>
        <?php else : ?>
            <?php foreach ($results as $index => $result): ?>
                <tr>
                    <td><?php echo htmlspecialchars($result['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($result['note']); ?></td>
                    <td><?php echo htmlspecialchars($result['date']); ?></td>
                    <td>
                        <button class="btn" onclick="toggleDetails(<?php echo $index; ?>)">Voir détails</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div id="details-<?php echo $index; ?>" class="details">
                            <h4>Questions et réponses :</h4>
                            <ul>
                                <?php foreach ($result['questions'] as $question): ?>
                                    <li><?php echo htmlspecialchars($question); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="logout.php">Se déconnecter</a>
<a href="index.php">Revenir à l'accueil</a>

</body>
</html>
