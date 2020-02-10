$(document).ready(function(){
    function init() {
        get_formations();
    }
    init();
    
    $(document).on('click', '.delete_data', function(){  
            var id = $(this).attr("id");
            console.log('[Console : Suppression formations id : '+id);
            var conf = confirm('Vous êtes sur le point de supprimé cette formation , êtes vous en sûre ?');
            if(id > 0){
                $.post('./inc/fonction.php', { id: id, action : 'fdeletetemp'}
                    , function(){
                        get_formations();
                        $('#msg').html('<div class="alert alert-success">Opération effectué</div>');
                    }); 
            } 
        });
        
    $(document).on('click', '.valide_data', function(){  
            var id = $(this).attr("id");
            console.log('[Console : Ajout formations temp id : '+id);
            var conf = confirm("Vous êtes sur le point d'ajouté cette formation , êtes vous en sûre ?");
            if(id > 0){
                $.post('./inc/fonction.php', { id: id, action : 'oktemp'}
                    , function(){
                        get_formations();
                        $('#msg').html('<div class="alert alert-success">Opération effectué</div>');
                    }); 
            } 
        });
                  
	function get_formations() {
		$.ajax({		
		type : 'GET',
		url  : './inc/fonction.php?action=flisttemp',
		success : function(response){
		response = JSON.parse(response);
		var tr;
	      	$('#emp_body').html('');
	      	$.each(response, function( index, formation ) {
	  tr = $('<tr/>');
	            tr.append("<td>" + formation.formation_id+ "</td>");
	            tr.append("<td>" + formation.code_formacode + "</td>");
	            tr.append("<td>" + formation.code_nfs + "</td>");
                    tr.append("<td>" + formation.code_rome + "</td>");
                    tr.append("<td>" + formation.intitule_formation + "</td>");
                    tr.append("<td>" + formation.objectif_formation + "</td>");
                    tr.append("<td>" + formation.libelle_o + "</td>");
                    tr.append("<td>" + formation.libelleville +  " ("+formation.cp_id+")</td>");
 
	            	var action = "<td><div class='btn-group' data-toggle='buttons'>";
                        action += "<a target='_blank' class='bouttonform button1 valide_data' id='"+formation.formation_id+"'>Confirmer</a>";
	            	action += "<a target='_blank' class='bouttonform button3 delete_data' id='"+formation.formation_id+"'>Supprimer</a>";
	            tr.append(action);
	            $('#emp_body').append(tr);
		});
		}
		});
	}
        

	
});

