<?php
	// Démarre la gestion de la session et inclut le fichier utils.php
	@ob_start();  // Désactive les messages d'erreur en cas de problème avec les en-têtes
    include 'utils.php';
    
    // Log l'adresse IP et l'accès à la page "index.php"
    log_adresse_ip("logs/log.txt","index.php");

	// Démarre la session PHP
	session_start();
	
	// Initialise les variables de session pour gérer l'avancement du quiz
	$_SESSION['nbMaxQuestions'] = 2;  // Nombre maximum de questions
	$_SESSION['nbQuestion'] = 0;      // Nombre de questions répondues
	$_SESSION['nbBonneReponse'] = 0;  // Nombre de bonnes réponses
	$_SESSION['prenom'] = "";          // Prénom de l'utilisateur (initialement vide)
	$_SESSION['historique'] = "";      // Historique des réponses (initialement vide)
	$_SESSION['origine'] = "index";    // Page d'origine, ici "index"
?>

<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Accueil</title>
	</head>
	<body style="background-color:grey;">
		<?php 
			// Initialisation des variables POST (elles ne seront pas utilisées directement ici, mais sont présentes pour la logique des formulaires)
			$_POST['nbQuestion'] = 0;
			$_POST['nbBonneReponse'] = 0;
			$_POST['prenom'] = "";
			$_POST['historique'] = "";
			$_POST['nbMaxQuestions'] = 10;  // Valeur par défaut du nombre maximum de questions
		?> 
		<center>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
						<center>
							<h1>Bonjour !</h1><br />
							<!-- Affiche le nombre de verbes à conjuguer -->
							<h2>Tu vas devoir conjuguer <?php echo ''.$_SESSION['nbMaxQuestions'].'' ?> verbes.</h2><br />
							
							<h3>Mais avant, Quel est ton prénom ?</h3>
							<!-- Formulaire pour demander le prénom de l'utilisateur -->
							<form action="./question.php" method="post">
								<input type="text" id="prenom" name="prenom" autocomplete="off" autofocus><br /><br /><br />
								<input type="submit" value="Commencer">
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
		<!-- Footer avec les crédits de l'image et des informations de contact -->
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
