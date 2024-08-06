<?php
/**
 * Plugin Name: Movie Listings
 * Description: Lists movies and info
 * Version: 1.0
 * Author: Shane Muirhead
 * Author URI:
 *
 * @package movie-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

require_once plugin_dir_path( __FILE__ ) . '/includes/movie-listings-scripts.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/movie-listings-cpt.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/movie-listings-settings.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/movie-listings-fields.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/movie-listings-reorder.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/movie-listings-shortcodes.php';
