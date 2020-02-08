<?php

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
    if ($longueurAnnee ==1||$longueurAnnee==2) {
        if ($intAnnee >= 0 && $intAnnee <= 20) {
            $intAnnee = 2000 + $intAnnee;
        } else {
            $intAnnee = 1900 + $intAnnee;
        }
    }


    return ajouteZeros($intJour, 2) . "-" . ajouteZeros($intMois, 2) . "-" . $intAnnee;
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

?>
