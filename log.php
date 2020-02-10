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
        require('./inc/headjscss.php'); 
            if(isset($_SESSION['id'])){
            // Redirection si pas connecté
                header('Location: index.php');
		exit;
            }
            include ('./inc/fonction.php');
		
            $log_msg = '';
		
            if(isset($_GET['pages']))
            {	
		if($_GET['pages'] == 'login')
		{	
                    $conn=  $dbconn->connect();
                    $login_app = filter_input(INPUT_POST, 'identifiant');
                    $pass_app = filter_input(INPUT_POST, 'motdepasse');
						
                    if((!$login_app) || (!$pass_app)) {
			header("location:./log.php?pages=error"); 
                    } else {
			try{
                            $hashedmdp = md5($pass_app);
                            $sql = "SELECT utilisateur_id , identifiant ,motdepasse ,droit, statut FROM utilisateur WHERE identifiant = '$login_app' AND motdepasse = '$hashedmdp'";
                            $result = $conn ->prepare($sql);
                            $result -> execute();
                            //$result = pg_query($conn, $sql) or die('query error');
                                               
                            foreach ($result ->fetchAll() as $row) {
                            }
								
                            $count = $result -> rowCount();
                                                               
                                                                
                            if($count > 0)  
                            {  
                                if($row["statut"] == 0){
                                    header("location:./log.php?pages=noactivate"); 
                                }
                                else
                                {
                                    $_SESSION["id"] = $row["utilisateur_id"];
                                    $_SESSION["identifiant"] = $row["identifiant"];
                                    $_SESSION["droit"] = $row["droit"];  
                                    $_SESSION["statut"] = $row["statut"]; 
                                    header("location:./index.php");  
                                }
										
                            }  
                            else  
                            {  
                                header("location:./log.php?pages=error"); 
                            }  
                        }catch (Exception $e) {
                            echo 'Exception reçue : ', $e->getMessage(), "\n";
                        }
							
                    $conn = null;
                    }
                }else if($_GET['pages'] == 'error'){
                    $log_msg = 'Erreur de connexion ! Vérifiés vos identifiants !';
		}else if($_GET['pages'] == 'noactivate'){
                    $log_msg = 'Erreur de connexion ! Compte non activé !';
                }
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
	<h2>Login</h2>
	 <?php
		if($log_msg != ''){
                    echo '<div class="alert alert-info" role="alert">
                    ',$log_msg,'
                    </div>';
                    $log_msg = '';}
        ?>
            <form class="form-horizontal" action='?pages=login' method='post' accept-charset='UFT-8'>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="identifiant">Email:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="identifiant" placeholder="Enter email" name="identifiant">
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="motdepasse">Mot de passe:</label>
                    <div class="col-sm-10">          
                        <input type="password" class="form-control" id="motdepasse" placeholder="Entrez votre mot de passe" name="motdepasse">
                    </div>
                </div>
                <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label><input type="checkbox" name="remember"> Se souvenir de moi !</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name = 'Submit' class="btn btn-default">Login</button>
                    </div>
                </div>
            </form>		
        </div>    
    </div>
 
    </div>

    <!-------------------------------------------------------------------------------------------------------------------------------------------------------------- --> 

    
    
  </body>
</html>
