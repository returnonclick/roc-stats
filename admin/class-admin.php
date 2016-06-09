<?php

/**
 * Class that holds most of the admin functionality for ROC Call admin.
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
		add_action( 'admin_menu', array( $this, 'roc_call_register_admin_page'));
		
		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts_styles' ));	
		
	}

	function load_scripts_styles($hook) {
		if('toplevel_page_roc-stats' != $hook){
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

		
	}
	

	public function roc_call_register_admin_page(){

		// Base 64 encoded SVG image
		$icon_svg = 'data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAATCAMAAACnUt2HAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAACOlBMVEUAAACPj49UVFSFhYUREREzMzNvb29qamqCgoLKyso9PT1cXFxwcHAgICB0dHR8fHzf399VVVUoKChISEigoKCFhYXMzMzLy8soKCiAgIB8fHykpKRbW1tkZGR0dHRMTEw5OTmhoaGNjY0mJiYuLi6Li4tvb29wcHCXl5coKChubm5WVlZgYGBwcHBxcXFZWVlfX1+4uLgXFxdbW1tgYGBsbGxra2tnZ2djY2OAgIA2NjZfX19bW1tnZ2cuLi43NzcyMjJGRkZDQ0M0NDRgYGAtLS01NTVVVVWqqqo+Pj4wMDBTU1Nzc3OmpqZ+fn5QUFAtLS2wsLDNzc0cHBxqamqJiYl9fX02NjZra2saGhpaWlqKiopiYmI/Pz8sLCwuLi4xMTFDQ0NpaWmOjo6lpaWsrKzR0dGoqKje3t5jY2NSUlImJiY2NjY3NzcuLi5vb29kZGRYWFgVFRUiIiJHR0dLS0sxMTFEREQoKChmZmZgYGBpaWlWVlYAAAA7OztQUFBMTEwaGhqpqanl5eU/Pz8RERF9fX1oaGg0NDRZWVm3t7fMzMzT09M1NTV0dHRnZ2dVVVUhISFfX1+tra3Q0NChoaEfHx9tbW1PT08gICCjo6Pi4uLHx8fPz88vLy9OTk5TU1NcXFxBQUFRUVE9PT1DQ0M6OjoZGRknJyd5eXl1dXV2dnZ4eHh/f38EBARubm5qampra2t6enqSkpJ3d3cCAgINDQ18fHxzc3NxcXGAgIBsbGxlZWUyMjI6tIzwAAAAY3RSTlMAAb1gAdjgm4cJxuodveATE4CVkCoIICrL4RQu+2EknOXNPmBbWutTYtvS0eFUbMbjLPnE41SLuN5O0vL3sO7Nl6Cbq5fs/v5zx/7+/ll//egSGemCTf6zReyfEHnJ6e/dqUDG3kfmAAAAAWJLR0QAiAUdSAAAAAlwSFlzAAALEgAACxIB0t1+/AAAAT1JREFUGNNjYIAARiZmBgzAwsrGzsGJLsqVnMLNgy7Im5rGx8/AICAoJCwCEREVE5dIz5CUYmCQlsnMkgUJyckrZOfk5uUrKimrqKoVFKoDxTSKinNLSsvKKzS1Kqu0daprdBkY9GrrCrPqGxqbmlta2/L1DdqBgoZGHZ2lpVkduV3dPb25fcYm/TWmDGatnQ0NpRMmTkqbPGXqtExzi+k1lgxWORNKS2c0zJw1e87c2aXzrG0K6m0Z7BrmNyxY0Ftc0zlhwsJF9g6OTs4uDK6lNYuXZLu5L122ZMmi5R4Qd3uWlazw8vZZuWr16jVrp/lCBP3W1fn7rFy/YePG9k0NAYEQwaDgpZvz+zds2FC9ZeXWEFhIhG5bFLZ9x84tu3a3hiPCJyKyuHzPxsK9rVHIoRYdExsXn5CYBBcAAHHhao2+ulFCAAAAAElFTkSuQmCC';

		// Add main page
		$admin_page = add_menu_page('Return On Click Statistics', 
									'ROC Statistics', 
									'manage_options', 
									'roc-stats', 
									array( $this, 'load_admin_page' ), 
									$icon_svg, 
									'100'  
									);
	}

	public function load_admin_page(){
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
		require_once plugin_dir_path( __FILE__ ) . 'template/admin.php';

		
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
		// if ( ! function_exists( 'buildpress_body_class' ) ) {
		// 	$this->warning_message .= '<h4>This stats depends on BuildPress Theme, please download and activate it before use this plugin.</h4>';	
		// }
	}

} /* End of class */
