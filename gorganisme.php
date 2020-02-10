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
        <script src="./inc/gestiono.js"></script>
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
        <h2>Gestion des Organismes - Listes</h2>
        <div class="mainbox">
            <div class="well clearfix">
                <div id="msg"></div>
            </div>
             
            <div class="listeorga">
                <table id="employee_grid" class="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                             <th>ID Organisme</th>
                             <th>Nom Organisme</th>
                             <th>Localisation</th>
                        </tr>
                    </thead>
                    <tbody id="emp_body">
                    </tbody>
                </table>
            </div>  
        </div>
        <div id="update_orga" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Modification de l'organisme</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="frm_edit">
                        <input type="hidden" value="edit" name="action" id="action">
                        
                        <!-- Valeur des ID -->
                        <input type="hidden" value="1" name="organisme_id" id="organisme_id">
                        <input type="hidden" value="1" name="cp_id" id="cp_id">
                        <input type="hidden" value="1" name="ville_id" id="ville_id">
                        <input type="hidden" value="1" name="adresse_id" id="adresse_id">
                        
                        <input type="hidden" value="1" name="tel_id" id="tel_id">
                        <input type="hidden" value="1" name="email_id" id="email_id">
                        <!-------------------- -->
                      <div class="form-group">
                        <label for="nom" class="control-label">Nom de l'organisme :</label>
                        <input type="text" class="form-control" id="organisme_libelle" name="organisme_libelle" />
                      </div>
                      <div class="form-group">
                        <label for="ville" class="control-label">Ville :</label>
                        <input type="text" class="form-control" id="o_libelleville" name="o_libelleville" value="Non renseigné" />
                      </div>
                      <div class="form-group">
                        <label for="cp" class="control-label">Code Postal:</label>
                        <input type="text" class="form-control" id="o_libellecp" name="o_libellecp" value="Non renseigné" />
                      </div>
                        
                        <div class="form-group">
                        <label for="rue1" class="control-label">Rue 1:</label>
                        <input type="text" class="form-control" id="o_rue1" name="o_rue1" value="Non renseigné" />
                      </div>
                        
                        <div class="form-group">
                        <label for="rue2" class="control-label">Rue 2:</label>
                        <input type="text" class="form-control" id="o_rue2" name="o_rue2" value="Non renseigné" />
                      </div>
                        
                        
                        <div class="form-group">
                        <label for="email" class="control-label">Email :</label>
                        <input type="text" class="form-control" id="o_email" name="o_email" value="Non renseigné" />
                      </div>
                        
                      <div class="form-group">
                        <label for="tel" class="control-label">Téléphone :</label>
                        <input type="text" class="form-control" id="o_tel" name="o_tel" value="Non renseigné" />
                      </div>
                        
                      <div class="form-group">
                        <label for="lon" class="control-label">Longitude :</label>
                        <input type="text" class="form-control" id="o_lng" name="o_lng" />
                      </div>
                        
                      
                        
                        <div class="form-group">
                        <label for="lat" class="control-label">Latitude:</label>
                        <input type="text" class="form-control" id="o_lat" name="o_lat" />
                      </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="button" id="btn_update" class="btn btn-primary action-btn" action-btn-value="edit" data-toggle="modal" data-target="#update_orga">Save</button>
                </div>
            </div>
       </div>
    </body>
</html>
