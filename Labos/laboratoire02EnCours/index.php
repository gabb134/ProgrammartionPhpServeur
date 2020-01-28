<?php

//1. ex: Nous sommes le 28-01-2020
$strDate = date("d-m-Y");
echo "Nous sommes le $strDate.<br/><br/>";

//1re technique : récupération du jour, mois et annee a partir de la fonction date()
$strJour = date("d");
var_dump($strJour);
$strMois = date("m");
var_dump($strMois);
$strAnnee = date("Y");
var_dump($strAnnee);

//conversion des dates en entier
$intJour = intval($strJour);
var_dump($intJour);
$intMois = intval($strMois);
var_dump($intMois);
$intAnnee = intval($strAnnee);
var_dump($intAnnee);

//affichage de la date
echo "nous sommes le $strJour-$strMois-$strAnnee.<br/>";
echo "nous somme le $intJour-$intMois-$intAnnee.<br/><br/>";

//2e technique : Extraction du jour, mois et annee a partir de $strDate
$intJour2 = intval(substr($strDate, 0, 2));
$intMois2 = intval(substr($strDate, 3, 2));
$intAnnee2 = intval(substr($strDate, 6, 4));

//affichage de la date
echo "Nous sommes le $intJour2-$intMois2-$intAnnee2.<br/><br/>";

/* FONCTION 
  |------------------------------------------------------|
  | convertiSousChaineEntier(2020-01-24)
  |------------------------------------------------------|
 */

function convertiSousChaineEntier($strChaine, $intDepart, $intLongeur) {
    $intEntier = intval(substr($strChaine, $intDepart, $intLongeur));
    return $intEntier;
}

//Utilisation de la fonction convertiSousChaineEntier
$intJour3 = convertiSousChaineEntier($strDate, 0, 2);
$intMois3 = convertiSousChaineEntier($strDate, 3, 2);
$intAnnee3 = convertiSousChaineEntier($strDate, 6, 4);

//affichage de la date avec la fonction convertiSousChaineEntier
echo "Nous sommes le $intJour3-$intMois-$intAnnee3.<br/><br/>";

/* FONCTION 
  |----------------------------------------------------------------------------|
  |extraitJJMMAAAA (2020-01-24)
  | Scénarios :extraitJJMMAAAA($intJour,$intMoi,intAnnee) <= date()
  |            extraitJJMMAAAA($intJour,$intMois,$intAnnee,$strDate)<= $strDate
  |----------------------------------------------------------------------------|
 */

function extraitJJMMAAAA(&$intJour, &$intMois, &$intAnnee) {
    /* Par defaut, l'extraction s'effectue a partir de la date courante
     * autrement elle s'effectue a partir du 4e arguement specifie a l'appel */

    if (func_num_args() == 3) {
        //recuperation de la date courante
        $strDate = date("d-m-Y");
    } else {
        //recuperation du 4e argument
        $strDate = func_get_arg(3);
    }
    $intJour = intval(substr($strDate, 0, 2));
    $intMois = intval(substr($strDate, 3, 2));
    $intAnnee = intval(substr($strDate, 6, 4));
}

//declaration des variables
$intJour4;
$intMois4;
$intAnnee4;

//Extraction a partir de la date courante
extraitJJMMAAAA($intJour4, $intMois4, $intAnnee4);
echo "Nous sommes le $intJour4-$intMois4-$intAnnee4.<br/><br/>";

//declaration des variables
$intJour5;
$intMois5;
$intAnnee5;
$strDate5 = "31-12-2020";

//Extraction a partir de la date specifiee
extraitJJMMAAAA($intJour5, $intMois5, $intAnnee5, $strDate5);
echo "Nous sommes le $intJour5-$intMois5-$intAnnee5.<br/><br/>";

/* FONCTION 
  |-----------------------------------------------------------------------------------|
  |moisEnLirterral (2020-01-24)
  | Scénarios :moisEnLirterral(,$intMois)              => Premiere lettre en miniscule
  |            moisEnLirterral(,$intMois,$binMajuscule)=> En fonction de $binMajuscule
  |-----------------------------------------------------------------------------------|
 */

function moisEnLiterral($intMois, $binMajuscule = false) {
    /* Par defaut la premiere lettre du mois s'affiche en minuscule ($binMajuscule = false)
     * Si un deuzueme argument est saisi, il determinera si la premiere lettre doit 
     * s'affciher en majuscule ou non */
    $strMois = "N/A";
    switch ($intMois) {
        case 1:
            $strMois = "janvier";
            break;
        case 2:
            $strMois = "f&eacute;vrier";
            break;
        case 3:
            $strMois = "mars";
            break;
        case 4:
            $strMois = "avril";
            break;
        case 5:
            $strMois = "mai";
            break;
        case 6:
            $strMois = "juin";
            break;
        case 7:
            $strMois = "juillet";
            break;
        case 8:
            $strMois = "ao&ucirc;t";
            break;
        case 9:
            $strMois = "septembre";
            break;
        case 10:
            $strMois = "octobre";
            break;
        case 11:
            $strMois = "novembre";
            break;
        case 12:
            $strMois = "d&eacute;cembre";
            break;

        default:
            break;
    }
    if ($binMajuscule)
        $strMois = ucfirst($strMois);
    //on aurait pu aussi le faire comme ca
    //$strMois = $binMajuscule ? ucfirst($strMois) : $strMois;
    return $strMois;
}

//test de la focntion moisEnLiterral
for ($i = 0; $i <= 13; $i++) {
    echo moisEnLiterral($i) . ", " . moisEnLiterral($i, false) . ", " . moisEnLiterral($i, true) . "<br/>";
}
echo "<br/>";
//Exercice 1 : Création de la fonction joursemaineEnLiterral


/* FONCTION 
  |-----------------------------------------------------------------------------------|
  |joursemaineEnLiterral (2020-01-24)
  | Scénarios :joursemaineEnLiterral($intJour)              => Premiere lettre en miniscule
  |            joursemaineEnLiterral($intJour,$binMajuscule)=> En fonction de $binMajuscule
  |-----------------------------------------------------------------------------------|
 */

function joursemaineEnLiterral($intNoJour, $binMajuscule = false) {
    $strJour = "N/A";

    switch ($intNoJour) {
        case 1:
            $strJour = "lundi";
            break;
        case 2:
            $strJour = "mardi";
            break;
        case 3:
            $strJour = "mercredi";
            break;
        case 4:
            $strJour = "jeudi";
            break;
        case 5:
            $strJour = "vendredi";
            break;
        case 6:
            $strJour = "samedi";
            break;
        case 7:
            $strJour = "dimanche";
            break;

        default:
            break;
        
       
    }
     if($binMajuscule)
            $strJour = ucfirst ($strJour);
     
     return $strJour;
    
}

//test de la fonction joursemaineEnLiterral
for($i = 0 ; $i<=8;$i++){
    echo joursemaineEnLiterral($i) . ", " . joursemaineEnLiterral($i,false) . ", " . joursemaineEnLiterral($i, true) . "<br/>";
}
?>



