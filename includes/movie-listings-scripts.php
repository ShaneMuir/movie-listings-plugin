<?php
/**
 * Movie listings script
 *
 * @package movie-listings
 */

/**
 * Add admin scripts for our plugin
 */
function ml_add_admin_scripts(): void {
	wp_enqueue_style( 'jquery-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css', null, '1.0' );
	wp_enqueue_style( 'ml-style', plugins_url() . '/movie-listings/css/style-admin.css', null, '1.0' );
	wp_enqueue_script( 'ml-script', plugins_url() . '/movie-listings/js/main.js', array( 'jquery', 'jquery-ui-sortable' ), '1.0', true );
	wp_localize_script('ml-script','ML_MOVIE_LISTING', array(
		'token' => wp_create_nonce('ml-token')
	));
}
add_action( 'admin_init', 'ml_add_admin_scripts' );

/**
 * Add frontend scripts for our plugin
 */
function ml_add_scripts(): void {
	wp_enqueue_style( 'ml-style', plugins_url() . '/movie-listings/css/style.css', null, '1.0' );
	wp_enqueue_script( 'ml-script', plugins_url() . '/movie-listings/js/main.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'ml_add_scripts' );
