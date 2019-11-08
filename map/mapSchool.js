window.onload = function(){

  var greenIcon = L.icon({

    iconUrl: '/ProjetWeb/map/images/marker.png',
  	//shadowUrl: '/ProjetWeb/map/images/shadow.png',

  	iconSize:     [38, 63], // size of the icon
  	iconAnchor:   [22, 65], // point of the icon which will correspond to marker's location
  	popupAnchor:  [-3, -50] // point from which the popup should open relative to the iconAnchor
});

  console.log("salut");
  var mymap = L.map('mapid').setView([48.837, 2.584], 15);
  var tileStreets = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    	maxZoom: 18,
    	id: 'mapbox.streets',
    	accessToken: 'pk.eyJ1IjoiaGVyZWFsIiwiYSI6ImNrMW92ZnJ3dDBvaWQzbWw4MWMyemRmMTkifQ.ybaNjSTBRj1Cw45T379ZMA'
    });
    tileStreets.addTo(mymap);
    var marker = L.marker([48.837, 2.584], {icon: greenIcon}).addTo(mymap);
    marker.bindPopup("IUT de Marne la Vallée");
}
