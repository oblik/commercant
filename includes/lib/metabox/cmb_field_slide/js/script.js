jQuery(document).ready(function($){

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