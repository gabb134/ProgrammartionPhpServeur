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
//Recuperation du parametre a partit de la barre d'adresse du navigateur
$strMatriculeRecherche = isset($_POST["tbMatricule"]) ? $_POST["tbMatricule"] : "";
echo "Matricule recherche : ";
echo $strMatriculeRecherche ? $strMatriculeRecherche : "Aucune matricule saisi";
//die();
//$strStyle = "stlyle =\"font-family:consolas; font-size:16px;\"";
//$strClass = "class=\"sGras sBleu\"";
?>
<div id="divSaisieMatricule">
    <p class="sTitreSection">
        Saisie du matricule de l'élève
    </p>
    Matricule :
    <input id="tbMatricule" name="tbMatricule" value="<?php echo $strMatriculeRecherche; ?>" type="text" maxlength="7" style="width: 70px">
    <input id="btnSoumettre" name="btnSoumettre" type="submit" value="Soumettre">
</div>
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
        $binTrouve = false;
        while (!feof($fp) && !$binTrouve) {
            $intLigne++;

            list($strMatricule, $strNom, $strPrenom, $strNoProgramme) = explode(";", remplaceEspaces($fp));
            if ($strMatricule == $strMatriculeRecherche) {
                $binTrouve = true;
                switch ($strNoProgramme) {
                    case "322.A0":
                        $strNomDeProgramme = "Techniques d'éducation à l'enfance";
                        break;
                    case "243.A0":
                        $strNomDeProgramme = "Électronique programmable et robotique";
                        break;
                    case "180.A0":
                        $strNomDeProgramme = "Soins infermiers";
                        break;
                    case "235.A0":
                        $strNomDeProgramme = "Technologie de la production pharmaceutique";
                        break;
                    case "410.B0":
                        $strNomDeProgramme = "Techniques de comptabilité et de gestion";
                        break;

                    default:
                        break;
                }
                ?>
                <tr>
                    <td class=""><?php echo ajouteZeros($intLigne, 2); ?> </td>
                    <td class="sGras sBleu"> <?php echo $strMatricule; ?></td>
                    <td class="sGras sBleu"><?php echo "$strPrenom $strNom"; ?></td>
                    <td class="sGras sBleu"><?php echo "$strNomDeProgramme ($strNoProgramme)"; ?></td>
                </tr>
                <?php
            }
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