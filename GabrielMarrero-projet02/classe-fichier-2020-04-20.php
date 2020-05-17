<?php

class fichier {
    /*
      |----------------------------------------------------------------------------------|
      | attributs
      |----------------------------------------------------------------------------------|
     */

    private $fp = null;
    public $intNbLignes = null;
    public $intTaille = null;
    public $strLigneCourante = null;
    public $strNom = null;
    public $strContenu = null;
    public $strContenuHTML = null;
    public $tContenu = array();

    /*
      |----------------------------------------------------------------------------------|
      | constructeur
      |----------------------------------------------------------------------------------|
     */

    function __construct($strNomFichier) {
        $this->strNom = $strNomFichier;
        if (func_num_args() == 2) {
            $this->ouvre(func_get_arg(1));
        }
    }

    /*
      |----------------------------------------------------------------------------------|
      | chargeEnMemoire() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://php.net/manual/fr/function.count.php
      |       http://ca.php.net/manual/fr/function.file.php
      |       http://php.net/manual/fr/function.file-get-contents.php
      |       http://ca.php.net/manual/fr/function.str-replace.php
      |       http://php.net/manual/fr/function.strlen.php
      |----------------------------------------------------------------------------------|
     */

    function chargeEnMemoire() {
        /* Récupère toutes les lignes et les entrepose dans un tableau
          Retrait de tous les CR et LF
          Récupère le nombre de lignes */
        $this->tContenu = file($this->strNom);
        $this->tContenu = str_replace("\n", "", str_replace("\r", "", $this->tContenu));
        $this->intNbLignes = count($this->tContenu);
        /* Récupère toutes les lignes et les entrepose dans une chaîne */
        $this->strContenu = file_get_contents($this->strNom);
        $this->intTaille = strlen($this->strContenu);
        /* Entrepose la chaîne résultante dans une autre après l'avoir XHTMLisé ! */
        $this->strContenuHTML = str_replace("\n\r", "<br />", str_replace("\r\n", "<br />", $this->strContenu));
    }

    /*
      |----------------------------------------------------------------------------------|
      | compteLignes() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://ca.php.net/manual/fr/function.count.php
      |       http://ca.php.net/manual/fr/function.file.php
      |----------------------------------------------------------------------------------|
     */

    function compteLignes() {
        $this->intNbLignes = -1;
        if ($this->existe()) {
            $this->intNbLignes = count(file($this->strNom));
        }
        return $this->intNbLignes;
    }

    /*
      |----------------------------------------------------------------------------------|
      | detecteFin() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://php.net/manual/fr/function.feof.php
      |----------------------------------------------------------------------------------|
     */

    function detecteFin() {
        $binVerdict = true;
        if ($this->fp) {
            $binVerdict = feof($this->fp);
        }
        return $binVerdict;
    }

    /*
      |----------------------------------------------------------------------------------|
      | ecritLigne() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://php.net/manual/fr/function.fputs.php
      |       http://php.net/manual/fr/function.gettype.php
      |----------------------------------------------------------------------------------|
     */

    function ecritLigne($strLigneCourante, $binSaut_intNbLignesSaut = false) {
        $binVerdict = fputs($this->fp, $strLigneCourante);
        if ($binVerdict) {
            switch (gettype($binSaut_intNbLignesSaut)) {
                case "integer" :
                    for ($i = 1; $i <= $binSaut_intNbLignesSaut && $binVerdict; $i++) {
                        $binVerdict = fputs($this->fp, "\r\n");
                    }
                    break;
                case "boolean" :
                    if ($binSaut_intNbLignesSaut) {
                        $binVerdict = fputs($this->fp, "\r\n");
                    }
                    break;
            }
        }
        return $binVerdict;
    }

    /*
      |----------------------------------------------------------------------------------|
      | existe() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://ca.php.net/manual/fr/function.file-exists.php
      |----------------------------------------------------------------------------------|
     */

    function existe() {
        return file_exists($this->strNom);
    }

    /*
      |----------------------------------------------------------------------------------|
      | ferme() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://ca.php.net/manual/fr/function.fclose.php
      |----------------------------------------------------------------------------------|
     */

    function ferme() {
        $binVerdict = false;
        if ($this->fp) {
            $binVerdict = fclose($this->fp);
        }
        return $binVerdict;
    }

    /*
      |----------------------------------------------------------------------------------|
      | litDonneesLigne() (2018-03-13; 2019-03-12; 2020-03-22)
      | Ref. : http://php.net/manual/fr/function.array-combine.php
      |        http://php.net/manual/fr/function.func-get-arg.php
      |        http://php.net/manual/fr/function.func-num-args.php
      |        http://stackoverflow.com/questions/6814760/php-using-explode-function-to-assign-values-to-an-associative-array
      |----------------------------------------------------------------------------------|
     */

    function litDonneesLigne(&$tValeurs, $strSeparateur) { /* 0 */
        for ($i = 2; $i <= func_num_args() - 1; $i++) { /* 1 */
            $tValeurs[func_get_arg($i)] = func_get_arg($i); /* 2 */
        } /* 3 */
        $tValeurs = array_combine($tValeurs, explode($strSeparateur, $this->litLigne())); /* 4 */
    }

    /*
      |----------------------------------------------------------------------------------|
      | litLigne() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://ca.php.net/manual/fr/function.fgets.php
      |       http://ca.php.net/manual/fr/function.str-replace.php
      |----------------------------------------------------------------------------------|
     */

    function litLigne() {
        $this->strLigneCourante = str_replace("\n", "", str_replace("\r", "", fgets($this->fp)));
        return $this->strLigneCourante;
    }

    /*
      |----------------------------------------------------------------------------------|
      | ouvre() (2018-03-13; 2019-03-12; 2020-03-22)
      | Réf.: http://ca.php.net/manual/fr/function.fopen.php
      |       http://ca.php.net/manual/fr/function.strtoupper.php
      |----------------------------------------------------------------------------------|
     */

    function ouvre($strMode = "L") {
        switch (strtoupper($strMode)) {

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
        $this->fp = fopen($this->strNom, $strMode);
        return $this->fp;
    }

}
?>

