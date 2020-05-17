<?php

//********************************FONCTIONS REGULIAIRES***********************************/
/*
  |-------------------------------------------------------------------------------------|
  | parametre (2020-02-11)
  | Récupère le paramètre passé via la barre d'adresse qu'il soit envoyé en GET ou en POST
  | NOUVELLE FONCTION À AJOUTER DANS LA LIBRAIRIE 'librairie-generale-2020-mm-jj.php'
  |-------------------------------------------------------------------------------------|
 */
function parametre($strIDParam) {
    return filter_input(INPUT_GET, $strIDParam, FILTER_SANITIZE_SPECIAL_CHARS) .
            filter_input(INPUT_POST, $strIDParam, FILTER_SANITIZE_SPECIAL_CHARS);
}

/*
  |-------------------------------------------------------------------------------------|
  | genereNombre (2020-02-11)
  | NOUVELLE FONCTION À AJOUTER DANS LA LIBRAIRIE 'librairie-generale-2020-mm-jj.php'
  |-------------------------------------------------------------------------------------|
 */

function genereNombre($Maximum) {
    list($usec, $sec) = explode(' ', microtime());
    $dblGerme = (float) $sec + ((float) $usec * 100000);
    srand($dblGerme);
    return floor(rand() % $Maximum + 1);
}

/* FONCTION convertiSousChaineEntier
  |------------------------------------------------------|
  | convertiSousChaineEntier(2020-01-24)
  |------------------------------------------------------|
 */

function convertiSousChaineEntier($strChaine, $intDepart, $intLongeur) {
    $intEntier = intval(substr($strChaine, $intDepart, $intLongeur));
    return $intEntier;
}

/* FONCTION er
  |-----------------------------------------------------------------------------------|
  |er (2020-01-29)
  | Scénarios :er($intEntier)              => Nombre passer en argument 1 ou autre
  |            er($intJour,$binExposant)   => En focntion de $binExposant
  |-----------------------------------------------------------------------------------|
 */

function er($intEntier, $binExposant = true) {


    return $intEntier . ($intEntier == 1 ? ($binExposant ? "<sup>er</sup>" : "er") : "");
}

/* FONCTION ajouteZeros
  |-----------------------------------------------------------------------------------|
  |er (2020-01-29)
  | Scénarios :ajouteZeros($numValeur, $intLargeur
  |-----------------------------------------------------------------------------------|
 */

function ajouteZeros($numValeur, $intLargeur) {

    $strFormat = "%0" . $intLargeur . "d";
    return sprintf($strFormat, $numValeur);
}

/* FONCTION remplaceEspaces
  |-----------------------------------------------------------------------------------|
  |er (2020-01-29)
  | Scénarios :remplaceEspaces($fp)
  |-----------------------------------------------------------------------------------|
 */

function remplaceEspaces($fp) {
    return str_replace("\n", "", str_replace("\r", "", fgets($fp)));
}

/* FONCTION dollar
  |-----------------------------------------------------------------------------------|
  |dollar (10)
  | Scénarios :dollar($intValeur) retourne le nombre passé en argument en format
  |                               monétaire. Un deuxieme parametre si l'on desire que
  |                               que le nombre de decimal soit different
  |-----------------------------------------------------------------------------------|
 */

function dollar($nombre) {

    //$intNombre = floatval($nombre);
    $dblNombre = floatval(str_replace(",", ".", $nombre));

    $strNombreRetourne;
    if (func_num_args() == 1) {

        $strNombreRetourne = number_format($dblNombre, 2, ',', ' ') . " $";
    } else {
        $intNombreDeDecimal = func_get_arg(1);
        $strNombreRetourne = number_format($dblNombre, $intNombreDeDecimal, ',', ' ') . " $";
    }


    return $strNombreRetourne;
}

/* FONCTION pourcent
  |-----------------------------------------------------------------------------------|
  |pourcent (10)
  | Scénarios :pourcent($intValeur)retourne le nombre passé en argument en format
  |                               pourcentage.
  |-----------------------------------------------------------------------------------|
 */

function pourcent($nombre) {

    //$intNombre = intval($nombre);
    //$intNombre = floatval($nombre);
    $dblNombre = floatval(str_replace(",", ".", $nombre));

    $strNombreRetourne;
    if (func_num_args() == 1) {

        $strNombreRetourne = number_format($dblNombre, 2, ',', ' ') . " %";
    } else {
        $intNombreDeDecimal = func_get_arg(1);
        $strNombreRetourne = number_format($dblNombre, $intNombreDeDecimal, ',', ' ') . " %";
    }


    return $strNombreRetourne;
}

function dollarParentheses($nombre) {
    $dblNombre = floatval(str_replace(",", ".", $nombre));


    $strNombreRetourne;
    if (func_num_args() == 1) {

        $strNombreRetourne = number_format($dblNombre, 2, ',', ' ');
    } else {
        $intNombreDeDecimal = func_get_arg(1);
        $strNombreRetourne = number_format($dblNombre, $intNombreDeDecimal, ',', ' ');
    }




    return ($strNombreRetourne < 0) ? "(" . str_replace("-", "", $strNombreRetourne) . ") $" : $strNombreRetourne . " $";
}

//********************************FONCTIONS POUR LES DATES***********************************/


function age($strDateUun, $strDateDeux) {

    /* $dob = strtotime(str_replace("/", "-", $strDateUun));

      $aujd = $strDateDeux;

      $diff = $aujd-$dob;

      $age = floor($diff/31556926);

      return $age; */
    $date_parts1 = explode("-", $strDateUun);
    $date_parts2 = explode("-", $strDateDeux);
    return $date_parts2[0] - $date_parts1[0];

    //  return intval(substr(date('Ymd') - date('Ymd', strtotime($strDate)), 0, -4));
    //https://stackoverflow.com/questions/5387166/calculating-number-of-years-between-2-dates-in-php
    //https://stackoverflow.com/questions/3776682/php-calculate-age
    //https://stackoverflow.com/questions/3776682/php-calculate-age
}

function jourDansLaSemaine($strDate, &$intJourSemaine) {
    $intJourSemaine = date("N", strtotime($strDate));
}

function premierJourDuMois($strDate) {

    return date("Y-m-01", strtotime($strDate));
    //https://www.w3resource.com/php-exercises/php-date-exercise-8.php
}

/* FONCTION hierOuDemain($strDate,$binDemain)
  |----------------------------------------------------------------------------|
  |hierOuDemain($strDate,$binDemain)
  | Scénarios :hierOuDemain(2019-12-31,true) retourne 2020-01-01
  |            hierOuDemain(2019-12-31,false) retourne 2019-12-30
  |----------------------------------------------------------------------------|
 */

function hierOuDemain($strDate, $binDemain, &$strNouvelleDate = "") {


    /*  $intJour = intval(substr($strDate, 0, 2));
      $intMois = intval(substr($strDate, 3, 2));
      $intAnnee = intval(substr($strDate, 6, 4)); */
    $strDateDemain = date('Y-m-d', strtotime('+1 day', strtotime($strDate)));

    $strDateHier = date('Y-m-d', strtotime('-1 day', strtotime($strDate)));

    if (func_num_args() == 3) {

        $strNouvelleDate = ($binDemain == true) ? $strDateDemain : $strDateHier;
    }


    return ($binDemain == true) ? $strDateDemain : $strDateHier;
    // return (func_num_args() == 2) ? (($binDemain == true) ? $strDateDemain : $strDateHier ) : ($binDemain) ?  $intJour = intval(substr($strDateDemain, 0, 2)):$intJour = intval(substr($strDateHier, 0, 2));
    //https://stackoverflow.com/questions/14460518/php-get-tomorrows-date-from-date/14460546
}

/* FONCTION moisEnLiterral
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

/* FONCTION joursemaineEnLiterral
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
    if ($binMajuscule)
        $strJour = ucfirst($strJour);

    return $strJour;
}

/* FONCTION AAAAMMJJ
  |-----------------------------------------------------------------------------------|
  |AAAAMMJJ (2020-01-24)
  | Scénarios :AAAAMMJJ($intJour,$intMois,$intAnnee)
  |-----------------------------------------------------------------------------------|
 */

function AAAAMMJJDIF($intJour, $intMois, $intAnnee) {

    $longueurAnnee = strlen((string) $intAnnee) . " ";
    //echo "longeur annee : " . $longueurAnnee;
    //echo "</br>intAnne : ". $intAnnee;
    if ($longueurAnnee == 1 || $longueurAnnee == 2) {
        if ($intAnnee >= 0 && $intAnnee <= 20) {
            $intAnnee = 2000 + $intAnnee;
        } else {
            $intAnnee = 1900 + $intAnnee;
        }
    }


    return $intAnnee . "-" . ajouteZeros($intMois, 2) . "-" . ajouteZeros($intJour, 2);
}

/* FONCTION JJMMAAAA
  |-----------------------------------------------------------------------------------|
  |JJMMAAAA (2020-01-24)
  | Scénarios :JJMMAAAA($intJour,$intMois,$intAnnee)
  |-----------------------------------------------------------------------------------|
 */

function JJMMAAAA($intJour, $intMois, $intAnnee) {

    $longueurAnnee = strlen((string) $intAnnee) . " ";
    //echo "longeur annee : " . $longueurAnnee;
    //echo "</br>intAnne : ". $intAnnee;
    if ($longueurAnnee == 1 || $longueurAnnee == 2) {
        if ($intAnnee >= 0 && $intAnnee <= 20) {
            $intAnnee = 2000 + $intAnnee;
        } else {
            $intAnnee = 1900 + $intAnnee;
        }
    }


    return ajouteZeros($intJour, 2) . "-" . ajouteZeros($intMois, 2) . "-" . $intAnnee;
}

/* FONCTION extraitJSJJMMAAAA
  |--------------------------------------------------------------------------------------|
  |extraitJSJJMMAAAA (2020-01-29)
  | Scénarios :extraitJSJJMMAAAA(&$intJourSemaine,&$intJour,&$intMois,&$intAnnee)
  |           extraitJSJJMMAAAA(&$intJourSemaine,&$intJour,&$intMois,&$intAnnee,$strDate)
  |--------------------------------------------------------------------------------------|
 */

function extraitJSJJMMAAAA(&$intJourSemaine, &$intJour, &$intMois, &$intAnnee) {
    //Par defaut, l'extraction s'effectue a partir de la date courante;
    //Autrement dit, elle s'effectue a partir du 5e argument specifie a l'appel
    if (func_num_args() == 4) {
        //Recuperation de la date courante
        $strDate = date("d-m-Y");
        //Recuperation du jour de la semaine
        $intJourSemaine = date("N");
    } else {
        //Recuperation du 5e argument
        $strDate = func_get_arg(4);
        //Recuperation du jour de la semaine apres convertit la date passee
        //sous forme d'une chaine en timestamp
        $intJourSemaine = date("N", strtotime($strDate));
    }
    $intJour = intval(substr($strDate, 0, 2));
    $intMois = intval(substr($strDate, 3, 2));
    $intAnnee = intval(substr($strDate, 6, 4));
}

/* FONCTION extraitJJMMAAAA
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

/* FONCTION aujourdhui($binAAAMMJJ=true)
  |----------------------------------------------------------------------------|
  |aujourdhui ($binAAAMMJJ=true)
  | Scénarios :aujourdhui() retourne 2020-01-31
  |            aujourdhui(true) retourne 2020-01-31
  |             aujourdhui(false) retourne 31-01-2020
  |----------------------------------------------------------------------------|
 */

function aujourdhui($binAAAMMJJ = true) {

    $strDate = date("d-m-Y");
    $intJour = intval(substr($strDate, 0, 2));
    $intMois = intval(substr($strDate, 3, 2));
    $intAnnee = intval(substr($strDate, 6, 4));

    return ($binAAAMMJJ) ? $intAnnee . "-" . ajouteZeros($intMois, 2) . "-" . ajouteZeros($intJour, 2) : ajouteZeros($intJour, 2) . "-" . ajouteZeros($intMois, 2) . "-" . $intAnnee;
}

/* FONCTION bissextile($intAnnee)
  |----------------------------------------------------------------------------|
  |bissextile($intAnnee)
  | Scénarios :bissextile(2019) retourne false
  |            bissextile(2020) retourne true
  |----------------------------------------------------------------------------|
 */

function bissextile($intAnnee) {

    $strAnnee = strval($intAnnee);
    //echo date("L", $intAnnee);

    return (date("L", strtotime($strAnnee . "-01-01")) == 1) ? true : false;
}

function nombreJoursAnnee($intAnnee) {

    return (bissextile($intAnnee) ? 366 : 365);
}

function nombreJoursMois($intMois, $intAnnee) {

    return date("t", mktime(0, 0, 0, $intMois, 1, $intAnnee));
}

function nombreJoursEntreDeuxDates($strDate1, $strDate2) {


    $diff = strtotime($strDate2) - strtotime($strDate1);

    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return (round($diff / 86400));

    //https://www.geeksforgeeks.org/program-to-find-the-number-of-days-between-two-dates-in-php/
}

function extraitJSJJMMAAAAv2(&$intJourSemaine, &$intJour, &$intMois, &$intAnnee) {

    //$bin = false;
    if (func_num_args() == 4) {
        //Recuperation de la date courante
        $strDate = date("d-m-Y");
        //Recuperation du jour de la semaine
        $intJourSemaine = date("N");
    } else {
        //Recuperation du 5e argument
        $strDate = func_get_arg(4);
        //Recuperation du jour de la semaine apres convertit la date passee
        //sous forme d'une chaine en timestamp
        $intJourSemaine = date("N", strtotime($strDate));
    }


    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $strDate)) {
        //  $bin = true;
        $intJour = intval(substr($strDate, 0, 2));
        $intMois = intval(substr($strDate, 3, 2));
        $intAnnee = intval(substr($strDate, 6, 4));
    } else {
        $intAnnee = intval(substr($strDate, 0, 4));
        $intMois = intval(substr($strDate, 5, 7));
        $intJour = intval(substr($strDate, 8, 10));
    }


    // return $bin;
}

function dateValide($strDate) {
    $intJour;
    $intMois;
    $intAnnee;
    $intJourSemaine;
    extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $strDate);


    // echo checkdate($intJour, $intMois, $intAnnee);
    return (checkdate($intMois, $intJour, $intAnnee));
}

function dateEnLitteral() {

    $intJour;
    $intMois;
    $intAnnee;
    $intJourSemaine;
    $strDateEnLitteral;


    $arg;

    $arg2;


    extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee);

    $strDateEnLitteral = er($intJour) . " " . moisEnLiterral($intMois) . " " . $intAnnee;

    if (func_num_args() == 1) {//1er argument
        $arg = func_get_arg(0);

        if ($arg == "c" || $arg == "C") {

            $strDateEnLitteral = joursemaineEnLiterral($intJourSemaine, true) . " " . er($intJour) . " " . moisEnLiterral($intMois) . " " . $intAnnee;
        } else if (dateValide($arg)) {

            extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $arg);

            $strDateEnLitteral = er($intJour) . " " . moisEnLiterral($intMois) . " " . $intAnnee;
        }
    } else if (func_num_args() == 2) {//2iem argument
        $arg = func_get_arg(0);
        $arg2 = func_get_arg(1);

        if (($arg == "c" || $arg == "C") && (dateValide($arg2))) {

            extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $arg2);

            $strDateEnLitteral = joursemaineEnLiterral($intJourSemaine, true) . " " . er($intJour) . " " . moisEnLiterral($intMois) . " " . $intAnnee;
        } else if (($arg2 == "c" || $arg2 == "C") && (dateValide($arg))) {
            extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee, $arg);

            $strDateEnLitteral = joursemaineEnLiterral($intJourSemaine, true) . " " . er($intJour) . " " . moisEnLiterral($intMois) . " " . $intAnnee;
        }
    }

    return $strDateEnLitteral;
}

/* FONCTION AAAAMMJJ
  |-----------------------------------------------------------------------------------|
  |AAAAMMJJ (2020-01-24)
  | Scénarios :AAAAMMJJ($intJour,$intMois,$intAnnee)
  |-----------------------------------------------------------------------------------|
 */

function AAAAMMJJ() {

    $strDate;
    $intJour;
    $intMois;
    $intAnnee;
    $strDateRetour;
    $js;
    if (func_num_args() == 1) {//1er argument
        $strDate = func_get_arg(0);

        extraitJSJJMMAAAAv2($js, $intJour, $intMois, $intAnnee, $strDate);



        $strDateRetour = (strlen($intAnnee) == 2 ? "20" . $intAnnee : $intAnnee) . "-" . ajouteZeros($intMois, 2) . "-" . ajouteZeros($intJour, 2);
    } else if (func_num_args() == 3) {
        $intJour = func_get_arg(0);
        $intMois = func_get_arg(1);
        $intAnnee = func_get_arg(2);

        $strDateRetour = ($intAnnee == 20 ? "20" . $intAnnee : $intAnnee) . "-" . ajouteZeros($intMois, 2) . "-" . ajouteZeros($intJour, 2);
    }

    return $strDateRetour;

    /*  $longueurAnnee = strlen((string) $intAnnee) . " ";
      //echo "longeur annee : " . $longueurAnnee;
      //echo "</br>intAnne : ". $intAnnee;
      if ($longueurAnnee == 1 || $longueurAnnee == 2) {
      if ($intAnnee >= 0 && $intAnnee <= 20) {
      $intAnnee = 2000 + $intAnnee;
      } else {
      $intAnnee = 1900 + $intAnnee;
      }
      }


      return $intAnnee . "-" . ajouteZeros($intMois, 2) . "-" . ajouteZeros($intJour, 2); */
}

function jour($strDate) {
    return str_replace("0", "", date("j", strtotime($strDate)));
}

function Annee($strDate) {
    return date("Y", strtotime($strDate));
}

function mois($strDate) {
    return str_replace("0", "", date("m", strtotime($strDate)));
}
//********************************FONCTIONS POUR LES FICHIERS***********************************/
 /*
   |----------------------------------------------------------------------------------|
   | chargeFichierEnMemoire() (2018-03-13; 2019-03-12; 2020-03-22)
   | Réf.: http://php.net/manual/fr/function.count.php
   |       http://ca.php.net/manual/fr/function.file.php
   |       http://php.net/manual/fr/function.file-get-contents.php
   |       http://ca.php.net/manual/fr/function.str-replace.php
   |       http://php.net/manual/fr/function.strlen.php
   |----------------------------------------------------------------------------------|
   */
   function chargeFichierEnMemoire($strNomFichier,
                                   &$tContenu, &$intNbLignes,
                                   &$strContenu, &$intTaille,
                                   &$strContenuHTML) {
      /* Récupère toutes les lignes et les entrepose dans un tableau
         Retrait de tous les CR et LF
         Récupère le nombre de lignes */
      $tContenu = file($strNomFichier);
      $tContenu = str_replace("\n", "", str_replace("\r", "", $tContenu));
      $intNbLignes = count($tContenu);

      /* Récupère toutes les lignes et les entrepose dans une chaîne */
      $strContenu = file_get_contents($strNomFichier);
      $intTaille = strlen($strContenu);

      /* Entrepose la chaîne résultante dans une autre après l'avoir XHTMLisé ! */
      $strContenuHTML = str_replace("\n\r", "<br />", str_replace("\r\n", "<br />", $strContenu));
   }
   /*
   |----------------------------------------------------------------------------------|
   | compteLignesFichier() (2018-03-13; 2019-03-12; 2020-03-22)
   | Réf.: http://ca.php.net/manual/fr/function.count.php
   |       http://ca.php.net/manual/fr/function.file.php
   |----------------------------------------------------------------------------------|
   */
   function compteLignesFichier($strNomFichier) {
      $intNbLignes = -1;
      if (fichierExiste($strNomFichier)) {
         $intNbLignes = count(file($strNomFichier));
      }
      return $intNbLignes;
   }
   /*
   |----------------------------------------------------------------------------------|
   | detecteFinFichier() (2018-03-13; 2019-03-12; 2020-03-22)
   | Réf.: http://php.net/manual/fr/function.feof.php
   |----------------------------------------------------------------------------------|
   */
   function detecteFinFichier($fp) {
      $binVerdict = true;
      if ($fp) {
         $binVerdict = feof($fp);
      }
      return $binVerdict;
   }
   /*
   |----------------------------------------------------------------------------------|
   | ecritLigneDansFichier() (2018-03-13; 2019-03-12; 2020-03-22)
   | Réf.: http://php.net/manual/fr/function.fputs.php
   |       http://php.net/manual/fr/function.gettype.php
   |----------------------------------------------------------------------------------|
   */
   function ecritLigneDansFichier($fp, $strLigneCourante, $binSaut_intNbLignesSaut = false) {
      $binVerdict = fputs($fp, $strLigneCourante);
      if ($binVerdict) {
         switch (gettype($binSaut_intNbLignesSaut)) {
            case "integer" :
               for ($i=1; $i<=$binSaut_intNbLignesSaut && $binVerdict; $i++) {
                  $binVerdict = fputs($fp, "\r\n");
               }
               break;
            case "boolean" :
               if ($binSaut_intNbLignesSaut) {
                  $binVerdict = fputs($fp, "\r\n");
               }
         }
      }
      return $binVerdict;
   }
   /*
   |----------------------------------------------------------------------------------|
   | fermeFichier() (2018-03-13; 2019-03-12; 2020-03-22)
   | Réf.: http://ca.php.net/manual/fr/function.fclose.php
   |----------------------------------------------------------------------------------|
   */
   function fermeFichier($fp) {
      $binVerdict = false;
        if ($fp) {
           $binVerdict = fclose($fp);
        }
      return $binVerdict;
   }
   /*
   |----------------------------------------------------------------------------------|
   | fichierExiste() (2018-03-13; 2019-03-12; 2020-03-22)
   | Réf.: http://ca.php.net/manual/fr/function.file-exists.php
   |----------------------------------------------------------------------------------|
   */
   function fichierExiste($strNomFichier) {
      return file_exists($strNomFichier);
   }
   /*
   |----------------------------------------------------------------------------------|
   | litLigneDansFichier() (2018-03-13; 2019-03-12; 2020-03-22)
   | Réf.: http://ca.php.net/manual/fr/function.fgets.php
   |       http://ca.php.net/manual/fr/function.str-replace.php
   |----------------------------------------------------------------------------------|
   */
   function litLigneDansFichier($fp) {
      return str_replace("\n", "", str_replace("\r", "", fgets($fp)));
   }
   /*
   |----------------------------------------------------------------------------------|
   | ouvreFichier() (2018-03-13; 2019-03-12; 2020-03-22)
   | Réf.: http://ca.php.net/manual/fr/function.fopen.php
   |       http://ca.php.net/manual/fr/function.strtoupper.php
   |----------------------------------------------------------------------------------|
   */
   function ouvreFichier($strNomFichier, $strMode="L") {
      switch (strtoupper($strMode)) {
         case "A" :
         case "A" :
            $strMode = "a";
            break;
         case "E" :
         case "W" :
            $strMode = "w";
            break;
         case "L" :
         case "R" :
            $strMode = "r";
            break;
      }
      $fp = fopen($strNomFichier, $strMode);
      return $fp;
   }
   //********************************FONCTIONS SQL***********************************/
     function detecteServeur(&$strMonIP, &$strIPServeur, &$strNomServeur, &$strInfosSensibles) {
      $strMonIP = $_SERVER["REMOTE_ADDR"];
      $strIPServeur = $_SERVER["SERVER_ADDR"];
      $strNomServeur = $_SERVER["SERVER_NAME"];
      $strInfosSensibles = str_replace(".", "-", $strNomServeur) . ".php";
   }
   
?>