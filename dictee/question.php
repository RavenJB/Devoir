<?php
// filepath: /c:/COURS/BUT3/S1/SAE/Devoir/dictee/question.php

@ob_start(); // Démarre la mise en tampon de sortie pour la gestion des erreurs sans affichage immédiat
include 'utils.php'; // Inclut le fichier 'utils.php' qui contient des fonctions utilitaires
session_start(); // Démarre la session pour gérer les variables de session

// Inclure et configurer Monolog pour la gestion des logs
$log = require __DIR__ . '/log_config.php'; // Charge la configuration du logger à partir du fichier 'log_config.php'

// Log l'adresse IP et la page d'accès
$log->info('Accès à question.php', [
    'ip' => $_SERVER['REMOTE_ADDR'], // Adresse IP de l'utilisateur
    'page' => 'question.php', // Page accédée
    'user' => $_SESSION['prenom'], // Prénom de l'utilisateur, stocké dans la session
    'question_number' => $_SESSION['nbQuestion'] // Numéro de la question dans la session
]);

// Si le nombre de questions dépasse le maximum défini, rediriger vers la page de fin
if ($_SESSION['nbQuestion'] > $_SESSION['nbMaxQuestions']) {
    header('Location: ./fin.php'); // Redirige vers la page 'fin.php' si on a dépassé le nombre max de questions
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
            // Incrémenter le numéro de la question dans la session
            $_SESSION['nbQuestion'] = $_SESSION['nbQuestion'] + 1; 

            // Charger le fichier contenant la liste des mots de la dictée
            $fichier = file("listeDeMots/liste_dictee_20230407.txt");

            // Calculer le nombre total de mots dans le fichier
            $total = count($fichier);

            // Choisir un mot aléatoire dans le fichier
            $alea = mt_rand(0, $total - 1);

            // Diviser la ligne choisie du fichier en un tableau à partir du séparateur ';'
            $ligneFichier = explode(';', $fichier[$alea]);
        ?>

        <center>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                        <center>

                            <!-- Affichage du numéro de la question -->
                            <h1>Question Numéro <?php echo "".$_SESSION['nbQuestion']."" ?></h1><br />

                            <!-- Lecture de l'audio correspondant au mot de la dictée -->
                            <audio autoplay controls>
                                <source src="./<?php echo './sons/'.$ligneFichier[1].''?>" type="audio/mpeg">
                                Votre navigateur ne supporte pas l'audio. Passez à Firefox !
                            </audio>

                            <!-- Formulaire pour que l'utilisateur entre la réponse -->
                            <form action="./correction.php" method="post">
                                <input type="hidden" name="correction" value="<?php echo ''.$ligneFichier[0].''?>"> <!-- Mot correct à comparer -->
                                <input type="hidden" name="nomFichierSon" value="<?php echo ''.$ligneFichier[1].''?>"> <!-- Nom du fichier audio -->
                                <br />
                                <!-- Demande à l'utilisateur ce qu'il a entendu -->
                                <label for="fname">Qu'as-tu entendu ?</label><br>
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

        <!-- Footer avec les crédits de l'application -->
        <footer style="background-color: #45a1ff;">
            <center>
                Rémi Synave<br />
                Contact : remi . synave @ univ - littoral [.fr]<br />
                Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
                Crédits voix : Denise de <a href="https://azure.microsoft.com/fr-fr/services/cognitive-services/text-to-speech/">Microsoft Azure</a>
            </center>
        </footer>
    </body>
</html>
