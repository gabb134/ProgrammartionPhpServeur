<?php

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
    
    $strFormat = "%0".$intLargeur."d";
    return sprintf($strFormat,$numValeur);
}

/* FONCTION remplaceEspaces
  |-----------------------------------------------------------------------------------|
  |er (2020-01-29)
  | Scénarios :remplaceEspaces($fp)
  |-----------------------------------------------------------------------------------|
 */
function remplaceEspaces($fp){
    return str_replace("\n", "", str_replace("\r", "", fgets($fp)));
}




?>
