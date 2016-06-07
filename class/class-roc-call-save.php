<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *  ROC_Call_Save class.
 */
class  ROC_Call_Save {

	protected $stat_id;

	/**
	 * Constructor
	 */
	public function __construct() {		
		//nothing to do at this moment

		// ADD handlers
		add_action( 'wp_ajax_save_call_click', array( $this, 'save_call_click'));
		add_action( 'wp_ajax_nopriv_save_call_click', array( $this, 'save_call_click') );
	}



	/**
	 * Save Call Click
	 * Saving all "clicks to call"
	 * This method uses POST table to save phone clicks on database
 	 */									
	public function save_call_click(){	
	    
		
		$clickDetails = json_decode(stripslashes($_POST['data']),true);
		
		$stats_data = array(
			'post_title'     => 'call-stat',					//Using post_title to save the Stat Name
			'post_content'   =>  json_encode($clickDetails),
			'post_excerpt'	 =>  $clickDetails['tag'],
			'post_type'      =>  ROC_Call()->get_post_type(),	//Using post_type to save the kind of the post 
			'comment_status' => 'closed'
		);

		//Saving the main post (main table)
		$this->stat_id = wp_insert_post( $stats_data );
		
		$return['post_id'] = $this->stat_id;

		wp_send_json(json_encode($return));
	    return $this->stat_id;
	}

	
}

