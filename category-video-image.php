<?php
/*
Plugin Name: Category video image
Description: This plugin adds video and image fields to category
Author: Dmytro Shevchenko
*/


define( 'CATEGORY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CATEGORY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );



require_once( CATEGORY_PLUGIN_DIR . 'includes/category_image.php' );
require_once( CATEGORY_PLUGIN_DIR . 'includes/category_video.php' );





add_action( 'admin_enqueue_scripts', 'load_media' );
function load_media() {
	wp_enqueue_media();
	wp_enqueue_script('admin_category_script', CATEGORY_PLUGIN_URL.'/assets/js/category_video_image_admin_script.js', array('jquery') );
	wp_enqueue_style('admin_category_style', CATEGORY_PLUGIN_URL.'/assets/css/category_video_image_admin_style.css' );
}


add_action( 'wp_enqueue_scripts', 'load_scripts' );
function load_scripts() {
	wp_enqueue_style('category_style', CATEGORY_PLUGIN_URL.'/assets/css/category_video_image_style.css' );
}



add_filter( 'category_description', 'insert_image_video_to_category_description', 10, 2 );
function insert_image_video_to_category_description( $description, $cat_id ) {

	if ( !is_admin() ){
		$new_description = '';
		$image_id = get_metadata('term', $cat_id, 'category_image_id')[0];
		if ( $image_id ) {
			$new_description .= '<div class="category_image">';
			$new_description .= wp_get_attachment_image ( $image_id, 'large' );
			$new_description .= '</div>';
		}

		$video_url = get_metadata('term', $cat_id, 'category_video_url')[0];
		if ( $video_url ) {
			$new_description .= '<div class="category_video">';
			$new_description .= apply_filters('the_content', $video_url);
			$new_description .= '</div>';
			
		}
		$new_description .= $description;

	} else{
		$new_description = $description;
	}

		return $new_description;
}




?>