<?php

/*
  |----------------------------------------------------------------------------------------|
  | class mysql
  |----------------------------------------------------------------------------------------|
 */

class mysql {
    /*
      |----------------------------------------------------------------------------------|
      | Attributs
      |----------------------------------------------------------------------------------|
     */

    public $cBD = null;                       /* Identifiant de connexion */
    public $listeEnregistrements = null;      /* Liste des enregistrements retournés */
    public $nomFichierInfosSensibles = "";    /* Nom du fichier 'InfosSensibles' */
    public $nomBD = "";                       /* Nom de la base de données */
    public $OK = false;                       /* Opération réussie ou non */
    public $requete = "";                     /* Requête exécutée */
    public $nbEnregistrements = null;

    /*
      |----------------------------------------------------------------------------------|
      | __construct
      |----------------------------------------------------------------------------------|
     */

    function __construct($strNomFichierInfosSensibles) {

        $this->nomFichierInfosSensibles = $strNomFichierInfosSensibles;
        $this->connexion();
        $this->selectionneBD();
    }

    /*
      |----------------------------------------------------------------------------------|
      | connexion()
      |----------------------------------------------------------------------------------|
     */

    function connexion() {
        require($this->nomFichierInfosSensibles);
        $this->nomBD = $strNomBD;
        $this->cBD = mysqli_connect("localhost", $strNomAdmin, $strMotPasseAdmin);
        if (mysqli_connect_errno()) {
            echo "<br />";
            echo "Problème de connexion... " . "Erreur no " . mysqli_connect_errno() . " (" . mysqli_connect_error() . ")";
            die();
        }
        return $this->cBD;
    }

    /*
      |-------------------------------------------------------------------------------------|
      | mysqli_result
      | Réf.: http://php.net/manual/fr/class.mysqli-result.php User Contributed Notes (Marc17)
      |
      | Exemple d'appel : echo mysqli_result($ListeEnregistrements, 0, "TotalVentes");
      |                   Affiche le champ "TotalVentes" du 1er enregistrement de la liste
      |                   d'enregistrements.
      |-------------------------------------------------------------------------------------|
     */

    function mysqli_result($result, $row, $field = 0) {
        if ($result === false)
            return false;
        if ($row >= mysqli_num_rows($result))
            return false;
        if (is_string($field) && !(strpos($field, ".") === false)) {
            $t_field = explode(".", $field);
            $field = -1;
            $t_fields = mysqli_fetch_fields($result);
            for ($id = 0; $id < mysqli_num_fields($result); $id++) {
                if ($t_fields[$id]->table == $t_field[0] && $t_fields[$id]->name == $t_field[1]) {
                    $field = $id;
                    break;
                }
            }
            if ($field == -1)
                return false;
        }
        mysqli_data_seek($result, $row);
        $line = mysqli_fetch_array($result);
        return isset($line[$field]) ? $line[$field] : false;
    }

    /*
      |-------------------------------------------------------------------------------------|
      | Prototype
      function retourneDernierNo($strNomTable, $strNomChamp)
      Retour
      • Valeur du champ $strNomChamp du dernier enregistrement de la table $strNomTable.
      Si la table est vide, c’est la valeur 0 qui est retournée.

      Remarque
      Il est impératif que vous créiez une nouvelle connexion MySQL pour résoudre ce problème.
      Exemple d’appel
      $strNomTablePourQ4 = "Q4_table_supplementaire";
      $intDernierNumero = $BDQuiz4->retourneDernierNo($strNomTablePourQ4, "Q4_No");
      
      SELECT Q4_No FROM Q4_table_supplementaire ORDER BY Q4_No DESC LIMIT 1
      |-------------------------------------------------------------------------------------|
     */

    function retourneDernierNo($strNomTable, $strNomChamp) {
        /* Nouvelle connexion MySQL */
        $BDTemp = new mysql($this->nomFichierInfosSensibles);
        $BDTemp->selectionneBD();


       // echo "info sensibles -- >" . $this->nomFichierInfosSensibles . "</br>";

        $this->requete = "SELECT $strNomChamp FROM $strNomTable ORDER BY $strNomChamp DESC LIMIT 1";

        $this->listeEnregistrements = mysqli_query($this->cBD, $this->requete);

        mysqli_data_seek($this->listeEnregistrements, 0);
        $line = mysqli_fetch_array($this->listeEnregistrements);
        return isset($line[$strNomChamp]) ? $line[$strNomChamp] : false;

        mysqli_close($BDTemp);
    }

    /*
      |-------------------------------------------------------------------------------------|
      |Prototype
      function metAJourEnregistrements($strNomTable,
      $strListeChangements,
      $strListeConditions="")
      où $strNomTable = Table contenant les enregistrements à modifier
      $strListeChangements = Liste des modifications à apporter
      $strListeConditions = Liste des conditions à respecter
      Action à effectuer
      • Initialise l’attribut requete.
      • Initialise l’attribut OK.
      • Exécute la commande UPDATE à partir des spécifications fournies.
      Retour
      • true si la mise à jour de la table s’est effectuée correctement; autrement false.
      Exemple d’appel 1
      $strNomTableEvaluations = "Q3_evaluations";
      $binOK = $BDQuiz4->metAJourEnregistrements($strNomTableEvaluations,
      "Evaluations_Sur=20",
      "Evaluations_Code='LAB'");
      
      UPDATE Q3_evaluations SET Evaluations_Sur=20 WHERE Evaluations_Code='LAB'
      Exemple d’appel 2
      $strNomTableNotes = "Q3_notes";
      $binOK = $BDQuiz4->metAJourEnregistrements($strNomTableNotes,
      "Notes_Valeur=Notes_Valeur*2",
      "Notes_Code='LAB'");
      
      UPDATE Q3_notes SET Notes_Valeur=Notes_Valeur*2 WHERE Notes_Code='LAB'
      |-------------------------------------------------------------------------------------|
     */

    function metAJourEnregistrements($strNomTable, $strListeChangements, $strListeConditions = "") {

        $this->requete = "UPDATE $strNomTable SET $strListeChangements WHERE $strListeConditions";


        $this->OK = mysqli_query($this->cBD, $this->requete);

        return $this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      | Pour commencer
      Copiez le code source de la fonction mysqli_result() du fichier mysqli-result.php dans
      votre fichier classe-mysql-2020-mm-jj.php.
      Prototype
      function contenuChamp($intNo, $strNomChamp)
      où $intNo = Numéro de l’enregistrement dans la table (0 à N-1 enregistrements)
      $strNomChamp = Nom du champ dans la table
      Action à effectuer
      • Retourne la valeur du champ $strNomChamp de l’enregistrement numéro $intNo de la
      listeEnregistrements. La fonction mysqli_result() doit être mise à contribution
      dans la rédaction de cette méthode.
      Retour
      Valeur du champ correspondant.
      Exemples d’appel
      for ($i = 0; $i < $BDQuiz3->nbEnregistrements; $i++) {
      echo "<li>";
      echo $BDQuiz3->contenuChamp($i, "Etudiants_DA") . ", ";
      echo $BDQuiz3->contenuChamp($i, "Etudiants_Nom") . ", ";
      echo $BDQuiz3->contenuChamp($i, "Etudiants_Prenom");
      echo "</li>";
      }
      
      1376542, Beaucage, Raphael
      92334, Blais, Dominic
      272894, Blais, Hugo
      9957228, Cote, Alexandre
      676699, Gagnon, Lise
      666779, Michaud, Guillaume
      9575762, O'Reilly, Derch'en
      9823725, Pilon, Denis
      46411, Sauve, Benoit
      711153, Seguin, Nicole
      |----------------------------------------------------------------------------------|
     */

    function contenuChamp($intNo, $strNomChamp) {
        //$test = mysqli_result($this->listeEnregistrements, $intNo, $strNomChamp);// utiliser sqliresult avec 3 arument

        mysqli_data_seek($this->listeEnregistrements, $intNo);
        $line = mysqli_fetch_array($this->listeEnregistrements);
        return isset($line[$strNomChamp]) ? $line[$strNomChamp] : false;
        //   return $test;
    }

    /*
      |----------------------------------------------------------------------------------|
      | Vérifie si la table $strNomTable existe.
      | $binOK = $BDQuiz3->tableExiste($strNomTableNotes);
      |
      |SHOW TABLES LIKE 'Q3_notes'
      |
      |----------------------------------------------------------------------------------|
     */

    function tableExiste($strNomTableNotes) {

        /* $requete = mysqli_query($this->cBD, "SELECT * FROM $strNomTableNotes");

          if (!$requete)
          $this->OK = false;
          else
          $this->OK = true; */


        // echo "------ >" .  $this->requete;
        return mysqli_query($this->cBD, "SELECT * FROM $strNomTableNotes"); //$this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      |Prototype
      function selectionneEnregistrements($strNomTable)
      Actions à effectuer
      • Par défaut, sélectionne tous les enregistrements de la table $strNomTable. En fonction
      des paramètres spécifiés, il est possible de sélectionner certains enregistrements (C=),
      de les regrouper (D=) et/ou de les trier (T=).
      • Initialise l’attribut requete.
      • Initialise l’attribut listeEnregistrements.
      • Initialise l’attribut nbEnregistrements. (attribut à ajouter à la classe mysql)
      Retour
      • Nombre d’enregistrements remplissant la ou les conditions (0 à N) ou -1 si l’attribut
      liste-Enregistrements est null (Ex. : table n’existe pas).
      Utilisation de paramètres variables
      • Un à trois paramètres peuvent être ajoutés.
      "C=expression"  "WHERE expression"
      "D=expression"  "GROUP BY expression"
      "T=expression"  "ORDER BY expression"
      Exemples d’appel
      $BDQuiz3->selectionneEnregistrements($strNomTableEtudiants,
      "T=Etudiants_Nom ASC, Etudiants_Prenom ASC");
      
      SELECT * FROM Q3_etudiants ORDER BY Etudiants_Nom ASC, Etudiants_Prenom ASC
     * $BDQuiz3->selectionneEnregistrements($strNomTableEvaluations,
      "T=Evaluations_Ponderation DESC");
      
      SELECT * FROM Q3_evaluations ORDER BY Evaluations_Ponderation DESC
      $BDQuiz3->selectionneEnregistrements($strNomTableNotes,
      "T=Notes_DA ASC, Notes_Code ASC");
      
      SELECT * FROM Q3_notes ORDER BY Notes_DA ASC, Notes_Code ASC
      $BDQuiz3->selectionneEnregistrements($strNomTableNotes,
      "T=Notes_DA ASC",
      "C=Notes_DA >= 6700000");
      
      SELECT * FROM Q3_notes WHERE Notes_DA >= 6700000 ORDER BY Notes_DA ASC

      |
      |----------------------------------------------------------------------------------|
     */

    function selectionneEnregistrements($strNomTable) {

        $strWhere = "";
        $strGroupBy = "";
        $strOrderBy = "";
        for ($i = 1; $i < func_num_args(); $i ++) {
            $strEnreistrements = func_get_arg($i);
            $lettre = substr($strEnreistrements, 0, 1);

            switch ($lettre) {
                case "T":

                    $strOrderBy = "ORDER BY " . substr($strEnreistrements, 2);
                    //$this->requete = "SELECT * FROM $strNomTable ORDER BY " . substr($premierEnregistrement, 2);

                    break;
                case "C":
                    $strWhere = "WHERE " . substr($strEnreistrements, 2);
                    //$this->requete = "SELECT * FROM $strNomTable WHERE " . substr($premierEnregistrement, 2);
                    break;
                case "D":
                    $strGroupBy = "GROUP BY " . substr($strEnreistrements, 2);
                    //$this->requete = "SELECT * FROM $strNomTable GROUP BY " . substr($premierEnregistrement, 2);
                    break;
            }



            // echo "valeude du where -> $strWhere ";
        }
        $this->requete = "SELECT * FROM $strNomTable  $strWhere  $strGroupBy  $strOrderBy";

        $this->listeEnregistrements = mysqli_query($this->cBD, $this->requete);
        $this->nbEnregistrements = mysqli_num_rows($this->listeEnregistrements);


        return ($this->listeEnregistrements == null) ? $this->nbEnregistrements = -1 : $this->nbEnregistrements;
    }

    /*
      |----------------------------------------------------------------------------------|
      |Prototype
      function selectionneEnregistrementsManuellement($strRequete)
      Actions à effectuer
      Exécute la requête $strRequete passée en paramètre et initialise les attributs requete,
      listeEnregistrements et nbEnregistrements de l’objet mysql correspondant..
      Retour
      • Nombre d’enregistrements remplissant la ou les conditions (0 à N) ou -1 si l’attribut
      listeEnregistrements est null (Ex. : table n’existe pas).
      Exemple d’appel 1
      $strRequete = "SELECT * FROM Q3_etudiants";
      $BDQuiz4->selectionneEnregistrementsManuellement($strRequete);
      
      "SELECT * FROM Q3_etudiants"
      Notez que dans ce premier scénario, vous êtes encouragé à exécuter la méthode selectionneEnregistrements comme indiqué ci-dessous. Cependant, ce ne sera pas possible pour le scénario 2.
      $BDQuiz4->selectionneEnregistrements("Q3_Etudiants");
      Exemple d’appel 2
      $strRequete = "SELECT Etudiants_DA, Etudiants_Nom, Etudiants_Prenom,
      Evaluations_Description, Notes_Valeur, Evaluations_Sur,
      Evaluations_Ponderation, Notes_Valeur/Evaluations_Sur*Evaluations_Ponderation AS
      SousTotal FROM Q3_evaluations INNER JOIN (Q3_etudiants INNER JOIN Q3_notes
      ON Etudiants_DA = Notes_DA) ON Evaluations_Code = Notes_Code GROUP BY
      Etudiants_DA, Etudiants_Nom, Etudiants_Prenom, Evaluations_Description,
      Notes_Valeur, Evaluations_Sur, Evaluations_Ponderation ORDER BY Etudiants_Nom,
      Etudiants_Prenom, Evaluations_Description;";
      $BDQuiz4->selectionneEnregistrementsManuellement($strRequete);
      |
      |----------------------------------------------------------------------------------|
     */

    function selectionneEnregistrementsManuellement($strRequete) {


        $this->requete = $strRequete;

        $this->listeEnregistrements = mysqli_query($this->cBD, $this->requete);
        $this->nbEnregistrements = mysqli_num_rows($this->listeEnregistrements);


        return ($this->listeEnregistrements == null) ? $this->nbEnregistrements = -1 : $this->nbEnregistrements;
    }

    /*
      |----------------------------------------------------------------------------------|
      |function etablitRelation($strNomTablePrimaire, $strClePrimaire,
      $strNomTableEtrangere, $strCleEtrangere,
      $strNomRelation="")
     * Retour
      • true si la contrainte a été appliquée correctement; autrement false.
      Exemple d’appel
      $BDQuiz3->etablitRelation($strNomTableEtudiants, "Etudiants_DA",
      $strNomTableNotes, "Notes_DA",
      $strNomRelationNotesEtudiants);
      
      ALTER TABLE Q3_notes ADD CONSTRAINT notes_etudiants
      FOREIGN KEY (Notes_DA)
      REFERENCES Q3_etudiants(Etudiants_DA);

      |
      |----------------------------------------------------------------------------------|
     */

    function etablitRelation($strNomTablePrimaire, $strClePrimaire, $strNomTableEtrangere, $strCleEtrangere, $strNomRelation = "") {

        /* echo "strNomTablePrimaire --> " .$strNomTablePrimaire."</br>";
          echo "strClePrimaire --> " .$strClePrimaire."</br>";;
          echo "strNomTableEtrangere --> " .$strNomTableEtrangere ."</br>";;
          echo "strCleEtrangere --> " .$strCleEtrangere."</br>"; */


        $this->requete = "ALTER TABLE $strNomTableEtrangere ADD CONSTRAINT ";

        $this->requete .= $strNomRelation . " FOREIGN KEY (" . $strCleEtrangere . ") REFERENCES " . $strNomTablePrimaire . "(" . $strClePrimaire . ");";

        $this->OK = mysqli_query($this->cBD, $this->requete);

        //echo "valeur de OK ---> " . $this->OK;
        return $this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      |Prototype
      function supprimeRelation($strNomTableEtrangere, $strNomRelation)
      Actions à effectuer
      • Supprime une relation entre deux tables.
      Retour
      • true si la suppression de la contrainte s’est effectuée correctement; autrement false.
      Exemple d’appel
      $BDQuiz3->supprimeRelation($strNomTableNotes, $strNomRelationNotesEtudiants);
      
      ALTER TABLE Q3_notes DROP FOREIGN KEY notes_etudiants;
      |
      |----------------------------------------------------------------------------------|
     */

    function supprimeRelation($strNomTableNotes, $strNomRelationNotesEtudiants) {

        /* echo "strNomTablePrimaire --> " .$strNomTablePrimaire."</br>";
          echo "strClePrimaire --> " .$strClePrimaire."</br>";;
          echo "strNomTableEtrangere --> " .$strNomTableEtrangere ."</br>";;
          echo "strCleEtrangere --> " .$strCleEtrangere."</br>"; */


        $this->requete = "ALTER TABLE $strNomTableNotes DROP ";

        $this->requete .= "FOREIGN KEY " . $strNomRelationNotesEtudiants . ";";

        $this->OK = mysqli_query($this->cBD, $this->requete);

        // echo "valeur de OK ---> " . $this->OK;
        return $this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      | copieEnregistrements
      |----------------------------------------------------------------------------------|
     */

    function copieEnregistrements($strNomTableSource, $strListeChampsSource, $strNomTableCible, $strListeChampsCible, $strListeConditions = "") {
        /* Réf.: www.lecoindunet.com/dupliquer-ou-copier-des-lignes-d-une-table-vers-une-autre-avec-mysql-175 */

        /* echo "strNomTableSource - > " . $strNomTableSource . "</br>";
          echo "strListeChampsSource - > " . $strListeChampsSource . "</br>";


          echo "strNomTableCible - > " . $strNomTableCible . "</br>";
          echo "strListeChampsCible - > " . $strListeChampsCible . "</br>";


          echo "strListeConditions - > " . $strListeConditions; */

        $this->requete = "INSERT INTO $strNomTableCible (";

        //Si $strListeChampsCible est vide (valeur assignée par défaut), alors…
        //$strListeChampsCible = $strListeChampsSource.
        if (empty($strListeChampsCible)) {
            $strListeChampsCible = $strListeChampsSource;
        }
        //Si $strListeConditions est vide, alors tous les enregistrements sont copiés.
        if ($strListeConditions == "") {

            $this->requete .= $strListeChampsCible . ") ";
            $this->requete .= "SELECT " . $strListeChampsSource . " FROM " . $strNomTableSource;
        } else {
            $this->requete .= $strListeChampsCible . ") ";
            $this->requete .= "SELECT " . $strListeChampsSource . " FROM " . $strNomTableSource . " WHERE " . $strListeConditions;
        }



        $this->OK = mysqli_query($this->cBD, $this->requete);
        return $this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      | creeTable
      |----------------------------------------------------------------------------------|
     */

    function creeTable($strNomTable) {
        $this->requete = "CREATE TABLE $strNomTable (";
        /* À chaque champ, son type */
        for ($i = 1; $i < func_num_args() - 1; $i += 2) {
            $strNomChamp = func_get_arg($i);
            $this->requete .= $strNomChamp . " " . func_get_arg($i + 1) . ", ";
        }
        /* Ajout de la clé primaire */
        $this->requete .= func_get_arg($i) . ")";
        $this->requete .= " ENGINE=InnoDB"; /* https://fr.wikipedia.org/wiki/InnoDB */
        /* Exécution de la requête */
        $this->OK = mysqli_query($this->cBD, $this->requete);
        return $this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      | creeTableGenerique()
      |----------------------------------------------------------------------------------|
     */
    function creeTableGenerique($strNomTable, $strDefinitions, $strCles) {
       
          $this->requete = "CREATE TABLE $strNomTable (";
          $tDef =  explode(";",$strDefinitions);
          /* À chaque champ, son type */ 
          for ($i=0; $i<count($tDef); $i++) { 
              $strType = explode(",",$tDef[$i]); 
              $tLettre  = str_split($strType[0]);
              $reste = ""; 
              $TypeFinal ="";
              for ($j=1; $j<count($tLettre) ; $j++) {
                  $reste .= $tLettre[$j];  
              }
              
              switch ($tLettre[0]) {
                case "B":
                    $TypeFinal = "BOOL";
                    break;
                case "C":
                    $TypeFinal = "DECIMAL(".str_ireplace(".",",",$reste).")";
                    break;
                case "D":
                    $TypeFinal = "DATE";
                    break;
                case "E":
                    $TypeFinal = "INT";
                    break;
                case "F":
                    $TypeFinal = "CHAR(".str_ireplace(".",",",$reste).")";
                    break;
                case "M":
                    $TypeFinal = "DECIMAL(10,2)";
                    break;
                case "N":
                    $TypeFinal = "INT NOT NULL";
                    break;
                case "T":
                    $TypeFinal = "DATETIME";
                    break;
                case "V":
                    $TypeFinal = "VARCHAR(".str_ireplace(".",",",$reste).")";
                    break;
            }
              $tTempo =  explode(",",$tDef[$i]);
              $this->requete .= $tTempo[1]." ".$TypeFinal.", ";     
          }
          /* Ajout de la clé primaire */ 
          $this->requete .= "PRIMARY KEY(".$strCles."))"; 
          $this->requete .= " ENGINE=InnoDB"; /* https://fr.wikipedia.org/wiki/InnoDB */ 
          //var_dump($this->requete);
          /* Exécution de la requête */ 
          $this->OK = mysqli_query($this->cBD, $this->requete); 
          return $this->OK;
      }

    function creeTableGeneriqueDeux($strNomTable, $strDefinitions, $strCles) {


        /* 1- Scan la chaine (explode apour le ";") pour creer un tableau 
          2- prendre chcune des ligne pour explode encore aavec la ,"
          3- parcour ce tableau creer et fair eun switch pour chaque type

         */
        $this->requete = "CREATE TABLE $strNomTable (";


        $tabDefinitions = array();
        $tabTypes = array();
        $strChampSeuil = "";
        $tabDecimal = array();

        // $test = "";

        $tabDefinitions = explode(";", $strDefinitions);

        // var_dump($tabDefinitions);
        // $strTableGenerique = "";

        for ($i = 0; $i < count($tabDefinitions); $i ++) {
            //echo $tabDefinitions[$i];
            $tabTypes = explode(",", $tabDefinitions[$i]);
            switch (substr($tabTypes[0], 0, 1)) {
                case "N";

                   // if ($tabTypes[1] == "NoEmploye")
                    //    $this->requete .= $tabTypes[1] . " INT NOT NULL, ";     //echo count($tabTypes[1]);
                   // else
                        $this->requete .= $tabTypes[1] . " INT NOT NULL, "; //echo count($tabTypes[1]);

                    break;
                case "B";
                    $this->requete .= $tabTypes[1] . " BOOL, ";
                    break;
                case "C";
                    $tabDecimal = explode(".", substr($tabTypes[0], 1));
                    $this->requete .= $tabTypes[1] . " DECIMAL(" . $tabDecimal[0] . "," . $tabDecimal[1] . "), ";
                    break;
                case "D";
                    $this->requete .= $tabTypes[1] . " DATE, ";
                    break;
                case "E";

                    $this->requete .= $tabTypes[1] . " INT, ";
                    break;
                case "F";
                    //  echo substr($tabTypes[0], 1);\
                    $this->requete .= $tabTypes[1] . " CHAR(" . substr($tabTypes[0], 1) . "), ";
                    break;
                case "M";
                    //DECIMAL(10,2),
                    $this->requete .= $tabTypes[1] . " DECIMAL(10,2), ";

                    break;
               
                case "V";
                    // echo substr($tabTypes[0], 1);
                    $this->requete .= $tabTypes[1] . " VARCHAR(" . substr($tabTypes[0], 1) . "), ";
                    break;
            }
        }

        /* Ajout de la clé primaire */
        $this->requete .= "PRIMARY KEY(" . $strCles . "))";
        $this->requete .= " ENGINE=InnoDB"; /* https://fr.wikipedia.org/wiki/InnoDB */
        
        //echo $this->requete;

        $this->OK = mysqli_query($this->cBD, $this->requete);
        return $this->OK;
    }
       /*
   |-------------------------------------------------------------------------------------|
   | afficheRequete
   |-------------------------------------------------------------------------------------|
   */
   function afficheRequete($cBD) {
      $strBR = "<br /><br />";
      if (func_num_args() == 2)
         $strBR = func_get_arg(1) ? "<br /><br />" : "";
      echo "<span class=\"sGras\">$cBD->requete</span>$strBR";
   }

    /*
      |----------------------------------------------------------------------------------|
      | deconnexion
      |----------------------------------------------------------------------------------|
     */

    function deconnexion() {
        mysqli_close($this->cBD);
    }

    /*
      |----------------------------------------------------------------------------------|
      | insereEnregistrement
      |----------------------------------------------------------------------------------|
     */

    function insereEnregistrement($strNomTable) {
        $this->requete = "INSERT INTO $strNomTable VALUES (";

        for ($i = 1; $i < func_num_args() - 1; $i++) {
            $strNomChamp = func_get_arg($i);

            if (gettype($strNomChamp) == "string") {
                $this->requete .= (strpos(func_get_arg($i), "'")) ? "'" . str_replace("'", "\'", func_get_arg($i)) . "'," : "'" . func_get_arg($i) . "',";
            } if (gettype($strNomChamp) == "double") {
                $this->requete .= floatval(func_get_arg($i)) . ",";
                // echo "les double --> ".floatval(func_get_arg($i));
            } if (gettype($strNomChamp) == "integer") {
                $this->requete .= (is_string(func_get_arg($i))) ? "'" . func_get_arg($i) . "'," : func_get_arg($i) . ",";
                //$this->requete .= func_get_arg($i) . ",";
            } if (gettype($strNomChamp) == "") {
                $this->requete .= (func_get_arg($i) == "") ? "NULL," : func_get_arg($i) . ",";
            } if (gettype($strNomChamp) == "boolean") {
                $this->requete .= func_get_arg($i) . ",";
            }
        }
        if (gettype($strNomChamp) == "string") {
            $this->requete .= (strpos(func_get_arg($i), "'")) ? "'" . str_replace("'", "\'", func_get_arg($i)) . "')" : "'" . func_get_arg($i) . "')";
        } if (gettype($strNomChamp) == "double") {
            $this->requete .= floatval(func_get_arg($i)) . ")";
            // echo "les double --> ".floatval(func_get_arg($i));
        } if (gettype($strNomChamp) == "integer") {
            $this->requete .= (is_string(func_get_arg($i))) ? "'" . func_get_arg($i) . "')" : func_get_arg($i) . ")";
            //$this->requete .= func_get_arg($i) . ",";
        } if (gettype($strNomChamp) == "") {
            $this->requete .= (func_get_arg($i) == "") ? "NULL," : func_get_arg($i) . ")";
        } if (gettype($strNomChamp) == "boolean") {
            $this->requete .= func_get_arg($i) . ")";
        }
        //$this->requete .= (strpos(func_get_arg($i),"'"))?"'" . str_replace("'", "\'", func_get_arg($i)) . "')":"'" . func_get_arg($i) . "')";
        // $this->requete .= "'" . str_replace("'", "\'", func_get_arg($i)) . "')";

        $this->OK = mysqli_query($this->cBD, $this->requete);
        return $this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      | modifieChamp
      |----------------------------------------------------------------------------------|
     */

    function modifieChamp($strNomTable, $strNomChamp, $strNouvelleDefinition) {
        $this->requete = "ALTER TABLE $strNomTable ";

        $this->requete .= "CHANGE " . $strNomChamp . " " . $strNouvelleDefinition;

        $this->OK = mysqli_query($this->cBD, $this->requete);
        return $this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      | selectionneBD()
      |----------------------------------------------------------------------------------|
     */

    function selectionneBD() {

        //this->requete = "SELECT FROM $this->nomBD";

        $this->OK = mysqli_select_db($this->cBD, $this->nomBD);

        return $this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      | supprimeEnregistrements
      |----------------------------------------------------------------------------------|
     */

    function supprimeEnregistrements($strNomTable, $strListeConditions = "") {

        if ($strListeConditions == "") {
            $this->requete = "DELETE FROM $strNomTable";
        } else {
            $this->requete = "DELETE FROM $strNomTable" . " WHERE " . $strListeConditions;
        }

        $this->OK = mysqli_query($this->cBD, $this->requete);
        return $this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      | supprimeTable()
      |----------------------------------------------------------------------------------|
     */

    function supprimeTable($strNomTable) {
        $this->requete = "DROP TABLE $strNomTable";
        $this->OK = mysqli_query($this->cBD, $this->requete);

        return $this->OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      | afficheInformationsSurBD()
      | Affiche la structure et le contenu de chaque table de la base de données recherchée
      |----------------------------------------------------------------------------------|
     */

    function afficheInformationsSurBD() {

        /* Si applicable, récupération du nom de la table recherchée */
        $strNomTableRecherchee = "";

        if (func_num_args() == 1) {
            $strNomTableRecherchee = func_get_arg(0);
        }

        /* Variables de base pour les styles */
        $strTable = "border-collapse:collapse;";
        $strCommande = "font-family:verdana; font-size:12pt; font-weight:bold; color:black; border:solid 1px black; padding:3px;";
        $strMessage = "font-family:verdana; font-size:10pt; font-weight:bold; color:red;";
        $strBorduresMessage = "border:solid 1px red; padding:3px;";
        $strContenu = "font-family:verdana; font-size:10pt; color:blue;";
        $strBorduresContenu = "border:solid 1px red; padding:3px;";
        $strTypeADefinir = "color:red;font-weight:bold;";
        $strDetails = "color:magenta;";

        /* Application des styles */
        $sTable = "style=\"$strTable\"";
        $sCommande = "style=\"$strCommande\"";
        $sMessage = "style=\"$strMessage\"";
        $sMessageAvecBordures = "style=\"$strMessage $strBorduresMessage\"";
        $sContenu = "style=\"$strContenu\"";
        $sContenuAvecBordures = "style=\"$strContenu $strBorduresContenu\"";
        $sTypeADefinir = "style=\"$strTypeADefinir\"";
        $sDetails = "style=\"$strDetails\"";

        /* --- Entreposage des noms de table --- */
        $ListeTablesBD = array_column(mysqli_fetch_all(mysqli_query($this->cBD, 'SHOW TABLES')), 0);
        $intNbTables = count($ListeTablesBD);

        /* --- Parcours de chacune des tables --- */
        echo "<span $sCommande>Informations sur " . (!empty($strNomTableRecherchee) ? "la table '$strNomTableRecherchee' de " : "") . "la base de données '$this->nomBD'</span><br />";
        $binTablePresente = false;
        for ($i = 0; $i < $intNbTables; $i++) {
            /* Récupération du nom de la table courante */
            $strNomTable = $ListeTablesBD[$i];
            if (empty($strNomTableRecherchee) || strtolower($strNomTable) == strtolower($strNomTableRecherchee)) {
                $binTablePresente = true;
                echo "<p $sMessage>Table no " . strval($i + 1) . " : " . $strNomTable . "</p>";

                /* Récupération des enregistrements de la table courante */
                $ListeEnregistrements = mysqli_query($this->cBD, "SELECT * FROM $strNomTable");

                /* Décompte du nombre de champs et d'enregistrements de la table courante */
                $NbChamps = mysqli_field_count($this->cBD);
                $NbEnregistrements = mysqli_num_rows($ListeEnregistrements);
                echo "<p $sContenu>$NbChamps champs ont été détectés dans la table.<br />";
                echo "    $NbEnregistrements enregistrements ont été détectés dans la table.</p>";

                /* Affichage de la structure de table courante */
                echo "<p $sContenu>";
                $j = 0;
                $tabNomChamp = array();
                while ($champCourant = $ListeEnregistrements->fetch_field()) {
                    $intDivAjustement = 1;
                    $tabNomChamp[$j] = $champCourant->name;
                    $strType = $champCourant->type;
                    switch ($strType) {
                        case 1 : $strType = "BOOL";
                            break;
                        case 3 : $strType = "INTEGER";
                            break;
                        case 10 : $strType = "DATE";
                            break;
                        case 12 : $strType = "DATETIME";
                            break;
                        case 246 : $strType = "DECIMAL";
                            break;
                        case 253 : $strType = "VARCHAR";
                            /* Ajustement temporaire */
                            if ($_SERVER["SERVER_NAME"] == "lmbrousseau.ca") {
                                $intDivAjustement = 3;
                            }
                            break;
                        case 254 : $strType = "CHAR";
                            break;
                        default : $strType = "<span $sTypeADefinir>$strType à définir</span>";
                            break;
                    }
                    $strLongueur = intval($champCourant->length) / $intDivAjustement;
                    $intDetails = $champCourant->flags;
                    $strDetails = "";
                    if ($intDetails & 1)
                        $strDetails .= "[NOT_NULL] ";
                    if ($intDetails & 2)
                        $strDetails .= "<span style=\"font-weight:bold;\">[PRI_KEY]</span> ";
                    if ($intDetails & 4)
                        $strDetails .= "[UNIQUE_KEY] ";
                    if ($intDetails & 16)
                        $strDetails .= "[BLOB] ";
                    if ($intDetails & 32)
                        $strDetails .= "[UNSIGNED] ";
                    if ($intDetails & 64)
                        $strDetails .= "[ZEROFILL] ";
                    if ($intDetails & 128)
                        $strDetails .= "[BINARY] ";
                    if ($intDetails & 256)
                        $strDetails .= "[ENUM] ";
                    if ($intDetails & 512)
                        $strDetails .= "[AUTO_INCREMENT] ";
                    if ($intDetails & 1024)
                        $strDetails .= "[TIMESTAMP] ";
                    if ($intDetails & 2048)
                        $strDetails .= "[SET] ";
                    if ($intDetails & 32768)
                        $strDetails .= "[NUM] ";
                    if ($intDetails & 16384)
                        $strDetails .= "[PART_KEY] ";
                    if ($intDetails & 32768)
                        $strDetails .= "[GROUP] ";
                    if ($intDetails & 65536)
                        $strDetails .= "[UNIQUE] ";
                    echo ($j + 1) . ". $tabNomChamp[$j], $strType($strLongueur) <span $sDetails>$strDetails</span><br />";
                    $j++;
                }
                echo "</p>";

                /* Affichage des enregistrements composant la table courante */
                echo "<table $sTable>";
                echo "<tr>";
                for ($k = 0; $k < $NbChamps; $k++)
                    echo "<td $sMessageAvecBordures>" . $tabNomChamp[$k] . "</td>";
                echo "</tr>";
                if (empty($NbEnregistrements)) {
                    echo "<tr>";
                    echo "<td $sContenuAvecBordures colspan=\"$NbChamps\">";
                    echo " Aucun enregistrement";
                    echo "</td>";
                    echo "</tr>";
                }
                while ($listeChampsEnregistrement = $ListeEnregistrements->fetch_row()) {
                    echo "<tr>";
                    echo "<tr>";
                    for ($j = 0; $j < count($listeChampsEnregistrement); $j++)
                        echo "      <td $sContenuAvecBordures>" . $listeChampsEnregistrement[$j] . "</td>";
                    echo "   </tr>";
                }
                echo "</table>";
                $ListeEnregistrements->free();
            }
        }
        if (!$binTablePresente)
            echo "<p $sMessage>Aucune table !</p>";
    }

}

?>