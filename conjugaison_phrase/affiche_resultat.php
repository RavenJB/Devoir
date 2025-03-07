<!doctype html>
<html lang="fr"> <!-- Déclare la langue de la page comme étant le français -->
	<head>
		<meta charset="utf-8"> <!-- Définit l'encodage des caractères en UTF-8 -->
		<title>Résultats</title> <!-- Définit le titre de la page affiché dans l'onglet du navigateur -->
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
	<body style="background-color:grey;"> <!-- Définit la couleur de fond de la page en gris -->
		<center> <!-- Centre le contenu de la page -->
			<table border="0" cellpadding="0" cellspacing="0"> <!-- Crée un tableau sans bordure, sans espace intérieur et sans espace entre les cellules -->
				<tr>
					<td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;"> <!-- Première cellule du tableau, avec une image de fond -->
						<center> <!-- Centre le contenu dans cette cellule -->
						
							<?php
								// Vérifie si le paramètre 'prenomRes' dans l'URL est vide
								if($_GET['prenomRes']==""){
									include 'utils.php'; // Inclut le fichier utils.php, probablement pour des fonctions utilitaires comme log_adresse_ip
									log_adresse_ip("logs/log.txt","affiche_resultat.php"); // Log l'adresse IP de l'utilisateur dans un fichier de log
							?>
						
							<!-- Si 'prenomRes' est vide, demande à l'utilisateur de saisir le prénom -->
							<h3>Quel est le prénom de l'enfant ?</h3><br />
							<form action="./affiche_resultat.php" method="get"> <!-- Le formulaire envoie une requête GET vers affiche_resultat.php -->
								<input type="text" id="prenomRes" name="prenomRes" autocomplete="off"><br /><br /><br />
								<input type="submit" value="Afficher les résultats"> <!-- Bouton pour soumettre le formulaire -->
							</form>
						
							<?php
								}else{
									// Si 'prenomRes' est rempli, continue ici
									include 'utils.php'; // Inclut à nouveau le fichier utils.php pour avoir accès à des fonctions comme log_adresse_ip
									log_adresse_ip("logs/log.txt","affiche_resultat.php - ".$_GET['prenomRes']); // Log l'adresse IP et le prénom de l'enfant dans le fichier de log
									echo '<h1>Résultats de '.$_GET['prenomRes'].'</h1>'; // Affiche le titre avec le prénom de l'enfant
									$total=0; // Initialise la variable pour totaliser les points
									$files=scandir('./resultats/'); // Récupère la liste des fichiers dans le dossier 'resultats'
									$_GET['prenomRes']=strtolower($_GET['prenomRes']); // Convertit le prénom en minuscules
                                    $_GET['prenomRes']=supprime_caracteres_speciaux($_GET['prenomRes']); // Supprime les caractères spéciaux du prénom
									
									// Parcourt tous les fichiers du dossier 'resultats' pour afficher ceux qui correspondent au prénom
									foreach ($files as $fichier)
										if(substr($fichier, 0, strlen($_GET['prenomRes']))==$_GET['prenomRes']){ // Si le début du nom de fichier correspond au prénom
											// Affiche le lien vers le fichier et ses résultats
											echo '<a href="./resultats/'.$fichier.'">'.$fichier.'</a> : ';
											$fichierOuvert = file('./resultats/'.$fichier); // Ouvre le fichier pour lire son contenu
											$der_ligne = $fichierOuvert[count($fichierOuvert)-1]; // Récupère la dernière ligne du fichier
											$total=$total+$der_ligne; // Ajoute le score de la dernière ligne au total
											// Affiche le score du fichier et un lien pour supprimer le fichier
											echo $der_ligne.' points - <a href="supprimer_resultat.php?prenomRes='.$_GET['prenomRes'].'&nomFichier='.$fichier.'">supprimer</a><br /><br />';
										}
										
									// Affiche le total des points
									echo '<hr><br />';
									if($total>1)
										echo '<h2>TOTAL : '.$total.' POINTS</h2>'; // Si le total est supérieur à 1, affiche "POINTS"
									else
										echo '<h2>TOTAL : '.$total.' POINT</h2>'; // Si le total est égal à 1, affiche "POINT"
								}
							?>
							
						</center>
					</td>
					<td style="width:280px;height:430px;background-image:url('./images/NE.jpg');background-repeat:no-repeat;"></td> <!-- Deuxième cellule avec une image de fond -->
				</tr>
				<tr>
					<td style="width:1000px;height:323px;background-image:url('./images/SO.jpg');background-repeat:no-repeat;"></td> <!-- Troisième cellule avec une image de fond -->
					<td style="width:280px;height:323px;background-image:url('./images/SE.jpg');background-repeat:no-repeat;"></td> <!-- Quatrième cellule avec une image de fond -->
				</tr>
			</table>
		</center>
		<br />
		<footer style="background-color: #45a1ff;"> <!-- Définit la couleur de fond du pied de page -->
			<center> <!-- Centre le contenu du pied de page -->
				Rémi Synave<br />
				Contact : remi . synave @ univ - littoral [.fr]<br />
				Crédits image : Image par <a href="https://pixabay.com/fr/users/Mimzy-19397/">Mimzy</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1576791">Pixabay</a> <br />
				Crédits voix : Denise de <a href="https://azure.microsoft.com/fr-fr/services/cognitive-services/text-to-speech/">Microsoft Azure</a>
			</center>
		</footer>
	</body>
</html>
