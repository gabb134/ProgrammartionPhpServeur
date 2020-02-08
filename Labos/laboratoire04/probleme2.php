<?php
require_once './librairie-date.php';
require_once './librairie-generale.php';
$strTitreApplication = "Affichage de la date courantesss";
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

extraitJSJJMMAAAA($intJourSemaine, $intJour, $intMois, $intAnnee,$strDate);


//echo "variable intJourSemaine: ".$intJourSemaine . "</br>";
//echo "Jour de la semaine : " . joursemaineEnLiterral($intJourSemaine) . "</br>";

echo "Nous sommes le " . joursemaineEnLiterral($intJourSemaine) . " " . er($intJour) . " " . moisEnLiterral($intMois) . " ". $intAnnee ."</br></br>"; 

?>
<div>
    C'est ici que nous afficherons la date courante
</div>
<?php
require_once './pied-page.php';
?>

