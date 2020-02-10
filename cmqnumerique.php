
<!DOCTYPE html>
<html>
    <!-- Aide : http://bl.ocks.org/ebrelsford/11295124 | https://leafletjs.com/examples/geojson/   | Leaflet Cookbook-->
    <head>
        <title>Map</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />       
        <link rel="stylesheet" href="./inc/css/style.css"/> <!-- html, body & #map -->
        <?php 
            include ("./inc/navbar.php"); 
            require('./inc/headjscss.php');
        ?>
        <style> #map{width: 100%;height: 94vh;z-index:1;}</style>
    </head>
    <body>
        <div id='map'></div>
        <script src="./inc/js/cmqnumerique.js"></script>	<!-- JS Map -->
    </body>
</html>
