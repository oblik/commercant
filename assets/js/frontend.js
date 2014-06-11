jQuery( document ).ready( function ( $ ) {

// GOOGLE MAPS - Commercant item

$(".commercant-item-map").each(function() {

		var mapId = $(this).attr('id');
		var commercant_data = $(this).data('commercant');
		var mapGps = commercant_data.localisation;

		  /* Déclaration de l'icône personnalisée */
		 
		  var monIconPerso = new google.maps.MarkerImage(commercant_info.pluginUrl+"/assets/images/marker.png",
		  /* dimensions de l'image */
		  new google.maps.Size(30,41),
		  /* Origine de l'image 0,0. */
		  new google.maps.Point(0,0),
		  /* l'ancre (point d'accrochage sur la map) du picto
		  (varie en fonction de ses dimensions) */
		  new google.maps.Point(15,41)
		);
		
		
		var locations = [
		  ['<div class="info_gmaps"><div class="info_gmaps_photo"><img src="'+commercant_data.thumb+'" alt="'+commercant_data.nom+'" /></div><p><strong>'+commercant_data.nom+'</strong><br/>'+commercant_data.rue+'<br/>'+commercant_data.cp+' '+commercant_data.ville+'<br/>T&eacute;l. '+commercant_data.tel+'</p></div>', mapGps.latitude,mapGps.longitude, 1]
		];

		var map = new google.maps.Map(document.getElementById(mapId), {
		  zoom: 12,
		  center: new google.maps.LatLng(mapGps.latitude,mapGps.longitude),
		  mapTypeId: google.maps.MapTypeId.ROADMAP,
		  scrollwheel: true
		});

		var infowindow = new google.maps.InfoWindow();

		var marker, i;

		for (i = 0; i < locations.length; i++) {  
		  marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			title:commercant_data.nom,
			icon : monIconPerso,
			map: map
		  });

		  google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
			  infowindow.setContent(locations[i][0]);
			  infowindow.open(map, marker);
			}
		  })(marker, i));
		  
		}	
		
	});

// DIAPORAMA PHOTO - Commercant item
	
	$(".owl-carousel-commercant-single").owlCarousel({
		navigation : true, 
		slideSpeed : 1000,
		paginationSpeed : 1000,
		singleItem:true,
		navigationText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
		pagination:true,
		autoPlay:4000,
		autoHeight:false
	});
	

});