<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class commercant {

	/**
	 * The single instance of commercant.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Settings class object
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = null;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_token;

	/**
	 * The main plugin file.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The main plugin directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $dir;

	/**
	 * The plugin assets directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_dir;

	/**
	 * The plugin assets URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_url;

	/**
	 * Suffix for Javascripts.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $script_suffix;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file = '', $version = '1.0.0' ) {
		$this->_version = $version;
		$this->_token = 'commercant';

		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->includes_dir = esc_url( trailingslashit( plugins_url( '/includes/', $this->file ) ) );
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );

		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		register_activation_hook( $this->file, array( $this, 'install' ) );

		// Load frontend JS & CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );

		// Load admin JS & CSS
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );

		// Handle localisation
		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );
	}

	/**
	 * Load frontend CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function enqueue_styles () {
	
		if(get_option ('wpt_commercant_unload_fontawesome') != 'on') {		
			wp_enqueue_style( 'commercant-fontawesome', esc_url( $this->assets_url )  . 'css/font-awesome.min.css');
		}
		
		if (get_option ('wpt_commercant_unload_owl') != 'on') {	
			wp_enqueue_style( 'commercant-caroussel', esc_url( $this->includes_dir )  . 'lib/owl-carousel/owl.carousel.css');
			wp_enqueue_style( 'commercant-theme', esc_url( $this->includes_dir )  . 'lib/owl-carousel/owl.theme.css');
			wp_enqueue_style( 'commercant-transitions', esc_url( $this->includes_dir )  . 'lib/owl-carousel/owl.transitions.css');
		}
	
		wp_register_style( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'css/frontend.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-frontend' );
		
	} // End enqueue_styles()

	/**
	 * Load frontend Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function enqueue_scripts () {
		wp_register_script( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'js/frontend' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-frontend' );



		if (get_option ('wpt_commercant_unload_owl') != 'on') {		
		wp_enqueue_script( 'commercant-owlcarousel-script', esc_url( $this->includes_dir )  . 'lib/owl-carousel/owl.carousel.min.js', array('jquery'), '', true );
		}
		
		if (get_option ('wpt_commercant_unload_gmaps') != 'on') {		
			wp_enqueue_script( 'commercant-gmaps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array('jquery'), '3.0', true );
		}
		
		
		// Recuperation variables PHP ver javascript
		// http://www.limecanvas.com/passing-variables-between-php-and-jquery/
		$var_for_js['pluginUrl'] = plugins_url( $this->_token);
		wp_localize_script( $this->_token . '-frontend', 'commercant_info', $var_for_js );
		
	} // End enqueue_scripts()

	/**
	 * Load admin CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function admin_enqueue_styles ( $hook = '' ) {
		wp_register_style( $this->_token . '-admin', esc_url( $this->assets_url ) . 'css/admin.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-admin' );
	} // End admin_enqueue_styles()

	/**
	 * Load admin Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function admin_enqueue_scripts ( $hook = '' ) {
		wp_register_script( $this->_token . '-admin', esc_url( $this->assets_url ) . 'js/admin' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-admin' );		
		
	} // End admin_enqueue_scripts()

	/**
	 * Load plugin localisation
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'commercant' , false , dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation()


	
	
	/**
	 * Load plugin textdomain
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'commercant';

	    $locale = apply_filters( 'plugin_locale' , get_locale() , $domain );

	    load_textdomain( $domain , WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain , FALSE , dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain()

	/**
	 * Main commercant Instance
	 *
	 * Ensures only one instance of commercant is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see commercant()
	 * @return Main commercant instance
	 */
	public static function instance ( $file = '', $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __wakeup()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install()

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	}

}