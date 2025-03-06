<?php
@ob_start(); // Démarre la mise en tampon de sortie pour éviter de sortir du contenu trop tôt
include 'utils.php'; // Inclusion de utilitaires (probablement pour des fonctions comme log_adresse_ip)
session_start(); // Démarre ou reprend la session utilisateur

// Inclure et configurer Monolog (pour la gestion des logs)
$log = require __DIR__ . '/log_config.php';

// Log l'adresse IP et la page visitée (dans ce cas "correction.php")
$log->info('Accès à correction.php', [
    'ip' => $_SERVER['REMOTE_ADDR'], // IP de l'utilisateur
    'page' => 'correction.php', // Page actuelle
    'user' => $_SESSION['prenom'], // Prénom de l'utilisateur (session)
    'question_number' => $_SESSION['nbQuestion'] // Numéro de la question actuelle
]);

// Si la réponse à la question est vide, on détruit la session et on redirige vers la page d'accueil
if ($_POST['correction'] == "") {
    session_destroy(); // Détruit la session
    session_unset(); // Supprime toutes les variables de session
    unset($_POST); // Supprime les données du formulaire
    header('Location: ./index.php'); // Redirige vers la page d'accueil
}
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Correction</title>
    </head>
    <body style="background-color:grey;">
        <center>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                        <center>
                        
                            <?php 
                                // Vérifie si la réponse donnée par l'utilisateur est correcte
                                if ($_POST['mot'] == $_POST['correction']) {
                                    // Si la réponse est correcte
                                    echo '<h1>Super '.$_SESSION['prenom'].' ! Bonne réponse.</h1>';
                                    $_SESSION['nbBonneReponse'] = $_SESSION['nbBonneReponse'] + 1; // Incrémente le nombre de bonnes réponses
                                    $_SESSION['historique'] = $_SESSION['historique'] . '' . $_POST['operation'] . $_POST['correction'] . "\n"; // Ajoute à l'historique
                                } else {
                                    // Si la réponse est incorrecte
                                    echo '<h1>Oh non !</h1><br />';
                                    echo '<h2>La bonne réponse était : '.$_POST['operation'].$_POST['correction'].'.</h2>';
                                    $_SESSION['historique'] = $_SESSION['historique'] . '********' . $_POST['operation'] . $_POST['mot'] . ';' . $_POST['correction'] . "\n"; // Ajoute à l'historique des mauvaises réponses
                                }
                                echo '<br />';
                                
                                // Affiche le nombre de bonnes réponses et le nombre total de questions
                                if ($_SESSION['nbQuestion'] < $_SESSION['nbMaxQuestions']) {
                                    if ($_SESSION['nbQuestion'] == 1)
                                        echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' question.';
                                    else {
                                        if ($_SESSION['nbBonneReponse'] > 1)
                                            echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonnes réponses sur '.$_SESSION['nbQuestion'].' questions.';
                                        else
                                            echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' questions.';
                                    }
                                }
                            ?>
                            <br /><br />
                            <?php
                                // Si le nombre de questions n'a pas encore atteint la limite
                                if ($_SESSION['nbQuestion'] < $_SESSION['nbMaxQuestions']) {
                            ?>
                            <form action="./question.php" method="post">
                                <input type="submit" value="Suite" autofocus>
                            </form>
                            <?php
                                } else {
                            ?>
                                    <!-- Si toutes les questions sont terminées, redirige vers la page de fin -->
                                    <form action="./fin.php" method="post">
                                        <input type="submit" value="Suite" autofocus>
                                    </form>
                            <?php
                                }
                            ?>
                     
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
        <!-- Footer de la page -->
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
