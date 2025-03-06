<?php
// log adresse ip
// paramètre : nom du fichier de log
function log_adresse_ip($cheminFichierLog, $nomPage) {
    // Récupère l'adresse IP du visiteur depuis la variable serveur
    $adresseIP = $_SERVER['REMOTE_ADDR'];
    
    // Ouvre le fichier de log en mode "ajout" (a), afin d'ajouter de nouvelles lignes sans écraser les anciennes
    $fichierLog = fopen($cheminFichierLog, "a");
    
    // Récupère la date et l'heure actuelles
    $tdate = getdate();
    
    // Formate la date au format JJ/MM/AAAA
    $jour = sprintf("%02.2d", $tdate["mday"]) . "/" . sprintf("%02.2d", $tdate["mon"]) . "/" . $tdate["year"];
    
    // Formate l'heure au format HHhMMmSSs
    $heure = sprintf("%02.2d", $tdate["hours"]) . "h" . sprintf("%02.2d", $tdate["minutes"]) . "m" . sprintf("%02.2d", $tdate["seconds"]) . "s";
    
    // Combine la date et l'heure dans un format lisible
    $d = "[" . $jour . " " . $heure . "]";
    
    // Écrit une ligne dans le fichier de log avec la date, l'adresse IP et la page accédée
    fwrite($fichierLog, $d . " - " . $adresseIP . " : " . $nomPage . "\n");
    
    // Ferme le fichier de log
    fclose($fichierLog);
}

?>

<?php
// Fonction pour supprimer les caractères spéciaux (accents) d'une chaîne
function supprime_caracteres_speciaux($chaine) { 
    // Remplace les caractères accentués par leur équivalent non accentué
    $chaine = str_replace("à", "a", $chaine);
    $chaine = str_replace("â", "a", $chaine);
    $chaine = str_replace("é", "e", $chaine);
    $chaine = str_replace("è", "e", $chaine);
    $chaine = str_replace("ë", "e", $chaine);
    $chaine = str_replace("ê", "e", $chaine);
    $chaine = str_replace("î", "i", $chaine);
    $chaine = str_replace("ï", "i", $chaine);
    $chaine = str_replace("ô", "o", $chaine);
    $chaine = str_replace("ö", "o", $chaine);
    $chaine = str_replace("ù", "u", $chaine);
    $chaine = str_replace("û", "u", $chaine);
    $chaine = str_replace("ü", "u", $chaine);
    $chaine = str_replace("ÿ", "y", $chaine);
    $chaine = str_replace("ç", "c", $chaine);
    
    // Retourne la chaîne modifiée sans accents
    return $chaine;
}

?>

<?php
// Fonction pour récupérer la conjugaison d'un verbe à une ligne spécifique dans un fichier donné
function conjugaison($nomFichier, $numLigne) {
    // Ouvre le fichier de verbes et le charge dans un tableau
    $fichierVerbe = file($nomFichier);
    
    // Récupère la ligne spécifiée (notez que les indices sont basés sur 0, donc on soustrait 1)
    $reponse = $fichierVerbe[$numLigne - 1];
    
    // Supprime le caractère de nouvelle ligne à la fin de la réponse
    $reponse = substr($reponse, 0, -1);
    
    // Retourne la réponse obtenue
    return $reponse;
}

?>
