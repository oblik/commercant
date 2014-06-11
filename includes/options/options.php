<?php
// ajouter le lien dans le menu
add_action('admin_menu', 'commercant_optionpage');

// lier le lien du menu à la page d'options
function commercant_optionpage() {
  if (function_exists('commercant_page_options')) {
  $plugin_page_options = add_options_page('Commercant options', 'Commercant options', 'manage_options', 'commercant', 'commercant_page_options');
  }
}

// la page des options
function commercant_page_options() {

  if (!current_user_can('administrator'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
  ?>
  <div class="wrap">
  <h2>Commer&ccedil;ants</h2>
<form method="post" action="options.php">

<!-- Ajoute 2 champs cachés pour savoir comment rediriger l'utilisateur -->
<?php wp_nonce_field('update-options'); ?>
<table class="form-table">
<!--
<tr>
<th scope="row">Desactiver CSS Font Awesome</th>
<td> <fieldset>
<label for="agenda_fontawesome">
<input type="checkbox" value="1" <?php checked( '1', get_option( 'agenda_fontawesome' ) ); ?> id="agenda_fontawesome" name="agenda_fontawesome">
A d&eacute;sactiver si le plugin CH1 Actus est actif</label>
</fieldset>
</td>
</tr>

<tr>
<th scope="row">Desactiver CSS OWL Carousel</th>
<td> <fieldset>
<label for="agenda_cssowlcarousel">
<input type="checkbox" value="1" <?php checked( '1', get_option( 'agenda_cssowlcarousel' ) ); ?> id="agenda_cssowlcarousel" name="agenda_cssowlcarousel">
A d&eacute;sactiver si le plugin CH1 Actus est actif</label>
</fieldset>
</td>
</tr>

<tr>
<th scope="row">Desactiver JS OWL Carousel</th>
<td> <fieldset>
<label for="agenda_jsowlcarousel">
<input type="checkbox" value="1" <?php checked( '1', get_option( 'agenda_jsowlcarousel' ) ); ?> id="agenda_jsowlcarousel" name="agenda_jsowlcarousel">
A d&eacute;sactiver si le plugin CH1 Actus est actif</label>
</fieldset>
</td>
</tr>

<tr>
<th scope="row">Desactiver Google Maps API V3</th>
<td> <fieldset>
<label for="agenda_googlemapsapi">
<input type="checkbox" value="1" <?php checked( '1', get_option( 'agenda_googlemapsapi' ) ); ?> id="agenda_googlemapsapi" name="agenda_googlemapsapi">
A d&eacute;sactiver si le script est d&eacute;j&agrave; charg&eacute; via le th&egrave;me ou un autre plugin.</label>
</fieldset>
</td>
</tr>

<tr>
<th scope="row">Nombre d'article par page dans la page Agenda</th>
<td> <fieldset>
<label for="agenda_archives_items">
<input type="text" value="<?php echo get_option( 'agenda_archives_items' ); ?>" id="agenda_archives_items" name="agenda_archives_items">
</label>
</fieldset>
</td>
</tr>
-->
<tr>
<th scope="row">Selection affichage d'une page commercant</th>
<td> <fieldset>
<label for="agenda_archives_items">
<input type="text" value="<?php echo get_option( 'agenda_archives_items' ); ?>" id="agenda_archives_items" name="agenda_archives_items">
<input type="radio" name="commercant_affichageSingle" value="1">Utiliser le template "single-commercant.php" situ&eacute; dans "includespost-typestemplates"
<input type="radio" name="commercant_affichageSingle" value="2">Utiliser le template "single.php" du theme actif, remplace la partie the_content();

</label>
</fieldset>
</td>
</tr>

</table>


<!-- Mise à jour des valeurs -->
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="agenda_fontawesome, agenda_cssowlcarousel, agenda_jsowlcarousel,option_etc,agenda_archives_items,agenda_googlemapsapi" />

<!-- Bouton de sauvegarde -->
<p class="submit">
<input type="submit" class="button button-primary" value="<?php _e('Save Changes'); ?>" />
</p>
</form>
</div>

<h3>Page Agenda archives</h3>

<?php
$page_agenda = get_page_by_title( 'Agenda' );
$page_agenda_id = $page_agenda->ID;
if (($page_agenda->post_status == 'publish') &&(!empty($page_agenda))) {
	$output .= '<p><strong>Super ! La page "Agenda" existe</strong>. Elle affichera automatiquement les articles appartenant &agrave; l\'agenda.<br/> Page ID : ' . $page_agenda_id . '</p>';
} else { 
	$output .= '<p><strong>Mince ! La page "Agenda" n\'existe pas ou n\'est pas publi&eacute;e.</strong><br/>Il faudra la cr&eacute;er pour afficher la liste des articles appartenant &agrave; l\'agenda.</p>';
	$output .= '<input type="submit" value="Creer cette page" name="createpage" id="createpageagenda" class="button-primary">';
}
$output .= '</p><div id="loaderajax" style="display:none"><img src="' . CH1_AGENDA_PLUGIN_URL .'/includes/images/loader.gif" alt="Chargement" /></div>';
$output .='<div id="result_ajax"></div></div>';
echo $output;
?>

<script type="text/javascript">
jQuery(document).ready(function() {

	var href = '<?php echo CH1_AGENDA_PLUGIN_URL; ?>includes/functions/class-options-interface-agenda-function.php';

	jQuery('#createpageagenda').click(function(event){
	
		event.preventDefault();
		
		jQuery.ajax({
		  url: href, //This is the page where you will handle your SQL insert
		  type: "POST",
		  data: {action: 'agenda'},
		  dataType: 'json',
		  cache: false,
		   beforeSend: function() {
			jQuery('#loaderajax').show();	
			},
		  success: function(data){			
			jQuery('#loaderajax').remove();			
			jQuery('#result_ajax').append('<div class="'+data.class+'"><p><strong>'+data.returned_val+'</strong><br/><a href="javascript: window.location.reload()">Recharger la page</a></p></div>').hide().fadeIn(1000);
		  },
		  error     : function(jqXHR, textStatus, errorThrown) {
			jQuery('#result_ajax').append('<div class="error"><p>Erreur : ' +errorThrown+'</a></p></div>').hide().fadeIn(1000);             
		  }
		});

	});
	
});
</script>
<?php
}
?>