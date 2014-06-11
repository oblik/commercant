jQuery(document).ready(function($){


	// slide sur la fiche commercant
	
	$('#commercant_metabox .cmb_metabox .cmb-type-title').each(function() {	
		$(this).find('td').append('<span class="toggle-section close"></span>').wrapInner('<a href="#" class="toggle-section close"></a>');
		$(this).find('.cmb_metabox_title').wrapAll('<div class="wrap-title" /></div>');
		$(this).nextUntil('.cmb-type-title').wrapAll('<div class="wrap-content" /></div>');
	});
	$('#commercant_metabox .cmb_metabox .wrap-content').hide();
	
	$('.toggle-section').click(function(event) {
	
		event.preventDefault();		
		
		$(this).toggleClass('activetab').closest('.cmb-type-title').next('.wrap-content').toggle('fast',  function() {
		
			// rafraichissement carto google
		
			if ($(this).prev('.cmb-type-title').hasClass('cmb_id__commercant_titresection2')) {
				
				if( $(this).prev('.cmb-type-title').find('a.toggle-section').hasClass('activetab') ) {
					
					map = $('.map').eq(0).get(0); 
					 // map = google.maps.Map($('.map').eq(0).get(0));
					
					//raffraichi									
					google.maps.event.trigger(map, "resize");
					//centrer
					var lat = $(this).find('.latitude').val();
					var lng = $(this).find('.longitude').val();
					
					console.log(lat + ' ' + lng);
					// map.setCenter(lat,lng);
					/*
//					
					
					google.maps.LatLng(lat, lng);
					event.trigger(map, "resize");
					map.panTo((lat, lng));
					*/
					// using global variable:
					
										
				} else {
				
					console.log($(this).attr('class'));
				
				}
				
			} 
			
		});

		});

	
	

	var fermeture = "Ferm\351";

	// Bouton checkbox fermeture
	
	$("a.ferme_button,a.ouvert_button").click( function(event) { 
	
		event.preventDefault();
		
		var classbutton = $(this).attr('class');		
		
		if (classbutton =='ferme_button') {
		
			$(this).removeClass('ferme_button').addClass('ouvert_button');
			$(this).prev('.slider-range-max').val(fermeture).prop('enabled', true).fadeTo( "slow" , 0.5, function() {});
			$(this).next('.ui-slider').hide().parent().find('.cmb_metabox_description').hide();
			
		} else {
		
			$(this).removeClass('ouvert_button').addClass('ferme_button');
			$(this).prev('.slider-range-max').val('').prop('enabled', true).fadeTo( "slow" , 1, function() {});
			$(this).next('.ui-slider').show().parent().find('.cmb_metabox_description').show();
			
		}
	});
	
	// Verification au chargement

	 $(".slider-range-max").each(function(n) {
	 
		 if ( $(this).attr('value') == fermeture) {
		 
			$(this).next('a').removeClass('ferme_button').addClass('ouvert_button');
			$(this).parent().find('.ui-slider').hide().parent().find('.cmb_metabox_description').hide();
			$(this).fadeTo( "slow" , 0.5, function() {});
			
		} 
		
      });
	
	
	
});