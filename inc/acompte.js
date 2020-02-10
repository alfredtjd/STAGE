$(document).ready(function(){
    function init() {
        get_comptes();
    }
    init();
    
   
    $( "#btn_add" ).click(function() {
        ajaxAction('add');
        
    });
    
    $( "#btn_fermer" ).click(function() {
        update_formulaire();
        
    });
        
        
         
        
   $(document).on('click', '.edit_data', function(){  
           var id = $(this).attr("id");
           console.log(id);
           $.ajax({  
                url:"./inc/fonction.php?action=get_compte&id="+id,  
                method:"GET", 
                dataType:"json",  
                success:function(data){ 
                     console.log(data); 
                        
                     $('#compte_id').val(data['utilisateur_id']);
                     $('#emailcompte').val(data['identifiant']);
                     $('#nom').val(data['motdepasse']);
                     $('#capacite').val(data['droit']);
                     $('#niv_requis').val(data['statut']);
 
                     
                     $('#modal-title').html("Modification du compte :");
                     $('#btn_add').html("Mettre à jour");
                     $('#action').val("cedit");  
                     $('#add_model').modal('show');  
                }  
           });  
      });
    
    $(document).on('click', '.delete_data', function(){  
            var id = $(this).attr("id");
            console.log('[Console : Suppression formations id : '+id);
            var conf = confirm('Vous êtes sur le point de supprimé ce compte , êtes vous en sûre ?');
            if(id > 0){
                $.post('./inc/fonction.php', { id: id, action : 'cdelete'}
                    , function(){
                        get_comptes();
                    }); 
            } 
        });
               
    function ajaxAction(action) {
		data = $("#frm_"+action).serializeArray();
                console.log(action);
		$.ajax({
                type: "POST",  
                url: "./inc/fonction.php",  
                data: data,
                dataType: "json",       
                success: function(response)  
                {
                        
                      $('#msg').html('');
                      if(response.status === true) {
                      $('#'+action+'_model').modal('hide');
                      $('#msg').html('<div class="alert alert-success">Opération effectué</div>');
                      get_comptes();
                      
                      
                      } else {
                      $('#msg').html('<div class="alert alert-danger ">Une erreur est survenue ! Veuillez contacter un administrateur !</div>');	
                      }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log($("#frm_"+action).serializeArray());
                $('#msg').html('<div class="alert alert-danger ">Erreur : '+textStatus+'!'+errorThrown);
                
                      }  
                  });
	}
        

        
	function get_comptes() {
		$.ajax({		
		type : 'GET',
		url  : './inc/fonction.php?action=clist',
		success : function(response){
		response = JSON.parse(response);
		var tr;
	      	$('#emp_body').html('');
	      	$.each(response, function( index, utilisateur ) {
	  tr = $('<tr/>');
	            tr.append("<td>" + utilisateur.utilisateur_id + "</td>");
	            tr.append("<td>" + utilisateur.identifiant + "</td>");
	            tr.append("<td>" + utilisateur.motdepasse + "</td>");
                    tr.append("<td>" + utilisateur.droit + "</td>");
                    tr.append("<td>" + utilisateur.statut + "</td>");
 
	            	var action = "<td><div class='btn-group' data-toggle='buttons'>";
                        action += "<a target='_blank' class='bouttonform button2 edit_data' id='"+utilisateur.utilisateur_id+"'>Modifier</a>";
	            	action += "<a target='_blank' class='bouttonform button3 delete_data' id='"+utilisateur.utilisateur_id+"'>Supprimer</a>";
	            tr.append(action);
	            $('#emp_body').append(tr);
		});
		}
		});
	}
        

	
});

