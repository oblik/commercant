<?php

class commercant_Display extends commercant {

	public function __construct () {
	
		define('BASE_URL', get_bloginfo('url'));
		
		add_filter( 'commercant_variables', 'return_commercant_variables' );
		
		/*	Custom template pour archives commercant */
		
		add_filter('template_include', array($this, 'commercant_archive_custom_template'),1);	
		
		/*	Choix du mode d'affichage pour la fiche commercant */
	
		$commercant_optionfiche_template = get_option( 'wpt_commercant_optionfiche_template' );

		if ("check1" == $commercant_optionfiche_template) {			
			add_filter('template_include', array($this, 'commercant_single_custom_template'),1);			
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
				$commercant_photos_resize[] = $photo_resize['url'];
			}
			
		
		} else {
		
				$commercant_photos_resize = false;
				
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
			'terms'								=>   wp_get_post_terms( $post->ID, 'cat_commercant'),
			'tags'								=>	get_the_tags($post->ID),
			'photos'							=>	$commercant_photos_resize,
			'thumb'							=>	get_the_post_thumbnail( $post->ID, 'medium')
		);
		
	}
	
	
	/**
	 * mempty()
	 *
	 * Test si plusieurs variables sont vides.
	 *
	 * @uses return_commercant_variables()
	 * @return string $return
	**/
	
	public function mempty($array) {
		foreach($array as $arg)
			if(empty($arg))
				continue;
			else
				return false;
		return true;
	}
	
		
	/**
	 * getCommercantInfos()
	 *
	 * Mise en forme des informations du commercant
	 *
	 * @uses return_commercant_variables()
	 * @return string $return
	**/
		
	public function getCommercantInfos($part=null,$title=false) {
	
		$commercant_item = $this->return_commercant_variables();		
		$return = "";
		$horairecheck = true;
		
		
		// thumb
		if ($part=="thumb") {
			$return = "";
			if (!empty($commercant_item['thumb'])) {
				$return .= '<div class="thumb-commercant-single">' . $commercant_item['thumb'] . '</div>';
			}
			return($return);
		}
		
		// Photos
		if ($part=="photos") {
			$return = "";
			if ($commercant_item['photos'] !=false ) {
				$return .= '<div class="owl-carousel-commercant-single owl-carousel owl-theme">';				
				foreach($commercant_item['photos'] as $url_photo) {
					$return .= "<img src='" . $url_photo .  "' alt='" . $commercant_item['nom']  . "' />"; 
				}				
				$return .= '</div>';
			}
			return($return);
		}
		
		// Identite
		if ($part=="Identite") {
			$return = "";
			if ($title != false) {$return .= "<h3>" . __('Identit&eacute; ','commercant') . " : </h3>";}
			$return .= "<p>" . $commercant_item['rue'] . "<br/>";
			$return .= $commercant_item['cp'] . " " . $commercant_item['ville'] . "</p>"; 
			if (!empty($commercant_item['tel'])) { $return .= "<p><span>" . __('T&eacute;l.','commercant') . " : </span>" . $commercant_item['tel'] . "<br/>"; }
			if (!empty($commercant_item['fax'])) { $return .= "<span>" . __('Fax','commercant') . " : </span>" . $commercant_item['fax'] . "<br/>"; }
			if (!empty($commercant_item['email'])) { $return .= "<span>" . __('Email','commercant') . " : </span>" . $commercant_item['email'] . "<br/>"; }
			if (!empty($commercant_item['url'])) { $return .= "<span>" . __('Site Internet','commercant') . " : </span> <a href='" . $commercant_item['url'] . "' target='_blank'>" . $commercant_item['url'] . "</a><br/>"; }
			if (!empty($commercant_item['facebook'])) { $return .= "<span>" . __('Facebook','commercant') . " : </span> <a href='" . $commercant_item['facebook'] . "' target='_blank'>" . $commercant_item['facebook'] . "</a><br/>"; }
			$return .= "</p>";
			return($return);
		}
		
		// Localisation
		if ($part=="localisation") {
			$return = "";
			if ($title != false) {$return .= "<h3>" . __('Localisation','commercant') . " : </h3>";}
			$return .= "<div class='commercant-item-map' id='commercant-item-map" . get_the_ID() . "' data-commercant='" . json_encode($commercant_item) . "' ></div>";
			return($return);
		}
		
		// Description generale
		if ($part=="description") {
			$return = "";
			if(!empty($commercant_item['description_generale'])) {
				if ($title != false) {$return .= "<h3>" . __('Description generale','commercant') . " : </h3>";}
				$return .= "<div class='commercant-item-description-generale'>";
				$return .= $commercant_item['description_generale'];
				$return .= "</div>";
			}
			return($return);
		}
		
		// Horaires
		if ($part=="horaires") {
			$return = "";
			$horairecheck = $this->mempty(array($commercant_item['h_lun_ma'],$commercant_item['h_lun_am'],$commercant_item['h_mar_ma'],$commercant_item['h_mar_am'],$commercant_item['h_mer_ma'],$commercant_item['h_mer_am'],$commercant_item['h_jeu_ma'],$commercant_item['h_jeu_am'],$commercant_item['h_ven_ma'],$commercant_item['h_ven_am'],$commercant_item['h_sam_ma'],$commercant_item['h_sam_am'],$commercant_item['h_dim_ma'],$commercant_item['h_dim_am'],));
			
			if(!empty($commercant_item['horaires_infos']) || $horairecheck != 1) {	
				if ($title != false) {$return .= "<h3>" . __('Horaires','commercant') . " : </h3>";}
			}
				
			if(!empty($commercant_item['horaires_infos'])) {	
				$return .= $commercant_item['horaires_infos'];
			}
			
			if($horairecheck != 1) {
					
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
									
			}
			
			return($return);
		
		}
		
		// Les plus
		if ($part=="plus") {
			$return = "";
			if (!empty($commercant_item['accepte_paiement'][0])) {
				if ($title != false) {$return .= "<h3>" . __('Moyen de paiement accept&eacute;s','commercant') . " : </h3>";}
				$return .= "<ul>";	
				if (in_array("check1",$commercant_item['accepte_paiement'][0] )) {	$return .= "<li>Cheque cadeau</li>";	}
				if (in_array("check2",$commercant_item['accepte_paiement'][0] )) {	$return .= "<li>Carte privilege</li>";	}
				if (in_array("check3",$commercant_item['accepte_paiement'][0] )) {	$return .= "<li>Ticket restaurant</li>";	}
				if (in_array("check4",$commercant_item['accepte_paiement'][0] )) {	$return .= "<li>Carte bleue</li>";	}
				$return .= "</ul>";
			}
			return($return);
		}
		
		// Terms
		if ($part=='terms') {
			$return = '';
			if (!empty($commercant_item['terms'])) {
				if ($title != false) {$return .= '<h3>' . __('Cat&eacute;gories','commercant') . ' : </h3>';}
				$return .= '<ul>';	
				// $return .= print_r($commercant_item['terms']);				
				foreach ($commercant_item['terms'] as $term) {
					$term = sanitize_term( $term,'cat_commercant');
					$term_link = get_term_link($term->term_id,'cat_commercant');
					// If there was an error, continue to the next term.
					if ( is_wp_error( $term_link ) ) {continue;}
					$return .= '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
				}
				$return .= "</ul>";
				return($return);
			}
		}
		
		// Tags
		if ($part=='tags') {
			$return = '';
			if (!empty($commercant_item['tags'])) {
				if ($title != false) {$return .= '<h3>' . __('Tags','commercant') . ' : </h3>';}				
				$return .= '<ul>';				
				foreach ($commercant_item['tags'] as $tag) {
					$return .= '<li><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a></li>';
				}
				$return .= "</ul>";				
				return($return);
			}

		}
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
			global $commercantobject;
			 if ($post->post_type == 'commercant') {
				$new_content = 
				$commercantobject->getCommercantInfos('photos') 
				.$commercantobject->getCommercantInfos('Identite',$titre=true)
				.$commercantobject->getCommercantInfos('localisation',$titre=true)
				.$commercantobject->getCommercantInfos('description',$titre=true)
				.$commercantobject->getCommercantInfos('horaires',$titre=true)
				.$commercantobject->getCommercantInfos('plus',$titre=true)
				.$commercantobject->getCommercantInfos('terms',$titre=true)
				.$commercantobject->getCommercantInfos('tags',$titre=true);
				$content = $new_content . $content;
			}
			return $content;
		}
	}

	/**
	 * commercant_single_custom_template()
	 *
	 * Custom template for single commercant
	 *
	 * @uses string $content
	 * @uses global $post
	 * @return $content 
	**/
	
	public function commercant_single_custom_template($template_path) {
	
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
	
	/**
	 * commercant_archive_custom_template()
	 *
	 * Custom template for single commercant
	 *
	 * @uses string $content
	 * @uses global $post
	 * @return $content 
	**/
	
	public function commercant_archive_custom_template($template_path) {
	
		if ( is_post_type_archive('commercant' ) ) {
				// checks if the file exists in the theme first,
				// otherwise serve the file from the plugin
				if ( $theme_file = locate_template( array ( 'archives-commercant.php' ) ) ) {
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path( __FILE__ ) . '/templates/archives-commercant.php';
				}
		}
		
		return $template_path;
	
	}
	
	
}
?>