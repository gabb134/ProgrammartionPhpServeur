<?php
require_once './librairie-date.php';
require_once './librairie-generale.php';

$strTitreApplication = "Lecture d'un fichier CSV";
$strNomFichierCSS = "index.css";
$strNomAuteur = "Gabriel Marrero";

require_once './en-tete.php';
//Initialisation des variables de travail
$strNomFichierCSV = "liste-eleves.csv";
$intLigne = 0;
$strStyle = "stlyle =\"font-family:consolas; font-size:16px;\"";
$strClass = "class=\"sGras sBleu\"";
?>
<div id="divContenuBrut">
    <p class="sTitreSection">
        Contenu brut du fichier '<?php echo $strNomFichierCSV; ?>'
    </p>
    <p>
        <?php
        //Ouverture du fichier CSV en lecture
        $fp = fopen($strNomFichierCSV, "r");
        //parcour du fichier
        while (!feof($fp)) {
            $intLigne++;
            list($strMatricule,$strNom,$strPrenom,$strNoProgramme) = explode(";", remplaceEspaces($fp));
            
            echo "<span $strStyle>" . ajouteZeros($intLigne, 2) ."</.span>: ";
            echo "<span $strClass>$strMatricule</span>, ";
            echo "<span $strClass>$strPrenom</span>, ";
            echo "<span $strClass>$strNom</span>, ";
            echo "<span $strClass>$strNoProgramme</span><br/>";
        }
        //Fermeture du fichier
        fclose($fp);
        ?>        
    </p>
</div>
<?php
require_once './pied-page.php';
?>