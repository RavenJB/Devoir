<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Résultats</title>
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
						
							<?php
								// Si le prénom n'est pas renseigné, demander à l'utilisateur de le saisir
								if($_GET['prenomRes']==""){
									include 'utils.php'; // Inclure les fonctions utilitaires
									log_adresse_ip("logs/log.txt","affiche_resultat.php"); // Log de l'accès
							?>
						
							<h3>Quel est le prénom de l'enfant ?</h3><br />
							<form action="./affiche_resultat.php" method="get">
								<input type="text" id="prenomRes" name="prenomRes" autocomplete="off"><br /><br /><br />
								<input type="submit" value="Afficher les résultats">
							</form>
						
							<?php
								// Si le prénom est renseigné, afficher les résultats correspondants
								}else{
									include 'utils.php'; // Inclure les fonctions utilitaires
									log_adresse_ip("logs/log.txt","affiche_resultat.php - ".$_GET['prenomRes']); // Log avec le prénom renseigné
									echo '<h1>Résultats de '.$_GET['prenomRes'].'</h1>';
									$total=0;
									$files=scandir('./resultats/'); // Récupérer la liste des fichiers dans le répertoire 'resultats'
									$_GET['prenomRes']=strtolower($_GET['prenomRes']); // Convertir le prénom en minuscules
                                    $_GET['prenomRes']=supprime_caracteres_speciaux($_GET['prenomRes']); // Supprimer les caractères spéciaux du prénom
									
									// Parcourir les fichiers de résultats pour afficher ceux correspondant au prénom
									foreach ($files as $fichier)
										if(substr($fichier, 0, strlen($_GET['prenomRes']))==$_GET['prenomRes']){
											// Afficher le lien vers le fichier de résultat
											echo '<a href="./resultats/'.$fichier.'">'.$fichier.'</a> : ';
											$fichierOuvert = file('./resultats/'.$fichier); // Ouvrir le fichier de résultat
											$der_ligne = $fichierOuvert[count($fichierOuvert)-1]; // Dernière ligne du fichier (score)
											$total=$total+$der_ligne; // Ajouter le score total
											// Afficher le score et un lien pour supprimer le fichier de résultat
											echo $der_ligne.' points - <a href="supprimer_resultat.php?prenomRes='.$_GET['prenomRes'].'&nomFichier='.$fichier.'">supprimer</a><br /><br />';
										}
										
									// Afficher le total des points
									echo '<hr><br />';
									if($total>1)
										echo '<h2>TOTAL : '.$total.' POINTS</h2>';
									else
										echo '<h2>TOTAL : '.$total.' POINT</h2>';
								}
							?>
							
						
						
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
