<?php
// filepath: /c:/COURS/BUT3/S1/SAE/Devoir/conjugaison_phrase/question.php
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
			$fichier = file("listeQuestions.txt");
			$total = count($fichier);
			$alea=mt_rand(0,$total-1);
			$ligneFichier=explode(';',$fichier[$alea]);
            $numPronom=mb_substr($ligneFichier[0],0,1);
            if($numPronom=="*"){
                $numPronom=mt_rand(1,1);
                switch ($numPronom) {
                case "1":
                    $sujet="Je";
                    break;
                case "2":
                    $sujet="Tu";
                    break;
                case "3":
                    $alea=mt_rand(0,2);
                    $sujet="Il";
                    if($alea==0)
                        $sujet="Elle";
                    if($alea==1)
                        $sujet="On";
                    break;
                case "4":
                    $sujet="Nous";
                    break;
                case "5":
                    $sujet="Vous";
                    break;
                case "6":
                    $sujet="Ils";
                    if(mt_rand(0,1)==0)
                        $sujet="Elles";
                        break;
                }
            }else{
                $sujet=mb_substr($ligneFichier[0],1);
            }
            $verbe=$ligneFichier[1];
            $finDePhrase=$ligneFichier[2];
            $bonneReponse=conjugaison("verbes/".supprime_caracteres_speciaux($verbe)."_present.txt",$numPronom);
            $bonneReponsescs=supprime_caracteres_speciaux($bonneReponse);
            if($sujet=="Je" && (substr($bonneReponsescs,0,1)=="a" || substr($bonneReponsescs,0,1)=="e" || substr($bonneReponsescs,0,1)=="i" || substr($bonneReponsescs,0,1)=="o" || substr($bonneReponsescs,0,1)=="u")){
                $sujet="J'";
            }
		?>
		<center>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
						<center>

		
		

		
							<h1>Question Numéro <?php echo "".$_SESSION['nbQuestion']."" ?></h1><br />
                            <h3>Conjugue le verbe **<u><?php echo ''.$verbe; ?></u>** pour complèter cette phrase.</h3>
							<form action="./correction.php" method="post">
                                <input type="hidden" name="sujet" value="<?php echo ''.$sujet.''?>"></input>
								<input type="hidden" name="correction" value="<?php echo ''.$bonneReponse.''?>"></input>
                                <input type="hidden" name="finDePhrase" value="<?php echo ''.$finDePhrase.''?>"></input>
								<br />
                                <label for="fname"><?php echo $sujet; ?>&nbsp;</label>
								<input type="text" id="mot" name="mot" autocomplete="off" autofocus>
                                <label for="fname"><?php echo $finDePhrase; ?>&nbsp;</label>
                                <br /><br /><br />
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
