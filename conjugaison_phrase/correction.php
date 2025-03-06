<?php
@ob_start(); // Démarre la mise en tampon de sortie (empêche l'affichage direct du contenu HTML avant son traitement)
include 'utils.php'; // Inclut un fichier utils.php, probablement pour des fonctions utilitaires comme la gestion des sessions ou des logs
session_start(); // Démarre ou reprend la session en cours

// Inclure et configurer Monolog (outil de gestion de logs)
$log = require __DIR__ . '/log_config.php'; // Inclut et configure Monolog à partir du fichier log_config.php

// Log l'adresse IP, la page visitée, le prénom de l'utilisateur et le numéro de la question
$log->info('Accès à correction.php', [
    'ip' => $_SERVER['REMOTE_ADDR'], // Récupère l'adresse IP de l'utilisateur
    'page' => 'correction.php', // Enregistre la page courante
    'user' => $_SESSION['prenom'], // Enregistre le prénom de l'utilisateur depuis la session
    'question_number' => $_SESSION['nbQuestion'] // Enregistre le numéro de la question courante
]);

// Si le champ 'correction' est vide, détruire la session et rediriger vers la page index
if ($_POST['correction'] == "") {
    session_destroy(); // Détruit la session actuelle
    session_unset(); // Libère toutes les variables de session
    unset($_POST); // Vide le tableau $_POST
    header('Location: ./index.php'); // Redirige vers la page index
}

?>

<!doctype html>
<html lang="fr"> <!-- Indique que la langue de la page est le français -->
	<head>
		<meta charset="utf-8"> <!-- Déclare l'encodage des caractères en UTF-8 -->
		<title>Correction</title> <!-- Titre de la page affiché dans l'onglet du navigateur -->
	</head>
	<body style="background-color:grey;"> <!-- Définit la couleur de fond de la page en gris -->
		<center> <!-- Centre tout le contenu de la page -->
			<table border="0" cellpadding="0" cellspacing="0"> <!-- Tableau sans bordures, sans espacement intérieur et entre les cellules -->
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;"> <!-- Cellule avec image de fond -->
						<center> <!-- Centre le contenu à l'intérieur de la cellule -->
							
							<!-- Mise en minuscule du mot entré par l'utilisateur -->
							<?php $_POST['mot']=strtolower($_POST['mot']); ?>

							<?php 
								// Si la réponse donnée par l'utilisateur est correcte
								if($_POST['mot']==$_POST['correction']){
									echo '<h1>Super '.$_SESSION['prenom'].' ! Bonne réponse.</h1>'; // Affiche un message de félicitations
									$_SESSION['nbBonneReponse']=$_SESSION['nbBonneReponse']+1; // Incrémente le compteur de bonnes réponses
									$_SESSION['historique']=$_SESSION['historique'].$_POST['sujet'].' '.$_POST['mot'].' '.substr($_POST['finDePhrase'],0,-1)."\n"; // Ajoute la réponse à l'historique
								}else{
									// Si la réponse est incorrecte, affiche le message avec la réponse correcte
									echo '<h1>Oh non !</h1><br /><h2>la bonne réponse était : </h2><br />'.$_POST['sujet'].' <strong><u>'.$_POST['correction'].'</u></strong> '.$_POST['finDePhrase'].'<br />';
									$_SESSION['historique']=$_SESSION['historique'].$_POST['sujet'].' ***'.$_POST['mot'].'*** '.substr($_POST['finDePhrase'],0,-2).';'.$_POST['correction']."\n"; // Ajoute la réponse incorrecte à l'historique
								}
								echo '<br />';
								
								// Affiche le nombre de bonnes réponses en fonction du nombre de questions
								if($_SESSION['nbQuestion']<$_SESSION['nbMaxQuestions']){
									if($_SESSION['nbQuestion']==1)
										echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' question.';
									else{
										if($_SESSION['nbBonneReponse']>1)
											echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonnes réponses sur '.$_SESSION['nbQuestion'].' questions.';
										else
											echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' questions.';
										}
								}
							?>
							<br /><br />
							
							<?php
								// Si ce n'est pas la dernière question, afficher un bouton "Suite"
								if($_SESSION['nbQuestion']<$_SESSION['nbMaxQuestions']){
							?>
							<!-- Formulaire pour continuer à la question suivante -->
							<form action="./question.php" method="post">
								<input type="submit" value="Suite" autofocus> <!-- Bouton pour continuer -->
							</form>
							<?php
								}else{
							?>
							<!-- Si c'est la dernière question, afficher un bouton "Suite" pour finir -->
							<form action="./fin.php" method="post">
								<input type="submit" value="Suite" autofocus> <!-- Bouton pour finir -->
							</form>
							<?php
								}
							?>
							
							<br /><br />
							<!-- Formulaire pour recommencer tout le quiz -->
							<form action="./raz.php" method="post">
								<input type="submit" value="Tout recommencer"> <!-- Bouton pour réinitialiser et recommencer -->
							</form>

						</center>
					</td>
					<td style="width:280px;height:430px;background-image:url('./images/NE.jpg');background-repeat:no-repeat;"></td> <!-- Cellule avec image de fond -->
				</tr>
				<tr>
					<td style="width:1000px;height:323px;background-image:url('./images/SO.jpg');background-repeat:no-repeat;"></td> <!-- Cellule avec image de fond -->
					<td style="width:280px;height:323px;background-image:url('./images/SE.jpg');background-repeat:no-repeat;"></td> <!-- Cellule avec image de fond -->
				</tr>
			</table>
		</center>
		<br />
		<footer style="background-color: #45a1ff;"> <!-- Footer avec couleur de fond bleue -->
			<center> <!-- Centre le contenu du footer -->
				Rémi Synave<br />
				Contact : remi . synave @ univ - littoral [.fr]<br />
				Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
				Crédits voix : Denise de <a href="https://azure.microsoft.com/fr-fr/services/cognitive-services/text-to-speech/">Microsoft Azure</a>
			</center>
		</footer>
	</body>
</html>
