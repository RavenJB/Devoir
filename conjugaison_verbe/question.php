<?php
// Inclut un fichier utilitaire pour des fonctions ou des variables partagées
@ob_start();
include 'utils.php';

// Démarre la session PHP pour suivre l'état de l'utilisateur
session_start();

// Inclure et configurer Monolog pour la gestion des logs
$log = require __DIR__ . '/log_config.php';

// Enregistrement d'un log d'accès pour suivre l'activité sur cette page
$log->info('Accès à question.php', [
    'ip' => $_SERVER['REMOTE_ADDR'],  // Adresse IP de l'utilisateur
    'page' => 'question.php',         // Nom de la page accédée
    'user' => $_SESSION['prenom'],    // Prénom de l'utilisateur (stocké en session)
    'question_number' => $_SESSION['nbQuestion']  // Le numéro de la question actuelle
]);

// Vérifie si le nombre de questions dépasse la limite, et redirige vers la page finale
if ($_SESSION['nbQuestion'] > $_SESSION['nbMaxQuestions']) {
    header('Location: ./fin.php');  // Redirige vers la page de fin
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
        // Active l'affichage des erreurs pour le débogage
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        // Incrémente le numéro de la question dans la session
        $_SESSION['nbQuestion'] = $_SESSION['nbQuestion'] + 1;

        // Génère aléatoirement un temps pour la conjugaison (présent, futur ou imparfait)
        $alea = mt_rand(2, 2);
        $temps = 'present';

        if ($alea == 1) {
            $temps = 'futur';
        }
        if ($alea == 2) {
            $temps = 'imparfait';
        }

        // Charge le fichier correspondant au temps sélectionné
        $fichier = file("verbes/" . $temps . ".txt");
        $total = count($fichier);  // Nombre total de verbes disponibles
        $alea = mt_rand(0, $total - 1);  // Choisit un verbe aléatoire
        $verbe = $fichier[$alea];  // Récupère le verbe à la position aléatoire
        $verbe = substr($verbe, 0, -1);  // Enlève le retour à la ligne à la fin du verbe

        // Supprime les accents du verbe pour créer un nom de fichier compatible
        $verbeSansAccent = str_replace(["à", "â", "é", "è", "ë", "ê", "î", "ï", "ô", "ö", "ù", "û", "ü", "ÿ", "ç"], 
                                       ["a", "a", "e", "e", "e", "e", "i", "i", "o", "o", "u", "u", "u", "y", "c"], 
                                       $verbe);

        // Crée le nom de fichier pour les conjugaisons du verbe au temps sélectionné
        $nomFichier = "verbes/" . $verbeSansAccent . "_" . $temps . ".txt";

        // Charge les réponses possibles du fichier
        $fichierVerbe = file($nomFichier);
        $reponse1 = substr($fichierVerbe[0], 0, -1);
        $reponse2 = substr($fichierVerbe[1], 0, -1);
        $reponse3 = substr($fichierVerbe[2], 0, -1);
        $reponse4 = substr($fichierVerbe[3], 0, -1);
        $reponse5 = substr($fichierVerbe[4], 0, -1);
        $reponse6 = substr($fichierVerbe[5], 0, -1);
    ?>

    <center>
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                    <center>
                        <h1>Verbe Numéro <?php echo $_SESSION['nbQuestion']; ?></h1><br />
                        <h3>Conjugue le verbe ***<u><?php echo $verbe; ?></u>*** au <?php 
                            echo $temps == 'present' ? 'présent' : ($temps == 'futur' ? 'futur' : 'imparfait');
                        ?> :</h3>
                        <form action="./correction.php" method="post">
                            <!-- Envoie les bonnes réponses pour vérifier la réponse de l'utilisateur -->
                            <input type="hidden" name="correction1" value="<?php echo $reponse1; ?>"></input>
                            <input type="hidden" name="correction2" value="<?php echo $reponse2; ?>"></input>
                            <input type="hidden" name="correction3" value="<?php echo $reponse3; ?>"></input>
                            <input type="hidden" name="correction4" value="<?php echo $reponse4; ?>"></input>
                            <input type="hidden" name="correction5" value="<?php echo $reponse5; ?>"></input>
                            <input type="hidden" name="correction6" value="<?php echo $reponse6; ?>"></input>

                            <!-- Formulaire avec les six conjugaisons à remplir -->
                            <table><tbody>
                                <tr><td><label for="fname">Je/J' </label></td><td><input type="text" id="mot1" name="mot1" autocomplete="off" autofocus></td></tr>
                                <tr><td><label for="fname">Tu </label></td><td><input type="text" id="mot2" name="mot2" autocomplete="off"></td></tr>
                                <tr><td><label for="fname">Il/Elle/On&nbsp;&nbsp;</label></td><td><input type="text" id="mot3" name="mot3" autocomplete="off"></td></tr>
                                <tr><td><label for="fname">Nous </label></td><td><input type="text" id="mot4" name="mot4" autocomplete="off"></td></tr>
                                <tr><td><label for="fname">Vous </label></td><td><input type="text" id="mot5" name="mot5" autocomplete="off"></td></tr>
                                <tr><td><label for="fname">Ils </label></td><td><input type="text" id="mot6" name="mot6" autocomplete="off"></td></tr>
                            </tbody></table>
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
