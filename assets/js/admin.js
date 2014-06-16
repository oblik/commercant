jQuery( document ).ready( function ( $ ) {
	
	
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
					
					// refresh									
					google.maps.event.trigger(map, "resize");
					
					// center - bug /!\
					
					var lat = $(this).find('.latitude').val();
					var lng = $(this).find('.longitude').val();
					
					console.log(lat + ' ' + lng);
									
										
				} else {
				
					console.log($(this).attr('class'));
				
				}
				
			} 
			
		});

		});
	
	
});