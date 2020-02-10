<!DOCTYPE html>
<html>
    <!-- Aide : http://bl.ocks.org/ebrelsford/11295124 | https://leafletjs.com/examples/geojson/   | Leaflet Cookbook-->
    <head>
        <title>eMap 'Run - Add</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" /> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <link rel="stylesheet" href="./inc/css/style.css"/> <!-- html, body & #map -->
        <script src="./inc/agestionf.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="./inc/css/bootstarp.min.css">
        <script src="./inc/js/bootstrap.min.js"></script>      
        <?php 
            include ("./inc/navbar.php"); 
            if(!isset($_SESSION['id'])){
		// Redirection si pas connecté
			header('Location: index.php');
			exit;
		}
           
        ?>
        <style> #map{width: 70%;height: 94vh;z-index:1;float:left;}</style>
    </head>
    <body>
     <div class="mainbox">
        <h2>Gestion des Formations en attente - Listes</h2>
        <div class="well clearfix">
            <div id="msg"></div>
        </div>

            <div class="listeorga">
                <table id="employee_grid" class="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                             <th>Temp ID</th>
                             <th>Nom</th>
                             <th>Type</th>
                             <th>Câpacité d'accueil</th>
                             <th>Niveau requis</th>
                             <th>Modalité spécifique au recrutement</th>
                             <th>Organisme</th>
                             <th>Ville</th>
                             
                        </tr>
                    </thead>
                    <tbody id="emp_body">
                    </tbody>
                </table>
            </div>  
        </div>   

    </body>
</html>
