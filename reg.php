<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Compte | eMap'Run</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./inc/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <?php include ("./inc/navbar.php"); 
        require('./inc/headjscss.php'); 
	if(isset($_SESSION['id'])){
		// Redirection si pas connecté
			header('Location: index.php');
			exit;
		}
	include ('./inc/fonction.php');

        $conn=  $dbconn->connect();

	$login_app = filter_input(INPUT_POST, 'identifiant');
	$pass_app = filter_input(INPUT_POST, 'motdepasse');
        $civilite_app = filter_input(INPUT_POST, 'civilite');
        $nom_app = filter_input(INPUT_POST, 'nom');
	$prenom_app = filter_input(INPUT_POST, 'prenom');
        $ligne_app = filter_input(INPUT_POST, 'ligne');
	$adr1_app = filter_input(INPUT_POST, 'adr1');
        $adr2_app = filter_input(INPUT_POST, 'adr2');
        $adr3_app = filter_input(INPUT_POST, 'adr3');
	$portable_app = filter_input(INPUT_POST, 'portable');
        //$coordonnee_app = filter_input(INPUT_POST, 'coordonnee_id');
	$reg_msg = '';
		
		
        if(isset($_GET['pages']))
        {	
            if($_GET['pages'] == 'register')
            {	
                if((!$login_app) || (!$pass_app)) {
                    echo "<center><h1> champs non remplis</h1></center>";
                } else {
                    try{
                        // Vérification si email existe ou pass
                        $sql = "SELECT COUNT(identifiant) AS identifiant FROM utilisateur WHERE identifiant = '$login_app'";
                        $result = $conn ->prepare($sql);
                        $result -> execute();
                        //$result = pg_query($conn, $sql) or die('query error');                                      
                        $nbrcompte = array();
                        while ($row = $result ->fetch()) {
                            $nbrcompte["identifiant"] = $row[0];
                        }                                                                                               
                        if($nbrcompte["identifiant"] > 0){
                            header("location:./reg.php?pages=error_reg"); 
                        }
                        else{
                            // Création du compte
                            $optionshash = [
                                'cost' => 12,
                            ];
                            $hashedmdp = md5($pass_app);
                                                                            
                            $sql_c = "INSERT INTO coordonnees (civilite, nom, prenom, ligne, adr1, adr2, adr3, portable) VALUES (:civilite,:nom,:prenom,:ligne,:adr1,:adr2,:adr3,:portable)";
                            $result_c = $conn ->prepare($sql_c);
                            $result_c -> execute(array(
                                'civilite' => $civilite_app,
                                'nom' => $nom_app,
                                'prenom' => $prenom_app,
                                'ligne' => $ligne_app,
                                'adr1' => $adr1_app,
                                'adr2' => $adr2_app,
                                'adr3' => $adr3_app,
                                'portable' => $portable_app
                            ));
                            
                            $coordonnee_app = intval($conn->lastInsertId());
                            
                            $sql_u = "INSERT INTO utilisateur (identifiant, motdepasse,coordonnee_id) VALUES (:identifiant, :motdepasse,:coordonnee_id)";
                            $resulte = $conn ->prepare($sql_u);
                            $resulte -> execute(array(
                                'identifiant' => $login_app,
                                'motdepasse' => $hashedmdp,
                                'coordonnee_id' => $coordonnee_app
                            ));
                            //$queryRecords = pg_query($conn, $sql) or die("Création compte : Impossible (erreur requete)");
                            
                            
                            /*$sql_cu = "INSERT INTO utilisateur (coordonnee_id) SELECT coordonnees.coordonnee_id FROM coordonnees;";
                            $result_cu = $conn ->prepare($sql_cu);
                            $result_cu -> execute();*/
                            $reg_msg = "Votre compte à bien était crée ( En attente d'activation ! )";
			}
                    }catch (Exception $e) {
                        echo 'Exception reçue : ', $e->getMessage(), "\n";
                    }								
		}
            }else if($_GET['pages'] == 'error_reg')
            {
		$reg_msg = 'Erreur ! cette adresse mail est déja prise !';
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
	<h2>Création de votre compte</h2>
	<?php
            if($reg_msg != ''){
		echo '<div class="alert alert-info" role="alert">
			',$reg_msg,'
			</div>';
			$reg_msg = '';}
	?>
        
        
	<form class="was-validated" action="?pages=register" method='post'>


                <div class="form-group">
                    <label class="control-label col-sm-2" for="nom">Nom :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nom" placeholder="Entrez votre nom" name="nom"required="">
                                <div class="invalid-feedback">Please fill out this field</div>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-sm-2" for="prenom">Prénom :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="prenom" placeholder="Entrez votre prénom" name="prenom"required="">
                                <div class="invalid-feedback">Please fill out this field</div>
                    </div>
		</div>
            
                <div class="form-group">
                    <label class="control-label col-sm-2" for=civilite"">Civilité :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="civilite" placeholder="--" name="civilite"required="">
                                <div class="invalid-feedback">Please fill out this field</div>
                    </div>
		</div>
            
                <div class="form-group">
                    <label class="control-label col-sm-2" for="ligne">Ligne :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ligne" placeholder="Entrez votre ligne" name="ligne"required="">
                                <div class="invalid-feedback">Please fill out this field</div>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-sm-2" for="adr1">Adresse n°1 :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="adr1" placeholder="Entrez votre adresse n°1" name="adr1"required="">
                                <div class="invalid-feedback">Please fill out this field</div>
                    </div>
		</div>
            
                <div class="form-group">
                    <label class="control-label col-sm-2" for="adr2">Adresse n°2 :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="adr2" placeholder="Entrez votre adresse n°2" name="adr2"required="">
                                <div class="invalid-feedback">Please fill out this field</div>
                    </div>
		</div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for=adr3"">Adresse n°3 :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="adr3" placeholder="Entrez votre adresse n°3" name="adr3"required="">
                                <div class="invalid-feedback">Please fill out this field</div>
                    </div>
		</div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="portable">Portable :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="portable" placeholder="Entrez votre portable" name="portable"required="">
                                <div class="invalid-feedback">Please fill out this field</div>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-sm-2" for="identifiant">Identifiant :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="identifiant" placeholder="Entrez votre identifiant" name="identifiant"required="">
                                <div class="invalid-feedback">Please fill out this field</div>
                    </div>
		</div>
            
				
		<div class="form-group">
                    <label class="control-label col-sm-2" for="motdepasse">Mot de passe :</label>
                    <div class="col-sm-10">          
                        <input type="password" class="form-control" id="motdepasse" placeholder="Entrez votre mot de passe" name="motdepasse" required="">
                        <div class="invalid-feedback">Please fill out this field.</div>  
                          <div class="valid-feedback">Valid.</div>
                                <div class="form-group form-check">
                                <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember" required> I agree on blabla.
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Check this checkbox to continue.</div>
                    </div>
		</div>
            

            

		<div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-primary">Créer</button>
                    </div>
		</div>  
			  
	</form>
        </div>
      </div>    
    </div>
  </body>
</html>
