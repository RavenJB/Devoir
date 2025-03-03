<?php
require 'db.php'; // Inclure la connexion à la base de données

$db = getDatabaseConnection();

// Récupérer la liste des enfants inscrits
$stmt = $db->query("SELECT id, name FROM users WHERE role = 'enfant'");
$children = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $selected_children = isset($_POST['children']) ? $_POST['children'] : [];

    // Vérification que le rôle est valide
    $valid_roles = ['enfant', 'enseignant', 'parent'];
    if (!in_array($role, $valid_roles)) {
        echo "Rôle invalide.";
        exit();
    }

    try {
        // Insérer l'utilisateur dans la base de données
        $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role]);
        $user_id = $db->lastInsertId(); // Récupérer l'ID de l'utilisateur inséré

        // Associer l'enseignant ou le parent aux enfants sélectionnés
        if (($role == 'enseignant' || $role == 'parent') && !empty($selected_children)) {
            $stmt = $db->prepare("INSERT INTO role (parent_id, teacher_id, child_id) VALUES (?, ?, ?)");
            foreach ($selected_children as $child_id) {
                $stmt->execute([
                    $role == 'parent' ? $user_id : null, // Si parent, on met l'ID dans parent_id
                    $role == 'enseignant' ? $user_id : null, // Si enseignant, on met l'ID dans teacher_id
                    $child_id
                ]);
            }
        }

        // Redirection vers la page de connexion
        header('Location: login.php');
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <script>
        function toggleChildrenSelection() {
            var role = document.getElementById("role").value;
            var childrenSection = document.getElementById("children-selection");

            if (role === "enseignant" || role === "parent") {
                childrenSection.style.display = "block";
            } else {
                childrenSection.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <h1>Inscription</h1>
    <form method="post" action="register.php">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="role">Rôle :</label>
        <select id="role" name="role" required onchange="toggleChildrenSelection()">
            <option value="enfant">Enfant</option>
            <option value="enseignant">Enseignant</option>
            <option value="parent">Parent</option>
        </select>
        <br>

        <!-- Sélection des enfants si le rôle est "enseignant" ou "parent" -->
        <div id="children-selection" style="display: none;">
            <label>Associer des enfants :</label>
            <br>
            <?php foreach ($children as $child) : ?>
                <input type="checkbox" name="children[]" value="<?= $child['id'] ?>"> <?= htmlspecialchars($child['name']) ?><br>
            <?php endforeach; ?>
        </div>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>