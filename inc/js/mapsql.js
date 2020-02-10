
$.post('./addpointmap.php',
    function(data) {
        if (data === 'connection error') {
            console.log('Erreur de connexion à la base de donnée!');
        } else if (data === 'query error') {
            console.log("Une erreur c'est produite lors de l'execution de la requêtes !");
        } 
         
    }
   ).done(function( data )
   {
       //________________VAR MAP _________________________________________________________________________________
        // Variable de la map
        var map = L.map('map', 
        {
            minZoom: 9,
            maxZoom: 22
        });
        // On initialise map 
        var osm = new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{ 
                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
        //________________________________________________________________________________________________________________                             



        //________________GROUPE POUR CLUSTER __________________ 

        var Groupe = new L.markerClusterGroup().addTo(map);

        var gbacpro = L.featureGroup.subGroup(Groupe).addTo(map);
        var gbts = L.featureGroup.subGroup(Groupe).addTo(map);
        var gcap = L.featureGroup.subGroup(Groupe).addTo(map);
        var gbp = L.featureGroup.subGroup(Groupe).addTo(map);
        var gdivers = L.featureGroup.subGroup(Groupe).addTo(map);
        //__________________________________________________________________        




        //________________GROUPE DE LAYERS (BTS , CAP ...)__________________ 
        var lbacpro = L.layerGroup().addTo(map);
        var lbts = L.layerGroup().addTo(map);
        var lcap = L.layerGroup().addTo(map);
        var lbp = L.layerGroup().addTo(map);
        var ldivers = L.layerGroup().addTo(map);
        //__________________________________________________________________ 

        // Options du marker
        var  OptionsMarkers = {
            'radius':15,
            'fillOpacity': 0.4
        };

        var basemapControl = { // Si on souhaite rajouté diff fond de map
          
        };

        var layerControl = {
          "Bac Pro": lbacpro, 
          "Bp": lbp, 
          "Cap": lcap, 
          "Bts": lbts, 
          "Divers": ldivers 
        };

        //-----------------------------------------Setup Map--------------------------------------

        map.setView([-21.136998,55.51512], 5); // Coordonée ou la map va se recentré ( Ile de la reunion )
        map.bounds = [],
        map.setMaxBounds([
            [-20.636998,56.05000],
            [-21.536998,55.00212]
        ]);
        
        // Recupere donnée bdd en JSON
        data = JSON.parse(data);
        console.log(data);
        for (var i = 0; i < data.length; i++) 
        {
            var libelle_o = data[i]['libelle_o'];
            var rue1 = data[i]['rue1'];
            var rue2 = data[i]['rue2'];
            var lat = data[i]['lat'];
            var lng = data[i]['lng'];
            
            var libelle_f = data[i]['libelle_f'];
            var capacite = data[i]['capacite'];
            var niv_requis = data[i]['niv_requis'];
            var type = data[i]['type'];
            
            var cp  = data[i]['libellecp'];
            
            var libelleville = data[i]['libelleville'];
            var modalitesperecrutement = data[i]['modalite_spe_recrutement'];
            OptionsMarkers.color = getColor(type);
            
            addOrganisme(lat,lng,type, libelle_o, rue1, rue2, cp , libelleville ,libelle_f,capacite,niv_requis,modalitesperecrutement);
                 
        }
        
        function addOrganisme(lat , lng , type, libelle_o, rue1, rue2, cp , libelleville , libelle_f,capacite,niv_requis,modalitesperecrutement){
            
            
            
            var organisme = L.circleMarker([lat, lng],OptionsMarkers);
            if(type === "BACPRO"){
                organisme.addTo(gbacpro); 
                lbacpro.addLayer(gbacpro); 
            } else if(type === "BTS"){
                organisme.addTo(gbts); 
                lbts.addLayer(gbts); 
            }else if(type === "BP") {
                organisme.addTo(gbp); 
                lbp.addLayer(gbp); 
            }else if(type === "CAP") {
                organisme.addTo(gcap); 
                lcap.addLayer(gcap); 
            }else{
               organisme.addTo(gdivers); 
               ldivers.addLayer(gdivers); 
            }
            addPopup(organisme, libelle_o, rue1, rue2, libelle_f,capacite,niv_requis, cp , libelleville,modalitesperecrutement,type);
        }
        
        
        function addPopup(organisme, libelle_o, rue1, rue2, libelle_f,capacite,niv_requis, cp , libelleville,modalitesperecrutement ,type){
            var ContenuePopup = "<b>"+ libelle_f + "</b> </br></br></br>"+ // Titre formation
            "<b> Organisme :</b> " + libelle_o + "</br></br>"+
            "<b> Site :</b> " + "</br></br>"+
            "<b> Sanction diplôme certificat :</b> " + type + "</br></br>"+
            "<b> Pré-requis :</b> " + modalitesperecrutement + "</br></br>"+
            "<b> Adresse :</b> " + rue1 + "</br></br>"+
            "<b> Complément d'adresse :</b> " + rue2 + "</br></br>"+
            "<b> Ville :</b> " + libelleville + "</br></br>"+
            "<b> Code postal :</b> " + cp + "</br></br>"+
            "<b> Téléphone :</b> " + "</br></br>"+
            "<b> Fax :</b> " + "</br></br>"+
            "<b> Mail :</b> " + "</br></br>"+
            "<b> Contact :</b> " + "</br></br>"+
                    "";

            organisme.bindPopup(ContenuePopup);
        }  
        
        
        L.control.layers(basemapControl, layerControl).addTo(map);
        
        function SearchInBDD(text, callResponse)//callback for 3rd party ajax requests
	{
		return $.ajax({
			url: './inc/fonction.php?action=recherche',	// Action search dans le fonction.php
			type: 'GET',
			data: {q: text},
			dataType: 'json',
			success: function(json) {
				callResponse(json);
			}
		});
	}
	map.addControl( new L.Control.Search({sourceData: SearchInBDD, text:'Color...', markerLocation: true,initial:false,casesensitive: false}) );
        
        showLegend = true;
        function getColor(type) {   // Recup couleur du marker en fonction du type de formation
            switch (type) {
                case 'BTS':
                    return  '#9932CC';
                    break;
                case 'BACPRO':
                    return '#008000';
                    break;
                case 'BP':
                    return '#991f00';
                    break;
                case 'CAP':
                    return '#000099';
                    break;
                default: // Divers
                    return '#8c918b';
                }
        }
        
        var legend = L.control({position: 'bottomleft'});
        legend.onAdd = function(map){

            var div = L.DomUtil.create('div','legend');
            label = ['<strong>Légende</strong>'],
            categories = ['BTS','BACPRO','BP','CAP','DIVERS'];
            for (var i = 0; i < categories.length; i++) {
                div.innerHTML +=
                        label.push('<i class="circle" style="background:' + getColor(categories[i]) + '"></i> ' +
                        (categories[i] ? categories[i] : '+'));

            }
            div.innerHTML = label.join('<br>');
            return div;
        };
        legend.addTo(map);  
        
        $( "#legendButton" ).click(function() {
            if(showLegend === true)
            {
                $('.legend').hide(); 
                $('#legendButton').html("Afficher"); 
                showLegend = false; 
            }else{
                $('.legend').show();
                $('#legendButton').html("Masquer"); 
                showLegend = true; 
            }
         }); 
         
        
        
   });