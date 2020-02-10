<?php

error_reporting(0);

require_once('./inc/fonction.php');

$latitude = strip_tags(htmlspecialchars($_POST['platitude']));
$longitude = strip_tags(htmlspecialchars($_POST['plongitude']));
$numero_activite = strip_tags(htmlspecialchars($_POST['pnumero_activite']));
$siret_organisme_formation = strip_tags(htmlspecialchars($_POST['psiret_organisme_formation']));
$nom_organisme = strip_tags(htmlspecialchars($_POST['pnom_organisme']));
$raison_sociale = strip_tags(htmlspecialchars($_POST['praison_sociale']));
$ligne = strip_tags(htmlspecialchars($_POST['pligne']));
$adr1 = strip_tags(htmlspecialchars($_POST['padr1']));
$adr2 = strip_tags(htmlspecialchars($_POST['padr2']));
$adr3 = strip_tags(htmlspecialchars($_POST['padr3']));
$telfixe = strip_tags(htmlspecialchars($_POST['ptelfixe']));
$portable = strip_tags(htmlspecialchars($_POST['pportable']));
$fax = strip_tags(htmlspecialchars($_POST['pfax']));
$courriel = strip_tags(htmlspecialchars($_POST['pcourriel']));
$urlweb = strip_tags(htmlspecialchars($_POST['purlweb']));



$dbconn->addOrganismes($latitude, $longitude,$ligne, $adr1, $adr2,$adr3,$telfixe,$portable,$fax,$courriel,$urlweb,$numero_activite,$siret_organisme_formation,$nom_organisme,$raison_sociale)






?>

