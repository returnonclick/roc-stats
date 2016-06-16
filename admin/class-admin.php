<?php

/**
 * Class that holds most of the admin functionality for ROC Stat admin.
 */
class ROC_Stat_Admin {

	private $post_type; 
	private $date_from;
	private $date_to;
	public $warning_message;


	/**
	 * Class constructor
	 */
	function __construct() {
		add_action( 'admin_menu', array( $this, 'roc_stat_register_admin_page'));
		
		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts_styles' ));	
		
	}

	function load_scripts_styles($hook) {
		if('toplevel_page_roc-stats' != $hook && 'roc-statistics_page_roc-stats/shortcodes' != $hook ){
			return;
		}

		//jquery
		wp_enqueue_script('jquery');

		// Bootstrap
		wp_register_style('bootstrap-styles-roc', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), '3.3.6');
		wp_enqueue_style('bootstrap-styles-roc');

		wp_register_script('bootstrap-script-roc', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array(), '3.3.6');
		wp_enqueue_script('bootstrap-script-roc');

		wp_register_script('google-chart-roc', '//www.gstatic.com/charts/loader.js');
		wp_enqueue_script('google-chart-roc');

		wp_register_script('moment-datepicker-roc', '//cdn.jsdelivr.net/momentjs/latest/moment.min.js');
		wp_enqueue_script('moment-datepicker-roc');

		wp_register_script('daterangepicker-roc', '//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js', array('moment-datepicker-roc'));
		wp_enqueue_script('daterangepicker-roc');

		wp_register_style('daterangepicker-styles-roc', '//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css');
		wp_enqueue_style('daterangepicker-styles-roc');		

		wp_register_style( 'roc-stat-plugin' , plugins_url( '/assets/css/style.css',  dirname( __FILE__ ) ) );
		wp_enqueue_style( 'roc-stat-plugin' );	

		wp_register_script( 'roc-stat-plugin' , plugins_url( '/assets/js/script.js',  dirname( __FILE__ ) ) );
		wp_enqueue_script( 'roc-stat-plugin' );	
		
	}
	

	public function roc_stat_register_admin_page(){

		// Base 64 encoded SVG image
		$icon_svg = 'data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAMAAAC6V+0/AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABIFBMVEUAAACeo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6ieo6gAAABjugU9AAAAXnRSTlMABmfDyGwLYOvivLvda41kHhz6o3ncsKdd4S9jtAH09xdixfIJYft6vRgC5fB4wQfMb5igd5/xqKK5x8J76mhWDex2WoIFMSJRDkI+V+YspiMzEqTjDwzozckRfNiBKMUl9gAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxIAAAsSAdLdfvwAAADrSURBVBjTTdDnWgIxEIXhIwgKFhQELCg2wFVRERUb9t5797v/yzDZZYPzZ5J3nkwmkWx0RKKY6IzF5aKrGxLJnl7jfaH1Q2rALgZjaTItHCIb1uM58jYPj4yOEXWtCsSk8QmKk1NMO51hViXTvfxfU1Q0Z2cpe22dZ0GLFkl7VZaWA11BRYJQjdUA6w4TWqMe4Dra8K2hTbZab9xGO9Z2lQwPSzS1Z2z/4JCj0I450SmcncOFG77JpXR1fcPtnbN7qjY9wKOzDAU/Pz3zEnm1q7fSO7mwXDOXfTTynyZV2l//9f1jJ8v+ev72D8C0NzfyQOqRAAAAAElFTkSuQmCC';

		// Add main page
		$admin_page = add_menu_page('Return On Click Statistics', 
									'ROC Statistics', 
									'manage_options', 
									'roc-stats', 
									array( $this, 'load_stats_admin_page' ), 
									$icon_svg, 
									'100'  
									);

		add_submenu_page('roc-stats', 'Statistics Shortcodes', 'Shortcodes', 'manage_options', 'roc-stats/shortcodes', array( $this, 'load_shortcodes_admin_page'));
	}

	public function load_stats_admin_page(){
		global $wpdb;
		
		$this->post_type = ROC_Stat()->get_post_type();

		if(isset($_POST['usedaterange']) && sanitize_text_field($_POST['usedaterange']) == '1'){
			$dates = explode(" - ",sanitize_text_field( $_POST['daterange'] ));
			$this->date_from = date('Y-m-d 00:00:00',strtotime($dates[0]));
			$this->date_to = date('Y-m-d 23:59:59',strtotime($dates[1]));	
		}else{
			$this->date_from = date('Y-m-d 00:00:00',strtotime("-1 week"));
			$this->date_to = date('Y-m-d 23:59:59');	
		}

		$this->check_dependencies();
		
		$call_stat_table_result = $this->get_call_stat();
		$email_stat_table_result = $this->get_email_stat();
		$stat_chart = $this->get_all_stat_per_day();
		
		//Get template to show results
		require_once plugin_dir_path( __FILE__ ) . 'template/stats_admin.php';
		
	}
	

	public function load_shortcodes_admin_page(){

		//Get template to show results
		require_once plugin_dir_path( __FILE__ ) . 'template/shortcode_admin.php';
	}

	private function get_call_stat(){
		global $wpdb;

		$sql_query_daily = "	SELECT count($wpdb->posts.ID) as phone_clicks, DATE(post_date) as day, post_excerpt as tag
									FROM $wpdb->posts 
									WHERE post_type = '$this->post_type'
										AND post_title = 'call-stat' 
										AND post_date between '$this->date_from' and '$this->date_to'
									GROUP BY DATE(post_date), post_excerpt
									ORDER BY day, tag  DESC ";
		
		return $wpdb->get_results($sql_query_daily , OBJECT );

	}

	private function get_email_stat(){
		global $wpdb;
		
		$sql_query = "	SELECT count($wpdb->posts.ID) as emails_sent, DATE(post_date) as day, post_excerpt as form_name
									FROM $wpdb->posts 
									WHERE post_type = '$this->post_type'
										AND post_title = 'email-stat' 
										AND post_date between '$this->date_from' and '$this->date_to'
									GROUP BY DATE(post_date), post_excerpt
									ORDER BY day DESC ";
		
		return $wpdb->get_results($sql_query , OBJECT );

	}

	private function get_all_stat_per_day(){
		global $wpdb;
		
		$sql_query = "	SELECT count($wpdb->posts.ID) as total, DATE(post_date) as day, post_title as stat_name
									FROM $wpdb->posts 
									WHERE post_type = '$this->post_type' 
										AND post_date between '$this->date_from' and '$this->date_to'
									GROUP BY DATE(post_date), post_title
									ORDER BY day DESC ";
		
		$query_result = $wpdb->get_results($sql_query , OBJECT );
		$table = array();
		foreach ($query_result as $row) {
			if('call-stat' == $row->stat_name)
				$table[$row->day]['calls'] = $row->total;

			if('email-stat' == $row->stat_name)
				$table[$row->day]['emails'] = $row->total;
		}
		$strToChart = "";
		foreach ($table as $key => $value) {
			if(!isset($value['calls']) || !($value['calls']>0)) $value['calls'] = 0;
			if(!isset($value['emails']) || !($value['emails']>0)) $value['emails'] = 0;

			$table[$key]['average'] = round(($value['calls'] + $value['emails']) / 2);
			$strToChart .= ",['".date('d M', strtotime($key))."',  ".$value['calls'].",      ".$value['emails'].",			".$table[$key]['average']."		]";	
		}
		$final_result['table'] = $table;
		$final_result['strToChart'] = $strToChart;
		
		return $final_result;
	}

	public function check_dependencies(){
		$this->warning_message = '';
		if( !is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
			$this->warning_message .= '<h4>This stats depends on Contact Form 7 plugin, please download and activate it before use this plugin.</h4>';
		}
		
	}

} /* End of class */
