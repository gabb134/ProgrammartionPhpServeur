<?php

require_once './librairie-date.php';
require_once './librairie-generale.php';
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



//Utilisation de la fonction convertiSousChaineEntier
$intJour3 = convertiSousChaineEntier($strDate, 0, 2);
$intMois3 = convertiSousChaineEntier($strDate, 3, 2);
$intAnnee3 = convertiSousChaineEntier($strDate, 6, 4);

//affichage de la date avec la fonction convertiSousChaineEntier
echo "Nous sommes le $intJour3-$intMois-$intAnnee3.<br/><br/>";


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

//test de la focntion moisEnLiterral
for ($i = 0; $i <= 13; $i++) {
    echo moisEnLiterral($i) . ", " . moisEnLiterral($i, false) . ", " . moisEnLiterral($i, true) . "<br/>";
}
echo "<br/>";

//Exercice 1 : Création de la fonction joursemaineEnLiterral



//test de la fonction joursemaineEnLiterral
for ($i = 0; $i <= 8; $i++) {
    echo joursemaineEnLiterral($i) . ", " . joursemaineEnLiterral($i, false) . ", " . joursemaineEnLiterral($i, true) . "<br/>";
}

//Exercice 2 : Creation de la fonction er

//test de la fonction er

echo "<br/>";
echo er(1) . ", ";
echo er(1, false) . ", ";
echo er(1, true) . "<br/>";
echo er(31) . "<br/><br/>";

//Exercice 3 : Creation de la fonction extraitJSJJMMAAAA

//test de la fonction extraitJSJJMMAAAA

$intJour6;
$intMois6;
$intAnnee6;
$intJourSemaine6;
//Extraction a partir de la date courante
echo "<br/>";
extraitJSJJMMAAAA($intJourSemaine6, $intJour6, $intMois6, $intAnnee6);
echo "Nous sommes le " . joursemaineEnLiterral($intJourSemaine6) . " " . er($intJour6) . " " . moisEnLiterral($intMois6) . "  $intAnnee6 . <br/><br/>";

//2e test de la fonction extraitJSJJMMAAAA

$intJour7;
$intMois7;
$intAnnee7;
$intJourSemaine7;

//Extraction a partir de la date specifiee
for($i = 1 ; $i <= 31;$i++){
    extraitJSJJMMAAAA($intJourSemaine7, $intJour7, $intMois7, $intAnnee7,($i < 10 ? "0" : "") . "$i-01-2020");
    echo "Nous sommes le " . joursemaineEnLiterral($intJourSemaine7). " ".er($intJour7)." ".moisEnLiterral($intMois7)." $intAnnee7.<br/>";
}
    




/*echo "Resultat de la fonction extraitJSJJMMAAAA<br/>";
echo "jour : " . $intJour6 . "<br/>";
echo "mois : " . $intMois6 . "<br/>";
echo "annee : " . $intAnnee6 . "<br/>";
echo "Jour de la semaine : " . $intJourSemaine6 . "<br/>";*/

echo "Jour de la semaine : " . $intJourSemaine6 . "<br/>";
//echo date("N");
//echo joursemaineEnLiterral(3);
//echo moisEnLiterral(1)



?>



