<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Résultats</title>
    </head>
    <body style="background-color:grey;">
        <center>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width:1000px;height:430px;background-image:url('./images/NO.jpg');background-repeat:no-repeat;">
                        <center>
                        
                            <?php
                                // Vérifie si le prénom n'a pas été saisi
                                if($_GET['prenomRes']==""){
                                    // Inclusion du fichier utils.php pour utiliser des fonctions comme log_adresse_ip
                                    include 'utils.php';
                                    // Log l'adresse IP de la personne accédant à la page
                                    log_adresse_ip("logs/log.txt","affiche_resultat.php");
                            ?>
                            
                            <!-- Si le prénom n'est pas fourni, demande à l'utilisateur de saisir un prénom -->
                            <h3>Quel est le prénom de l'enfant ?</h3><br />
                            <form action="./affiche_resultat.php" method="get">
                                <input type="text" id="prenomRes" name="prenomRes" autocomplete="off"><br /><br /><br />
                                <input type="submit" value="Afficher les résultats">
                            </form>
                            
                            <?php
                                } else {
                                    // Log l'accès avec le prénom fourni
                                    include 'utils.php';
                                    log_adresse_ip("logs/log.txt","affiche_resultat.php - ".$_GET['prenomRes']);
                                    echo '<h1>Résultats de '.$_GET['prenomRes'].'</h1>';
                                    $total = 0; // Initialisation du total des points
                                    
                                    // Scanne tous les fichiers dans le répertoire ./resultats/
                                    $files = scandir('./resultats/');
                                    // Formatage du prénom pour ignorer les majuscules et caractères spéciaux
                                    $_GET['prenomRes'] = strtolower($_GET['prenomRes']);
                                    $_GET['prenomRes'] = supprime_caracteres_speciaux($_GET['prenomRes']);
                                    
                                    // Vérifie tous les fichiers qui commencent par le prénom
                                    foreach ($files as $fichier)
                                        // Si le fichier commence par le prénom saisi
                                        if (substr($fichier, 0, strlen($_GET['prenomRes'])) == $_GET['prenomRes']) {
                                            echo '<a href="./resultats/'.$fichier.'">'.$fichier.'</a> : ';
                                            // Ouvre le fichier et lit son contenu
                                            $fichierOuvert = file('./resultats/'.$fichier);
                                            // Prend la dernière ligne du fichier pour obtenir le score final
                                            $der_ligne = $fichierOuvert[count($fichierOuvert) - 1];
                                            // Ajoute les points à un total
                                            $total = $total + $der_ligne;
                                            // Affiche les points du fichier avec un lien pour supprimer le résultat
                                            echo $der_ligne.' points - <a href="supprimer_resultat.php?prenomRes='.$_GET['prenomRes'].'&nomFichier='.$fichier.'">supprimer</a><br /><br />';
                                        }

                                    // Affiche un total des points
                                    echo '<hr><br />';
                                    if ($total > 1) {
                                        echo '<h2>TOTAL : '.$total.' POINTS</h2>';
                                    } else {
                                        echo '<h2>TOTAL : '.$total.' POINT</h2>';
                                    }
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
        <!-- Footer de la page -->
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
