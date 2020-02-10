<?php



$params = $_REQUEST;
$action = isset($params['action']) && $params['action'] !='' ? $params['action'] : 'edit';
$id = isset($params['id']) && $params['id'] !='' ? htmlspecialchars($params['id']) : 0;
$dbconn = new ConnectToDb();
 
switch($action) {
    case 'olist':
        $dbconn->getOrganisme();
        break;
    case 'oget_organisme':
        $dbconn->getOrganimeInfoId($id);
        break;
    case 'oedit':
	$dbconn->updateOrganisme();
        break;
    case 'odelete':
	$dbconn->deleteOrganisme($id);
        break;
    case 'flist':
        $dbconn->get_formations();
        break;
    case 'flisttemp':
        $dbconn->get_formationstemp();
        break;
    case 'olisttemp':
        $dbconn->get_organismetemp();
        break;
    case 'clist':
        $dbconn->get_comptelist();
        break;
    case 'add':
        $dbconn->insertFormation();
        break;
    case 'fget_employee':
	$dbconn->getFormation($id);
        break;
    case 'get_compte':
	$dbconn->getcompte($id);
        break;
    case 'fdelete':
	$dbconn->deleteFormation($id);
        break;
    case 'fdeletetemp':
	$dbconn->deleteFormationTemp($id);
        break;
    case 'odeletetemp':
	$dbconn->deleteOrganismeTemp($id);
        break;
    case 'oktemp':
	$dbconn->OkFormationTemp($id);
        break;
    case 'oktempo':
	$dbconn->OkOrganismeTemp($id);
        break;
    case 'cdelete':
	$dbconn->deleteCompte($id);
        break;
    case 'fedit':
	$dbconn->updateFormation();
        break;
    case 'cedit':
	$dbconn->updateCompte();
        break;
    case 'deroullist':
	$dbconn->getDeroulList();
        break;
    case 'deroullisttype':
	$dbconn->getDeroulListType();
        break;
     case 'deroullistville':
	$dbconn->getDeroulListVille();
        break;
    case 'recherche':
        $search = isset($params['q']) && $params['q'] !='' ? htmlspecialchars($params['q']) : 0;
	$dbconn->getSearchResult($search);
        break;
    default:
    return;
}

//Connexion à la base de données 
class ConnectToDb {
        private $dbconn;
        protected $listOrganisme = array();
        //Fonction permettant la connexion à la base de données
        public function connect()
	{
		/*$host = "localhost";
		$username = "postgres";
		$mdp = "7894561230a";
                $db = "stage";
                $port = "5432";*/
                
                $servername = "localhost";
                $username = "postgres";
                $password = "7894561230Alfred";
                $db = "stage";
                $port = "5432";
                // Test connexion
                try{
                    $dbconn = new PDO("pgsql:host=$servername;dbname=$db", $username, $password); 
                    // set the PDO error mode to exception
                    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //echo "Connected successfully";    
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                //echo "<script>console.debug( \"PHP DEBUG: $port\" );</script>";
		return $dbconn;
	}
        
        //Permet l'ajout d'un organisme 
	public function addOrganismes($latitude, $longitude,$ligne, $adr1, $adr2,$adr3,$telfixe,$portable,$fax,$courriel,$urlweb,$numero_activite,$siret_organisme_formation,$nom_organisme,$raison_sociale)
	{
            // ORGANISME
            $dbconn =  $this->connect();
            $query_c = 'INSERT INTO coordonnees (latitude,longitude,ligne,adr1,adr2,adr3,telfixe,portable,fax,courriel,urlweb) VALUES (:latitude,:longitude,:ligne,:adr1,:adr2,:adr3,:telfixe,:portable,:fax,:courriel,:urlweb)';
            
            //Execute une requête préparée pour l'ajout d'un organisme
            //$tempinsert = pg_prepare($dbconn, "temp_orga",$query);  
            //$tempinsert = pg_execute($dbconn, "temp_orga", array(floatval($latitude), floatval($longitude),$adr1,$adr2)) or die("Impossible d'inserer l'organisme temporaire (en attente de vérification/confirmation)");
            
            $result_c = $dbconn->prepare($query_c);
            $result_c -> execute(array(
                'latitude' => $latitude,
                'longitude' => $longitude,
                'ligne' => $ligne,
                'adr1' => $adr1,
                'adr2' => $adr2,
                'adr3' => $adr3,
                'telfixe' => $telfixe,
                'portable' => $portable,
                'fax' => $fax,
                'courriel' => $courriel,
                'urlweb' => $urlweb
            ));
            //echo $lat.$lng.$name.$adr1.$adr2.$cpdeville.$telephone.$email.$intituleadresse;
            $coordonnee_app = intval($dbconn->lastInsertId());
            
            $query_o = 'INSERT INTO organisme (numero_activite,siret_organisme_formation,nom_organisme,raison_sociale,coordonnee_id) VALUES(:numero_activite,:siret_organisme_formation,:nom_organisme,:raison_sociale,:coordonnee_id)';
            $result_o = $dbconn->prepare($query_o);
            $result_o ->execute(array(
                'numero_activite' => $numero_activite,
                'siret_organisme_formation' => $siret_organisme_formation,
                'nom_organisme' => $nom_organisme,
                'raison_sociale' => $raison_sociale,
                'coordonnee_id' => $coordonnee_app
            ));
            if  (!$tempinsert) {
                 echo "<script>console.debug( \"PHP DEBUG: $tempinsert\" );</script>";
            }
            
           
            
            pg_close($dbconn);
	}
        //public function updateOrganismes( $id, $details, $latitude, $longitude, $telephone, $keywords)
	//{
		 
		  
	//}
        
        //Récupère la liste des formations 
        public function get_formations() {
            $dbconn =  $this->connect();
            $sql = "SELECT f.formation_id , f.libelle_f , f.type , f.capacite , f.niv_requis , f.modalite_spe_recrutement , f.organisme_id , organisme.libelle_o FROM formation_organisme f LEFT JOIN organisme ON organisme.organisme_id = f.organisme_id";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossible d'avoir la liste des formations");
            $data = pg_fetch_all($queryRecords);
            echo json_encode($data);
        }
        
        //Récupère la liste des formations temporaires
        public function get_formationstemp() {
            $dbconn =  $this->connect();
            $sql = "SELECT formation_id,code_formacode, code_nfs, code_rome, intitule_formation, objectif_formation FROM formation";
            $result = $dbconn->prepare($sql);
            $result ->execute();
            $data = $result->fetchAll();
            echo json_encode($data);
        }
        
        //Récupère la liste des organismes temporaires
        public function get_organismetemp() {
            $dbconn =  $this->connect();
            $sql = "SELECT organisme_id , numero_activite,siret_organisme_formation, nom_organisme, raison_sociale,statut, coordonnee_id FROM organisme";
            $result = $dbconn->prepare($sql);
            $result ->execute();
            $data = $result->fetchAll();
            echo json_encode($data);
        }
        
        //Récupère la liste des comptes
         public function get_comptelist() {
            $dbconn =  $this->connect();
            $sql = "SELECT utilisateur_id , identifiant , droit, statut FROM utilisateur";
            $result = $dbconn->prepare($sql);
            $result -> execute();
            $data = $result ->fetchAll();
            echo json_encode($data);
        }
        
        //Récupère la liste des organismes  
        public function getOrganisme() {
            
                $dbconn =  $this->connect();
		$sql = 'SELECT * FROM organisme';
                $result = $dbconn->prepare($sql);
                $result ->execute();
                $data = $result->fetchAll();
                echo json_encode($data);
                pg_close($dbconn);
		//return $listOrganisme;
	}
        
        //Permet de supprimer une formation
        public function deleteFormation($id) {
            $dbconn =  $this->connect();
            $sql = "Delete FROM formation_organisme Where formation_id='$id'";
            
            //Execute une requête préparée pour la suppression d'une formation
            $result = pg_prepare($dbconn, "deleteFormation",$sql);  
            $result = pg_execute($dbconn, "deleteFormation", array()) or die("Impossible de supprimer la formation ");
            //$queryRecords = pg_query($dbconn, $sql) or die("Impossibles de supprimé la formation");
            
            //Test de suppression de formation
            if($result) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        
        //Permet de supprimer une formation temporaire
        public function deleteFormationTemp($id) {
            $dbconn =  $this->connect();
            $sql = "Delete FROM formation Where formation_id='$id'";
            $result = $dbconn->prepare($sql);
            $result ->execute();
            //Execute une requête preparée pour la suppression d'une formation temporaire
            //$result = pg_prepare($dbconn, "deleteFormationTemp",$sql);  
            //$result = pg_execute($dbconn, "deleteFormationTemp", array()) or die("Impossible de supprimer la formation temporaire");
            //$queryRecords = pg_query($dbconn, $sql) or die("Impossibles de supprimé la formation temporaire");
            
            //Test de suppression de formation temporaire
            if($result) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        
        //Permet de supprimer un organisme temporaire
        public function deleteOrganismeTemp($id) {
            $dbconn =  $this->connect();
            $sql = "Delete FROM organisme Where organisme_id='$id'";
            $result = $dbconn->prepare($sql);
            $result ->execute();
            //Execute une requête préparée pour la suppression d'un organisme temporaire
            //$result = pg_prepare($dbconn, "deleteOrganismeTemp",$sql);  
            //$result = pg_execute($dbconn, "deleteOrganismeTemp", array()) or die("Impossible de supprimer l'organisme temporaire");
            //$queryRecords = pg_query($dbconn, $sql) or die("Impossibles de supprimé l'organisme temporaire");
            
            //Test de suppression d'organisme temporaire
            if($result) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        
        //Permet de confirmer une formation temporaire
        public function OkFormationTemp($id) {
            $dbconn =  $this->connect();
            $sql = "UPDATE formation SET formation_id='$id' WHERE formation_id='$id'";
            
            //Execute une requête préparée pour la confirmation d'une formation temporaire
            $result = $dbconn->prepare($sql);
            $result ->execute();
            //$result = pg_prepare($dbconn, "OkFormationTemp",$sql);  
            //$result = pg_execute($dbconn, "OkFormationTemp", array()) or die("Impossible de confirmer la formation temporaire");
            //$queryRecords = pg_query($dbconn, $sql) or die("Impossibles de confirmer la formation temporaire");
            
            //Test de confirmation de formation temporaire
            if($result) {
                    echo true;
            } else {
                    echo false;
            }
            //pg_close($dbconn);
        }
        
        //Permet de confirmer un organisme temporaire
        public function OkOrganismeTemp($id) {
            $dbconn =  $this->connect();
            $sql = "UPDATE temp_organismes SET temp_id='$id' WHERE temp_id='$id'";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossibles de confirmer l'organisation temporaire");
            
            //Test de confirmation d'un organisme temporaire
            if($queryRecords) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        
        //Permet la suppression d'un compte
        public function deleteCompte($id) {
            $dbconn =  $this->connect();
            $sql = "Delete FROM utilisateur Where utilisateur_id='$id'";
            
            //Execute une requête préparée pour la suppression d'un compte
            $result = $dbconn->prepare($sql);
            $result -> execute();
            if($result) {
                    echo true;
            } else {
                    echo false;
            }
            $dbconn = null;
        }
        
        //Permet la modification d'une formation 
        public function updateFormation() {
            $dbconn =  $this->connect();
		$data = $resp = array();
		$resp['status'] = false;
                
                //Collecte de données pour le formulaire de formation pour modification
		$libelle_f = $data['libelle_f'] = htmlspecialchars($_POST["libelle_f"]);
		$type = $data['type'] = htmlspecialchars($_POST["type"]);
		$capacite = $data['capacite'] = htmlspecialchars($_POST["capacite"]);
                $niv_requis = $data['niv_requis'] = htmlspecialchars($_POST["niv_requis"]);
                $modalite_spe_recrutement = $data['modalite_spe_recrutement'] = htmlspecialchars($_POST["modalite_spe_recrutement"]);
                $organisme_id = $data['organisme_id'] = htmlspecialchars($_POST["organisme_id"]);
		$forma_id = $data['formation_id'] = htmlspecialchars($_POST["formation_id"]);
		
                $sql = "UPDATE formation_organisme SET libelle_f = '$libelle_f', type = '$type' , capacite = '$capacite' , niv_requis ='$niv_requis' , modalite_spe_recrutement = '$modalite_spe_recrutement' , organisme_id = '$organisme_id' WHERE formation_id = '$forma_id'";
		
                //Execute une requête préparée pour modifier une formation
                $result = pg_prepare($dbconn, "updateFormation",$sql);  
                $result = pg_execute($dbconn, "updateFormation", array()) or die("Impossible de modifier les informations de la formation");
                //pg_query($dbconn, $sql) or die("Impossible de mettre à jour la formation");
                
        $resp['status'] = true;
        $resp['Record'] = $data;
        echo json_encode($resp);  // send data as json format*/
		
	}
        
        //Permet la modification d'un compte 
        public function updateCompte() {
            $dbconn =  $this->connect();
		$data = $resp = array();
		$resp['status'] = false;
                
                //Collecte de données pour le formulaire de compte pour modification
		$email = $data['identifiant'] = htmlspecialchars($_POST["emailcompte"]);
		$nom = $data['motdepasse'] = htmlspecialchars($_POST["nom"]);
		$capacite = $data['droit'] = htmlspecialchars($_POST["capacite"]);
                $niv_requis = $data['statut'] = htmlspecialchars($_POST["niv_requis"]);
		$compte_id = $data['utilisateur_id'] = htmlspecialchars($_POST["compte_id"]);
		
                $sql = "UPDATE utilisateur SET identifiant = '$email', motdepasse = '$nom' , droit = '$capacite' , statut ='$niv_requis' WHERE utilisateur_id = '$compte_id'";
                
                //Execute une requête préparée pour modifier un compte
                $result = $dbconn->prepare($sql);
                $result -> execute(array(':identifiant' => $email , ':motdepasse' => $nom , 'droit' => $capacite , 'statut' => $niv_requis));
                //$result = pg_prepare($dbconn, "updateCompte",$sql);  
                //$result = pg_execute($dbconn, "updateCompte", array()) or die("Impossible de modifier les informations du compte");
                //pg_query($dbconn, $sql) or die("Impossible de mettre à jour la formation")
                
        $resp['status'] = true;
        $resp['Record'] = $data;
        echo json_encode($resp);  // send data as json format*/
		
	}
        
        //Récupère une formation 
        public function getFormation($id) {
            $dbconn =  $this->connect();
            $sql = "SELECT f.formation_id , f.libelle_f , f.type , f.capacite , f.niv_requis , f.modalite_spe_recrutement , f.organisme_id FROM formation_organisme f WHERE f.formation_id = $1";
            $data = pg_fetch_object($result);
            echo json_encode($data);
        }
        
        //Récupère un compte
        public function getcompte($id) {
            $dbconn =  $this->connect();
            $sql = "SELECT utilisateur_id , identifiant , droit , statut FROM utilisateur WHERE utilisateur_id = $1";
            $result = $dbconn ->prepare($sql);
            $result -> execute(array($id));
            $data = $result -> fetch(PDO::FETCH_OBJ);
            echo json_encode($data);
        }
        
        //Permet l'ajout d'une formation
        public function insertFormation() {
           $dbconn =  $this->connect();
              $data = $resp = array();
              $resp['status'] = false;
              
            //Collecte de données pour le formulaire de formation pour ajout
            $data['code_formacode'] = htmlspecialchars(filter_input(INPUT_POST, 'code_formacode'));
            $data['code_nfs'] = htmlspecialchars(filter_input(INPUT_POST, 'code_nfs'));
            $data['code_rome'] = htmlspecialchars(filter_input(INPUT_POST, 'code_rome'));
            $data['intitule_formation'] = htmlspecialchars(filter_input(INPUT_POST, 'intitule_formation'));
            $data['objectif_formation'] = htmlspecialchars(filter_input(INPUT_POST, 'objectif_formation'));
            $data['resultats_attendus'] = htmlspecialchars(filter_input(INPUT_POST, 'resultats_attendus'));
            $data['contenu_formation'] = htmlspecialchars(filter_input(INPUT_POST, 'contenu_formation'));
            //$data['certifiante'] = htmlspecialchars(filter_input(INPUT_POST, 'certifiante'));
            $data['parcours_de_formation'] = htmlspecialchars(filter_input(INPUT_POST, 'parcours_de_formation'));
            $data['code_niveau_entree'] = htmlspecialchars(filter_input(INPUT_POST, 'code_niveau_entree'));
            $data['code_niveau_sortie'] = htmlspecialchars(filter_input(INPUT_POST, 'code_niveau_sortie'));
            //$data['statut'] = htmlspecialchars(filter_input(INPUT_POST, 'statut'));
            
            
            $query_f = 'INSERT INTO formation (code_formacode, code_nfs, code_rome, intitule_formation, objectif_formation, resultats_attendus, contenu_formation, parcours_de_formation, code_niveau_entree, code_niveau_sortie) VALUES (:code_formacode, :code_nfs, :code_rome, :intitule_formation, :objectif_formation, :resultats_attendus, :contenu_formation, :parcours_de_formation, :code_niveau_entree, :code_niveau_sortie) ';
            $result_f = $dbconn->prepare($query_f);
            $result_f-> execute(array(
                'code_formacode' => $data['code_formacode'],
                'code_nfs' => $data['code_nfs'],
                'code_rome' => $data['code_rome'],
                'intitule_formation' =>  $data['intitule_formation'],
                'objectif_formation' => $data['objectif_formation'],
                'resultats_attendus' => $data['resultats_attendus'],
                'contenu_formation' => $data['contenu_formation'],
                'parcours_de_formation' => $data['parcours_de_formation'],
                'code_niveau_entree' => $data['code_niveau_entree'],
                'code_niveau_sortie' => $data['code_niveau_sortie']
            ));    
                      
            //Execute une requête préparée pour l'ajout d'une formation
            //$tempinsert = pg_prepare($dbconn, "temp_forma",$query);  
            //$tempinsert = pg_execute($dbconn, "temp_forma", array($data['libelle_f'],$data['type'], intval($data['capacite']),$data['niv_requis'],$data['modalite_spe_recrutement'], intval($data['organisme_id']))) or die("Impossible d'inserer la formation temporaire (en attente de vérification/confirmation)");
              
            //pg_insert($dbconn, 'formation_organisme' , $data) or die("Impossible d'inserer une nouvelle formation");

              $resp['status'] = true;
              $resp['Record'] = $data;
              echo json_encode($resp);  // send data as json format*/

          }
        // Permet la suppresion d'un organisme ( à corriger ne marche pas )
        public function deleteOrganisme($id) {
            $dbconn =  $this->connect();
            // Sup tout les formations liés
            $deleteformation = "DELETE FROM formation_organisme WHERE organisme_id = '$id'";
            pg_query($dbconn, $deleteformation) or die('Impossible effacé forma ');  
            // Sup tout les emails liés
            $deleteemail = "DELETE FROM mail WHERE organisme_id = '$id'";
            pg_query($dbconn, $deleteemail) or die('Impossible effacé email '); 
            
            // Recup donnée des id à sup
            $selectid = "SELECT o.organisme_id, adr.adresse_id FROM organisme o LEFT JOIN adresse adr ON o.organisme_id = adr.organisme_id WHERE o.organisme_id = '$id'";
            $queryRecords = pg_query($dbconn, $selectid) or die('query error');          
            $donneeid = array();
            while ($row = pg_fetch_row($queryRecords)) {
                $donneeid["organisme_id"] = $row[1];
                $donneeid["adresse_id"] = $row[1];
                $donneeid["ville_id"] = $row[1];
                $donneeid["cp_id"] = $row[1];
            }
            
            
            $adresse_id = $donneeid["adresse_id"];
            
            //sup téléphone
            $deletetel = "DELETE FROM adresse_telephone WHERE adresse_id = '$id'";
            pg_query($dbconn, $deletetel) or die('Impossible effacé tel '); 
            
             // Sup adresse
            $adresse_id = $donneeid["adresse_id"];
            $deleteadresse= "DELETE FROM adresse WHERE adresse_id = '$id'";
            pg_query($dbconn, $deleteadresse) or die('Impossible effacé adresse '); 
            

            
            // Sup Orga
            
            $orga_id = $donneeid["organisme_id"];
            $deleteorga = "DELETE FROM organisme WHERE organisme_id = '$id'";
            pg_query($dbconn, $deleteorga) or die('Impossible effacé orga '); 
           
            
            

            pg_close($dbconn);
        }
        
        //Récupère les informations concernant les organismes ( à corriger ne marche pas)
        public function getOrganimeInfoId($idorganisme)
	{
            $dbconn =  $this->connect();
            $query = "SELECT o.organisme_id, o.libelle_o, adr.adresse_id,adr.rue1,adr.rue2,adr.lat,adr.lng,v.ville_id,v.libelleville,cp.cp_id, cp.libellecp, em.mail,em.mail_id , tel.telephone,tel.telephone_id FROM organisme o RIGHT JOIN mail em ON o.organisme_id = em.organisme_id RIGHT JOIN telephone tel ON o.organisme_id = tel.organisme_id LEFT JOIN adresse adr ON o.organisme_id = adr.organisme_id LEFT JOIN ville v ON adr.adresse_id = v.adresse_id LEFT JOIN cpdeville cpdv ON v.ville_id = cpdv.ville_id LEFT JOIN codepostal cp ON cpdv.cp_id = cp.cp_id WHERE o.organisme_id = '$idorganisme'";
            $queryRecords = pg_query($dbconn, $query) or die("Impossible d'avoir les informations de cette organisme");
            $listOrganisme = pg_fetch_all($queryRecords);
            pg_close($dbconn);
            echo json_encode($listOrganisme);
	}
        
        // Permet la modification d'un organisme ( à corriger ne marche pas )
	public function updateOrganisme() {
            
                
		$data = $resp = array();
		$resp['status'] = false;
                
                //Collecte des id's pour le formulaire d'organisme pour modification
                $organisme_id = $data['organisme_id'] = filter_input(INPUT_POST, 'organisme_id');
                $cp_id = $data['cp_id'] = filter_input(INPUT_POST, 'cp_id');
                $adresse_id = $data['adresse_id'] = filter_input(INPUT_POST, 'adresse_id');
                $villeid = $data['ville_id'] = filter_input(INPUT_POST, 'ville_id');
                
                
                
              
                
                //Collecte de données pour le formulaire d'organisme pour modification
		$libelle_o = $data['libelle_o'] = filter_input(INPUT_POST, 'organisme_libelle');
		$libelleville = $data['libelleville'] = filter_input(INPUT_POST, 'o_libelleville');
		$cp = $data["libellecp"] = filter_input(INPUT_POST, 'o_libellecp');
                
                $rue1 = $data['rue1'] = filter_input(INPUT_POST, 'o_rue1');
                $rue2 = $data['rue2'] = filter_input(INPUT_POST, 'o_rue2');
                $lat = $data['lat'] = filter_input(INPUT_POST, 'o_lat');
                $lng = $data['lng'] = filter_input(INPUT_POST, 'o_lng');
                
                $tel = $data['telephone'] = filter_input(INPUT_POST, 'o_tel');
                $email = $data['mail'] = filter_input(INPUT_POST, 'o_email');
		
               
                
                $sql ="UPDATE codepostal SET libellecp = '$cp' WHERE cp_id = '$cp_id';";
                $sql .="UPDATE ville SET libelleville = '$libelleville' WHERE ville_id = '$villeid';";
                $sql .="UPDATE organisme SET libelle_o = '$libelle_o' WHERE organisme_id ='$organisme_id';";
                $sql .="UPDATE adresse SET rue1 = '$rue1', rue2 = '$rue2', lat = '$lat' , lng = '$lng' WHERE adresse_id = '$adresse_id';";
                $sql .="UPDATE mail SET mail = '$email' WHERE organisme_id = '$organisme_id';";
                $sql .="UPDATE telephone SET telephone = '$tel' WHERE organisme_id = '$organisme_id';";
		
		//$result = pg_update($this->conn, 'employee' , $data, array('id' => $data['id'])) or die("error to insert employee data");
                $dbconn =  $this->connect();
                
                
		pg_query($dbconn, $sql) or die("Impossible d'effecuté la mise à jour de l'organisme");

                pg_close($dbconn);
                $resp['status'] = true;
                $resp['Record'] = $data;
                echo json_encode($resp);  // send data as json format*/

	}
        
        //Récupère la liste des formations afin de l'afficher sur la carte
        public function getFormationsList()
	{
            $dbconn =  $this->connect();
            $query = "SELECT o.organisme_id, o.libelle_o, adr.rue1 , adr.rue2 , adr.lat , adr.lng, fo.libelle_f , fo.capacite, fo.niv_requis,fo.type,fo.modalite_spe_recrutement , cp.cp_id , v.libelleville FROM formation_organisme fo RIGHT JOIN organisme o ON o.organisme_id = fo.organisme_id LEFT JOIN adresse adr ON o.organisme_id = adr.organisme_id LEFT JOIN cpdeville cp ON cp.cpdeville_id = adr.cpdeville LEFT JOIN ville v ON v.ville_id = cp.ville_id";

            $result = pg_query($dbconn, $query) or die("Impossible d'avoir la liste des formations");
            
            //Remplis les différents champs lié à la formation à l'aide d'un tableau
            $city = array();

            $citiesArray = array();

            while ($row = pg_fetch_row($result)) {
                $city["libelle_o"] = $row[1];
                $city["rue1"] = $row[2];
                $city["rue2"] = $row[3];
                $city["lat"] = $row[4];
                $city["lng"] = $row[5];
                $city["libelle_f"] = $row[6];
                $city["capacite"] = $row[7];
                $city["niv_requis"] = $row[8];
                $city["type"] = $row[9];
                $city["modalite_spe_recrutement"] = $row[10];
                $city["libellecp"] = $row[11];               
                $city["libelleville"] = $row[12];
                
                
                    

                
                
                
                
                
                array_push($citiesArray, $city);
            }
            pg_close($dbconn);
            
            return json_encode($citiesArray, JSON_UNESCAPED_UNICODE);
	}
        
        //Récupère les organismes dans une liste déroulante pour le formulaire de formation
        public function getDeroulList(){          
            if(isset($_GET['go'])) {  
               
                $dbconn =  $this->connect();
                $queryoranisme = "SELECT * FROM organisme ORDER BY libelle_o ASC";
                $queryRecords = pg_query($dbconn, $queryoranisme) or die("error to fetch employees data");
                $data = pg_fetch_all($queryRecords);
                echo json_encode($data);

            }
        }
        
        //Récupère les villes et code postaux dans une liste déroulante pour le formulaire d'ajout d'organismes
        public function getDeroulListVille(){          
            if(isset($_GET['villes'])) {   // requête qui récupère les localités un
               
                $dbconn =  $this->connect();
                $queryoranisme = "SELECT c.cpdeville_id , c.cp_id , v.libelleville FROM cpdeville c LEFT JOIN ville v ON v.ville_id = c.ville_id ORDER BY v.libelleville ASC";
                $queryRecords = pg_query($dbconn, $queryoranisme) or die("Impossible d'avoir la liste des villes");
                $data = pg_fetch_all($queryRecords);
                echo json_encode($data);

            }
        }
        
        //Récupère les types de formations dans une liste déroulante pour le formulaire de formation
        public function getDeroulListType(){          
            if(isset($_GET['types'])) {   // requête qui récupère les localités un
               
                $dbconn =  $this->connect();
                $queryoranisme = "SELECT DISTINCT type FROM formation_organisme ORDER BY type ASC";
                $queryRecords = pg_query($dbconn, $queryoranisme) or die("Impossible d'avoir la liste des types formations");
                $data = pg_fetch_all($queryRecords);
                echo json_encode($data);

            }
        }
        
        //Récupère les formations via une barre de recherche 
        public function getSearchResult($search){  
            
            function searchInit($text)	//search initial text in titles
            {
                    //$reg = '/'.$_GET['q'].'/';	//initial case insensitive searching
                     //$reg = '/''/';	//initial case insensitive searching
                    return preg_match('/'.$_GET['q'].'/', $text['title']);
            }
            if(!isset($_GET['q']) or empty($_GET['q']))
            {
                die( json_encode(array('ok'=>0, 'errmsg'=>'Erreur lors de la recherche !') ) );
            } else {
                $searcharray = array();
                $AllSearch = array();
                $dbconn =  $this->connect();
                $queryoranisme = "SELECT lat , lng , libelle_f ,libelleville libelleville FROM formation_organisme fo RIGHT JOIN organisme o ON o.organisme_id = fo.organisme_id LEFT JOIN adresse addr ON addr.organisme_id = o.organisme_id LEFT JOIN ville v ON v.adresse_id = addr.adresse_id";         
                $queryRecords = pg_query($dbconn, $queryoranisme) or die("Impossible d'effectué la recherche");
                //$data = pg_fetch_all($queryRecords);
                while ($row = pg_fetch_row($queryRecords)) {
                    $searcharray["loc"] = [$row[0],$row[1]];                

                    $searcharray["title"] = $row[2]." <b>".$row[3]."</b>"; 
                    //echo $searcharray["title"];
                    array_push($AllSearch, $searcharray);
                }
                $fdata = array_filter($AllSearch, 'searchInit');	//filter data
                $fdata = array_values($fdata);	//reset $fdata indexs
                echo json_encode($fdata);
            }
        }
}

// = new ConnectToDb();