<?php
// Démarrage de la session et inclusion des fichiers nécessaires
@ob_start(); // Active le buffering de sortie, permettant de manipuler les données avant leur envoi au navigateur.
include 'utils.php'; // Inclusion d'un fichier utilitaire pour potentiellement loguer l'adresse IP ou d'autres fonctions
session_start(); // Démarre ou continue une session PHP, permettant de conserver des variables entre les pages

// Configuration du logger Monolog
$log = require __DIR__ . '/log_config.php'; // Charge la configuration du logger Monolog à partir du fichier 'log_config.php'

// Enregistrement d'un log pour suivre l'accès à cette page
$log->info('Accès à question.php', [
    'ip' => $_SERVER['REMOTE_ADDR'], // Récupère l'adresse IP de l'utilisateur
    'page' => 'question.php', // Le nom de la page qui a été consultée
    'user' => $_SESSION['prenom'], // Le prénom de l'utilisateur stocké dans la session
    'question_number' => $_SESSION['nbQuestion'] // Le numéro de la question actuelle de l'utilisateur
]);

// Vérification si le nombre de questions dépasse le maximum autorisé
if ($_SESSION['nbQuestion'] > $_SESSION['nbMaxQuestions']) {
    header('Location: ./fin.php'); // Redirige l'utilisateur vers la page de fin si le nombre de questions est atteint
}

?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Question</title>
    </head>
    <body style="background-color:grey;">
        <?php 
        // Incrémentation du numéro de la question
        $_SESSION['nbQuestion'] = $_SESSION['nbQuestion'] + 1;

        // Initialisation des variables pour la génération de la question
        $nbGauche = 0;
        $nbDroite = 0;
        $operation = 0;
        $reponse = 0;

        // Génération aléatoire des nombres pour le calcul
        $nbGauche = mt_rand(100, 10000); // Nombre aléatoire à gauche entre 100 et 10 000
        $nbDroite = mt_rand(11, 99); // Nombre aléatoire à droite entre 11 et 99
        $operation = $nbGauche . ' x ' . $nbDroite; // Opération de multiplication
        $reponse = $nbGauche * $nbDroite; // Calcul de la réponse correcte à l'opération
        ?>
        <center>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                        <center>
                            <!-- Affichage du numéro de la question et de l'opération -->
                            <h1>Question Numéro <?php echo "".$_SESSION['nbQuestion'].""; ?></h1><br />
                            <h3>Combien fait le calcul suivant ?</h3>
                            <h3><?php echo ''.$operation.' = ?'; ?></h3>

                            <!-- Formulaire pour envoyer la réponse -->
                            <form action="./correction.php" method="post">
                                <!-- Envoi des données cachées : l'opération et la réponse correcte -->
                                <input type="hidden" name="operation" value="<?php echo ''.$operation.' = ' ?>"></input>
                                <input type="hidden" name="correction" value="<?php echo ''.$reponse.'' ?>"></input>
                                <br />
                                <label for="fname">Combien fait le calcul ci-dessus ? </label><br>
                                <input type="text" id="mot" name="mot" autocomplete="off" autofocus><br /><br /><br />
                                <input type="submit" value="Valider"> <!-- Bouton pour valider la réponse -->
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
