<?php
/**
 * Plugin Name: 	ROC - Call Tracking
 * Plugin URI:		http://wordpress.org/plugins/roc-call-tracking/
 * Description:		Track clicks on "Call" button or link
 * Version: 		1.0
 * Author:      	Jossandro Balardin - Return On Click
 * Author URI:  	http://www.returnonclick.com.au
 * Text Domain: 	roc-call
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class  ROC_Call.
 *
 * Main ROC - Call Tracking.
 *
 * @class		 ROC_Call
 * @version		1.0
 * @author		Jossandro Balardin
 */
class  ROC_Call {

	/**
	 * Instance of plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var object $instance The instance of the plugin class.
	 */
	private static $instance;



	private $post_type = 'statistic';
	

	/**
	 * Construct.
	 *
	 * Initialize the class and plugin.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Initialize plugin parts
		$this->init();

	}


	/**
	 * Instance.
	 *
	 * An global instance of the class. Used to retrieve the instance
	 * to use on other files/plugins/themes.
	 *
	 * @since 1.0.0
	 * @return object Instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) :
			self::$instance = new self();
		endif;

		return self::$instance;

	}


	/**
	 * Init.
	 *
	 * Initialize plugin parts.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		/**
		 * Including all classes needed.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'class/class-roc-call-save.php';
		require_once plugin_dir_path( __FILE__ ) . 'class/class-roc-call-shortcode.php';
		//Admin Class
		require_once plugin_dir_path( __FILE__ ) . 'admin/class-admin.php';
		
		//==== Adding new post type for STATS Plugin
		add_action( 'init', array($this,'register_types' ));


		// ADD handlers
		add_shortcode( 'place_info', array($this, 'get_place_info' ));		//Get all place information

		add_shortcode( 'place_part_info', array($this, 'get_part_place_info' ));		//Get partial information

		//Instantiate objects, initialize classes and objects
		new ROC_Call_shortcode();
		new ROC_Call_Save();
		new ROC_Call_Admin();
		
		
	}

	
	public function register_types() {
		// Interest post type
		register_post_type( 'statistic',
			array(
				'labels' => array(
					'name' => __( 'Statistics' ),
					'singular_name' => __( 'Statistic' )
					),
				'public' => true,
				'has_archive' => true,
				'rewrite' => false,
				'query_var' => false 
			)
		);
		
	}

	public function get_post_type(){
		return $this->post_type;
	}

}


/**
 * The main function responsible for returning the  ROC_Call object.
 *
 * Use this function like you would a global variable, except without needing to declare the global.
 *
 * Example: <?php  ROC_Call()->method_name(); ?>
 *
 * @since 1.0.0
 *
 * @return object  ROC_Call class object.
 */
if ( ! function_exists( 'ROC_Call' ) ) :

 	function  ROC_Call() {
		return  ROC_Call::instance();
	}

endif;

ROC_Call();
