<?php
// filepath: /c:/COURS/BUT3/S1/SAE/Devoir/dictee/question.php
@ob_start();
include 'utils.php';
session_start();

// Inclure et configurer Monolog
$log = require __DIR__ . '/log_config.php';

// Log l'adresse IP et la page
$log->info('Accès à question.php', [
    'ip' => $_SERVER['REMOTE_ADDR'],
    'page' => 'question.php',
    'user' => $_SESSION['prenom'],
    'question_number' => $_SESSION['nbQuestion']
]);

if ($_SESSION['nbQuestion'] > $_SESSION['nbMaxQuestions']) {
	header('Location: ./fin.php');
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
			$_SESSION['nbQuestion']=$_SESSION['nbQuestion']+1;
			$fichier = file("listeDeMots/liste_dictee_20230407.txt");
			$total = count($fichier);
			$alea=mt_rand(0,$total-1);
			$ligneFichier=explode(';',$fichier[$alea]);
		?>
		<center>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
						<center>

		
		

		
							<h1>Question Numéro <?php echo "".$_SESSION['nbQuestion']."" ?></h1><br />
							<audio autoplay controls>
								<source src="./<?php echo './sons/'.$ligneFichier[1].''?>" type="audio/mpeg">
								Votre navigateur ne supporte pas l'audio. Passez à Firefox !
							</audio>
							<form action="./correction.php" method="post">
								<input type="hidden" name="correction" value="<?php echo ''.$ligneFichier[0].''?>"></input>
								<input type="hidden" name="nomFichierSon" value="<?php echo ''.$ligneFichier[1].''?>"></input>
								<br />
								<label for="fname">Qu'as-tu entendu ?</label><br>
								<input type="text" id="mot" name="mot" autocomplete="off" autofocus><br /><br /><br />
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
				Crédits voix : Denise de <a href="https://azure.microsoft.com/fr-fr/services/cognitive-services/text-to-speech/">Microsoft Azure</a>
			</center>
		</footer>
	</body>
</html>
