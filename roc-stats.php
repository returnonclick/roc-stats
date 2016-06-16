<?php
/**
 * Plugin Name: 	ROC - Statistics
 * Plugin URI:		http://wordpress.org/plugins/roc-call-tracking/
 * Description:		Save phone clicks and emails sent stats and show it for admin users
 * Version: 		1.0
 * Author:      	Return On Click
 * Author URI:  	http://www.returnonclick.com.au
 * Text Domain: 	roc-stats
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class  ROC_Call.
 *
 * Main ROC - Statistics.
 *
 * @class		 ROC_Call
 * @version		1.0
 * @author		Jossandro Balardin
 */
class  ROC_Stat {

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
		require_once plugin_dir_path( __FILE__ ) . 'class/class-roc-stats-save.php';
		require_once plugin_dir_path( __FILE__ ) . 'class/class-roc-stats-shortcode.php';
		require_once plugin_dir_path( __FILE__ ) . 'class/class-widget-roc-iconbox.php';
		//Admin Class
		require_once plugin_dir_path( __FILE__ ) . 'admin/class-admin.php';
		
		//==== Adding new post type for STATS Plugin
		add_action( 'init', array($this,'register_types' ));

		
		//Instantiate objects, initialize classes and objects
		new ROC_Stat_shortcode();
		new ROC_Stat_Save();
		new ROC_Stat_Admin();
		new ROC_Icon_Box();
		
	}

	public function register_types() {
		// Interest post type
		register_post_type( 'statistic',
			array(
				'labels' => array(
					'name' => __( 'Statistics' ),
					'singular_name' => __( 'Statistic' )
					),
				'public' => false,
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
 * The main function responsible for returning the  ROC_Stat object.
 *
 * Use this function like you would a global variable, except without needing to declare the global.
 *
 * Example: <?php  ROC_Stat()->method_name(); ?>
 *
 * @since 1.0.0
 *
 * @return object  ROC_Stat class object.
 */
if ( ! function_exists( 'ROC_Stat' ) ) :

 	function  ROC_Stat() {
		return  ROC_Stat::instance();
	}

endif;

ROC_Stat();
