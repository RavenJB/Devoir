// filepath: /c:/COURS/BUT3/S1/SAE/Devoir/multiplication/correction.php

// Démarre la mise en mémoire tampon de sortie (ob_start) et la session PHP
@ob_start();
include 'utils.php';  // Inclut un fichier utilitaire, peut-être pour des fonctions auxiliaires comme le logging
session_start();  // Démarre une session PHP pour gérer les variables de session

// Inclure et configurer Monolog pour le logging
$log = require __DIR__ . '/log_config.php';  // Inclut et configure Monolog pour enregistrer les logs

// Log l'adresse IP et la page consultée
$log->info('Accès à correction.php', [
    'ip' => $_SERVER['REMOTE_ADDR'],  // Adresse IP de l'utilisateur
    'page' => 'correction.php',  // Page consultée
    'user' => $_SESSION['prenom'],  // Prénom de l'utilisateur
    'question_number' => $_SESSION['nbQuestion']  // Numéro de la question
]);

// Vérifie si une correction a été fournie, sinon détruit la session et redirige vers la page d'accueil
if ($_POST['correction'] == "") {
    session_destroy();  // Détruit la session en cours
    session_unset();  // Libère toutes les variables de session
    unset($_POST);  // Efface les données du formulaire POST
    header('Location: ./index.php');  // Redirige vers la page d'accueil
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">  <!-- Définit l'encodage des caractères de la page -->
    <title>Correction</title>  <!-- Titre de la page affiché dans le navigateur -->
</head>
<body style="background-color:grey;">  <!-- Définir le fond de la page -->
    <center>  <!-- Centre le contenu sur la page -->
        <table border="0" cellpadding="0" cellspacing="0">  <!-- Table pour organiser la mise en page -->
            <tr>
                <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">  <!-- Section de la page avec une image d'arrière-plan -->
                    <center>  <!-- Centre le contenu dans la cellule -->
                        <?php 
                        // Vérifie si la réponse donnée par l'utilisateur est correcte
                        if ($_POST['mot'] == $_POST['correction']) {
                            // Si la réponse est correcte, affiche un message de succès
                            echo '<h1>Super ' . $_SESSION['prenom'] . ' ! Bonne réponse.</h1>';
                            $_SESSION['nbBonneReponse'] = $_SESSION['nbBonneReponse'] + 1;  // Incrémente le nombre de bonnes réponses
                            $_SESSION['historique'] = $_SESSION['historique'] . '' . $_POST['operation'] . $_POST['correction'] . "\n";  // Ajoute la réponse correcte à l'historique
                        } else {
                            // Si la réponse est incorrecte, affiche un message d'erreur
                            echo '<h1>Oh non !</h1><br />';
                            echo '<h2>La bonne réponse était : ' . $_POST['operation'] . $_POST['correction'] . '.</h2>';
                            $_SESSION['historique'] = $_SESSION['historique'] . '********' . $_POST['operation'] . $_POST['mot'] . ';' . $_POST['correction'] . "\n";  // Enregistre l'erreur dans l'historique
                        }
                        echo '<br />';
                        // Si l'utilisateur n'a pas encore répondu à toutes les questions
                        if ($_SESSION['nbQuestion'] < $_SESSION['nbMaxQuestions']) {
                            // Affiche le score actuel en fonction des réponses correctes
                            if ($_SESSION['nbQuestion'] == 1)
                                echo 'Tu as ' . $_SESSION['nbBonneReponse'] . ' bonne réponse sur ' . $_SESSION['nbQuestion'] . ' question.';
                            else {
                                if ($_SESSION['nbBonneReponse'] > 1)
                                    echo 'Tu as ' . $_SESSION['nbBonneReponse'] . ' bonnes réponses sur ' . $_SESSION['nbQuestion'] . ' questions.';
                                else
                                    echo 'Tu as ' . $_SESSION['nbBonneReponse'] . ' bonne réponse sur ' . $_SESSION['nbQuestion'] . ' questions.';
                            }
                        }
                        ?>
                        <br /><br />
                        <?php
                        // Si l'utilisateur n'a pas terminé toutes les questions, afficher un bouton pour passer à la question suivante
                        if ($_SESSION['nbQuestion'] < $_SESSION['nbMaxQuestions']) {
                        ?>
                        <form action="./question.php" method="post">  <!-- Formulaire pour passer à la question suivante -->
                            <input type="submit" value="Suite" autofocus>  <!-- Bouton pour soumettre et continuer -->
                        </form>
                        <?php
                        } else {
                        ?>
                        <form action="./fin.php" method="post">  <!-- Formulaire pour aller à la page de fin après avoir répondu à toutes les questions -->
                            <input type="submit" value="Suite" autofocus>  <!-- Bouton pour soumettre et terminer -->
                        </form>
                        <?php
                        }
                        ?>
                    </center>
                </td>
                <td style="width:280px;height:430px;background-image:url('./images/NE.jpg');background-repeat:no-repeat;"></td>  <!-- Cellule avec une autre image d'arrière-plan -->
            </tr>
            <tr>
                <td style="width:1000px;height:323px;background-image:url('./images/SO.jpg');background-repeat:no-repeat;"></td>  <!-- Cellule inférieure avec image d'arrière-plan -->
                <td style="width:280px;height:323px;background-image:url('./images/SE.jpg');background-repeat:no-repeat;"></td>  <!-- Autre cellule inférieure avec image d'arrière-plan -->
            </tr>
        </table>
    </center>
    <br />
    <footer style="background-color: #45a1ff;">  <!-- Section du bas avec le pied de page -->
        <center>
            Rémi Synave<br />
            Contact : remi . synave @ univ - littoral [.fr]<br />  <!-- Informations de contact -->
            Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />  <!-- Crédits des images -->
            et Image par <a href="https://pixabay.com/fr/users/everesd_design-16482457/">everesd_design</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=5213756">Pixabay</a> <br />  <!-- Autres crédits d'image -->
        </center>
    </footer>
</body>
</html>
