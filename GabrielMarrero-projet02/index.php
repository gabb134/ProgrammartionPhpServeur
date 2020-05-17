
<!DOCTYPE html>
<html>
    <head>
        <title>Création des équipes pour le projet "13 juin 2020"</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="index.css" />
        <script type="text/javascript">
            function confirmationDemandee() {
                if (confirm("Cliquer sur OK pour reconstruire les tables; autrement ANNULER.")) {
                    window.location = 'index.php?Reinitialisation=Oui&Matricule=1559730&Trace=';
                }
            }
        </script>
    </head>
    <body>
        <form id="frmSaisie" method="get" action="">
            <input id="Matricule" name="Matricule" type="hidden" value="1559730" />
            <input id="Trace" name="Trace" type="hidden" value="" />

            <div id="divEntete" class="sDivEntete">
                <p class="sTitreApplication">
                    Projet 2 : Création des équipes pour le projet "13 juin 2020"
                    <span class="sTitreSection">
                        <br />par <span class="sRouge">Gabriel Marrero</span>
                        <a class="sConsigne sBleu" href="index.php?Deconnexion=Oui&Matricule=1559730&Trace=">Déconnexion</a>
                        <a class="sConsigne sBleu" href="javascript:confirmationDemandee()">Réinitialisation des tables</a>
                        <br />
                    </span>
                </p>
            </div>
            <?php
            /*
              |-------------------------------------------------------------------------------------|
              | DÉMARRAGE DE LA SESSION
              | Doit être exécutée si des variables de session ont été préalablement initialisée.
              |-------------------------------------------------------------------------------------|
             */
            // session_start();
            /*
              |---------------------------------------------------------------------------------------------------------|
              | Liste des fichiers d'inclusion
              |---------------------------------------------------------------------------------------------------------|
             */
            require_once("./classe-fichier-2020-04-20.php");
            require_once("./classe-mysql-2020-04-27.php");
            require_once("./librairie-generale-2020-04-28.php");
            require_once("./fonctions-specifiques-projet02.php");
            /*
              |---------------------------------------------------------------------------------------------------------|
              | Recuperation des variables de session et du get
              |---------------------------------------------------------------------------------------------------------|
             */
            $strIDEtudiantSaisie = parametre("tbDA");

            //echo "id: " . $strIDEtudiantSaisie;

            /*
              |-------------------------------------------------------------------------------------|
              | afficheTrace
              | Affichage une trace d'exécution de l'application.
              |-------------------------------------------------------------------------------------|
             */

            function afficheTrace($strRequete, $binTrace, $strMessage, $binOK) {
                echo "<p class=\"sCommande\">$strRequete<br />";
                if ($binTrace) {
                    echo "<span class=\"sMessage\">";
                    echo $strMessage;
                    if ($binOK)
                        echo " confirmée";
                    else
                        echo " impossible";
                    echo "</span>";
                }
                echo "</p>";
            }

            /*
              |---------------------------------------------------------------------------------------------------------|
              | Détermination du fichier "InfosSensibles" à utiliser
              |---------------------------------------------------------------------------------------------------------|
             */

            $strMonIP = null;
            $strIPServeur = null;
            $strNomServeur = null;
            $strInfosSensibles = null;
            detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);

            //echo "$strMonIP => $strIPServeur ($strNomServeur) => $strInfosSensibles<br />";

            /*
              |---------------------------------------------------------------------------------------------------------|
              | Initialisation des variables de travail
              |---------------------------------------------------------------------------------------------------------|
             */
            $strNomFichierEtudiants = "etudiants.csv";
            $strNomFichierRoles = "roles.csv";
            $strNomTable_pjr2_Etudiants = "prj2_etudiants";
            $strNomTable_pjr2_Roles = "prj2_roles";
            $strNomTable_pjr2_Equipes = "prj2_equipes";
            $strNomTable_pjr2_Membres = "prj2_membres";

            /*
              |---------------------------------------------------------------------------------------------------------|
              | Création de l'instance, connexion avec mySQL et sélection de la base de données
              | Sélection de la base de données
              |---------------------------------------------------------------------------------------------------------|
             */
            $BDProjet2 = new mysql($strInfosSensibles);
            $BDProjet2->selectionneBD();

            /*
              |---------------------------------------------------------------------------------------------------------|
              | Partie PHP (exécutée avant le chargement de la page Web)Déroulement de l’exécution ( 10 points )
              |---------------------------------------------------------------------------------------------------------|
             */
            if (!$BDProjet2->tableExiste($strNomTable_pjr2_Etudiants)) { //si la tale nexiste pas...
                creeTableEtudiants($BDProjet2, $strNomTable_pjr2_Etudiants);
                remplitTableEtudiants($BDProjet2, $strNomTable_pjr2_Etudiants, $strNomFichierEtudiants);
                // afficheRequete($BDProjet2);
            }
            if (!$BDProjet2->tableExiste($strNomTable_pjr2_Roles)) { //si la tale nexiste pas...
                creeTableRoles($BDProjet2, $strNomTable_pjr2_Roles);
                remplitTableRoles($BDProjet2, $strNomTable_pjr2_Roles, $strNomFichierRoles);
                //afficheRequete($BDProjet2);
            }
            if (!$BDProjet2->tableExiste($strNomTable_pjr2_Equipes)) {
                creeTableEquipes($BDProjet2, $strNomTable_pjr2_Equipes);
            }
            if (!$BDProjet2->tableExiste($strNomTable_pjr2_Membres)) {
                creeTableMembres($BDProjet2, $strNomTable_pjr2_Membres);
            }

            /*
              |---------------------------------------------------------------------------------------------------------|
              |Authentification de l’étudiant (10 points)
              |---------------------------------------------------------------------------------------------------------|
             */
            $strMessageSaisieDA = "Composé de 7 chiffres";
            $erreur_01 = "DA invalide ou non reconnu !";
            $binvalider = parametre("btnValider");
            $binEtudiantAutentifie = false;
            if ($binvalider) {
                $binEtudiantAutentifie = authentifieEtudiant($BDProjet2, $strNomTable_pjr2_Etudiants, $strIDEtudiantSaisie);


                if (!$binEtudiantAutentifie) {
                    $strMessageSaisieDA = "<span class=\"sGras sRouge\">" . $erreur_01 . "</span>";
                }
            }


//ici jai un probleme " voir comment je peux autentifier seulement quand je click sur le button valider // cest regleee!!
////voir comment je peux faire pour que quand je valide, je puisse hide les divs et activer les autres... //cest reglee!!!!
            // $binDivVisible = false;
            ?>

            <?php
            if (!$binEtudiantAutentifie) {
                ?>
                <div id="divPresentation" class="">
                    <p class="sTitreSection">
                        Présentation
                    </p>
                    <p>
                        Le but de cette application est de permettre de créer les équipes pour un projet de fin d'étape.
                    </p>
                </div>

                <div id="divSaisieDA" class="">
                    <hr />
                    <p class="sTitreSection">
                        Identification
                    </p>
                    <table>
                        <tr>
                            <td>Entrez votre numéro de DA : </td>
                            <td>
                                <input id="tbDA" name="tbDA" type="text" class="sDA" maxlength="7" value="<?php echo $strIDEtudiantSaisie; ?>" autocomplete="off" />
                                <input id="btnValider" name="btnValider" type="submit" class="" value="Valider" />
                                <span class="sConsigne sGras"><?php echo $strMessageSaisieDA; ?></span>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php
            } else { //etudiant est autentifiee
                ?>
                <div id="divIdentification" class="">
                    <p class="sTitreSection">
                        Confirmation de l'identité
                    </p>
                    <p>
                        Bonjour <span class="sMembreEquipe"><?php echo $_SESSION["InfosEtudiant"][2]; ?></span> !
                    </p>
                    <p>
                        Selon nos dossiers
                        vous ne faites pas partie d'une équipe.

                    </p>
                </div>
                <div id="divEnEquipe" class="">
                    <hr />
                    <p class="sTitreSection">
                        Désirez-vous...
                    </p>
                    <p class="sTitreSousSection">
                        1. créer une équipe ?
                    </p>
                    <table>
                        <tr>
                            <td>Nom de l'équipe :</td>
                            <td>
                                <input id="tbNomEquipeCreer" name="tbNomEquipeCreer" type="text" maxlength="15" class="sNomEquipe" value="" autocomplete="off" />
                                <input id="Action" name="Action" type="submit" value="Créer" />
                                <span id="lblMessageCreer" class="sConsigne sGras">Composé de 5 à 15 caractères; Lettres minuscules et caractère de soulignement seulement; Débute par une lettre</span>
                            </td>
                        </tr>
                    </table>
                    <p class="sTitreSousSection">
                        2. joindre une équipe ?
                    </p>
                    <table>
                        <tr>
                            <td>Numéro du jeton :</td>
                            <td>
                                <input id="tbNoJetonJoindre" name="tbNoJetonJoindre" type="text" maxlength="5" class="sNoJeton" value="" autocomplete="off" />
                                <input id="Action" name="Action" type="submit" value="Joindre" />
                                <span id="lblMessageJoindre" class="sConsigne sGras">10000 à 99999; (visible présentement aux fins de la démonstration seulement)</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php
            }
            ?>



            <div id="divPiedPage">
                <hr />
                <p class="sDroits">
                    &copy; Département d'informatique G.-G.
                </p>
            </div>
        </form>
    </body>
</html>