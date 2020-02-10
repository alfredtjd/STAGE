//-----------------------------------------Liste des variable--------------------------------------
//________________VAR FICHIER GEOJSON _______________________________
// Variable stockant l'url/source du fichier geojson
var formations = "./inc/geo/cmqbatiment/formation.geojson";

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
    'opacity': .5,
    'color': "blue",
    'fillColor':  "blue",
    'fillOpacity': 0.4
};

var basemapControl = {
  //"My Basemap": osm// an option to select a basemap (makes more sense if you have multiple basemaps)
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
        filter: function(feature, gbacpro) {   
         return (feature.properties.formation  === "BACPRO" );
        }
    });
    points.addTo(gbacpro);
    lbacpro.addLayer(gbacpro);
  
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
        filter: function(feature, gbacpro) {   
         return (feature.properties.formation  === "BTS" );
        }
    });
    points.addTo(gbts);
    lbts.addLayer(gbts);
  
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
        filter: function(feature, gbacpro) {   
         return (feature.properties.formation  === "CAP" );
        }
    });
    points.addTo(gcap);
    lcap.addLayer(gcap);
  
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
        filter: function(feature, gbacpro) {   
         return (feature.properties.formation  === "BP" );
        }
    });
    points.addTo(gbp);
    lbp.addLayer(gbp);
  
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
        filter: function(feature, gbacpro) {   
         return (feature.properties.formation  === "DIVERS" );
        }
    });
    points.addTo(gdivers);
    ldivers.addLayer(gdivers);
  
});


L.control.search({
    layer: Groupe,
    initial: false,
    propertyName: 'name'
       
}).addTo(map);

L.control.layers(basemapControl, layerControl).addTo(map);