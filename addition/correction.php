<?php
@ob_start(); // Active le tampon de sortie pour éviter des erreurs d'envoi de headers
include 'utils.php'; // Inclusion du fichier contenant des fonctions utiles
session_start(); // Démarrage de la session PHP pour utiliser les variables de session

// Inclusion et configuration de Monolog pour la journalisation
$log = require __DIR__ . '/log_config.php';

// Enregistre l'accès à cette page dans les logs avec l'adresse IP, la page et les informations utilisateur
$log->info('Accès à correction.php', [
    'ip' => $_SERVER['REMOTE_ADDR'], // Adresse IP de l'utilisateur
    'page' => 'correction.php', // Nom de la page visitée
    'user' => $_SESSION['prenom'], // Prénom de l'utilisateur
    'question_number' => $_SESSION['nbQuestion'] // Numéro de la question actuelle
]);

// Vérifie si le champ correction est vide, dans ce cas, détruit la session et redirige vers l'accueil
if ($_POST['correction'] == "") {
    session_destroy(); // Détruit la session
    session_unset(); // Supprime toutes les variables de session
    unset($_POST); // Supprime les données postées
    header('Location: ./index.php'); // Redirection vers la page d'accueil
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Correction</title> <!-- Titre de la page -->
</head>
<body style="background-color:grey;"> <!-- Définition d'un fond gris -->
    <center>
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                    <center>
                        <?php 
                        // Vérifie si la réponse de l'utilisateur est correcte
                        if($_POST['mot'] == $_POST['correction']){
                            echo '<h1>Super '.$_SESSION['prenom'].' ! Bonne réponse.</h1>';
                            $_SESSION['nbBonneReponse'] += 1; // Incrémente le nombre de bonnes réponses
                            $_SESSION['historique'] .= $_POST['operation'].$_POST['correction']."\n"; // Ajoute à l'historique
                        } else {
                            echo '<h1>Oh non !</h1><br />';
                            echo '<h2>La bonne réponse était : '.$_POST['operation'].$_POST['correction'].'.</h2>';
                            $_SESSION['historique'] .= '********'.$_POST['operation'].$_POST['mot'].';'.$_POST['correction']."\n"; // Enregistre l'erreur
                        }
                        echo '<br />';

                        // Affiche le score actuel de l'utilisateur
                        if($_SESSION['nbQuestion'] < $_SESSION['nbMaxQuestions']){
                            if($_SESSION['nbQuestion'] == 1)
                                echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' question.';
                            else {
                                if($_SESSION['nbBonneReponse'] > 1)
                                    echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonnes réponses sur '.$_SESSION['nbQuestion'].' questions.';
                                else
                                    echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' questions.';
                            }
                        }
                        ?>
                        <br /><br />
                        <?php
                        // Vérifie si toutes les questions ont été répondues
                        if($_SESSION['nbQuestion'] < $_SESSION['nbMaxQuestions']){
                        ?>
                            <form action="./question.php" method="post">
                                <input type="submit" value="Suite" autofocus> <!-- Bouton pour la prochaine question -->
                            </form>
                        <?php
                        } else {
                        ?>
                            <form action="./fin.php" method="post">
                                <input type="submit" value="Suite" autofocus> <!-- Bouton pour finir le test -->
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
    <footer style="background-color: #45a1ff;"> <!-- Pied de page -->
        <center>
            Rémi Synave<br />
            Contact : remi . synave @ univ - littoral [.fr]<br />
            Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/">Pixabay</a> <br />
            et Image par <a href="https://pixabay.com/fr/users/everesd_design-16482457/">everesd_design</a> de <a href="https://pixabay.com/fr/">Pixabay</a> <br />
        </center>
    </footer>
</body>
</html>
