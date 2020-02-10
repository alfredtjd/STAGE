$(document).ready(function(){
    function init() {
        get_formations();
    }
    init();
    
    $(document).on('click', '.delete_data', function(){  
            var id = $(this).attr("id");
            console.log('[Console : Suppression formations id : '+id);
            var conf = confirm('Vous êtes sur le point de supprimé cette organisme , êtes vous en sûre ?');
            if(id > 0){
                $.post('./inc/fonction.php', { id: id, action : 'odeletetemp'}
                    , function(){
                        get_formations();
                        $('#msg').html('<div class="alert alert-success">Opération effectué</div>');
                    }); 
            } 
        });
        
    $(document).on('click', '.valide_data', function(){  
            var id = $(this).attr("id");
            console.log('[Console : Ajout formations temp id : '+id);
            var conf = confirm("Vous êtes sur le point d'ajouté cette organisme , êtes vous en sûre ?");
            if(id > 0){
                $.post('./inc/fonction.php', { id: id, action : 'oktempo'}
                    , function(){
                        get_formations();
                        $('#msg').html('<div class="alert alert-success">Opération effectué</div>');
                    }); 
            } 
        });
                  
	function get_formations() {
		$.ajax({		
		type : 'GET',
		url  : './inc/fonction.php?action=olisttemp',
		success : function(response){
		response = JSON.parse(response);
		var tr;
	      	$('#emp_body').html('');
	      	$.each(response, function( index, organisme ) {
	  tr = $('<tr/>');
	            tr.append("<td>" + organisme.organisme_id+ "</td>");
	            tr.append("<td>" + organisme.numero_activite + "</td>");
	            tr.append("<td>" + organisme.siret_organisme_formation + "</td>");
                    tr.append("<td>" + organisme.nom_organisme + "</td>");
                    tr.append("<td>" + organisme.raison_sociale +  " ("+organisme.cp_id+")</td>");
                    tr.append("<td>" + organisme.statut + "</td>");
                    tr.append("<td>" + organisme.coordonnee_id + "</td>");
                    tr.append("<td>" + organisme.telephone + "</td>");
                    
                    //
 
	            	var action = "<td><div class='btn-group' data-toggle='buttons'>";
                        action += "<a target='_blank' class='bouttonform button1 valide_data' id='"+organisme.organisme_id+"'>Confirmer</a>";
	            	action += "<a target='_blank' class='bouttonform button3 delete_data' id='"+organisme.organisme_id+"'>Supprimer</a>";
	            tr.append(action);
	            $('#emp_body').append(tr);
		});
		}
		});
	}
        

	
});

