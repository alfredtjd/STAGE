$(document).ready(function(){
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
map.setView([-21.136998,55.51512], 5); // Coordonée ou la map va se recentré ( Ile de la reunion )
map.bounds = [],
map.setMaxBounds([
    [-20.636998,56.05000],
    [-21.536998,55.00212]
]); 




// Liste déroulante ville

var $listederou = $('#listeville');

$listederou.append('<option value="">Selectionnez ...</option>');
$.ajax(
{
        url: './inc/fonction.php?action=deroullistville',
        data: 'villes', 
        success: function(json) {
            json = JSON.parse(json);
            $.each(json, function(index, ville)
            {
                var action = "<option value='"+ville.cpdeville_id+"'>"+ ville['libelleville'] +" ("+ ville['cp_id'] +") </option>";
                $('#listeville').append(action);

            });
            console.log(json);

    }

});

// à la sélection de la localité un dans la liste
$listederou.on('change', function() {
    var val = $(this).val(); // on récupère la valeur de la localité un
    $('#cpdeville').val(val); 
    
});


var marker = L.marker([0, 0]).addTo(map); // Ajout d'un marker

map.on('click', function(e) 
{

    var lat = e.latlng.lat.toFixed(5);
    var lon = e.latlng.lng.toFixed(5);

    marker.setLatLng([lat, lon]);

    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lon;
    document.getElementById('numero_activite').value;
    document.getElementById('siret_organisme_formation').value;
    document.getElementById('nom_organisme').value;
    document.getElementById('raison_sociale').value;
    document.getElementById('ligne').value;
    document.getElementById('adr1').value;
    document.getElementById('adr2').value;
    document.getElementById('adr3').value;
    document.getElementById('telfixe').value;
    document.getElementById('portable').value;
    document.getElementById('fax').value;
    document.getElementById('courriel').value;
    document.getElementById('urlweb').value;
    document.getElementById('status').innerHTML = '';
    
    document.getElementById('btnSave').onclick = AddDbOrganisme;
   
    
    function AddDbOrganisme() // Renvoie les données
    {

        var latitude = document.getElementById('latitude').value;
        var longitude = document.getElementById('longitude').value;
        
        var numero_activite = document.getElementById('numero_activite').value;
        var siret_organisme_formation = document.getElementById('siret_organisme_formation').value;
        var nom_organisme = document.getElementById('nom_organisme').value;
        var raison_sociale = document.getElementById('raison_sociale').value;
        
        var ligne = document.getElementById('ligne').value;
        var adr1 = document.getElementById('adr1').value;
        var adr2 = document.getElementById('adr2').value;
        var adr3 = document.getElementById('adr3').value;
        
        var telfixe = document.getElementById('telfixe').value;
        var portable = document.getElementById('portable').value;
        var fax = document.getElementById('fax').value;
        var courriel = document.getElementById('courriel').value;
        
        
        var urlweb = document.getElementById('urlweb').value;
        
        
        
        
        
        $.post('./addorg.php',
        {
            platitude: latitude,
            plongitude: longitude,
            pnumero_activite: numero_activite,
            psiret_organisme_formation: siret_organisme_formation,
            pnom_organisme: nom_organisme,
            praison_sociale: raison_sociale,
            pligne: ligne,
            padr1: adr1,
            padr2: adr2,
            padr3: adr3,
            ptelfixe : telfixe,
            pportable: portable,
            pfax : fax,
            pcourriel : courriel,
            purlweb : urlweb

        },
        function(data) // Insertion ok
        {
                document.getElementById('latitude').value = '';
                document.getElementById('longitude').value = '';
                document.getElementById('numero_activite').value = '';
                document.getElementById('siret_organisme_formation').value = '';
                document.getElementById('nom_organisme').value = '';
                document.getElementById('raison_sociale').value = '';
                document.getElementById('ligne').value = '';
                document.getElementById('adr1').value = '';
                document.getElementById('adr2').value = '';
                document.getElementById('adr3').value = '';
                document.getElementById('telfixe').value = '';
                document.getElementById('portable').value = '';
                document.getElementById('status').innerHTML = 'Organisme enregistré avec succés ! (Approbation demandé)';
                document.getElementById('fax').value = '';
                document.getElementById('courriel').value = '';
                document.getElementById('urlweb').value = '';
   
         
        }
        );
    }

});

});




