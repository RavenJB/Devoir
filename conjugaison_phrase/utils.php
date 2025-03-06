<?php
// Fonction pour loguer l'adresse IP et la page accédée
// Paramètre :
// $cheminFichierLog : chemin du fichier où les logs doivent être enregistrés
// $nomPage : nom de la page à logger
function log_adresse_ip($cheminFichierLog, $nomPage) {
    // Récupère l'adresse IP du client
    $adresseIP = $_SERVER['REMOTE_ADDR'];

    // Ouvre le fichier de log en mode ajout
    $fichierLog = fopen($cheminFichierLog, "a");

    // Récupère la date et l'heure actuelles
    $tdate = getdate();
    $jour = sprintf("%02.2d", $tdate["mday"]) . "/" . sprintf("%02.2d", $tdate["mon"]) . "/" . $tdate["year"];
    $heure = sprintf("%02.2d", $tdate["hours"]) . "h" . sprintf("%02.2d", $tdate["minutes"]) . "m" . sprintf("%02.2d", $tdate["seconds"]) . "s";

    // Formate la date et l'heure pour le log
    $d = "[" . $jour . " " . $heure . "]";

    // Écrit l'adresse IP et le nom de la page dans le fichier de log
    fwrite($fichierLog, $d . " - " . $adresseIP . " : " . $nomPage . "\n");

    // Ferme le fichier après l'écriture
    fclose($fichierLog);
}

?>

<?php
// Fonction pour supprimer les caractères spéciaux dans une chaîne
// Remplace certains caractères accentués ou spéciaux par des lettres simples
function supprime_caracteres_speciaux($chaine) { 
    // Remplacement de chaque caractère accentué par un caractère sans accent
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

    // Retourne la chaîne modifiée
    return $chaine;
}

?>

<?php
// Fonction pour récupérer la conjugaison d'un verbe à partir d'un fichier
// Paramètres : 
// $nomFichier : le chemin du fichier contenant la conjugaison du verbe
// $numLigne : le numéro de la ligne à récupérer dans le fichier
function conjugaison($nomFichier, $numLigne) {
    // Ouvre le fichier contenant les conjugaisons du verbe
    $fichierVerbe = file($nomFichier);

    // Récupère la ligne correspondant au numéro passé en argument
    $reponse = $fichierVerbe[$numLigne - 1];

    // Supprime le caractère de fin de ligne (newline) de la réponse
    $reponse = substr($reponse, 0, -1);

    // Retourne la conjugaison
    return $reponse;
}

?>
