<?php
require_once './librairie-date.php';
require_once './librairie-generale.php';
$strTitreApplication = "Date de réunion";
$strNomFichierCSS = "index.css";
$strNomAuteur = "Gabriel Marrero";

require_once './en-tete.php';
//Declarations de variables
$intJour;
$intMois;
$intAnnee;
$intJourSemaine;
$strDate = "01-02-2020";

//Extraction du jour de la semaine, du jour, du mois et de l'annee de la date courante

extraitJSJJMMAAAA($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);


//echo "variable intJourSemaine: ".$intJourSemaine . "</br>";
//echo "Jour de la semaine : " . joursemaineEnLiterral($intJourSemaine) . "</br>";
//echo "Nous sommes le " . joursemaineEnLiterral($intJourSemaine) . " " . er($intJour) . " " . moisEnLiterral($intMois) . " " . $intAnnee . "</br></br>";
//exercice 2
for ($i = 0; $i <= 10; $i++) {
    //echo ajouteZeros(1, $i) . "</br>";
}
//die();
//exercice 3
for ($i = 0; $i <= 99; $i++) {
    // echo JJMMAAAA(1,1,$i) . "</br>";
}
//echo "</br>";
//echo JJMMAAAA(1,1,2020) . "<br/>";
//echo JJMMAAAA(31,12,2020);
//die();
//echo JJMMAAAA(1,2,21);
//Exercice 4
//Declaration de variables
$strDate;
$intJourSemaine;
$intPremierSamediMois;
for ($i = 1; $i <= 12; $i++) {
    //Entrposez la date correspondante au premier jour du mois dans $strDate
    $strDate = "01-" . ajouteZeros($i, 2) . "-2020";
    // echo $strDate."</br>";

    $intJourSemaine = date("N", strtotime($strDate));


    // echo $intJourSemaine . "</br>";
    switch ($intJourSemaine) {
        case 1:
            $intPremierSamediMois = 6;
            break;
        case 2:
            $intPremierSamediMois = 5;
            break;
        case 3:
            $intPremierSamediMois = 4;
            break;
        case 4:
            $intPremierSamediMois = 3;
            break;
        case 5:
            $intPremierSamediMois = 2;
            break;
        case 6:
            $intPremierSamediMois = 1;
            break;
        case 7:
            $intPremierSamediMois = 7;
            break;


        default:
            break;
    }
    //  echo $intPremierSamediMois. "</br>";
    //echo joursemaineEnLiterral(6 ). "</br>";
    echo "Réunion no " . ajouteZeros($i, 2) . " :" . "<strong>" . er($intPremierSamediMois) . " " . moisEnLiterral($i) . " " . $intAnnee . "</strong>" . "</br></br>";
}
?>

<!--<div>
    C'est ici que nous afficherons la date courante
</div> -->
<?php
require_once './pied-page.php';
?>

