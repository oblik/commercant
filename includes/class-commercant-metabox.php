<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class commercant_Metabox {

	public function __construct () {
	
		if ( is_admin() ) {		
			// initialize_cmb_meta_boxes			
			add_action( 'init', array( $this, 'commercant_initialize_cmb_meta_boxes' ), 9999 );
			add_action( 'init', array( $this, 'commercant_initialize_tax_metaboxes' ), 9999 );
			
			// Include and setup custom metaboxes and fields			
			add_filter( 'cmb_meta_boxes', array( $this, 'commercant_metaboxes' ) );			
		}
		
	}
	

	// Initialisation

	public function commercant_initialize_cmb_meta_boxes() {

		if ( !class_exists( 'cmb_Meta_Box' ) ) {
			 require_once( plugin_dir_path( __FILE__ ) . '/lib/metabox/init.php' );	
		}
		
		if ( !function_exists( 'pw_map_field' ) ) {
			require_once( plugin_dir_path( __FILE__ ) . '/lib/metabox/cmb_field_map/cmb-field-map.php' );
		}
		
		if ( !function_exists( 'cmb_field_slide' ) ) {
			require_once( plugin_dir_path( __FILE__ ) . 'lib/metabox/cmb_field_slide/cmb_field_slide.php' );
		}
		
	}

	/**
	 * Define the metabox and field configurations.
	 *
	 * @param  array $meta_boxes
	 * @return array
	 */
	
	public function commercant_initialize_tax_metaboxes() {
	
		$config = array(
		   'id' => 'commercant_tax_metabox',                         // meta box id, unique per meta box
		   'title' => 'Commercant Meta Box',                      // meta box title
		   'pages' => array('cat_commercant'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
		   'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
		   'fields' => array(),                             // list of meta fields (can be added by field arrays)
		   'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
		   'use_with_theme' => false                        //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		);
	 
		$commercantMetaObject = new Tax_Meta_Class($config);		 
		//select field
		$commercantMetaObject->addSelect('select_field_id',array('selectkey1'=>'Select Value1','selectkey2'=>'Select Value2'),array('name'=> 'My select ', 'std'=> array('selectkey2')));
		//Color field
		$commercantMetaObject->addColor('commercant_tax_color',array('name'=> 'Couleur '));
		$commercantMetaObject->Finish();
	
	}
	
	
	/**
	 * Define the metabox and field configurations.
	 *
	 * @param  array $meta_boxes
	 * @return array
	 */

	 public function commercant_metaboxes( array $meta_boxes ) {

		// Start with an underscore to hide fields from custom fields list
		$prefix = '_commercant_';

		$meta_boxes[] = array(
			'id'         => 'commercant_metabox',
			'title'      => 'Infos commercant',
			'pages'      => array( 'commercant', ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name' => 'Identit&eacute; du commer&ccedil;ant',
					'id'   => $prefix . 'titresection',
					'type' => 'title',
				),
				array(
					'name' => 'Rue',
					'desc' => 'Rue du commer&ccedil;ant. Exemple : 14 rue du pont ',
					'id'   => $prefix . 'rue',
					'type' => 'text_medium',
				),
				array(
					'name' => 'Code postal',
					'desc' => 'Code postal du commer&ccedil;ant. Exemple : 50100 ',
					'id'   => $prefix . 'cp',
					'type' => 'text_medium',
				),
				array(
					'name' => 'Ville',
					'desc' => 'Ville du commer&ccedil;ant. Exemple : Cherbourg ',
					'id'   => $prefix . 'ville',
					'type' => 'text_medium',
				),
				array(
					'name' => 'T&eacute;l&eacute;phone',
					'desc' => 'T&eacute;l&eacute;phone du commer&ccedil;ant. Exemple : 02.33.03.29.38 ',
					'id'   => $prefix . 'tel',
					'type' => 'text_medium',
				),
				array(
					'name' => 'Fax',
					'desc' => 'Fax du commer&ccedil;ant. Exemple : 02.33.03.29.38 ',
					'id'   => $prefix . 'fax',
					'type' => 'text_medium',
				),
				array(
					'name' => 'Email',
					'desc' => 'Email du commer&ccedil;ant. Exemple : commercant@gmail.com',
					'id'   => $prefix . 'email',
					'type' => 'text_email',
				),
				array(
					'name' => 'Site Internet',
					'desc' => 'Site Internet du commer&ccedil;ant. Exemple : www.commercant.com ',
					'id'   => $prefix . 'url',
					'type' => 'text_url',
				),
				array(
					'name' => 'Facebook',
					'desc' => 'Page Facebook du commer&ccedil;ant. Exemple : www.facebook.com/commercant ',
					'id'   => $prefix . 'facebook',
					'type' => 'text_url',
				),
				array(
					'name' => 'Description du commer&ccedil;ant',
					'id'   => $prefix . 'descriptiontitle',
					'type' => 'title',
				),
				array(
					'name' => 'Description',
					'desc' => 'Description g&eacute;n&eacute;rale du commer&ccedil;ant.',
					'default' => '',
					'id' => $prefix . 'description_generale',
					'type' => 'wysiwyg'
				),
				array(
					'name' => 'Situation du commer&ccedil;ant',
					'id'   => $prefix . 'titresection2',
					'type' => 'title',
				),
				array(
					'name' => 'Situation',
					'desc' => 'D&eacute;placez le marqueur &agrave; la position pr&eacute;cise.',
					'id' => $prefix . 'localisation',
					'type' => 'pw_map',
					'sanitization_cb' => 'pw_map_sanitise',
				),
				array(
					'name' => 'Horaires d\'ouverture',
					'id'   => $prefix . 'titresection3',
					'type' => 'title',
				),
				array(
					'name' => 'Information sur les horaires',
					'desc' => 'Exemple : Ouverture non stop du mardi au samedi.',
					'default' => '',
					'id' => $prefix . 'horaires_infos',
					'type' => 'wysiwyg'				
				),
				array(
					'name' => 'Lundi matin',
					'id' => $prefix . 'lundi_matin',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>0,
					'max' =>780,
					'desc' => 'Exemple : 8h00 -12h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Lundi apres-midi',
					'id' => $prefix . 'lundi_amidi',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>720,
					'max' =>1440,
					'desc' => 'Exemple : 13h30 -18h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Mardi matin',
					'id' => $prefix . 'mardi_matin',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>0,
					'max' =>780,
					'desc' => 'Exemple : 8h00 -12h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Mardi apres-midi',
					'id' => $prefix . 'mardi_amidi',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>720,
					'max' =>1440,
					'desc' => 'Exemple : 13h30 -18h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Mercredi matin',
					'id' => $prefix . 'mercredi_matin',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>0,
					'max' =>780,
					'desc' => 'Exemple : 8h00 -12h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Mercredi apres-midi',
					'id' => $prefix . 'mercredi_amidi',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>720,
					'max' =>1440,
					'desc' => 'Exemple : 13h30 -18h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Jeudi matin',
					'id' => $prefix . 'jeudi_matin',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>0,
					'max' =>780,
					'desc' => 'Exemple : 8h00 -12h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Jeudi apres-midi',
					'id' => $prefix . 'jeudi_amidi',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>720,
					'max' =>1440,
					'desc' => 'Exemple : 13h30 -18h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Vendredi matin',
					'id' => $prefix . 'vendredi_matin',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>0,
					'max' =>780,
					'desc' => 'Exemple : 8h00 -12h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Vendredi apres-midi',
					'id' => $prefix . 'vendredi_amidi',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>720,
					'max' =>1440,
					'desc' => 'Exemple : 13h30 -18h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Samedi matin',
					'id' => $prefix . 'samedi_matin',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>0,
					'max' =>780,
					'desc' => 'Exemple : 8h00 -12h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Samedi apres-midi',
					'id' => $prefix . 'samedi_amidi',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>720,
					'max' =>1440,
					'desc' => 'Exemple : 13h30 -18h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Dimanche matin',
					'id' => $prefix . 'dimanche_matin',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>0,
					'max' =>780,
					'desc' => 'Exemple : 8h00 -12h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Dimanche apres-midi',
					'id' => $prefix . 'dimanche_amidi',
					'type' => 'slide_field',
					'step' => 15,
					'min' =>720,
					'max' =>1440,
					'desc' => 'Exemple : 13h30 -18h00 ou ferm&eacute;.'
				),
				array(
					'name' => 'Les +',
					'id'   => $prefix . 'titresection4',
					'type' => 'title',
				),
				array(
					'name' => 'Moyens de paiement accept&eacute;s',
					'desc' => '',
					'id' => $prefix . 'accepte_paiement',
					'type' => 'multicheck',
					'options' => array(
						'check1' => 'Cheque cadeau',
						'check2' => 'Carte privilege',
						'check3' => 'Ticket restaurant',
						'check4' => 'Carte bleue',
					)
				),
				array(
					'name' => 'Photos',
					'id'   => $prefix . 'titresection5',
					'type' => 'title',
				),
				array(
					'name' => 'Photos',
					'desc' => '',
					'id' => $prefix . 'photos',
					'type' => 'file_list',
					'preview_size' => array( 100, 100 )
				),
			),
		);

		// Add other metaboxes as needed

		return $meta_boxes;
	}
	
	public function commercant_tax_metabox() {
	
		$config = array(
		   'id' => 'commercant_tax_metabox',                         // meta box id, unique per meta box
		   'title' => 'Commercant Meta Box',                      // meta box title
		   'pages' => array('cat_commercant'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
		   'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
		   'fields' => array(),                             // list of meta fields (can be added by field arrays)
		   'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
		   'use_with_theme' => false                        //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		);
		 
		$commercantMetaObject = new Tax_Meta_Class($config);		 
		//select field
		$commercantMetaObject->addSelect('select_field_id',array('selectkey1'=>'Select Value1','selectkey2'=>'Select Value2'),array('name'=> 'My select ', 'std'=> array('selectkey2')));
		//Color field
		$commercantMetaObject->addColor('commercant_tax_color',array('name'=> 'Couleur '));
		$commercantMetaObject->Finish();


		$commercantobject = new commercant_Post_Type();
		$commercantobject = new commercant_Metabox();
		$commercantobject = new commercant_Display();
	}
}
?>