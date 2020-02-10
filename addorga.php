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
        <style> #map{width: 70%;height: 160vh;z-index:1;float:left;}</style>
    </head>
    <body>
        <div id='map'> <script src="./inc/js/addorganisme.js"></script></div>
        <div class="gestion">
              <div class="box">
                <div class="inputDiv"> 
       
                    <input type="hidden" value="0" name="cpdeville" id="cpdeville">
                   
                    <strong><center>Ajouter un organisme</strong> </center><br>
                        <br>
                    <strong><center>Coordonnées de L'organisme</center></strong>
                    <div class='box1'>
                        <strong>Latitude</strong>: <br>
                        <input type="text" id="latitude" name="Latitude" placeholder="Latitude" required=""> <br>
                        <strong>Longitude</strong>: <br>
                        <input type="text" id="longitude" name="Longitude" placeholder="Longitude" required=""> <br>
                        <strong>Numero d'activité</strong>: <br>
                        <input type="text" id="numero_activite" name="Numero activité" placeholder="Numero activité" > <br>
                        <strong>N° SIRET d'un organisme de formation</strong>: <br>
                        <input type="text" id="siret_organisme_formation" name="Siret d'un Organisme de Formation" placeholder="Siret d'un Organisme de Formation"  > <br>
                        <strong>Nom de l'organisme</strong>: <br>
                        <input type="text" id="nom_organisme" name="Nom de l'organisme" placeholder="Nom de l'organisme" required=""> <br>
                        <strong>La raison sociale de l'organisme</strong>: <br>
                        <input type="text" id="raison_sociale" name="La raison sociale de l'organisme" placeholder="La raison sociale de l'organisme"> <br>
                    </div>
                    
                    <strong><center>Coordonnées de L'utilisateur</center></strong>
                    
                    <div class="separation">
                        <strong> Ligne(Lieu dit)</strong>
                        <input type="text" id="ligne" name="Ligne(Lieu dit)" placeholder="Ligne(Lieu dit)"> <br>
                        <strong>Adresse 1</strong>: <br>
                        <input type="text" id="adr1" name="Adresse 1" placeholder="Adresse 1" required=""><br>
                        <strong>Adresse 2</strong>: <br>
                        <input type="text" id="adr2" name="Adresse 2" placeholder="Adresse 2"><br>
                        <strong>Adresse 3</strong>: <br>
                        <input type="text" id="adr3" name="Adresse 3" placeholder="Adresse 3"><br>
                        <strong>Téléphone fixe</strong>: <br>
                        <input type="text" id="telfixe" name="Téléphone fixe" placeholder="Téléphone fixe" required=""> <br>
                        <strong>Téléphone portable</strong>: <br>
                        <input type="text" id="portable" name="Téléphone portable" placeholder="Téléphone portable" required=""> <br> 
                        <strong>Fax</strong>: <br>
                        <input type="text" id="fax" name="Fax" placeholder="Fax"> <br> 
                        <strong>Email de l'organisme</strong>: <br>
                        <input type="email" id="courriel" name="Email de l'organisme" size="50e" placeholder="Email de l'organisme" required=""> <br>
                        <strong>URL de l'organisme</strong>: <br>
                        <input type="text" id="urlweb" name="URL de l'organisme" placeholder="URL de l'organisme"><br>
                        <strong>Ville</strong>: <br>
                        <select class="select-orga" name="listeville" id="listeville"></select> <br> 
                    </div>
                                        
 
                    
                    
                    
                    <br>
                    <input type="button" value="Ajouter" id="btnSave" class="bouttonform button2">
                    <p id="status"></p>
                </div>
             </div>
        </div>
    </body>
</html>
