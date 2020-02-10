<?php

 require_once("./inc/fonction.php");
 $formation = $dbconn->getFormationsList();
 
 echo $formation;
 
?>

