<?php
/**
 * Register movie listings fields for the CPT.
 *
 * @package movie-listings
 */

/**
 * Add fields.
 *
 * @return void
 */
function ml_add_fields_metabox(): void {
	add_meta_box(
		'ml_listing_info',
		__( 'Listing Info', 'movie-listings' ),
		'ml_add_fields_callback',
		'movie_listing',
		'normal',
		'default'
	);
}

add_action( 'add_meta_boxes', 'ml_add_fields_metabox' );

/**
 * Add fields callback.
 *
 * @param object $post the post object.
 *
 * @return void
 */
function ml_add_fields_callback( object $post ): void {
	wp_nonce_field( basename( __FILE__ ), 'ml_movie_listings_nonce' );

	$ml_stored_meta = get_post_meta( $post->ID );
	?>
		<div class="wrap movie-listing-form">
			<div class="form-group">
				<label for="movie_id"><?php esc_html_e( 'Movie Listing ID', 'movie-listings' ); ?></label>
				<input type="text" name="movie_id" id="movie_id" value="<?php if ( ! empty( $ml_stored_meta['movie_id'] ) ) {echo esc_attr( $ml_stored_meta['movie_id'][0] );} ?>">
			</div>

			<div class="form-group">
				<label for="mpaa_rating"><?php esc_html_e( 'MPAA Rating', 'movie-listings' ); ?></label>
				<select name="mpaa_rating" id="mpaa_rating">
					<?php
					$option_name = array( 'G', 'PG', 'PG-13', 'R', 'NR' );
					foreach ( $option_name as $key => $value ) {
						if ( $value === $ml_stored_meta['mpaa_rating'][0] ) {
							?>
								<option selected><?php echo esc_attr( $value ); ?></option>
							<?php
						} else {
							?>
							<option><?php echo esc_attr( $value ); ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>

            <?php if ( get_option( 'ml_setting_show_editor' ) ) : ?>
                <div class="form-group">
                    <label for="details"><?php esc_html_e( 'Details', 'movie-listings' ); ?></label>
                    <?php
                    $content  = get_post_meta( $post->ID, 'details', true );
                    $editor   = 'details';
                    $settings = array(
                        'textarea_rows' => 5,
                        'media_buttons' => get_option('ml_setting_show_media_buttons'),
                    );

                    wp_editor( $content, $editor, $settings );
                    ?>
                </div>
            <?php else : ?>
                <div class="form-group">
                    <label for="details"><?php esc_html_e( 'Details', 'movie-listings' ); ?></label>
                    <textarea class="full" name="details" id="details"><?php if ( ! empty( $ml_stored_meta['details'] ) ) {echo esc_html($ml_stored_meta['details'][0]);}?></textarea>
                </div>
            <?php endif; ?>

			<div class="form-group">
				<label for="release_date"><?php esc_html_e( 'Release Date', 'movie-listings' ); ?></label>
				<input type="date" name="release_date" id="release_date" value="<?php if ( ! empty( $ml_stored_meta['release_date'] ) ) {echo esc_attr( $ml_stored_meta['release_date'][0] );} ?>">
			</div>

			<div class="form-group">
				<label for="director"><?php esc_html_e( 'Director', 'movie-listings' ); ?></label>
				<input type="text" name="director" id="director" value="<?php if ( ! empty( $ml_stored_meta['director'] ) ) {echo esc_attr( $ml_stored_meta['director'][0] );} ?>">
			</div>

			<div class="form-group">
				<label for="stars"><?php esc_html_e( 'Stars', 'movie-listings' ); ?></label>
				<input type="text" name="stars" id="stars" value="<?php if ( ! empty( $ml_stored_meta['stars'] ) ) {echo esc_attr( $ml_stored_meta['stars'][0] );} ?>">
			</div>

			<div class="form-group">
				<label for="runtime"><?php esc_html_e( 'Runtime', 'movie-listings' ); ?></label>
				<input type="text" name="runtime" id="runtime" value="<?php if ( ! empty( $ml_stored_meta['runtime'] ) ) {echo esc_attr( $ml_stored_meta['runtime'][0] );} ?>"><span class="mins"> Mins</span>
			</div>

			<div class="form-group">
				<label for="trailer"><?php esc_html_e( 'Youtube ID / Trailer', 'movie-listings' ); ?></label>
				<input type="text" name="trailer" id="trailer" value="<?php if ( ! empty( $ml_stored_meta['trailer'] ) ) {echo esc_attr( $ml_stored_meta['trailer'][0] );} ?>">
			</div>

		</div>
	<?php
}

/**
 * Save post meta
 *
 * @param int $post_id The post ID.
 *
 * @return void
 */
function ml_meta_save( int $post_id ): void {
	$is_autosave    = wp_is_post_autosave( $post_id );
	$is_revision    = wp_is_post_revision( $post_id );
	$nonce          = isset( $_POST['ml_movie_listings_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['ml_movie_listings_nonce'] ) ) : '';
	$is_valid_nonce = $nonce && wp_verify_nonce( $nonce, basename( __FILE__ ) );

	if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
		return;
	}

	if ( ! empty( $_POST['movie_id'] ) ) {
		update_post_meta( $post_id, 'movie_id', sanitize_text_field( wp_unslash( $_POST['movie_id'] ) ) );
	}

	if ( ! empty( $_POST['movie_id'] ) ) {
		update_post_meta( $post_id, 'movie_id', sanitize_text_field( wp_unslash( $_POST['movie_id'] ) ) );
	}

	if ( ! empty( $_POST['mpaa_rating'] ) ) {
		update_post_meta( $post_id, 'mpaa_rating', sanitize_text_field( wp_unslash( $_POST['mpaa_rating'] ) ) );
	}

	if ( ! empty( $_POST['details'] ) ) {
		update_post_meta( $post_id, 'details', sanitize_text_field( wp_unslash( $_POST['details'] ) ) );
	}

	if ( ! empty( $_POST['release_date'] ) ) {
		update_post_meta( $post_id, 'release_date', sanitize_text_field( wp_unslash( $_POST['release_date'] ) ) );
	}

	if ( ! empty( $_POST['director'] ) ) {
		update_post_meta( $post_id, 'director', sanitize_text_field( wp_unslash( $_POST['director'] ) ) );
	}

	if ( ! empty( $_POST['stars'] ) ) {
		update_post_meta( $post_id, 'stars', sanitize_text_field( wp_unslash( $_POST['stars'] ) ) );
	}

	if ( ! empty( $_POST['runtime'] ) ) {
		update_post_meta( $post_id, 'runtime', sanitize_text_field( wp_unslash( $_POST['runtime'] ) ) );
	}

	if ( ! empty( $_POST['trailer'] ) ) {
		update_post_meta( $post_id, 'trailer', sanitize_text_field( wp_unslash( $_POST['trailer'] ) ) );
	}
}

add_action( 'save_post', 'ml_meta_save' );
