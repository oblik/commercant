<?php

class commercant_Display extends commercant {

	public function __construct () {
		define('BASE_URL', get_bloginfo('url'));
		$commercantobject = commercant();
		
		add_filter( 'commercant_variables', 'return_commercant_variables' );
		
		/*	Choix du mode d'affichage pour la fiche commercant */
	
		$commercant_optionfiche_template = get_option( 'wpt_commercant_optionfiche_template' );

		if ("check1" == $commercant_optionfiche_template) {			
			add_filter('template_include', array($this, 'commercant_custom_template'),1);			
		} else {	
			add_filter('the_content', array( $this, 'insertCommercantInfos' ));
		}
		
	}
		
	/**
	 * return_commercant_variables()
	 *
	 * Recupere les metabox du commercant
	 *
	 * @uses global $post
	 * @return array 
	**/

	public function return_commercant_variables() {

		global $post;
		
		// recuperation de la premiere image et retaille
		$commercant_photos = get_post_meta( $post->ID, '_commercant_photos', false );
		
		if (!empty($commercant_photos)) {
		
			foreach($commercant_photos[0] as $commercant_photo) {
				$photo_resize = vt_resize( '', $commercant_photo, 620, 340, false );
				$commercant_photos_resize[] = $photo_resize[url];
			}
			
			foreach($commercant_photos[0] as $commercant_photo) {
				$commercant_thumb = vt_resize( '', $commercant_photo, 140, 110, true );
				break; 
			}
		
		}
		
		
		return array (
			'nom'								=>	$post->post_title,
			'rue'									=>	get_post_meta( $post->ID, '_commercant_rue', true ),
			'cp'									=>	get_post_meta( $post->ID, '_commercant_cp', true ),
			'ville'								=>	get_post_meta( $post->ID, '_commercant_ville', true ),
			'tel'									=>	get_post_meta( $post->ID, '_commercant_tel', true ),
			'fax'									=>	get_post_meta( $post->ID, '_commercant_fax', true ),
			'email'								=>	get_post_meta( $post->ID, '_commercant_email', true ),
			'url'									=>	get_post_meta( $post->ID, '_commercant_url', true ),
			'facebook'						=>	get_post_meta( $post->ID, '_commercant_facebook', true ),
			'description_generale'		=>	wpautop(get_post_meta( $post->ID, '_commercant_description_generale', true )),
			'localisation'						=>	get_post_meta( $post->ID, '_commercant_localisation', true ),
			'horaires_infos'				=>	wpautop(get_post_meta( $post->ID, '_commercant_horaires_infos', true )),
			'h_lun_ma'						=>	get_post_meta( $post->ID, '_commercant_lundi_matin', true ),
			'h_lun_am'						=>	get_post_meta( $post->ID, '_commercant_lundi_amidi', true ),
			'h_mar_ma'						=>	get_post_meta( $post->ID, '_commercant_mardi_matin', true ),
			'h_mar_am'						=>	get_post_meta( $post->ID, '_commercant_mardi_amidi', true ),
			'h_mer_ma'						=>	get_post_meta( $post->ID, '_commercant_mercredi_matin', true ),
			'h_mer_am'						=>	get_post_meta( $post->ID, '_commercant_mercredi_amidi', true ),
			'h_jeu_ma'						=>	get_post_meta( $post->ID, '_commercant_jeudi_matin', true ),
			'h_jeu_am'						=>	get_post_meta( $post->ID, '_commercant_jeudi_amidi', true ),
			'h_ven_ma'						=>	get_post_meta( $post->ID, '_commercant_vendredi_matin', true ),
			'h_ven_am'						=>	get_post_meta( $post->ID, '_commercant_vendredi_amidi', true ),
			'h_sam_ma'						=>	get_post_meta( $post->ID, '_commercant_samedi_matin', true ),
			'h_sam_am'						=>	get_post_meta( $post->ID, '_commercant_samedi_amidi', true ),
			'h_dim_ma'						=>	get_post_meta( $post->ID, '_commercant_dimanche_matin', true ),
			'h_dim_am'						=>	get_post_meta( $post->ID, '_commercant_dimanche_amidi', true ),
			'accepte_paiement'			=>	get_post_meta( $post->ID, '_commercant_accepte_paiement', false ),
			'photos'							=>	$commercant_photos_resize,
			'thumb'							=>  $commercant_thumb[url],
		);
		
	}
		
	/**
	 * getCommercantInfos()
	 *
	 * Mise en forme des informations du commercant
	 *
	 * @uses return_commercant_variables()
	 * @return string $return
	**/
		
	public function getCommercantInfos() {
	
		$commercant_item = $this->return_commercant_variables();
		
		$return = "";
		
		// Photos
		
		$return .= '<div class="owl-carousel-commercant-single owl-carousel owl-theme">';
		
		if (!empty($commercant_item['photos'] )) {
		
			foreach($commercant_item['photos'] as $url_photo) {
				$return .= "<img src='" . $url_photo .  "' alt='" . $commercant_item['nom']  . "' />"; 
			}
		
		}
		
		$return .= '</div>';
		
		
		// Identite
		
		$return .= "<h3>" . __('Identit&eacute; ','commercant') . " : </h3>";
		$return .= "<p>" . $commercant_item['rue'] . "<br/>";
		$return .= $commercant_item['cp'] . " " . $commercant_item['ville'] . "</p>"; 
		if (!empty($commercant_item['tel'])) { $return .= "<p><span>" . __('T&eacute;l.','commercant') . " : </span>" . $commercant_item['tel'] . "<br/>"; }
		if (!empty($commercant_item['fax'])) { $return .= "<span>" . __('Fax','commercant') . " : </span>" . $commercant_item['fax'] . "<br/>"; }
		if (!empty($commercant_item['email'])) { $return .= "<span>" . __('Email','commercant') . " : </span>" . $commercant_item['email'] . "<br/>"; }
		if (!empty($commercant_item['url'])) { $return .= "<span>" . __('Site Internet','commercant') . " : </span> <a href='" . $commercant_item['url'] . "' target='_blank'>" . $commercant_item['url'] . "</a><br/>"; }
		if (!empty($commercant_item['facebook'])) { $return .= "<span>" . __('Facebook','commercant') . " : </span> <a href='" . $commercant_item['facebook'] . "' target='_blank'>" . $commercant_item['facebook'] . "</a><br/>"; }
		$return .= "</p>";
		
		// Localisation
		
		$return .= "<h3>" . __('Localisation','commercant') . " : </h3>";
		$return .= "<div class='commercant-item-map' id='commercant-item-map" . get_the_ID() . "' data-commercant='" . json_encode($commercant_item) . "' ></div>";
		
		// Description generale
		if(!empty($commercant_item['description_generale'])) {
			$return .= "<h3>" . __('Description generale','commercant') . " : </h3>";
			$return .= "<div class='commercant-item-description-generale'>";
			$return .= $commercant_item['description_generale'];
			$return .= "</div>";
		}
	
		// Horaires
		
		$return .= "<h3>" . __('Horaires','commercant') . " : </h3>";
		if(!empty($commercant_item['horaires_infos'])) {	
			$return .= $commercant_item['horaires_infos'];
		}
		$return .= "<table class='commercant-table commercant-table-horaires'>
								<tr>
									<td></td>
									<th>" . __('Matin','commercant') . "</th>
									<th>" . __('Apres-midi','commercant') . "</th>	
								</tr>
								<tr>								
									<th>" . __('Lundi','commercant') . "</th>
									<td>" . $commercant_item['h_lun_ma'] . "</td>
									<td>" . $commercant_item['h_lun_am'] . "</td>								
								</tr>
								<tr>
									<th>" . __('Mardi','commercant') . "</th>
									<td>" . $commercant_item['h_mar_ma'] . "</td>
									<td>" . $commercant_item['h_mar_am'] . "</td>			
								</tr>
								<tr>
									<th>" . __('Mercredi','commercant') . "</th>
									<td>" . $commercant_item['h_mer_ma'] . "</td>
									<td>" . $commercant_item['h_mer_am'] . "</td>					
								</tr>
								<tr>
									<th>" . __('Jeudi','commercant') . "</th>
									<td>" . $commercant_item['h_jeu_ma'] . "</td>
									<td>" . $commercant_item['h_jeu_am'] . "</td>				
								</tr>
								<tr>
									<th>" . __('Vendredi','commercant') . "</th>
									<td>" . $commercant_item['h_ven_ma'] . "</td>
									<td>" . $commercant_item['h_ven_am'] . "</td>					
								</tr>
								<tr>
									<th>" . __('Samedi','commercant') . "</th>
									<td>" . $commercant_item['h_sam_ma'] . "</td>
									<td>" . $commercant_item['h_sam_am'] . "</td>			
								</tr>
								<tr>
									<th>" . __('Dimanche','commercant') . "</th>
									<td>" . $commercant_item['h_dim_ma'] . "</td>
									<td>" . $commercant_item['h_dim_am'] . "</td>					
								</tr>
							</table>";
						
		// Les plus
		
		$return .= "<h3>" . __('Moyen de paiement accept&eacute;s','commercant') . " : </h3>";
		// $return .= print_r($commercant_item['accepte_paiement']);
		$return .= "<ul>";	
		if (in_array("check1",$commercant_item['accepte_paiement'][0] )) {	$return .= "<li>Cheque cadeau</li>";	}
		if (in_array("check2",$commercant_item['accepte_paiement'][0] )) {	$return .= "<li>Carte privilege</li>";	}
		if (in_array("check3",$commercant_item['accepte_paiement'][0] )) {	$return .= "<li>Ticket restaurant</li>";	}
		if (in_array("check4",$commercant_item['accepte_paiement'][0] )) {	$return .= "<li>Carte bleue</li>";	}
		$return .= "</ul>";
		

		
		// envoi des infos
		
		return($return);

	}




	/**
	 * insertCommercantInfos()
	 *
	 * Insere les informations d'un commercant dans le template single
	 *
	 * @uses string $content
	 * @uses global $post
	 * @return $content 
	**/

	public function insertCommercantInfos($content) {

		if( is_main_query() && in_the_loop() && is_single()) {
			global $post;
			 if ($post->post_type == 'commercant') {
				$new_content = $this->getCommercantInfos();
				$content = $new_content . $content;
			}
			return $content;
		}
	}

	/**
	 * commercant_custom_template()
	 *
	 * Custom template for single commercant
	 *
	 * @uses string $content
	 * @uses global $post
	 * @return $content 
	**/
	
	public function commercant_custom_template($template_path) {
	if ( get_post_type() == 'commercant' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-commercant.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/templates/single-commercant.php';
            }
        }
    }
    return $template_path;
	}
	

	
	
}
?>