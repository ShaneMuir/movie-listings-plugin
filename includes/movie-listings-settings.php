<?php
/**
 * Add movie listing settings to the reading sections in WP admin.
 *
 * @package movie-listings
 */

/**
 * Add movie listing settings.
 *
 * @return void
 */
function ml_movie_listings_settings(): void {
	add_settings_section(
		'ml_setting_section',
		'Movie Listings Settings',
		'ml_setting_section_callback',
		'reading'
	);

	add_settings_field(
		'ml_setting_show_editor',
		'Show Editor',
		'ml_setting_show_editor_callback',
		'reading',
		'ml_setting_section'
	);

	register_setting( 'reading', 'ml_setting_show_editor' );

	add_settings_field(
		'ml_setting_show_media_buttons',
		'Show Media Buttons',
		'ml_setting_show_media_buttons_callback',
		'reading',
		'ml_setting_section'
	);

	register_setting( 'reading', 'ml_setting_show_media_buttons' );
}

add_action( 'admin_init', 'ml_movie_listings_settings' );

/**
 * Register our settings section callback
 *
 * @return void
 */
function ml_setting_section_callback(): void {
	echo '<p>Settings for the Movie Listings plugin</p>';
}

/**
 * Show editor callback
 *
 * @return void
 */
function ml_setting_show_editor_callback(): void {
	echo '<input 
	name="ml_setting_show_editor" 
	id="ml_setting_show_editor" 
	type="checkbox" 
	value="1" 
	class="code" 
	' . checked( 1, get_option( 'ml_setting_show_editor' ), false ) . ' />
	Choose if details should be an editor';
}

/**
 * Show media buttons callback
 *
 * @return void
 */
function ml_setting_show_media_buttons_callback(): void {
	echo '<input 
	name="ml_setting_show_media_buttons" 
	id="ml_setting_show_media_buttons" 
	type="checkbox" 
	value="1" 
	class="code" 
	' . checked( 1, get_option( 'ml_setting_show_media_buttons' ), false ) . ' />
	Choose if media buttons should be enabled';
}
