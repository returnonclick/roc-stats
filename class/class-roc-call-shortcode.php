<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * ROC_Call_Shortcode class.
 */
class  ROC_Call_Shortcode {

	/**
	 * Constructor
	 */
	public function __construct() {
		
		//wp_register_style('remodal_css', plugin_dir_path( __FILE__ ).'assets/css/remodal.css' );
		// wp_register_style('remodal_css', plugins_url( '/assets/css/remodal.css', __FILE__ ), false );
		// // wp_register_style('remodal-default-theme_css', plugin_dir_path( __FILE__ ).'assets/css/remodal-default-theme.css' );
		// wp_register_style('remodal-default-theme_css', plugins_url( '/assets/css/remodal-default-theme.css', __FILE__ ), false );
		// wp_enqueue_style('remodal_css');
		// wp_enqueue_style('remodal-default-theme_css');
		
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_my_scripts') );
		
		// ADD handlers
		add_shortcode( 'call_button', array($this, 'show_call_button' ));
		add_shortcode( 'call_link', array($this, 'show_call_link' ));

	}

	public function enqueue_my_scripts() {
		//global jquery 
		wp_enqueue_script('jquery');

		// frontend JS to send Ajax
    	wp_register_script( 'roc_call_plugin_js' , plugins_url( '/assets/js/script.js',  dirname( __FILE__ ) ), array('jquery') );
		wp_enqueue_script( 'roc_call_plugin_js' );
		wp_localize_script( 'roc_call_plugin_js', 'ajax_url', admin_url( 'admin-ajax.php' ) );		//set the variable at JS file

	}
	
	public function show_call_link($params){
		extract( shortcode_atts( array(
	        'phone_number' 	=> '#',			//Default phone number
	        'hide' 			=> 'true',
			'tag' 			=> 'default',
	        'style'		=> ' ',		
    	), $params ) );

		$justNumbers=preg_replace('/\s+/', '', $phone_number);
		$numberToShow = substr($phone_number, 0, -3) . '...';
    	
    	$tag_link = '<a 
					data-phone-number= "'. $phone_number .'"
					data-hidden="'.$hide.'"
					data-tag="'.$tag.'"
					class="phone-call-link '.$style. '"
					href="tel:'.$justNumbers .'" >'
					.$numberToShow . '</a>';

    	return $tag_link;
	}
	
	function show_call_button( $atts , $content = '' ) {
		extract( shortcode_atts( array(
			'phone_number' 	=> '#',			//Default phone number
	        'hide' 			=> 'true',
	        'tag' 			=> 'default',
	        'style'		=> ' ',
		), $atts ) );

		$justNumbers=preg_replace('/\s+/', '', $phone_number);
		$numberToShow = substr($phone_number, 0, -3) . '...';
		$content = ($content=='')?$numberToShow:$content;
		$tag_link = '<a 
					data-phone-number= "'. $phone_number .'"
					data-hidden="'.$hide.'"
					data-tag="'.$tag.'"
					class="phone-call-link btn  btn-' . strtolower( $style ) . '" 
					href="tel:' . $justNumbers . '" >' . $content . '</a>';

		return $tag_link;
	}
	

}

