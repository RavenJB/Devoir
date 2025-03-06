<?php
@ob_start(); // Active la mise en tampon de sortie pour éviter des erreurs d'affichage
include 'utils.php'; // Inclusion du fichier utils.php contenant des fonctions utiles
session_start(); // Démarre la session PHP pour stocker et récupérer des variables de session

// Inclure et configurer Monolog pour la journalisation des événements
$log = require __DIR__ . '/log_config.php';

// Enregistre dans les logs l'accès à cette page avec l'adresse IP et les informations utilisateur
$log->info('Accès à question.php', [
    'ip' => $_SERVER['REMOTE_ADDR'], // Adresse IP de l'utilisateur
    'page' => 'question.php', // Nom de la page
    'user' => $_SESSION['prenom'], // Prénom de l'utilisateur stocké en session
    'question_number' => $_SESSION['nbQuestion'] // Numéro de la question en cours
]);

// Vérifie si le nombre de questions dépasse le maximum défini, si oui, redirige vers la page de fin
if ($_SESSION['nbQuestion'] > $_SESSION['nbMaxQuestions']) {
	header('Location: ./fin.php');
}

?>

<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8"> <!-- Définition du jeu de caractères -->
		<title>Question</title> <!-- Titre de la page affiché dans l'onglet -->
	</head>
	<body style="background-color:grey;"> <!-- Définition du fond de la page en gris -->
		<?php 
            // Incrémente le compteur de questions à chaque affichage de cette page
            $_SESSION['nbQuestion'] = $_SESSION['nbQuestion'] + 1;
			
            // Déclaration des variables pour générer une opération mathématique
			$nbGauche = 0;
			$nbDroite = 0;
			$operation = 0;
			$reponse = 0;

			// Génération aléatoire des nombres pour l'addition
			$nbGauche = mt_rand(1000, 10000); // Nombre de gauche (entre 1000 et 10000)
			$nbDroite = mt_rand(5000, 10000); // Nombre de droite (entre 5000 et 10000)

			// Création de l'opération mathématique et du résultat attendu
			$operation = $nbGauche . ' + ' . $nbDroite;
			$reponse = $nbGauche + $nbDroite;
		?>
		<center>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
						<center>
							<h1>Question Numéro <?php echo $_SESSION['nbQuestion']; ?></h1><br />
							<h3>Combien fait le calcul suivant ?</h3>
							<h3><?php echo $operation . ' = ?'; ?></h3> <!-- Affichage du calcul généré -->

							<!-- Formulaire permettant à l'utilisateur de saisir sa réponse -->
							<form action="./correction.php" method="post">
								<!-- Stocke l'opération et la réponse correcte sous forme de champs cachés -->
								<input type="hidden" name="operation" value="<?php echo $operation . ' = '; ?>"></input>
								<input type="hidden" name="correction" value="<?php echo $reponse; ?>"></input>
								
								<br />
								<label for="fname">Combien fait le calcul ci-dessus ? </label><br>
								<input type="text" id="mot" name="mot" autocomplete="off" autofocus><br /><br /><br />
								<input type="submit" value="Valider"> <!-- Bouton pour soumettre la réponse -->
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
		<!-- Pied de page contenant les informations de contact et les crédits images -->
		<footer style="background-color: #45a1ff;">
			<center>
				Rémi Synave<br />
				Contact : remi . synave @ univ - littoral [.fr]<br />
				Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/">Pixabay</a> <br />
				et Image par <a href="https://pixabay.com/fr/users/everesd_design-16482457/">everesd_design</a> de <a href="https://pixabay.com/fr/">Pixabay</a> <br />
			</center>
		</footer>
	</body>
</html>
