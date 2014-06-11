<?php
define( 'slide_URL', plugin_dir_url( __FILE__ ) );

function pw_slide_field( $field, $meta ) {
	
	wp_enqueue_script( 'metaboxslide_init', slide_URL . 'js/script.js', array(), null );
	wp_enqueue_style( 'metaboxslide_css', slide_URL . 'css/style.css', array(), null );
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_style('metaboxslide-admin-ui-css', slide_URL . 'css/jquery-ui-1.10.4.custom.css',array(), null );
	
	echo '<input type="text" class="slider-range-max cmb_text_medium" id="' . $field['id'] . '" name="' . $field['id'] . '" value="' . $meta . '" /> <a href="#" class="ferme_button">Ferm&eacute;</a>';
	echo '<div id="slider-range-max-' . $field['id'] . '"></div>';	
	// http://codepen.io/NaszvadiG/pen/miGaJ
	echo '<script>jQuery(document).ready(function($){
			var rangeTimes = [];
			$( "#slider-range-max-' . $field['id'] . '" ).slider({
				range: true,
				min: '.$field['min'] .',
				max: '.$field['max'] .',
				values: [540, 1080],
				step: '.$field['step'] .',
				slide: slideTime
			});

				function slideTime(event, ui){
				
					if (event && event.target) {
						var $rangeslider = $(event.target);
						var $rangetime = $("#' . $field['id'] . '");
					}					

					if (ui!==undefined) {
					var val0 = ui.values[0],
						  val1 = ui.values[1];
					} else {
						  var val0 = $rangeslider.slider("values", 0),
						  val1 = $rangeslider.slider("values", 1);
					}

					var minutes0 = parseInt(val0 % 60, 10),
						hours0 = parseInt(val0 / 60 % 24, 10),
						minutes1 = parseInt(val1 % 60, 10),
						hours1 = parseInt(val1 / 60 % 24, 10);
					if (hours1==0) hours1=24;

					rangeTimes[0] = [getTime(hours0, minutes0),getTime(hours1, minutes1)];

					$rangetime.val(rangeTimes[0][0] + " - " + rangeTimes[0][1]);
				  
				} 
				
				function getTime(hours, minutes) {
						var time = null; 
						minutes = minutes + "";
						if (minutes.length == 1) {
					  minutes = "0" + minutes;
						}
						return hours + ":" + minutes;
				}
				
		});</script>';

	if ( ! empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';
}
add_filter( 'cmb_render_slide_field', 'pw_slide_field', 10, 2 );

?>