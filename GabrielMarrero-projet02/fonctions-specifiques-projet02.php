<?php

/*
  |-------------------------------------------------------------------------------------|
  | DÉMARRAGE DE LA SESSION
  | Doit être exécutée si des variables de session ont été préalablement initialisée.
  |-------------------------------------------------------------------------------------|
 */
session_start();
//if(!isset($_SESSION["InfosEtudiant"]))
$_SESSION["InfosEtudiant"] = array();
/*
  |----------------------------------------------------------------------------------------|
  | fonctions specifiques projet 2
  |----------------------------------------------------------------------------------------|
 */
require_once("./classe-fichier-2020-04-20.php");
require_once("./classe-mysql-2020-04-27.php");
require_once("./librairie-generale-2020-04-28.php");

//require_once("./fonctions-specifiques-projet02.php");
/*
  |----------------------------------------------------------------------------------------|
  |7. Authentification de l’étudiant (10 points)
  Prototype : authentifieEtudiant($BDProjet02, $strNomTableEtudiants, $strDA)
  But : Confirmer que l’étudiant est bien autorisé à se connecter.
  Si c’est le cas, création de la variable de session InfosEtudiant, puis entreposage du DA, nom, prénom et nom complet de l’étudiant dans cette dernière. Référez-vous à la section Création de la variable de session InfosEtudiant
  à la page 10.
  Retour : true si l’étudiant est authentifié; false autrement.
  Contrainte : Vous devez utiliser les méthodes selectionneEnregistrements et contenuChamp.
  |----------------------------------------------------------------------------------------|
 */
function authentifieEtudiant($BDProjet2, $strNomTable_pjr2_Etudiants, $strIDEtudiantSaisie) {
    $nbEnregistrementsEtudiants = $BDProjet2->selectionneEnregistrements($strNomTable_pjr2_Etudiants);


    //echo "nb Enregistrements : ". $nbEnregistrementsEtudiants;
    $bintrouver = false;

    for ($i = 0; $i < $nbEnregistrementsEtudiants && !$bintrouver; $i++) {

        // echo "DA des etudiants: ".$BDProjet2->contenuChamp($i,"etudiant_DA")."</br>";

        if ($strIDEtudiantSaisie == $BDProjet2->contenuChamp($i, "etudiant_DA")) {

            //  echo "voici les infos du DA -> " . $BDProjet2->contenuChamp($i, "etudiant_DA") . "</br>";
            // echo "Nom : " . $BDProjet2->contenuChamp($i, "etudiant_Nom") . "</br>";
            // echo "Prenom : " . $BDProjet2->contenuChamp($i, "etudiant_Prenom");
            $nomEtudiant = $BDProjet2->contenuChamp($i, "etudiant_Nom");
            $prenomEtudiant = $BDProjet2->contenuChamp($i, "etudiant_Prenom");
            $nomCompletEtudiant = $prenomEtudiant . " " . $nomEtudiant;
            $noJeton = null;
            $strNomEquipe = null;
            

            // entreposage du DA, nom, prénom et nom complet de l’étudiant dans la variable de session
            array_push($_SESSION["InfosEtudiant"], $nomEtudiant, $prenomEtudiant, $nomCompletEtudiant,$noJeton,$strNomEquipe);
            $bintrouver = true;
        }
    }
    // echo "etudiant identifie: ".$bintrouver;
    return $bintrouver;
}

/*
  |----------------------------------------------------------------------------------------|
  | 1. Création de la table prj2_etudiants (2 points)
  Prototype : creeTableEtudiants($BDProjet02, $strNomTableEtudiants)
  But : Créer la structure de la table prj2_etudiants. Référez-vous à la section Description des tables nécessaires au projet 2 à la page 2.
  Contrainte : Vous devez utiliser la méthode creeTableGenerique.
  |----------------------------------------------------------------------------------------|
 */

function creeTableEtudiants($BDProjet2, $strNomTable_pjr2_Etudiants) {

    //echo $strNomTable_pjr2_Etudiants;
    $strDefinitions = "V7,etudiant_DA;V25,etudiant_Nom;V20,etudiant_Prenom;";
    $strCles = "etudiant_DA";
    $BDProjet2->creeTableGeneriqueDeux($strNomTable_pjr2_Etudiants, $strDefinitions, $strCles);
    /* if ($BDProjet2->OK) {
      echo "<li>Confirmation de la création de la table '$strNomTable_pjr2_Etudiants'<br />";
      } else {
      echo "<li>Création de la table '$strNomTable_pjr2_Etudiants' impossible.<br />";
      } */
}

/*
  |----------------------------------------------------------------------------------------|
  | 3. Création de la table prj2_roles (2 points)
  Prototype : creeTableRoles($BDProjet02, $strNomTableRoles)
  But : Créer la structure de la table prj2_roles. Référez-vous à la section Description des tables nécessaires au projet 2.
  Contrainte : Vous devez utiliser la méthode creeTableGenerique.
  |----------------------------------------------------------------------------------------|
 */

function creeTableRoles($BDProjet2, $strNomTable_pjr2_Roles) {

    //echo $strNomTable_pjr2_Etudiants;
    $strDefinitions = "N,role_No;V50,role_Description;";
    $strCles = "role_No";
    $BDProjet2->creeTableGeneriqueDeux($strNomTable_pjr2_Roles, $strDefinitions, $strCles);
    /* if ($BDProjet2->OK) {
      echo "<li>Confirmation de la création de la table '$strNomTable_pjr2_Etudiants'<br />";
      } else {
      echo "<li>Création de la table '$strNomTable_pjr2_Etudiants' impossible.<br />";
      } */
}

/* |----------------------------------------------------------------------------------------|
  | 5. Création de la table prj2_equipes (2 points)
  Prototype : creeTableEquipes($BDProjet02, $strNomTableEquipes)
  But : Créer la structure de la table prj2_equipes. Référez-vous à la section Description des tables nécessaires au projet 2.
  Contrainte : Vous devez utiliser la méthode creeTableGenerique.
  |----------------------------------------------------------------------------------------|
 */

function creeTableEquipes($BDProjet2, $strNomTable_pjr2_Equipes) {

    //echo $strNomTable_pjr2_Etudiants;
    $strDefinitions = "N,nom_equipe_No_jeton;V15,nom_equipe_URL;";
    $strCles = "nom_equipe_No_jeton";
    $BDProjet2->creeTableGeneriqueDeux($strNomTable_pjr2_Equipes, $strDefinitions, $strCles);
    /* if ($BDProjet2->OK) {
      echo "<li>Confirmation de la création de la table '$strNomTable_pjr2_Etudiants'<br />";
      } else {
      echo "<li>Création de la table '$strNomTable_pjr2_Etudiants' impossible.<br />";
      } */
}

/* |----------------------------------------------------------------------------------------|
  | 6. Création de la table prj2_membres (2 points)
  Prototype : creeTableMembres($BDProjet02, $strNomTableMembres)
  But : Créer la structure de la table prj2_Membres. Référez-vous à la section Description des tables nécessaires au projet 2.
  Contrainte : Vous devez utiliser la méthode creeTableGenerique
  |----------------------------------------------------------------------------------------|
 */

function creeTableMembres($BDProjet2, $strNomTable_pjr2_Membres) {

    //echo $strNomTable_pjr2_Etudiants;
    $strDefinitions = "N,membre_No_jeton;V7,membre_DA;N,membre_Role";
    $strCles = "membre_No_jeton,membre_DA";
    $BDProjet2->creeTableGeneriqueDeux($strNomTable_pjr2_Membres, $strDefinitions, $strCles);
    /* if ($BDProjet2->OK) {
      echo "<li>Confirmation de la création de la table '$strNomTable_pjr2_Etudiants'<br />";
      } else {
      echo "<li>Création de la table '$strNomTable_pjr2_Etudiants' impossible.<br />";
      } */
}

/*
  |----------------------------------------------------------------------------------------|
  | 2. Chargement de la table prj2_etudiants (2 points)
  Prototype : remplitTableEtudiants($BDProjet02,
  $strNomTableEtudiants,
  $strNomFichierEtudiants)
  But : Charger la table prj2_Etudiants. Référez-vous à la section Le fichier texte
  etudiants.csv à la page 3.
  Contrainte : Vous devez utiliser la méthode insereEnregistrement et les méthodes de la
  classe fichier.
  |----------------------------------------------------------------------------------------|
 */

function remplitTableEtudiants($BDProjet2, $strNomTable_pjr2_Etudiants, $strNomFichierEtudiants) {
    //$strNomTable_pjr2_Etudiants = "prj2_etudiants";
    // echo $strNomFichierEtudiants;
    // echo "allo";
    $fpEtudiants = new fichier($strNomFichierEtudiants, "L");
    //  $tEtudiants = array();
    while (!$fpEtudiants->detecteFin()) {
        $fpEtudiants->litDonneesLigne($tEtudiants, ";", "DA", "Nom", "Prenom");
        $intDA = intval($tEtudiants["DA"]);
        $strNom = $tEtudiants["Nom"];
        $strPrenom = $tEtudiants["Prenom"];

        //echo $intDA . " " . $strNom . " " . $strPrenom . "</br>";

        $BDProjet2->insereEnregistrement($strNomTable_pjr2_Etudiants, $intDA, $strNom, $strPrenom);
    }
}

/*
  |----------------------------------------------------------------------------------------|
  | 4. Chargement de la table prj2_roles (2 points)
  Prototype : remplitTableRoles($BDProjet02,
  $strNomTableRoles,
  $strNomFichierRoles)
  But : Charger la table prj2_roles. Référez-vous à la section Le fichier texte roles.csv
  à la page 3.
  Contrainte : Vous devez utiliser la méthode insereEnregistrement et les méthodes de la
  classe fichier.
  |----------------------------------------------------------------------------------------|
 */

function remplitTableRoles($BDProjet2, $strNomTable_pjr2_Roles, $strNomFichierRoles) {
    //$strNomTable_pjr2_Etudiants = "prj2_etudiants";
    // echo $strNomFichierEtudiants;
    // echo "allo";
    $fpRoles = new fichier($strNomFichierRoles, "L");
    //  $tEtudiants = array();
    while (!$fpRoles->detecteFin()) {
        $fpRoles->litDonneesLigne($tRoles, ";", "No", "Description");
        $intNoRole = intval($tRoles["No"]);
        $strDescriptionRole = $tRoles["Description"];


        // echo $intDA . " " . $strNom . " " . $strPrenom . "</br>";

        $BDProjet2->insereEnregistrement($strNomTable_pjr2_Roles, $intNoRole, $strDescriptionRole);
    }
}

?>