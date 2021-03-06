jQuery( document ).ready( function ( $ ) {

// GOOGLE MAPS - Commercant item

$(".commercant-item-map").each(function() {

		var mapId = $(this).attr('id');
		var commercant_data = $(this).data('commercant');
		var mapGps = commercant_data.localisation;

		  /* D�claration de l'ic�ne personnalis�e */
		 
		  var monIconPerso = new google.maps.MarkerImage(commercant_info.pluginUrl+"/assets/images/marker.png",
		  /* dimensions de l'image */
		  new google.maps.Size(30,41),
		  /* Origine de l'image 0,0. */
		  new google.maps.Point(0,0),
		  /* l'ancre (point d'accrochage sur la map) du picto
		  (varie en fonction de ses dimensions) */
		  new google.maps.Point(15,41)
		);
		
		// Photo commercant
		if ($('#myElement').length > 0) { 
			var photocommercant = '<div class="info_gmaps_photo"><img src="'+commercant_data.thumb+'" alt="'+commercant_data.nom+'" /></div>';
		} else { 
			var photocommercant =""; 
		}
				
		var locations = [['<div class="info_gmaps">'+photocommercant+'<p><strong>'+commercant_data.nom+'</strong><br/>'+commercant_data.rue+'<br/>'+commercant_data.cp+' '+commercant_data.ville+'<br/>T&eacute;l. '+commercant_data.tel+'</p></div>', mapGps.latitude,mapGps.longitude, 1]];

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
	
// GOOGLE MAPS - taxonomy archives

$(".commercant-by-taxonomy-map").each(function() {

		var mapId = $(this).attr('id');
		var commercant_data = $(this).data('commercant');
		var locations = [];
		var commercant_item = [];
		/* D�claration de l'ic�ne personnalis�e */		 
		  var monIconPerso = new google.maps.MarkerImage(commercant_info.pluginUrl+"/assets/images/marker.png",
		  /* dimensions de l'image */
		  new google.maps.Size(30,41),
		  /* Origine de l'image 0,0. */
		  new google.maps.Point(0,0),
		  /* l'ancre (point d'accrochage sur la map) du picto
		  (varie en fonction de ses dimensions) */
		  new google.maps.Point(15,41)
		);
		
		$.each( commercant_data, function( index, commercant_data ){
			
			// console.log(commercant_data);
			
			/* gps */
			  var mapGps = commercant_data.localisation;
			  
			
			// Photo commercant
			if ($(commercant_data.thumb).length > 0) { 
				var photocommercant = '<div class="info_gmaps_photo">'+commercant_data.thumb+'</div>';
			} else { 
				var photocommercant =""; 
			}
				
		
			commercant_item = ['<div class="info_gmaps">'+photocommercant+'<p><strong>'+commercant_data.nom+'</strong><br/>'+commercant_data.rue+'<br/>'+commercant_data.cp+' '+commercant_data.ville+'<br/>T&eacute;l. '+commercant_data.tel+'</p></div>', mapGps.latitude,mapGps.longitude, 1];
			
			locations.push( commercant_item );
		
		});
		
		 var mapGps = commercant_data[0].localisation;
		
		// Construction de la carte

		var map = new google.maps.Map(document.getElementById(mapId), {
		  zoom: 12,
		  center: new google.maps.LatLng(mapGps.latitude,mapGps.longitude),
		  mapTypeId: google.maps.MapTypeId.ROADMAP,
		  scrollwheel: true,
		  maxZoom:18
		});

		// Construction du marqueur et  info bulle
		
		var infowindow = new google.maps.InfoWindow();
		var bounds = new google.maps.LatLngBounds();
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

			bounds.extend(marker.getPosition());
		
		}

		// centre la carte pour afficher tous les markers
		map.fitBounds(bounds);	
		 

		
	

		
		
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