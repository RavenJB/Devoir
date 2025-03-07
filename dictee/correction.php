<?php
@ob_start(); // Démarre la mise en tampon de sortie
include 'utils.php'; // Inclure le fichier utils.php qui contient des fonctions utilitaires
session_start(); // Démarre la session PHP

// Inclure et configurer Monolog pour les logs
$log = require __DIR__ . '/log_config.php';

// Log l'adresse IP, la page visitée et des informations utilisateur
$log->info('Accès à correction.php', [
    'ip' => $_SERVER['REMOTE_ADDR'],
    'page' => 'correction.php',
    'user' => $_SESSION['prenom'], // Utilisateur (prénom)
    'question_number' => $_SESSION['nbQuestion'] // Numéro de la question actuelle
]);

// Si la réponse est vide, réinitialiser la session et rediriger vers index.php
if ($_POST['correction'] == "") {
    session_destroy(); // Détruire la session
    session_unset(); // Supprimer toutes les variables de session
    unset($_POST); // Réinitialiser la variable POST
    header('Location: ./index.php'); // Redirection vers la page d'accueil
}
?>

<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Correction</title>
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
		<center>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
						<center>
							
							<!-- Code de correction : Si la réponse est correcte -->
							<?php 
								//$_POST['mot']=strtolower($_POST['mot']); 
							?>

							<?php 
								// Si la réponse est correcte
								if($_POST['mot'] == $_POST['correction']){
									echo '<h1>Super '.$_SESSION['prenom'].' ! Bonne réponse.</h1>';
									$_SESSION['nbBonneReponse'] = $_SESSION['nbBonneReponse'] + 1; // Incrémenter le nombre de bonnes réponses
									$_SESSION['historique'] = $_SESSION['historique'].''.$_POST['mot']."\n"; // Ajouter à l'historique des réponses
								}else{
									// Si la réponse est incorrecte
									echo '<h1>Oh non !</h1><br /><h2>Tu as écrit '.$_POST['mot'].'.</h2><h2>La bonne réponse était : '.$_POST['correction'].'.</h2>';
									$_SESSION['historique'] = $_SESSION['historique'].'********'.$_POST['mot'].';'.$_POST['correction']."\n"; // Ajouter l'erreur à l'historique
								}
								echo '<br />';
								// Affichage du nombre de bonnes réponses jusqu'à présent
								if($_SESSION['nbQuestion'] < $_SESSION['nbMaxQuestions']){
									if($_SESSION['nbQuestion'] == 1)
										echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' question.';
									else{
										// Cas avec plusieurs réponses
										if($_SESSION['nbBonneReponse'] > 1)
											echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonnes réponses sur '.$_SESSION['nbQuestion'].' questions.';
										else
											echo 'Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' questions.';
										}
								}
							?>
							<br /><br />
							<?php
								// Si la réponse était correcte
								if($_POST['mot'] == $_POST['correction']){
									// Si ce n'est pas la dernière question
									if($_SESSION['nbQuestion'] < $_SESSION['nbMaxQuestions']){
							?>
							<!-- Formulaire pour passer à la question suivante -->
							<form action="./question.php" method="post">
								<input type="submit" value="Suite" autofocus>
							</form>
							<?php
									}else{
							?>
							<!-- Formulaire pour finir si c'était la dernière question -->
							<form action="./fin.php" method="post">
								<input type="submit" value="Suite" autofocus>
							</form>
							<?php
									}
								}else{
							?>
							<!-- Si la réponse était incorrecte, permettre à l'utilisateur de revoir la correction -->
							<form action="./recopie.php" method="post">
								<input type="hidden" name="recopie" value=""></input>
								<input type="hidden" name="correction" value="<?php echo "".$_POST['correction']."" ?>"></input>
								<input type="submit" value="Suite" autofocus>
							</form>
							<?php
								}		
							?>
							<br /><br />
							<!-- Formulaire pour recommencer le test -->
							<form action="./raz.php" method="post">
								<input type="submit" value="Tout recommencer">
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
				Crédits voix : Denise de <a href="https://azure.microsoft.com/fr-fr/services/cognitive-services/text-to-speech/">Microsoft Azure</a>
			</center>
		</footer>
	</body>
</html>
