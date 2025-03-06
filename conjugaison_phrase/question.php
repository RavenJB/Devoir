<?php
// Début du code PHP. On inclut les utilitaires et démarre la session.
@ob_start();
include 'utils.php';
session_start();

// Inclure et configurer Monolog pour enregistrer les logs
$log = require __DIR__ . '/log_config.php';

// Log l'accès à la page question.php avec l'adresse IP de l'utilisateur, la page, le prénom de l'utilisateur et le numéro de la question
$log->info('Accès à question.php', [
    'ip' => $_SERVER['REMOTE_ADDR'],
    'page' => 'question.php',
    'user' => $_SESSION['prenom'],
    'question_number' => $_SESSION['nbQuestion']
]);

// Si le nombre de questions dépasse le nombre maximal, rediriger vers la page de fin
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
			// Incrémente le nombre de questions de la session
			$_SESSION['nbQuestion'] = $_SESSION['nbQuestion'] + 1;

			// Ouvre le fichier listeQuestions.txt et le charge dans un tableau
			$fichier = file("listeQuestions.txt");
			$total = count($fichier);
			
			// Génère un nombre aléatoire entre 0 et le nombre total de questions - 1
			$alea = mt_rand(0, $total - 1);

			// Sépare la ligne choisie en trois parties : pronom, verbe et fin de phrase
			$ligneFichier = explode(';', $fichier[$alea]);

            // Récupère le premier caractère du pronom
            $numPronom = mb_substr($ligneFichier[0], 0, 1);

            // Si le pronom commence par "*", choisir aléatoirement un pronom parmi ceux disponibles
            if ($numPronom == "*") {
                $numPronom = mt_rand(1, 6);
                switch ($numPronom) {
                    case "1": $sujet = "Je"; break;
                    case "2": $sujet = "Tu"; break;
                    case "3": $sujet = mt_rand(0, 2) == 0 ? "Elle" : "On"; break;
                    case "4": $sujet = "Nous"; break;
                    case "5": $sujet = "Vous"; break;
                    case "6": $sujet = mt_rand(0, 1) == 0 ? "Elles" : "Ils"; break;
                }
            } else {
                $sujet = mb_substr($ligneFichier[0], 1); // Si le pronom n'est pas un astérisque, on prend directement le pronom
            }

            // Récupère le verbe et la fin de phrase de la ligne
            $verbe = $ligneFichier[1];
            $finDePhrase = $ligneFichier[2];

            // Utilise une fonction de conjugaison pour obtenir la forme correcte du verbe au présent
            $bonneReponse = conjugaison("verbes/" . supprime_caracteres_speciaux($verbe) . "_present.txt", $numPronom);
            $bonneReponsescs = supprime_caracteres_speciaux($bonneReponse);

            // Si le sujet est "Je" et que la réponse commence par une voyelle, mettre "J'" au lieu de "Je"
            if ($sujet == "Je" && (substr($bonneReponsescs, 0, 1) == "a" || substr($bonneReponsescs, 0, 1) == "e" || substr($bonneReponsescs, 0, 1) == "i" || substr($bonneReponsescs, 0, 1) == "o" || substr($bonneReponsescs, 0, 1) == "u")) {
                $sujet = "J'";
            }
		?>
		<center>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
						<center>
							<!-- Affiche le numéro de la question actuelle -->
							<h1>Question Numéro <?php echo "" . $_SESSION['nbQuestion'] . ""; ?></h1><br />
                            
                            <!-- Affiche la question avec le verbe à conjuguer et la phrase à compléter -->
                            <h3>Conjugue le verbe **<u><?php echo '' . $verbe; ?></u>** pour complèter cette phrase.</h3>
							<form action="./correction.php" method="post">
                                <!-- Envoie des informations cachées à la page correction.php pour valider la réponse -->
                                <input type="hidden" name="sujet" value="<?php echo '' . $sujet . ''; ?>"></input>
								<input type="hidden" name="correction" value="<?php echo '' . $bonneReponse . ''; ?>"></input>
                                <input type="hidden" name="finDePhrase" value="<?php echo '' . $finDePhrase . ''; ?>"></input>
								<br />
                                
                                <!-- Champ de texte pour que l'utilisateur entre la réponse -->
                                <label for="fname"><?php echo $sujet; ?>&nbsp;</label>
								<input type="text" id="mot" name="mot" autocomplete="off" autofocus>
                                
                                <!-- Affiche la fin de la phrase -->
                                <label for="fname"><?php echo $finDePhrase; ?>&nbsp;</label>
                                <br /><br /><br />
								
                                <!-- Bouton de soumission pour valider la réponse -->
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
				<!-- Informations de contact et crédits -->
				Rémi Synave<br />
				Contact : remi . synave @ univ - littoral [.fr]<br />
				Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
				Crédits voix : Denise de <a href="https://azure.microsoft.com/fr-fr/services/cognitive-services/text-to-speech/">Microsoft Azure</a>
			</center>
		</footer>
	</body>
</html>
