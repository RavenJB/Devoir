<?php
@ob_start(); // Active la mise en tampon de sortie, pour éviter l'affichage prématuré du contenu HTML.
include 'utils.php'; // Inclut un fichier 'utils.php' qui pourrait contenir des fonctions utiles (comme la gestion des logs).
log_adresse_ip("logs/log.txt","index.php"); // Enregistre l'adresse IP de l'utilisateur dans un fichier log pour la page index.php.

session_start(); // Démarre ou reprend une session en cours.

$_SESSION['nbMaxQuestions'] = 10; // Définit le nombre maximum de questions à 10.
$_SESSION['nbQuestion'] = 0; // Initialisation du nombre de questions posées à 0.
$_SESSION['nbBonneReponse'] = 0; // Initialisation du nombre de bonnes réponses à 0.
$_SESSION['prenom'] = ""; // Initialisation du prénom à une chaîne vide.
$_SESSION['historique'] = ""; // Initialisation de l'historique des réponses à une chaîne vide.
$_SESSION['origine'] = "index"; // Enregistre l'origine de la session (page d'accueil).

?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8"> <!-- Déclare que la page utilise l'encodage UTF-8 pour gérer correctement les caractères spéciaux -->
		<title>Accueil</title> <!-- Titre de la page qui apparaît dans l'onglet du navigateur -->
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
	<body style="background-color:grey;"> <!-- Définition du fond gris pour la page -->

		<?php 
			// Réinitialisation des variables de session en cas de redémarrage du test
			$_POST['nbQuestion'] = 0; 
			$_POST['nbBonneReponse'] = 0; 
			$_POST['prenom'] = ""; 
			$_POST['historique'] = ""; 
			$_POST['nbMaxQuestions'] = 10; // Assure que les valeurs sont réinitialisées à chaque fois que la page est chargée
		?> 

		<center> <!-- Centre le contenu dans la page -->
			<table border="0" cellpadding="0" cellspacing="0"> <!-- Crée un tableau sans bordure, sans espacement intérieur ni entre les cellules -->
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
						<center>
							<h1>Bonjour !</h1><br /> <!-- Titre de bienvenue -->
							<h2>Tu vas devoir complèter <?php echo ''.$_SESSION['nbMaxQuestions'].'' ?> phrases avec un verbe conjugué.</h2><br /> <!-- Description de la tâche -->
							<h3>Mais avant, Quel est ton prénom ?</h3> <!-- Demande du prénom à l'utilisateur -->
							
							<!-- Formulaire permettant à l'utilisateur de saisir son prénom et de commencer le test -->
							<form action="./question.php" method="post">
								<input type="text" id="prenom" name="prenom" autocomplete="off" autofocus><br /><br /><br />
								<input type="submit" value="Commencer"> <!-- Bouton pour soumettre et commencer -->
							</form>
						</center>
					</td>
					<td style="width:280px;height:430px;background-image:url('./images/NE.jpg');background-repeat:no-repeat;"></td> <!-- Image de fond -->
				</tr>
				<tr>
					<td style="width:1000px;height:323px;background-image:url('./images/SO.jpg');background-repeat:no-repeat;"></td> <!-- Image de fond -->
					<td style="width:280px;height:323px;background-image:url('./images/SE.jpg');background-repeat:no-repeat;"></td> <!-- Image de fond -->
				</tr>
			</table>
		</center>

		<br />
		<footer style="background-color: #45a1ff;"> <!-- Section footer avec fond bleu -->
			<center>
				<p>Rémi Synave<br /> <!-- Détails de contact -->
				Contact : remi . synave @ univ - littoral [.fr]<br />
				Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
				et Image par <a href="https://pixabay.com/fr/users/everesd_design-16482457/">everesd_design</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=5213756">Pixabay</a> <br />
				</p>
			</center>
		</footer>
	</body>
</html>
