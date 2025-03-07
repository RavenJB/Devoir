<?php
// Démarre le tampon de sortie (ob_start) pour capturer toute la sortie HTML dans le tampon
@ob_start();

// Inclusion du fichier utils.php contenant des fonctions utiles pour l'application
include 'utils.php';

// Démarre la session pour pouvoir stocker et récupérer des variables de session
session_start();

// Inclure et configurer Monolog (gestion des logs)
$log = require __DIR__ . '/log_config.php';

// Log l'adresse IP de l'utilisateur, la page accédée, son prénom (stocké dans la session),
// et le numéro de la question (également stocké dans la session)
$log->info('Accès à question.php', [
    'ip' => $_SERVER['REMOTE_ADDR'],    // Récupère l'adresse IP de l'utilisateur
    'page' => 'question.php',           // La page qui est accédée
    'user' => $_SESSION['prenom'],      // Le prénom de l'utilisateur stocké dans la session
    'question_number' => $_SESSION['nbQuestion']  // Le numéro de la question stocké dans la session
]);

// Si le nombre de questions a dépassé le maximum autorisé, redirige vers la page de fin
if ($_SESSION['nbQuestion'] > $_SESSION['nbMaxQuestions']) {
    header('Location: ./fin.php');
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Question</title>
</head>
<header>
    <nav>
        <center>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="../profile.php">Profil</a>
                <a href="../logout.php">Se déconnecter</a>
            <?php else : ?>
                <a href="../index.php">Accueil</a>
                <a href="../register.php">S'inscrire</a>
                <a href="../login.php">Se connecter</a>
            <?php endif; ?>
        </center>
    </nav>
</header>
<body style="background-color:grey;">
    <?php 
        // Incrémente le numéro de la question dans la session
        $_SESSION['nbQuestion'] = $_SESSION['nbQuestion'] + 1;

        // Initialisation des variables
        $nbGauche = 0;
        $nbDroite = 0;
        $operation = 0;
        $reponse = 0;

        // Génération de la question (version difficile)
        $nbGauche = mt_rand(6000, 10000);    // Génère un nombre aléatoire entre 6000 et 10000 pour le nombre de gauche
        $nbDroite = mt_rand(100, 6000);      // Génère un nombre aléatoire entre 100 et 6000 pour le nombre de droite
        $operation = $nbGauche . ' - ' . $nbDroite;  // Formule de l'opération
        $reponse = $nbGauche - $nbDroite;    // Calcul de la réponse

        // Version facile (commentée ici mais peut être utilisée pour une version plus simple)
        // $nbGauche = mt_rand(6, 10); 
        // $nbDroite = mt_rand(1, $nbGauche);
        // $operation = $nbGauche . ' - ' . $nbDroite;
        // $reponse = $nbGauche - $nbDroite;
    ?>
    <center>
        <!-- Structure de la page avec une table pour aligner les éléments -->
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                    <center>
                        <!-- Affiche le numéro de la question -->
                        <h1>Question Numéro <?php echo "" . $_SESSION['nbQuestion'] . ""; ?></h1><br />
                        <!-- Affiche l'opération à résoudre -->
                        <h3>Combien fait le calcul suivant ?</h3>
                        <h3><?php echo '' . $operation . ' = ?'; ?></h3>
                        
                        <!-- Formulaire pour soumettre la réponse -->
                        <form action="./correction.php" method="post">
                            <input type="hidden" name="operation" value="<?php echo '' . $operation . ' = ' ?>"></input>
                            <input type="hidden" name="correction" value="<?php echo '' . $reponse . '' ?>"></input>
                            <br />
                            <!-- Demande à l'utilisateur de répondre -->
                            <label for="fname">Combien fait le calcul ci-dessus ? </label><br>
                            <input type="text" id="mot" name="mot" autocomplete="off" autofocus><br /><br /><br />
                            <input type="submit" value="Valider">
                        </form>
                    </center>
                </td>
                <td style="width:280px;height:430px;background-image:url('./images/NE.jpg');background-repeat:no-repeat;"></td>
            </tr>
            <tr>
                <td style="width:1000px;height:323px;background-image:url('./images/SO.jpg');background-repeat:no-repeat;"></td>
                <td style="width:280px;height:323px;background-image:url('./images/SE.jpg');background-repeat:no-repeat;"></td>
            </tr>
        </table>
    </center>
    <br />
    <!-- Footer avec des informations de contact -->
    <footer style="background-color: #45a1ff;">
        <center>
            Rémi Synave<br />
            Contact : remi . synave @ univ - littoral [.fr]<br />
            Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
            et Image par <a href="https://pixabay.com/fr/users/everesd_design-16482457/">everesd_design</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=5213756">Pixabay</a> <br />
        </center>
    </footer>
</body>
</html>
