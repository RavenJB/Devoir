<?php
@ob_start();
include 'utils.php';
session_start();

// Inclure et configurer Monolog
$log = require __DIR__ . '/log_config.php';

// Log l'adresse IP et la page
$log->info('Accès à fin.php', [
    'ip' => $_SERVER['REMOTE_ADDR'],
    'page' => 'fin.php',
    'user' => $_SESSION['prenom']
]);

// Enregistrer l'origine
$_SESSION['origine'] = "fin";

// Sauvegarder les résultats dans le dossier resultats/
$_SESSION['prenom'] = strtolower($_SESSION['prenom']);
$_SESSION['prenom'] = supprime_caracteres_speciaux($_SESSION['prenom']);
$today = date('Ymd-His'); // Format YYYYMMDD-HHMMSS
$results_folder = '../resultats/';
$filename = $results_folder . $_SESSION['prenom'] . '-' . $today . '.txt';

// Ouvrir le fichier pour écrire
$fp = fopen($filename, 'w');
if ($fp) {
    // Écrire les détails de l'examen (exemple : nb bonne réponse, questions, etc.)
    $content = "Nom: " . $_SESSION['prenom'] . "\n";
    $content .= "Nombre de bonnes réponses: " . $_SESSION['nbBonneReponse'] . "\n";
    $content .= "Nombre total de questions: " . $_SESSION['nbQuestion'] . "\n";
    $content .= "Historique des réponses: " . $_SESSION['historique'] . "\n";

    fwrite($fp, $content); // Ecrire dans le fichier
    fclose($fp); // Fermer le fichier
} else {
    $log->error('Erreur lors de l\'enregistrement des résultats', [
        'filename' => $filename
    ]);
    echo "Erreur lors de l'enregistrement des résultats.";
}
?>

<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Fin de la série</title>
	</head>
	<body style="background-color:grey;">
		<center>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
						<center>
						
							
														
                            <?php
                             $_SESSION['nbQuestion']=$_SESSION['nbQuestion']*6;
                                if($_SESSION['nbBonneReponse']>1)
                                    echo '<h2>Fin du test.</h2>Tu as '.$_SESSION['nbBonneReponse'].' bonnes réponses sur '.$_SESSION['nbQuestion'].' questions.';
                                else
                                    echo '<h2>Fin du test.</h2>Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' questions.';

							$_SESSION['prenom']=strtolower($_SESSION['prenom']);
                            $_SESSION['prenom']=supprime_caracteres_speciaux($_SESSION['prenom']);
							$today = date('Ymd-His'); 
							$fp = fopen('./resultats/'.$_SESSION['prenom'].'-'.$today.'.txt', 'w');
							$_SESSION['historique']=$_SESSION['historique'].''.$_SESSION['nbBonneReponse'];
							fwrite($fp, $_SESSION['historique']);
							fclose($fp);
							
							
							if($_SESSION['nbBonneReponse']>=$_SESSION['nbMaxQuestions']*0.8){
								echo '<h3>Félicitations !</h3>';
								echo '<img src="./images/medailleOr.png" width="100px"><br />';
							}else{								
								if($_SESSION['nbBonneReponse']>=$_SESSION['nbMaxQuestions']*0.6){
									echo '<h3>Très bien !</h3>';
									echo '<img src="./images/medailleArgent.png" width="100px"><br />';
								}else{
									if($_SESSION['nbBonneReponse']>=$_SESSION['nbMaxQuestions']*0.4){
										echo '<h3>Super !</h3>';
										echo '<img src="./images/medailleBronze.png" width="100px"><br />';
									}else{
										echo '<h3>Recommence. Tu peux faire mieux !</h3>';
										echo '<img src="./images/smileyTriste.png" width="100px"><br />';
									}	
								}
							}
							//session_destroy();
							//session_unset();
							?>
							<form action="./index.php" method="post">
								<input type="submit" value="Recommencer" autofocus>
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
