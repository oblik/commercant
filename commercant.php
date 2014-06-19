<?php
/*
 * Plugin Name: Commercants
 * Version: 1.0
 * Plugin URI: 
 * Description: Plugin pour la gestion d'une liste de commercants.
 * Author: Sylvain
 * Author URI: 
 * Requires at least: 3.8
 * Tested up to: 3.8.1
 *
 * @package WordPress
 * @author Sylvain
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define("SCRIPT_DEBUG",  1);

// Include plugin class files
require_once( 'includes/class-commercant.php' );
require_once( 'includes/class-commercant-settings.php' );

//constant
if ( ! defined( 'commercant_site_URL' ) )
    define( 'commercant_site_URL', get_site_url());

/**
 * Returns the main instance of commercant to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object commercant
 */
function commercant () {
	$instance = commercant::instance( __FILE__, '1.0.0' );
	if( is_null( $instance->settings ) ) {
		$instance->settings = commercant_Settings::instance( $instance );
	}
	return $instance;
}

$commercantobject = commercant();

require_once( 'includes/post-types/class-commercant-post_type.php' );
if ( ! class_exists( 'Tax_Meta_Class') ) {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/lib/Tax-meta-class/Tax-meta-class.php' );	
}	
require_once( 'includes/class-commercant-metabox.php' );
require_once( 'includes/post-types/class-commercant-display.php' );


// vt_resize - Resize images dynamically using wp built in functions
add_action( 'init', 'commercant_load_php_class' );
function commercant_load_php_class() {
	if(!function_exists('vt_resize')) {
		include ( plugin_dir_path( __FILE__ ) . 'includes/lib/vt_resize/vt_resize.php' );	
	}
}

$commercantobject = new commercant_Post_Type();
$commercantobject = new commercant_Metabox();
$commercantobject = new commercant_Display();

?>
