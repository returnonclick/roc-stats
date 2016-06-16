<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * ROC_Stat_Shortcode class.
 */
class  ROC_Stat_Shortcode {

	/**
	 * Constructor
	 */
	public function __construct() {

		//add_filter('widget_text', 'do_shortcode');
			
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_my_scripts') );
		
		// ADD handlers
		// add_shortcode( 'call_button', array($this, 'show_call_button' ));
		// add_shortcode( 'call_link', array($this, 'show_call_link' ));

		add_shortcode( 'call', array($this, 'show_call' ));

	}

	public function enqueue_my_scripts() {
		//global jquery 
		wp_enqueue_script('jquery');

		// Bootstrap
		wp_register_style('bootstrap-styles-roc', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), '3.3.6');
		wp_enqueue_style('bootstrap-styles-roc');

		// frontend JS to send Ajax
    	wp_register_script( 'roc_stat_plugin_js' , plugins_url( '/assets/js/script.js',  dirname( __FILE__ ) ), array('jquery') );
		wp_enqueue_script( 'roc_stat_plugin_js' );

		// frontend CSS
		wp_register_style( 'roc_stat_plugin_css' , plugins_url( '/assets/css/style.css',  dirname( __FILE__ ) ) );
		wp_enqueue_style( 'roc_stat_plugin_css' );

		//indicates to JS the ajax URL
		wp_localize_script( 'roc_stat_plugin_js', 'ajax_url', admin_url( 'admin-ajax.php' ) );		//set the variable at JS file

	}

	function show_call( $atts ) {			//, $content = ''
		extract( shortcode_atts( array(
			'to' 		=> '#',			//Default phone number
	        'hide' 		=> 'true',
	        'tag' 		=> 'default',
	        'content'	=> '',
	        'style'		=> ' ',
		), $atts ) );

		switch ($style) {
			case 'default':
				$style = 'phone-call-link btn  btn-'.$style;
				break;
				
			case 'primary':
				$style = 'phone-call-link btn  btn-'.$style;
				break;

			default:
				$style = 'phone-call-link '.$style;
				break;
		}


		$justNumbers=preg_replace('/\s+/', '', $to);

		$numberToShow = ($hide == 'true') ? substr($to, 0, -3) . '...' : $to;
		$content = ($content=='') ? $numberToShow : $content;
		$tag_link = '<a 
					data-phone-number= "'. $to .'"
					data-hidden="'.$hide.'"
					data-tag="'.$tag.'"
					class="' . strtolower( $style ) . '" 
					href="tel:' . $justNumbers . '" >
						<span class="phone-call-content " >' . $content . '</span></a>';

		return $tag_link;
	}
	
	// public function show_call_link($params){
	// 	extract( shortcode_atts( array(
	//         'phone_number' 	=> '#',			//Default phone number
	//         'hide' 			=> 'true',
	// 		'tag' 			=> 'default',
	//         'style'		=> ' ',		
 //    	), $params ) );

	// 	$justNumbers=preg_replace('/\s+/', '', $phone_number);
	// 	$numberToShow = substr($phone_number, 0, -3) . '...';
    	
 //    	$tag_link = '<a 
	// 				data-phone-number= "'. $phone_number .'"
	// 				data-hidden="'.$hide.'"
	// 				data-tag="'.$tag.'"
	// 				class="phone-call-link '.$style. '"
	// 				href="tel:'.$justNumbers .'" >'
	// 				.$numberToShow . '</a>';

 //    	return $tag_link;
	// }
	
	// function show_call_button( $atts , $content = '' ) {
	// 	extract( shortcode_atts( array(
	// 		'phone_number' 	=> '#',			//Default phone number
	//         'hide' 			=> 'true',
	//         'tag' 			=> 'default',
	//         'style'		=> ' ',
	// 	), $atts ) );

	// 	$justNumbers=preg_replace('/\s+/', '', $phone_number);
	// 	$numberToShow = substr($phone_number, 0, -3) . '...';
	// 	$content = ($content=='')?$numberToShow:$content;
	// 	$tag_link = '<a 
	// 				data-phone-number= "'. $phone_number .'"
	// 				data-hidden="'.$hide.'"
	// 				data-tag="'.$tag.'"
	// 				class="phone-call-link btn  btn-' . strtolower( $style ) . '" 
	// 				href="tel:' . $justNumbers . '" >' . $content . '</a>';

	// 	return $tag_link;
	// }
	

}

