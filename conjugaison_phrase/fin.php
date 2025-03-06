<?php
@ob_start(); // Démarre la mise en tampon de sortie pour éviter l'affichage direct du contenu HTML avant le traitement
include 'utils.php'; // Inclut un fichier utilitaire pour des fonctions supplémentaires
session_start(); // Démarre ou reprend la session en cours

// Inclure et configurer Monolog (outil de gestion de logs)
$log = require __DIR__ . '/log_config.php'; // Charge la configuration de Monolog à partir d'un fichier

// Log l'adresse IP et la page actuelle de l'utilisateur
$log->info('Accès à fin.php', [
    'ip' => $_SERVER['REMOTE_ADDR'], // Récupère l'adresse IP de l'utilisateur
    'page' => 'fin.php', // Enregistre que l'utilisateur est sur la page fin.php
    'user' => $_SESSION['prenom'] // Enregistre le prénom de l'utilisateur depuis la session
]);

// Enregistrer l'origine comme étant "fin" pour suivre le processus
$_SESSION['origine'] = "fin";

// Sauvegarder les résultats dans le dossier resultats/
$_SESSION['prenom'] = strtolower($_SESSION['prenom']); // Met le prénom de l'utilisateur en minuscule
$_SESSION['prenom'] = supprime_caracteres_speciaux($_SESSION['prenom']); // Supprime les caractères spéciaux du prénom
$today = date('Ymd-His'); // Format de la date : YYYYMMDD-HHMMSS pour éviter les collisions de noms de fichiers
$results_folder = '../resultats/'; // Chemin vers le dossier de résultats
$filename = $results_folder . $_SESSION['prenom'] . '-' . $today . '.txt'; // Nom du fichier avec le prénom de l'utilisateur et la date/heure

// Ouvre le fichier pour écrire les résultats
$fp = fopen($filename, 'w'); // Ouvre le fichier en écriture
if ($fp) {
    // Écrit les résultats dans le fichier
    $content = "Nom: " . $_SESSION['prenom'] . "\n";
    $content .= "Nombre de bonnes réponses: " . $_SESSION['nbBonneReponse'] . "\n";
    $content .= "Nombre total de questions: " . $_SESSION['nbQuestion'] . "\n";
    $content .= "Historique des réponses: " . $_SESSION['historique'] . "\n";

    fwrite($fp, $content); // Écrit le contenu dans le fichier
    fclose($fp); // Ferme le fichier
} else {
    // Enregistre une erreur dans les logs si le fichier ne peut pas être ouvert
    $log->error('Erreur lors de l\'enregistrement des résultats', [
        'filename' => $filename
    ]);
    echo "Erreur lors de l'enregistrement des résultats."; // Affiche un message d'erreur
}
?>
<!doctype html>
<html lang="fr"> <!-- Déclare que la langue de la page est le français -->
	<head>
		<meta charset="utf-8"> <!-- Déclare l'encodage des caractères en UTF-8 -->
		<title>Fin de la dictée</title> <!-- Titre de la page affiché dans l'onglet du navigateur -->
	</head>
	<body style="background-color:grey;"> <!-- Applique un fond gris à la page -->
		<center> <!-- Centre le contenu de la page -->
			<table border="0" cellpadding="0" cellspacing="0"> <!-- Tableau sans bordure, sans espacement intérieur et entre les cellules -->
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;"> <!-- Cellule avec une image de fond -->
						<center>
							<?php
							// Affiche le nombre de bonnes réponses et de questions
							if($_SESSION['nbBonneReponse']>1)
								echo '<h2>Fin du test.</h2>Tu as '.$_SESSION['nbBonneReponse'].' bonnes réponses sur '.$_SESSION['nbQuestion'].' questions.';
							else
								echo '<h2>Fin du test.</h2>Tu as '.$_SESSION['nbBonneReponse'].' bonne réponse sur '.$_SESSION['nbQuestion'].' questions.';
							
							// Sauvegarde les résultats dans un fichier texte
							$_SESSION['prenom'] = strtolower($_SESSION['prenom']);
							$_SESSION['prenom'] = supprime_caracteres_speciaux($_SESSION['prenom']);
							$today = date('Ymd-His'); // Format de la date pour éviter les conflits de noms
							$fp = fopen('./resultats/'.$_SESSION['prenom'].'-'.$today.'.txt', 'w'); // Ouvre un fichier pour enregistrer les résultats
							$_SESSION['historique'] = $_SESSION['historique'] . '' . $_SESSION['nbBonneReponse']; // Ajoute les réponses à l'historique
							fwrite($fp, $_SESSION['historique']); // Écrit l'historique dans le fichier
							fclose($fp); // Ferme le fichier

							// Affiche des messages et des images en fonction du score
							if($_SESSION['nbBonneReponse'] >= $_SESSION['nbMaxQuestions'] * 0.8) {
								echo '<h3>Félicitations !</h3>';
								echo '<img src="./images/medailleOr.png" width="100px"><br />';
							} else {								 
								if($_SESSION['nbBonneReponse'] >= $_SESSION['nbMaxQuestions'] * 0.6) {
									echo '<h3>Très bien !</h3>';
									echo '<img src="./images/medailleArgent.png" width="100px"><br />';
								} else {
									if($_SESSION['nbBonneReponse'] >= $_SESSION['nbMaxQuestions'] * 0.4) {
										echo '<h3>Super !</h3>';
										echo '<img src="./images/medailleBronze.png" width="100px"><br />';
									} else {
										echo '<h3>Recommence. Tu peux faire mieux !</h3>';
										echo '<img src="./images/smileyTriste.png" width="100px"><br />';
									}	
								}
							}
							?>
							<!-- Formulaire pour recommencer le test -->
							<form action="./index.php" method="post">
								<input type="submit" value="Recommencer" autofocus> <!-- Bouton pour recommencer le test -->
							</form>
						</center>
					</td>
					<td style="width:280px;height:430px;background-image:url('./images/NE.jpg');background-repeat:no-repeat;"></td> <!-- Cellule avec une image de fond -->
				</tr>
				<tr>
					<td style="width:1000px;height:323px;background-image:url('./images/SO.jpg');background-repeat:no-repeat;"></td> <!-- Cellule avec une image de fond -->
					<td style="width:280px;height:323px;background-image:url('./images/SE.jpg');background-repeat:no-repeat;"></td> <!-- Cellule avec une image de fond -->
				</tr>
			</table>
		</center>
		<br />
		<footer style="background-color: #45a1ff;"> <!-- Footer avec couleur de fond bleue -->
			<center> <!-- Centre le contenu du footer -->
				Rémi Synave<br />
				Contact : remi . synave @ univ - littoral [.fr]<br />
				Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
				et Image par <a href="https://pixabay.com/fr/users/everesd_design-16482457/">everesd_design</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=5213756">Pixabay</a> <br />
				Crédits voix : Denise de <a href="https://azure.microsoft.com/fr-fr/services/cognitive-services/text-to-speech/">Microsoft Azure</a>
			</center>
		</footer>
	</body>
</html>
