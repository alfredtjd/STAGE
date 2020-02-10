<!DOCTYPE html>
<html>
    <!-- Aide : http://bl.ocks.org/ebrelsford/11295124 | https://leafletjs.com/examples/geojson/   | Leaflet Cookbook-->
    <head>
        <title>eMap 'Run - Admin</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" /> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <link rel="stylesheet" href="./inc/css/style.css"/> <!-- html, body & #map -->
        <script src="./inc/acompte.js"></script>
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
        <h2>Admin - Gestion des comptes</h2>
        <div class="well clearfix">
            <div id="msg"></div>
        </div>
         
        
         <div id="add_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal-title">Modification du Compte</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_add">
                    <input type="hidden" value="add" name="action" id="action">
                    <input type="hidden" value="0" name="compte_id" id="utilisateur_id">
                  <div class="form-group">
                        <label for="name" class="control-label">Email:</label>
                    <input type="text" class="form-control" id="identifiant" name="emailcompte"/>
                  </div>
                  <div class="form-group">
                    <label for="name" class="control-label">Nom:</label>
                    
                   
                    <input type="text" class="form-control" id="motdepasse" name="nom"/>
                  </div>
                  <div class="form-group">
                    <label for="salary" class="control-label">Compte activé :</label>
                    <input type="text" class="form-control" id="droit" name="capacite"/>
                    <select class="select-orga" name="listetype" id="listetype"></select>
                  </div>
                  <div class="form-group">
                    <label for="salary" class="control-label">Droit du compte:</label>
                    <input type="text" class="form-control" id="statut" name="niv_requis"/>
                    <select class="select-orga" name="listetype" id="listetype"></select>
                  </div>
                                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_fermer" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" id="btn_add" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    </div>
         
         
         
         

       
            <div class="listeorga">
                <table id="employee_grid" class="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                             <th>ID Compte</th>
                             <th>Email</th>
                             <th>Nom</th>
                             <th>Actif</th>
                             <th>Droit</th>
                             
                        </tr>
                    </thead>
                    <tbody id="emp_body">
                    </tbody>
                </table>
            </div>  
        </div>   

    </body>
</html>
