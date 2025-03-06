<?php
// log adresse ip
// paramètre : nom du fichier de log
function log_adresse_ip($cheminFichierLog, $nomPage) {
    $adresseIP = $_SERVER['REMOTE_ADDR']; // Récupère l'adresse IP de l'utilisateur qui accède à la page.
    $fichierLog = fopen($cheminFichierLog, "a"); // Ouvre le fichier de log en mode ajout (append).
    $tdate = getdate(); // Récupère la date et l'heure actuelles sous forme de tableau (avec jour, mois, année, heures, minutes, secondes).
    
    // Formate la date au format JJ/MM/AAAA
    $jour = sprintf("%02.2d", $tdate["mday"])."/".sprintf("%02.2d", $tdate["mon"])."/".$tdate["year"];
    
    // Formate l'heure au format HHhMMmSSs
    $heure = sprintf("%02.2d", $tdate["hours"])."h".sprintf("%02.2d", $tdate["minutes"])."m".sprintf("%02.2d", $tdate["seconds"])."s";
    
    $d = "[".$jour." ".$heure."]"; // Construit un timestamp avec la date et l'heure.
    
    // Écrit dans le fichier de log la date, l'adresse IP et le nom de la page avec un retour à la ligne
    fwrite($fichierLog, $d." - ".$adresseIP." : ".$nomPage."\n");
    
    fclose($fichierLog); // Ferme le fichier de log après l'écriture.
}
?>

<?php
function supprime_caracteres_speciaux($chaine) { 
    // Remplacement des caractères accentués par leurs équivalents non accentués
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
    
    return $chaine; // Retourne la chaîne modifiée sans les caractères spéciaux.
}
?>


<?php
function conjugaison($nomFichier, $numLigne) {
    $fichierVerbe = file($nomFichier); // Charge le fichier spécifié ($nomFichier) et le transforme en un tableau de lignes.
    $reponse = $fichierVerbe[$numLigne-1]; // Récupère la ligne correspondant au numéro passé en paramètre ($numLigne). On soustrait 1 pour compenser l'indexation à partir de 0.
    $reponse = substr($reponse, 0, -1); // Supprime le dernier caractère de la ligne (probablement un retour à la ligne).
    return $reponse; // Retourne la ligne sans le dernier caractère.
}
?>
