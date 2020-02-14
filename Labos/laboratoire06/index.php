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
$strNoProgrammeRecherche = isset($_POST["ddlNoProgrammeRecherche"]) ? $_POST["ddlNoProgrammeRecherche"] : "Tous";
?>
<div id="divSaisieProgramme">
    <p class="sTitreSection">
        Saisie du programme de l'élève
    </p>
    Sélectionnez le nom du programme</br>
    <select id="ddlNoProgrammeRecherche" name="ddlNoProgrammeRecherche" onchange="document.getElementById('frmSaisie').submit();" >
        <option value="Tous"> Tous les programmes</option>
        <option value="180.A0">Soins infermiers</option>
        <option value="235.C0">Technologie de la production pharmaceutique</option>
        <option value="243.A0">Électronique programmable et robotique</option>
        <option value="322.A0">Techniques d'éducation à l'enfance</option>
        <option value="410.B0">Techniques de comptabilité et de gestion</option>
        <option value="420.AA">Techniques de l'informatique</option>
    </select>
    <!--<input id="btnSoumettre" name="btnSoumettre" type="submit" value="Soumettre"/>-->
</div>
<div id="divContenuFormate">
    <p class="sTitreSection">
        Liste des étudiants
        <?php
        if ($strNoProgrammeRecherche == "Tous") {
         ?>
            de tous les programmes
        <?php
        } else {
         ?>
            de "<span id="lblNomProgramme"></span>"( <?php echo $strNoProgrammeRecherche; ?>)
        <?php
        }
        ?>
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
      <?php 
      //Affichage de la derniere colonne lorsque necessaire seulement 
        if($strNoProgrammeRecherche=="Tous"){
        ?>
            <td class="sEntete">Programme</td>
            <?php 
        }
            ?>
        </tr>
        <?php
        //parcour du fichier
        while (!feof($fp)) {
         //   $intLigne++;

            list($strMatricule, $strNom, $strPrenom, $strNoProgramme) = explode(";", remplaceEspaces($fp));
            if ( $strNoProgrammeRecherche == "Tous") {
               
                //  $strNomDeProgramme;
                // echo "strnoMatriRecherche : ". $strNoProgrammeRecherche;
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
                    case "235.C0":
                        $strNomDeProgramme = "Technologie de la production pharmaceutique";
                        break;
                    case "410.B0":
                        $strNomDeProgramme = "Techniques de comptabilité et de gestion";
                        break;
                    case "420.AA":
                        $strNomDeProgramme = "Techniques de l'informatique";
                        break;

                    default:
                        break;
                }
            }
                //Affichage des donnes de l eleve lorsque necesaire seuelement
                if($strNoProgramme == $strNoProgrammeRecherche || $strNoProgrammeRecherche=="Tous"){
                     $intLigne++;
                ?>
                <tr>
                    <td class=""><?php echo ajouteZeros($intLigne, 2); ?> </td>
                    <td class="sGras sBleu"> <?php echo $strMatricule; ?></td>
                    <td class="sGras sBleu"><?php echo "$strPrenom $strNom"; ?></td>
                <?php 
                if($strNoProgrammeRecherche == "Tous"){
                ?>
                    <td class="sGras sBleu"><?php echo "$strNomDeProgramme ($strNoProgramme)"; ?></td>
                <?php 
                }
                ?>
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
<script type="text/javascript">
    
    document.getElementById('ddlNoProgrammeRecherche').value = '<?php echo $strNoProgrammeRecherche; ?>';
    function objb(strID){
        return document.getElementById(strID);
    }
    function select(strID,valueOuText){
        return valueOuText== undefined ? /*"null fait l'affaire egalement"*/
                objb(strID).options[objb(strID).selectedIndex].text:objb(strID).options[objb(strID).selectedIndex].value;
    }
   if(document.getElementById('lblNomProgramme'))
       document.getElementById('lblNomProgramme').innerHTML = select('ddlNoProgrammeRecherche');
</script>