<?php
@ob_start();
include 'utils.php';
session_start();

// Inclure et configurer Monolog
$log = require __DIR__ . '/log_config.php';

// Log l'adresse IP et la page
$log->info('Accès à correction.php', [
    'ip' => $_SERVER['REMOTE_ADDR'],
    'page' => 'correction.php',
    'user' => $_SESSION['prenom'],
    'question_number' => $_SESSION['nbQuestion']
]);

// Si aucune correction n'est envoyée, redirection vers la page d'accueil
if ($_POST['correction'] == "") {
    session_destroy();
    session_unset();
    unset($_POST);
    header('Location: ./index.php');
}
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Correction</title>
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
        <center>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                        <center>
                             <h2>Voici tes bonnes et mauvaises réponses !</h2>

                            <?php
                                $nbPointsLocal = 0;
                                // Vérification des réponses et affichage des résultats
                                if($_POST['mot1'] == $_POST['correction1']){
                                    echo 'Je/J\' '.$_POST['mot1'].' &#9989;<br />';
                                    $_SESSION['nbBonneReponse']++;
                                    $nbPointsLocal++;
                                    $_SESSION['historique'] .= 'Je/J\' '.$_POST['correction1']."\n";
                                } else {
                                    echo 'Je/J\' <strike>'.$_POST['mot1'].'</strike> &#10060; &#10132; '.$_POST['correction1'].'<br />';
                                    $_SESSION['historique'] .= '********Je/J\' '.$_POST['mot1'].';Je/J\' '.$_POST['correction1']."\n";
                                }
                                // Répéter pour les autres réponses...
                                if($_POST['mot2'] == $_POST['correction2']){
                                    echo 'Tu '.$_POST['mot2'].' &#9989;<br />';
                                    $_SESSION['nbBonneReponse']++;
                                    $nbPointsLocal++;
                                    $_SESSION['historique'] .= 'Tu '.$_POST['correction2']."\n";
                                } else {
                                    echo 'Tu <strike>'.$_POST['mot2'].'</strike> &#10060; &#10132; '.$_POST['correction2'].'<br />';
                                    $_SESSION['historique'] .= '********Tu '.$_POST['mot2'].';Tu '.$_POST['correction2']."\n";
                                }
                                // Plus de vérifications pour mot3, mot4, mot5, mot6...
                                if($_POST['mot6'] == $_POST['correction6']){
                                    echo 'Ils/Elles '.$_POST['mot6'].' &#9989;<br />';
                                    $_SESSION['nbBonneReponse']++;
                                    $nbPointsLocal++;
                                    $_SESSION['historique'] .= 'Ils/Elles '.$_POST['correction6']."\n";
                                } else {
                                    echo 'Ils/Elles <strike>'.$_POST['mot6'].'</strike> &#10060; &#10132; '.$_POST['correction6'].'<br />';
                                    $_SESSION['historique'] .= '********Ils/Elles '.$_POST['mot6'].';Ils/Elles '.$_POST['correction6']."\n";
                                }

                                // Affichage du nombre de bonnes réponses
                                echo '<br />';
                                if($nbPointsLocal > 1)
                                    echo 'Tu as '.$nbPointsLocal.' bonnes réponses sur 6 questions.';
                                else
                                    echo 'Tu as '.$nbPointsLocal.' bonne réponse sur 6 questions.';
                            ?>
                            <br /><br />
                            <?php
                                // Vérifie s'il y a encore des questions
                                if($_SESSION['nbQuestion'] < $_SESSION['nbMaxQuestions']){
                            ?>
                            <form action="./question.php" method="post">
                                <input type="submit" value="Suite" autofocus>
                            </form>
                            <?php
                                } else {
                            ?>
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
