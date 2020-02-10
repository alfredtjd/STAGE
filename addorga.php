<!DOCTYPE html>
<html>
    <!-- Aide : http://bl.ocks.org/ebrelsford/11295124 | https://leafletjs.com/examples/geojson/   | Leaflet Cookbook-->
    <head>
        <title>eMap 'Run - Add</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />       
        <link rel="stylesheet" href="./inc/css/style.css"/> <!-- html, body & #map -->
        <?php 
            include ("./inc/navbar.php"); 
            require('./inc/headjscss.php');
            if(!isset($_SESSION['id'])){
		// Redirection si pas connecté
			header('Location: index.php');
			exit;
		}
        ?>
        <style> #map{width: 70%;height: 94vh;z-index:1;float:left;}</style>
    </head>
    <body>
        <div id='map'> <script src="./inc/js/addorganisme.js"></script></div>
        <div class="gestion">
            <div class="box">
                <div class="inputDiv">
                    <input type="hidden" value="0" name="cpdeville" id="cpdeville">
                    <b><center>Ajouté un organisme</b> </center><br><br>
                    <b>Latitude</b>: <br>
                    <input type="text" id="latitude"> <br>
                    <b>Longitude</b>: <br>
                    <input type="text" id="longitude"> <br>
                    <b>Numero d'activité</b>: <br>
                    <input type="text" id="numero_activite"> <br>
                    <b>N° SIRET d'un organisme de formation</b>: <br>
                    <input type="text" id="siret_organisme_formation"> <br>
                    <b>Nom de l'organisme</b>: <br>
                    <input type="text" id="nom_organisme"> <br>
                    <b>La raison sociale de l'organisme</b>: <br>
                    <input type="text" id="raison_sociale"> <br>
                    <b>Ligne</b>: <br>
                    <input type="text" id="ligne"> <br>
                    <b>Adresse 1</b>: <br>
                    <input type="text" id="adr1"> <br>
                    <b>Adresse 2</b>: <br>
                    <input type="text" id="adr2"> <br>
                    <b>Adresse 3</b>: <br>
                    <input type="text" id="adr3"> <br>
                    <b>Téléphone fixe</b>: <br>
                    <input type="text" id="telfixe"> <br>
                    <b>Téléphone portable</b>: <br>
                    <input type="text" id="portable"> <br> 
                    <b>Fax</b>: <br>
                    <input type="text" id="fax"> <br> 
                    <b>Email de l'organisme</b>: <br>
                    <input type="text" id="courriel"> <br>
                    <b>URL de l'organisme</b>: <br>
                    <input type="text" id="urlweb"> <br>
                    <b>Ville</b>: <br>
                    <select class="select-orga" name="listeville" id="listeville"></select> <br> 
                    
                        
 
                    
                    
                    
                    <br>
                    <input type="button" value="Ajouter" id="btnSave" class="bouttonform button2">
                    <p id="status"></p>
                </div>
             </div>
        </div>
    </body>
</html>
