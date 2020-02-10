$(document).ready(function(){
    function init() {
        get_formations();
    }
    init();
    
    $( "#btn_add" ).click(function() {
        ajaxAction('add');
        
    });
    
    $( "#btn_fermer" ).click(function() {
        update_formulaire();
        
    });
    
    var $listederou = $('#listeorga');
    var $listetype = $('#listetype');
    
    $listederou.append('<option value="">Selectionnez ...</option>');
        $.ajax(
        {
            url: './inc/fonction.php?action=deroullist',
            data: 'go', // on envoie $_GET['go']
            success: function(json) {
                    json = JSON.parse(json);
                    $.each(json, function(index, organisme)
                    {
                        var action = "<option value='"+organisme.organisme_id+"'>"+ organisme['libelle_o'] +"</option>";
                        $('#listeorga').append(action);

                    });
                    console.log(json);

            }

        });
        
        $listetype.append('<option value="">Selectionnez ...</option>');
        $.ajax(
        {
            url: './inc/fonction.php?action=deroullisttype',
            data: 'types', // on envoie $_GET['go']
            success: function(json) {
                    json = JSON.parse(json);
                    $.each(json, function(index, type)
                    {
                        var action = "<option value='"+type.type+"'>"+ type['type'] +"</option>";
                        $('#listetype').append(action);

                    });
                    console.log(json);

            }

        });
        
        
        // à la sélection de la localité un dans la liste
        $listetype.on('change', function() {
            var val = $(this).val(); // on récupère la valeur de la localité un
            $('#type').val(val); 

        });
        
        $listederou.on('change', function() {
            var val = $(this).val(); // on récupère la valeur de la localité un
            $('#organisme_id').val(val);
            console.log(val);

        });
         
        
   $(document).on('click', '.edit_data', function(){  
           var id = $(this).attr("id");
           console.log(id);
           $.ajax({  
                url:"./inc/fonction.php?action=fget_employee&id="+id,  
                method:"GET", 
                dataType:"json",  
                success:function(data){ 
                     console.log(data); 
                        
                     $('#formation_id').val(data['formation_id']);
                     $('#libelle_f').val(data['libelle_f']);
                     $('#type').val(data['type']);
                     $('#capacite').val(data['capacite']);
                     $('#niv_requis').val(data['niv_requis']);
                     $('#modalite_spe_recrutement').val(data['modalite_spe_recrutement']);
                     $('#organisme_id').val(data['organisme_id']);
 
                     
                     $('#modal-title').html("Modification de la formation :");
                     $('#btn_add').html("Mettre à jour");
                     $('#action').val("fedit");  
                     $('#add_model').modal('show');  
                }  
           });  
      });
    
    $(document).on('click', '.delete_data', function(){  
            var id = $(this).attr("id");
            console.log('[Console : Suppression formations id : '+id);
            var conf = confirm('Vous êtes sur le point de supprimé cette organisme , êtes vous en sûre ?');
            if(id > 0){
                $.post('./inc/fonction.php', { id: id, action : 'fdelete'}
                    , function(){
                        get_formations();
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
                      get_formations();
                      
                      
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
        
        function update_formulaire() {    
           $('#modal-title').html("Ajouté une formation :");
           $('#formation_id').val("0");
           $('#libelle_f').val("");
           $('#type').val("");
           $('#capacite').val("");
           $('#niv_requis').val("");
           $('#modalite_spe_recrutement').val("");
           $('#organisme_id').val("");
 
                     
                     
           $('#btn_add').html("Ajouté");
           $('#action').val("add");  
        }
        
        
	function get_formations() {
		$.ajax({		
		type : 'GET',
		url  : './inc/fonction.php?action=flist',
		success : function(response){
		response = JSON.parse(response);
		var tr;
	      	$('#emp_body').html('');
	      	$.each(response, function( index, formation ) {
	  tr = $('<tr/>');
	            tr.append("<td>" + formation.formation_id + "</td>");
	            tr.append("<td>" + formation.libelle_f + "</td>");
	            tr.append("<td>" + formation.type + "</td>");
                    tr.append("<td>" + formation.capacite + "</td>");
                    tr.append("<td>" + formation.niv_requis + "</td>");
                    tr.append("<td>" + formation.modalite_spe_recrutement + "</td>");
                    tr.append("<td>" + formation.libelle_o + "</td>");
 
	            	var action = "<td><div class='btn-group' data-toggle='buttons'>";
                        action += "<a target='_blank' class='bouttonform button2 edit_data' id='"+formation.formation_id+"'>Modifier</a>";
	            	action += "<a target='_blank' class='bouttonform button3 delete_data' id='"+formation.formation_id+"'>Supprimer</a>";
	            tr.append(action);
	            $('#emp_body').append(tr);
		});
		}
		});
	}
        

	
});

