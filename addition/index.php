<?php
@ob_start(); // Active la mise en tampon de sortie pour éviter des erreurs d'envoi de headers
include 'utils.php'; // Inclusion du fichier utils.php qui contient des fonctions utilitaires
log_adresse_ip("logs/log.txt","index.php"); // Enregistre l'adresse IP de l'utilisateur dans un fichier log

session_start(); // Démarre une session pour stocker des variables de session

// Initialisation des variables de session pour le suivi du quiz
$_SESSION['nbMaxQuestions'] = 10; // Nombre maximum de questions
$_SESSION['nbQuestion'] = 0; // Compteur de questions posées
$_SESSION['nbBonneReponse'] = 0; // Compteur de bonnes réponses
$_SESSION['name'] = ""; // Prénom de l'utilisateur
$_SESSION['historique'] = ""; // Historique des réponses de l'utilisateur
$_SESSION['origine'] = "index"; // Indique l'origine de la session
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Accueil</title> <!-- Titre de la page -->
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
<body style="background-color:grey;"> <!-- Couleur de fond de la page -->
    <center>
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <!-- Affichage de l'image de fond pour la partie principale -->
                <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                    <center>
                        <h1>Bonjour !</h1><br />
                        <h2>Nous allons faire du calcul mental. Tu devras faire <?php echo $_SESSION['nbMaxQuestions']; ?> calculs.</h2><br />
                        <h3>Mais avant, Quel est ton prénom ?</h3>
                        <!-- Formulaire permettant à l'utilisateur d'entrer son prénom -->
                        <form action="./question.php" method="post">
                            <input type="text" id="name" name="name" autocomplete="off" autofocus required><br /><br /><br />
                            <input type="submit" value="Commencer">
                        </form>
                    </center>
                </td>
                <!-- Image sur le côté droit -->
                <td style="width:280px;height:430px;background-image:url('./images/NE.jpg');background-repeat:no-repeat;"></td>
            </tr>
            <tr>
                <!-- Images pour le bas de la page -->
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