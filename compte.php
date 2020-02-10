<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Accueil | BTS SIO 1</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="./inc/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<?php include ("./inc/navbar.php");
		  include ('./inc/fonction.php');
                  require('./inc/headjscss.php');
		  if(!isset($_SESSION['id'])){
			// Redirection si pas connecté
			header('Location: log.php');
			exit;
		  }
    ?>
	
  </head>
  
  
  <body>  
   
    <!-------------------------------------------------------------------------------------------------------------------------------------------------------------- -->    
    <div class="t-page">
    <!-------------------------------------------------------------------------------------------------------------------------------------------------------------- -->      
    
      
    <!---------------------------------------------------------------------------ACCUEIL------------------------------------------------------------------------- -->    
    <div class="container">
		<div class="container-fluid">
			<a href="https://cdn.glitch.com/ce9915f4-ec74-4709-babf-71eb72708429%2FLogo%20LyceeNelsonslide.jpg?1551633637787">
				<img src="https://cdn.glitch.com/ce9915f4-ec74-4709-babf-71eb72708429%2FLogo%20LyceeNelsonslide.jpg?1551633637787" alt="banniere" width="700">
			</a>
			
				<h2>Mon compte - Modifier mes informations</h2>

				<?php
					$conn=  $dbconn->connect();
					
					//$compte = $conn->query('SELECT username from users WHERE username: "'.$_SESSION['username'].'"');
					//$donnees = $compte->fetch();
					$id = $_SESSION['id'];
					$sql = "SELECT * FROM coordonnees INNER JOIN utilisateur ON coordonnees.coordonnee_id = utilisateur.coordonnee_id WHERE utilisateur_id = '$id'"; 
                                        $result = $conn ->prepare($sql);
                                        $result -> execute();
                                        //$result = pg_query($conn, $sql) or die('query error');
                                        
					foreach ($result ->fetchAll() as $row) {
					}

					
					if(isset($_GET['pages']))
					{	
						if($_GET['pages'] == 'compte_update')
						{
							if(empty($_POST['motdepasse']))
							{
                                                                $identifiant = $_POST["identifiant"];
                                                                $nomupdate = $_POST["nom"];
                                                                $prenomupdate = $_POST["prenom"];
                                                                $civiliteupdate = $_POST["civilite"];
                                                                $ligneupdate = $_POST["ligne"];
                                                                $adr1update = $_POST["adr1"];
                                                                $adr2update = $_POST["adr2"];
                                                                $adr3update = $_POST["adr3"];
                                                                $portableupdate = $_POST["portable"];
                                                                
								$update = "UPDATE utilisateur SET identifiant = '$identifiant' WHERE utilisateur_id ='$id'";
                                                                $result = $conn ->prepare($update);
                                                                $result -> execute();
                                                                //$result = pg_query($conn, $update) or die('query error');
                                                                
                                                                
                                                                
								$update_cu = "UPDATE coordonnees SET nom = '$nomupdate', prenom = '$prenomupdate' , civilite = '$civiliteupdate' , ligne = '$ligneupdate',adr1 = '$adr1update', adr2 = '$adr2update',adr3 = '$adr3update',portable = '$portableupdate'";
                                                                $result_cu = $conn ->prepare($update_cu);
                                                                $result_cu -> execute();
								echo '<div class="alert alert-success" role="alert">
										Vos informations ont etaient mis à jour ( Sauf mot de passe ) ! Recharger la page !
									 </div>';
							}
							else
							{
								$identifiant = $_POST["identifiant"];
                                                                $nomupdate = $_POST["nom"];
                                                                $prenomupdate = $_POST["prenom"];
                                                                $civiliteupdate = $_POST["civilite"];
                                                                $ligneupdate = $_POST["ligne"];
                                                                $adr1update = $_POST["adr1"];
                                                                $adr2update = $_POST["adr2"];
                                                                $adr3update = $_POST["adr3"];
                                                                $portableupdate = $_POST["portable"];
                                                                $mdpupdate = $_POST["motdepasse"];
                                                                $hashedmdp = md5($mdpupdate);
                                                                
								$update = "UPDATE utilisateur SET identifiant = '$identifiant', motdepasse = '$hashedmdp' WHERE utilisateur_id ='$id'";							
                                                                $result = $conn ->prepare($update);
                                                                $result -> execute();
                                                                
                                                                $update_cu = "UPDATE coordonnees SET nom = '$nomupdate', prenom = '$prenomupdate' , civilite = '$civiliteupdate' , ligne = '$ligneupdate',adr1 = '$adr1update', adr2 = '$adr2update',adr3 = '$adr3update',portable = '$portableupdate'";
                                                                $result_cu = $conn ->prepare($update_cu);
                                                                $result_cu -> execute();
                                                                //$result = pg_query($conn, $update) or die('query error');
								
								echo '<div class="alert alert-success" role="alert">
										Vos informations ont etaient mis à jour ! Recharger la page !
									 </div>';
									 
							}
                                                        $_SESSION["identifiant"] = $_POST["identifiant"];
							$_SESSION["nom"] = $_POST["nom"];
                                                        $_SESSION["prenom"] = $_POST["prenom"];
							$_SESSION["civilite"] = $_POST["civilite"];
                                                        $_SESSION["ligne"] = $_POST["ligne"];
                                                        $_SESSION["adr1"] = $_POST["adr1"];
                                                        $_SESSION["adr2"] = $_POST["adr2"];
                                                        $_SESSION["adr3"] = $_POST["adr3"];
                                                        $_SESSION["portable"] = $_POST["portable"];
							
						}
					}
				
				?>
				<form class="form-horizontal" action="?pages=compte_update" method="post"> 
                                    
					<div class="form-group">
						<label class="control-label col-sm-2" for="nom">Nom :</label>
						<div class="col-sm-10">          
                                                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $row['nom'];  ?>">
						</div>
					</div>
                                        
                                        <div class="form-group">
						<label class="control-label col-sm-2" for="prenom">Prénom :</label>
						<div class="col-sm-10">          
                                                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $row['prenom'];  ?>">
						</div>
					</div>
                                    
                                        <div class="form-group">
						<label class="control-label col-sm-2" for="civilite">Civilité :</label>
						<div class="col-sm-10">          
                                                    <input type="text" class="form-control" id="civilite" name="civilite" value="<?php echo $row['civilite'];  ?>">
						</div>
					</div>
                                    
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="ligne">Ligne :</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="ligne" placeholder="Entrez votre ligne" name="ligne" value="<?php echo $row['ligne'];  ?>">
                                                        
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="adr1">Adresse n°1 :</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="adr1" placeholder="Entrez votre adresse n°1" name="adr1" value="<?php echo $row['adr1'];  ?>">
                                                        
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="adr2">Adresse n°2 :</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="adr2" placeholder="Entrez votre adresse n°2" name="adr2" value="<?php echo $row['adr2'];  ?>">
                                                        
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for=adr3"">Adresse n°3 :</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="adr3" placeholder="Entrez votre adresse n°3" name="adr3" value="<?php echo $row['adr3'];  ?>">
                                                        
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="portable">Portable :</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="portable" placeholder="Entrez votre portable" name="portable" value="<?php echo $row['portable'];  ?>">
                                                        
                                            </div>
                                        </div>
                                        <div class="form-group">
						<label class="control-label col-sm-2" for="identifiant">Identifiant :</label>
						<div class="col-sm-10">          
                                                    <input type="text" class="form-control" id="identifiant" name="identifiant" value="<?php echo $row['identifiant'];  ?>">
						</div>
					</div>
					
					
					
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="motdepasse">Mot de passe:</label>
						<div class="col-sm-10">          
							<input type="password" class="form-control" id="motdepasse" name="motdepasse" placeholder="Entrez votre nouveau mot de passe"> 
						</div>
					</div>
					
					<div class="form-group">        
					  <div class="col-sm-offset-2 col-sm-10">
						<button type="submit" name = 'Submit' class="btn btn-success">Modifier</button>
					  </div>
					</div>
				</form>
		</div>    
    </div>
     <!---------------------------------------------------------------------------NAVIGATION------------------------------------------------------------------------- -->    

        
        
        
  
          
          
          
          
          
          
          
          
          
          
          
          
          
          
        </div>
      </div>

    <!-------------------------------------------------------------------------------------------------------------------------------------------------------------- --> 
    </div> 
    <!-------------------------------------------------------------------------------------------------------------------------------------------------------------- -->    

    
    
  </body>
</html>
