<?php
@ob_start(); // Active la mise en tampon de sortie pour éviter des erreurs d'envoi de headers
include 'utils.php'; // Inclusion du fichier utils.php qui contient des fonctions utilitaires
session_start(); // Démarre la session PHP pour accéder aux variables de session

// Inclure et configurer Monolog pour la journalisation
$log = require __DIR__ . '/log_config.php';

// Enregistrer l'accès à cette page dans les logs avec l'adresse IP, la page visitée et le prénom de l'utilisateur
$log->info('Accès à fin.php', [
    'ip' => $_SERVER['REMOTE_ADDR'], // Adresse IP de l'utilisateur
    'page' => 'fin.php', // Nom de la page visitée
    'user' => $_SESSION['prenom'] // Prénom de l'utilisateur stocké en session
]);

// Définir l'origine de la session sur "fin" pour suivre le parcours utilisateur
$_SESSION['origine'] = "fin";

// Nettoyage et mise en forme du prénom de l'utilisateur pour éviter les caractères spéciaux et le rendre en minuscules
$_SESSION['prenom'] = strtolower($_SESSION['prenom']);
$_SESSION['prenom'] = supprime_caracteres_speciaux($_SESSION['prenom']);

// Création du nom de fichier avec la date et l'heure pour stocker les résultats
$today = date('Ymd-His'); // Format YYYYMMDD-HHMMSS pour l'unicité du fichier
$results_folder = '../resultats/'; // Dossier de stockage des résultats
$filename = $results_folder . $_SESSION['prenom'] . '-' . $today . '.txt'; // Chemin complet du fichier

// Ouvrir le fichier pour l'écriture des résultats
$fp = fopen($filename, 'w');
if ($fp) {
    // Création du contenu du fichier avec les détails du test
    $content = "Nom: " . $_SESSION['prenom'] . "\n";
    $content .= "Nombre de bonnes réponses: " . $_SESSION['nbBonneReponse'] . "\n";
    $content .= "Nombre total de questions: " . $_SESSION['nbQuestion'] . "\n";
    $content .= "Historique des réponses: " . $_SESSION['historique'] . "\n";

    fwrite($fp, $content); // Écriture des données dans le fichier
    fclose($fp); // Fermeture du fichier après écriture
} else {
    // En cas d'erreur d'ouverture du fichier, journalisation de l'erreur
    $log->error('Erreur lors de l\'enregistrement des résultats', [
        'filename' => $filename
    ]);
    echo "Erreur lors de l'enregistrement des résultats."; // Affichage d'un message d'erreur à l'utilisateur
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Fin de la série</title> <!-- Titre de la page -->
</head>
<body style="background-color:grey;"> <!-- Fond de couleur grise -->
    <center>
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                    <center>
                        <?php
                        // Affichage du score final de l'utilisateur
                        if($_SESSION['nbBonneReponse']>1)
                            echo '<h2>Fin du test.</h2>Tu as '.$_SESSION['nbBonneReponse'].' bonnes réponses sur '.$_SESSION['nbQuestion'].' questions.';
                        else
                            echo '<h2>Fin du test.</h2>Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' questions.';
                        
                        // Normalisation du prénom à nouveau et enregistrement du score final
                        $_SESSION['prenom']=strtolower($_SESSION['prenom']);
                        $_SESSION['prenom']=supprime_caracteres_speciaux($_SESSION['prenom']);
                        $today = date('Ymd-His'); // Récupération de la date actuelle
                        $fp = fopen('./resultats/'.$_SESSION['prenom'].'-'.$today.'.txt', 'w'); // Ouverture du fichier
                        $_SESSION['historique']=$_SESSION['historique'].''.$_SESSION['nbBonneReponse']; // Ajout du score final dans l'historique
                        fwrite($fp, $_SESSION['historique']); // Écriture dans le fichier
                        fclose($fp); // Fermeture du fichier
                        
                        // Attribution des médailles selon le score de l'utilisateur
                        if($_SESSION['nbBonneReponse']>=$_SESSION['nbMaxQuestions']*0.8){
                            echo '<h3>Félicitations !</h3>';
                            echo '<img src="./images/medailleOr.png" width="100px"><br />'; // Médaille d'or
                        }else{                                
                            if($_SESSION['nbBonneReponse']>=$_SESSION['nbMaxQuestions']*0.6){
                                echo '<h3>Très bien !</h3>';
                                echo '<img src="./images/medailleArgent.png" width="100px"><br />'; // Médaille d'argent
                            }else{
                                if($_SESSION['nbBonneReponse']>=$_SESSION['nbMaxQuestions']*0.4){
                                    echo '<h3>Super !</h3>';
                                    echo '<img src="./images/medailleBronze.png" width="100px"><br />'; // Médaille de bronze
                                }else{
                                    echo '<h3>Recommence. Tu peux faire mieux !</h3>';
                                    echo '<img src="./images/smileyTriste.png" width="100px"><br />'; // Smiley triste en cas de faible score
                                }    
                            }
                        }
                        ?>
                        <form action="./index.php" method="post">
                            <input type="submit" value="Recommencer" autofocus> <!-- Bouton pour recommencer le test -->
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
