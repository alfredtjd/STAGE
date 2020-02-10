$(document).ready(function()
{

	//initialize method on load
 	function init() {
            get_organisme();
            
 	}
 	init();
        
        $( "#btn_update" ).click(function() {
            ajaxAction('add');
        });
        
        $(document).on('click', '.edit_data', function() /* Edition des données*/
        {  
            var id = $(this).attr("id");
            $('#modal-title').html("Modification de l'organisme");
            $.ajax({  
                url:"./inc/fonction.php?action=oget_organisme&id="+id,  
                method:"GET", 
                dataType:"json",  
                success:function(data){ 
                    
                    console.log(data); 
                    // Les ID's
                    $('#organisme_id').val(data['0']['organisme_id']);
                    $('#adresse_id').val(data['0']['adresse_id']);
                    $('#cp_id').val(data['0']['cp_id']);
                    $('#ville_id').val(data['0']['ville_id']);
                    $('#tel_id').val(data['0']['telephone_id']);
                    $('#email_id').val(data['0']['email_id']);
                    // Données
                    $('#organisme_libelle').val(data['0']['libelle_o']);
                    $('#o_libelleville').val(data['0']['libelleville']); 
                    $('#o_libellecp').val(data['0']['libellecp']);
                    
                    $('#o_rue1').val(data['0']['rue1']);
                    $('#o_rue2').val(data['0']['rue2']);
                    $('#o_lat').val(data['0']['lat']);
                    $('#o_lng').val(data['0']['lng']);
                    
                    $('#o_tel').val(data['0']['telephone']);
                    $('#o_email').val(data['0']['mail']);
           
                    
                    
                    // Divers
                    $('#btn_update').html("Mettre à jour");
                    $('#action').val("oedit");  
                    $('#update_orga').modal('show'); 

                   }  
                });  
        });
        
        function ajaxAction(action) {
		data = $("#frm_edit").serializeArray();
		$.ajax({
                type: "POST",  
                url: "./inc/fonction.php",  
                data: data,
                dataType: "json",       
                success: function(response)  
                {
                      console.log( $("#frm_edit").serializeArray() );
                      $('#msg').html('');
                      if(response.status === true) {
                      $('#'+action+'_model').modal('hide');
                      $('#msg').html('<div class="alert alert-success">Modification effectué !</div>');
                      get_organisme();
                      } else {
                      $('#msg').html('<div class="alert alert-danger ">Erreur !</div>');	
                      }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                $('#msg').html('<div class="alert alert-danger ">Error'+textStatus+'!'+errorThrown);
                console.log( $("#frm_edit").serializeArray() );
                      }  
                  });
	}
        
        $(document).on('click', '.delete_data', function(){  
            var id = $(this).attr("id");
            console.log('[Console : Suppression organisme id : '+id);
            var conf = confirm('Vous êtes sur le point de supprimé cette organisme , êtes vous en sûre ?');
            if(id > 0){
                $.post('./inc/fonction.php', { id: id, action : 'odelete'}
                    , function(){
                        get_organisme();
                    }); 
            } 
        });
        
        
        function get_organisme() {
            $.ajax({		
                    type : 'GET',
                    url  : './inc/fonction.php?action=olist',
                    success : function(response){
                        response = JSON.parse(response);
                        var tr;
                        $('#emp_body').html('');
                        $.each(response, function( index, organisme ) {
                                tr = $('<tr/>');
                                tr.append("<td>" + organisme.organisme_id + "</td>");
                                tr.append("<td>" + organisme.libelle_o + "</td>");
                                tr.append("<td>" + organisme.libelleville + " (" + organisme.cp_id + ")</td>");

                                var action = "<td><div class='btn-group' data-toggle='buttons'>";
                                action += "<a target='_blank' class='bouttonform button2 edit_data' id='"+organisme.organisme_id+"'>Modifié</a>";
                                action += "<a target='_blank' class='bouttonform button3 delete_data' id='"+organisme.organisme_id+"'>Supprimé</a>";

                                tr.append(action);
                                
                                $('#emp_body').append(tr);
                            });
                    }
                });
        }

});






        










          

 