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
                        // Vérifie si le prénom de l'enfant est fourni dans l'URL
                        if($_GET['prenomRes']==""){
                            include 'utils.php';
                            // Log l'accès à la page
                            log_adresse_ip("logs/log.txt","affiche_resultat.php");
                        ?>
                        
                        <!-- Formulaire pour demander le prénom de l'enfant -->
                        <h3>Quel est le prénom de l'enfant ?</h3><br />
                        <form action="./affiche_resultat.php" method="get">
                            <input type="text" id="prenomRes" name="prenomRes" autocomplete="off"><br /><br /><br />
                            <input type="submit" value="Afficher les résultats">
                        </form>
                        
                        <?php
                        } else {
                            include 'utils.php';
                            // Log l'accès à la page avec le prénom de l'enfant
                            log_adresse_ip("logs/log.txt","affiche_resultat.php - ".$_GET['prenomRes']);
                            echo '<h1>Résultats de '.$_GET['prenomRes'].'</h1>';
                            $total=0;
                            // Scanne le répertoire des résultats
                            $files=scandir('./resultats/');
                            // Normalise le prénom de l'enfant
                            $_GET['prenomRes']=strtolower($_GET['prenomRes']);
                            $_GET['prenomRes']=supprime_caracteres_speciaux($_GET['prenomRes']);
                            // Parcourt les fichiers de résultats
                            foreach ($files as $fichier)
                                if(substr($fichier, 0, strlen($_GET['prenomRes']))==$_GET['prenomRes']){
                                    echo '<a href="./resultats/'.$fichier.'">'.$fichier.'</a> : ';
                                    $fichierOuvert = file('./resultats/'.$fichier);
                                    $der_ligne = $fichierOuvert[count($fichierOuvert)-1];
                                    $total=$total+$der_ligne;
                                    echo $der_ligne.' points - <a href="supprimer_resultat.php?prenomRes='.$_GET['prenomRes'].'&nomFichier='.$fichier.'">supprimer</a><br /><br />';
                                }
                                
                            echo '<hr><br />';
                                
                            // Affiche le total des points
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
            et Image par <a href="https://pixabay.com/fr/users/everesd_design-16482457/">everesd_design</a> de <a href="https://pixabay.com/fr/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=5213756">Pixabay</a> <br />
        </center>
    </footer>
</body>
</html>