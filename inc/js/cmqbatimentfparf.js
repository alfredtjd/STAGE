//-----------------------------------------Liste des variable--------------------------------------
//________________VAR FICHIER GEOJSON _______________________________
// Variable stockant l'url/source du fichier geojson
var formations = "./inc/geo/cmqbatiment/formationfam.geojson";


//__________________________________________________________________   




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

var gfamille1 = L.featureGroup.subGroup(Groupe).addTo(map);
var gfamille2 = L.featureGroup.subGroup(Groupe).addTo(map);
var gfamille3 = L.featureGroup.subGroup(Groupe).addTo(map);
var gfamille4 = L.featureGroup.subGroup(Groupe).addTo(map);
var gfamille5 = L.featureGroup.subGroup(Groupe).addTo(map);
//__________________________________________________________________        




//________________GROUPE DE LAYERS (BTS , CAP ...)__________________ 
var lfamille1 = L.layerGroup().addTo(map);
var lfamille2 = L.layerGroup().addTo(map);
var lfamille3 = L.layerGroup().addTo(map);
var lfamille4 = L.layerGroup().addTo(map);
var lfamille5 = L.layerGroup().addTo(map);
//__________________________________________________________________ 

// Options du marker
var  OptionsMarkers = {
    'radius':15,
    'opacity': .5,
    'color': "blue",
    'fillColor':  "blue",
    'fillOpacity': 0.4
};

var basemapControl = {
  // Rajouté ici les diff* fond de carte
};

var layerControl = {
  "Béton | Gros oeuvres | Travaux publics | Études géometres | Conduites d'engins": lfamille1, 
  "Seconde oeuvre et aménagement carrelage | Peintre | Platre": lfamille4, 
  "Métal | Alluminium | Chaudronerie": lfamille3, 
  "Bois | Menusierie | Charpente | Couverture": lfamille2, 
  "Electrécité | Plomberie | Climatisation domotique": lfamille5 
};

//-----------------------------------------Setup Map--------------------------------------

map.setView([-21.136998,55.51512], 5); // Coordonée ou la map va se recentré ( Ile de la reunion )
map.bounds = [],
map.setMaxBounds([
    [-20.636998,56.05000],
    [-21.536998,55.00212]
]);




//-----------------------------------------Listes fonctions--------------------------------------

// Pour chaque marker , on va récuperer ces données et les faires appaitre dans une popup
function forEachFeature(feature, marker) 
{
	var ContenuePopup = "<b>" +
            feature.properties.name + "</b></br>" +
            feature.properties.organisme + "</br>" +
            feature.properties.ville + "</br>" +
            feature.properties.téléphone + "</br>";
    
        if (feature.properties && feature.properties.ContenuePopup) {
            ContenuePopup += feature.properties.ContenuePopup;
        }
	marker.bindPopup(ContenuePopup);

};



//----------------------------------------- Chargement des fichiers + placements des données --------------------------------------

//_______________________________________________________BAC PRO________________________________________________

$.getJSON(formations, function(geojson) 
{
    var points = L.geoJSON(geojson, 
    {
       
        onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) 
        {
            return L.circleMarker(latlng, OptionsMarkers);
        }       ,
        filter: function(feature, gfamille1) {   
         return (feature.properties.famille  === 1 );
        }
    });
    points.addTo(gfamille1);
    lfamille1.addLayer(gfamille1);
  
});


//_______________________________________________________BTS________________________________________________

$.getJSON(formations, function(geojson) 
{
    var points = L.geoJSON(geojson, 
    {
       
        onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) 
        {
            return L.circleMarker(latlng, OptionsMarkers);
        }       ,
        filter: function(feature, gfamille1) {   
         return (feature.properties.famille  === 2 );
        }
    });
    points.addTo(gfamille2);
    lfamille2.addLayer(gfamille2);
  
});


//_______________________________________________________CAP________________________________________________

$.getJSON(formations, function(geojson) 
{
    var points = L.geoJSON(geojson, 
    {
       
        onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) 
        {
            return L.circleMarker(latlng, OptionsMarkers);
        }       ,
        filter: function(feature, gfamille1) {   
         return (feature.properties.famille  === 3 );
        }
    });
    points.addTo(gfamille3);
    lfamille3.addLayer(gfamille3);
  
});



//_______________________________________________________BP________________________________________________
$.getJSON(formations, function(geojson) 
{
    var points = L.geoJSON(geojson, 
    {
       
        onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) 
        {
            return L.circleMarker(latlng, OptionsMarkers);
        }       ,
        filter: function(feature, gfamille1) {   
         return (feature.properties.famille  === 4 );
        }
    });
    points.addTo(gfamille4);
    lfamille4.addLayer(gfamille4);
  
});


//_______________________________________________________DIVERS________________________________________________

$.getJSON(formations, function(geojson) 
{
    var points = L.geoJSON(geojson, 
    {
       
        onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) 
        {
            return L.circleMarker(latlng, OptionsMarkers);
        }       ,
        filter: function(feature, gfamille1) {   
         return (feature.properties.famille  === 5);
        }
    });
    points.addTo(gfamille5);
    lfamille5.addLayer(gfamille5);
  
});


L.control.search({
    layer: Groupe,
    initial: false,
    propertyName: "name"
       
}).addTo(map);

L.control.layers(basemapControl, layerControl).addTo(map);