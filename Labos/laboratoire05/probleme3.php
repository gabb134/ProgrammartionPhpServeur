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
<div id="divContenuFormate">
    <p class="sTitreSection">
        Contenu formaté du fichier '<?php echo $strNomFichierCSV; ?>'
    </p>
    <?php
    //Ouverture du fichier CSV en lecture
    $fp = fopen($strNomFichierCSV, "r");
    ?>
    <table class="sTableau">
        <tr>
            <td class="sEntete">No</td>
            <td class="sEntete">Matricule</td>
            <td class="sEntete">Nom complet</td>
            <td class="sEntete">Programme</td>
        </tr>
<?php
        //parcour du fichier
        while (!feof($fp)) {
            $intLigne++;
            list($strMatricule, $strNom, $strPrenom, $strNoProgramme) = explode(";", remplaceEspaces($fp));
?>
            <tr>
                <td class=""><?php echo ajouteZeros($intLigne, 2); ?> </td>
                <td class="sGras sBleu"> <?php echo $strMatricule; ?></td>
                <td class="sGras sBleu"><?php echo "$strPrenom $strNom" ?></td>
                <td class="sGras sBleu"><?php echo $strNoProgramme; ?></td>
            </tr>
<?php
        }
?>
    </table>
<?php
    //Fermeture du fichier
    fclose($fp);
?>
</div>
<?php
require_once './pied-page.php';
?>