<?php
	@ob_start(); // Démarre la mise en tampon de sortie pour éviter l'envoi de données avant l'en-tête
	session_start(); // Démarre la session pour pouvoir stocker des informations de session
    include 'utils.php'; // Inclut un fichier utils.php qui peut contenir des fonctions utiles
    log_adresse_ip("logs/log.txt", "index.php"); // Enregistre l'accès à cette page dans un fichier de log

	// Initialisation des variables de session
	$_SESSION['nbMaxQuestions'] = 10; // Nombre maximum de questions
	$_SESSION['nbQuestion'] = 0; // Numéro de la question actuelle (commence à 0)
	$_SESSION['nbBonneReponse'] = 0; // Nombre de bonnes réponses données
	$_SESSION['prenom'] = ""; // Le prénom de l'utilisateur
	$_SESSION['historique'] = ""; // Historique des réponses
	$_SESSION['origine'] = "index"; // Indique la page d'origine (index.php ici)
?>

<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8"> <!-- Déclare l'encodage des caractères en UTF-8 -->
		<title>Accueil</title> <!-- Titre de la page -->
	</head>
	<body style="background-color:grey;"> <!-- Définit un fond gris pour la page -->
		<center>
			<table border="0" cellpadding="0" cellspacing="0"> <!-- Table pour la mise en page -->
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
						<center>
						
							<h1>Bonjour !</h1><br /> <!-- Titre principal de la page -->
							<h2>Nous allons faire une dictée de <?php echo ''.$_SESSION['nbMaxQuestions'].'' ?> mots.</h2><br /> <!-- Indication du nombre de questions dans la dictée -->
							<h3>Mais avant, Quel est ton prénom ?</h3><br /> <!-- Question demandant le prénom de l'utilisateur -->
							
							<!-- Formulaire pour entrer le prénom -->
							<form action="./question.php" method="post"> <!-- Envoie le prénom à la page question.php -->
								<input type="text" id="prenom" name="prenom" autocomplete="off" autofocus><br /><br /><br />
								<input type="submit" value="Commencer"> <!-- Bouton pour soumettre le prénom et commencer la dictée -->
							</form>
						
						</center>
					</td>
					<td style="width:280px;height:430px;background-image:url('./images/NE.jpg');background-repeat:no-repeat;"></td> <!-- Image à droite -->
				</tr>
				<tr>
					<td style="width:1000px;height:323px;background-image:url('./images/SO.jpg');background-repeat:no-repeat;"></td> <!-- Image du bas gauche -->
					<td style="width:280px;height:323px;background-image:url('./images/SE.jpg');background-repeat:no-repeat;"></td> <!-- Image du bas droite -->
				</tr>
			</table>
		</center>
		<br />
		<footer style="background-color: #45a1ff;"> <!-- Pied de page -->
			<center>
				Rémi Synave<br /> <!-- Crédit auteur -->
				Contact : remi . synave @ univ - littoral [.fr]<br /> <!-- Coordonnées de contact -->
				Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
				Crédits voix : Denise de <a href="https://azure.microsoft.com/fr-fr/services/cognitive-services/text-to-speech/">Microsoft Azure</a> <!-- Crédits pour l'image et la voix -->
			</center>
		</footer>
	</body>
</html>
