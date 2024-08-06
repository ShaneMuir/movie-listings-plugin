<?php
/**
 * Shortcode logic for listing our movies on the
 * frontend.
 *
 * @package movie-listings
 */

/**
 * List Movies on the frontend via shortcode
 *
 *
 *
 * @param array $atts
 * @param null $content
 *
 * @return string
 */
function ml_list_movies( array $atts, $content = null ): string {
	$atts = shortcode_atts(array(
		'title'      => 'Latest Movies',
		'count'      => 3,
		'genre'      => 'all',
		'pagination' => 'on'
	), $atts);

	$pagination = ! ( $atts['pagination'] === 'on' );
	$paged      = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

	// Check the genre.
	if ($atts['genre'] === 'all') {
		$terms = '';
	} else {
		$terms = array(array(
			'taxonomy' => 'genres',
			'field'    => 'slug',
			'terms'    => $atts['genre']
		));
	}

	// Main query args.
	$args = array(
		'post_type'        => 'movie_listing',
		'post_status'      => 'publish',
		'orderby'          => 'menu_order',
		'order'            => 'ASC',
		'no_found_rows'    => $pagination,
		'posts_per_page'   => $atts['count'],
		'paged'            => $paged,
		'tax_query'        => $terms,
	);

	// Get movies.
	$movies = new WP_Query( $args );

	if ( $movies->have_posts() ) {
		$genre = str_replace( '-', ' ', $atts['genre'] );

		$output = '<div class="movie-list">';

		while ( $movies->have_posts() ) {
			$movies->the_post();
			$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-post-thumbnail');

			$movie_title = esc_html(get_the_title());
			$movie_permalink = esc_url(get_permalink());
			$image_src = esc_url($image[0]);

			$output .= <<<HTML
            <div class="movie-col">
                <img class="feat-image" src="$image_src" alt="$movie_title">
                <h5 class="movie-title">$movie_title</h5>
                <a href="$movie_permalink">View Details</a>
            </div>
            HTML;
		}
		$output .= '</div>';

		// Clear float.
		$output .= '<div style="clear:both"></div>';

		// Pagination
		if ($movies->max_num_pages > 1 && is_page()) {
			$prev_link = get_next_posts_link(__('<span class="meta-nav">&larr;</span> Previous'), $movies->max_num_pages);
			$next_link = get_previous_posts_link(__('<span class="meta-nav">&rarr;</span> Next'));

			$output .= <<<HTML
            <nav class="prev-next-posts">
                <div class="nav-previous">
                    $prev_link
                </div>
                <div class="next-posts-link">
                    $next_link
                </div>
            </nav>
            HTML;
		}

		wp_reset_postdata();

		return $output;
	} else {
		return '<p>No Movies Found.</p>';
	}
}
add_shortcode( 'movies', 'ml_list_movies' );
