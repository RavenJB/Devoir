<?php
    // Démarre la mise en mémoire tampon (ob_start) pour contrôler le flux de sortie.
    @ob_start();

    // Inclut un fichier externe contenant des fonctions utilitaires, par exemple pour le logging
    include 'utils.php';

    // Enregistre l'adresse IP de l'utilisateur dans un fichier de log avec la page d'accès
    log_adresse_ip("logs/log.txt", "index.php");

    // Démarre une session PHP, permettant de maintenir des variables entre les pages
    session_start();

    // Initialisation des variables de session pour suivre l'état de l'utilisateur
    $_SESSION['nbMaxQuestions'] = 10;  // Le nombre maximal de questions
    $_SESSION['nbQuestion'] = 0;  // Le numéro de la question actuelle (commence à 0)
    $_SESSION['nbBonneReponse'] = 0;  // Le nombre de bonnes réponses (commence à 0)
    $_SESSION['prenom'] = "";  // Le prénom de l'utilisateur (vide au début)
    $_SESSION['historique'] = "";  // Historique des réponses de l'utilisateur
    $_SESSION['origine'] = "index";  // L'origine de la demande (utilisée pour navigation)
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">  <!-- Définit l'encodage des caractères de la page -->
        <title>Accueil</title>  <!-- Le titre de la page qui sera affiché dans l'onglet du navigateur -->
    </head>
    <body style="background-color:grey;">  <!-- Définir un fond gris pour la page -->
        <?php 
            // Initialisation des variables $_POST pour stocker les informations soumises
            $_POST['nbQuestion'] = 0;  // Nombre de questions, initialisé à 0
            $_POST['nbBonneReponse'] = 0;  // Nombre de bonnes réponses, initialisé à 0
            $_POST['prenom'] = "";  // Prénom, initialisé à vide
            $_POST['historique'] = "";  // Historique des réponses, initialisé à vide
            $_POST['nbMaxQuestions'] = 10;  // Le nombre maximal de questions, ici 10
        ?> 
        <center>  <!-- Centre le contenu de la page -->
            <table border="0" cellpadding="0" cellspacing="0">  <!-- Tableau pour la structure de la page -->
                <tr>
                    <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">  <!-- Cellule avec une image d'arrière-plan à gauche -->
                        <center>  <!-- Centre le contenu de cette cellule -->
                            <!-- Affiche un message de bienvenue et de préparation pour l'exercice -->
                            <h1>Bonjour !</h1><br />
                            <h2>Nous allons faire du calcul mental. Tu devras faire <?php echo ''.$_SESSION['nbMaxQuestions'].'' ?> calculs.</h2><br />
                            <h3>Mais avant, Quel est ton prénom ?</h3>
                            <!-- Formulaire pour demander le prénom de l'utilisateur -->
                            <form action="./question.php" method="post">  <!-- Envoie les données vers question.php -->
                                <input type="text" id="prenom" name="prenom" autocomplete="off" autofocus><br /><br /><br />  <!-- Champ de texte pour le prénom -->
                                <input type="submit" value="Commencer">  <!-- Bouton pour soumettre le formulaire -->
                            </form>
                        </center>
                    </td>
                    <td style="width:280px;height:430px;background-image:url('./images/NE.jpg');background-repeat:no-repeat;"></td>  <!-- Cellule avec une image d'arrière-plan à droite -->
                </tr>
                <tr>
                    <td style="width:1000px;height:323px;background-image:url('./images/SO.jpg');background-repeat:no-repeat;"></td>  <!-- Cellule inférieure gauche avec image d'arrière-plan -->
                    <td style="width:280px;height:323px;background-image:url('./images/SE.jpg');background-repeat:no-repeat;"></td>  <!-- Cellule inférieure droite avec image d'arrière-plan -->
                </tr>
            </table>
        </center>
        <br />
        <footer style="background-color: #45a1ff;">  <!-- Pied de page avec un fond bleu clair -->
            <center>
                <!-- Informations de contact -->
                Rémi Synave<br />
                Contact : remi . synave @ univ - littoral [.fr]<br />
                <!-- Crédits pour les images utilisées -->
                Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
                et Image par <a href="https://pixabay.com/fr/users/everesd_design-16482457/">everesd_design</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=5213756">Pixabay</a> <br />
            </center>
        </footer>
    </body>
</html>
