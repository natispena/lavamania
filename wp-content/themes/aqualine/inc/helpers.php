<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Helper functions and classes with static methods for usage in theme
 */


/**
 * Getter function for Featured Content Plugin.
 *
 * @return array An array of WP_Post objects.
 */
function aqualine_get_featured_posts() {
	
	/**
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'aqualine_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @return bool Whether there are featured posts.
 */
function aqualine_has_featured_posts() {
	
	return ! is_paged() && (bool) aqualine_get_featured_posts();
}

/**
 * Print the attached image with a link to the next attached image.
 */ 
if ( ! function_exists( 'aqualine_the_attached_image' ) ) {

	function aqualine_the_attached_image() {
		$post = get_post();
		/**
		 * Filter the default attachment size.
		 *
		 * @param array $dimensions {
		 *     An array of height and width dimensions.
		 *
		 * @type int $height Height of the image in pixels. Default 810.
		 * @type int $width Width of the image in pixels. Default 810.
		 * }
		 */
		$attachment_size     = apply_filters( 'aqualine_attachment_size', array( 810, 810 ) );
		$next_attachment_url = wp_get_attachment_url();

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => - 1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id ) {
				$next_attachment_url = get_attachment_link( $next_id );
			} // End if().
			else {
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
			}
		}

		printf( '<a href="%1$s" rel="attachment">%2$s</a>',
			esc_url( $next_attachment_url ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
}


/**
 * Print a list of all site contributors who published at least one post.
 */
if ( ! function_exists( 'aqualine_list_authors' ) ) {

	function aqualine_list_authors() {

		$contributor_ids = get_users( array(
			'fields'  => 'ID',
			'orderby' => 'post_count',
			'order'   => 'DESC',
			'who'     => 'authors',
		) );

		foreach ( $contributor_ids as $contributor_id ) :
			$post_count = count_user_posts( $contributor_id );

			// Move on if user has not published a post (yet).
			if ( ! $post_count ) {
				continue;
			}
			?>

			<div class="contributor">
				<div class="contributor-info">
					<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
					<div class="contributor-summary">
						<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name',
						$contributor_id ); ?></h2>

						<p class="contributor-bio">
							<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
						</p>
						<a class="button contributor-posts-link"
						   href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
							<?php printf( _n( '%d Article', '%d Articles', $post_count, 'aqualine' ), $post_count ); ?>
						</a>
					</div>
					<!-- .contributor-summary -->
				</div>
				<!-- .contributor-info -->
			</div><!-- .contributor -->

		<?php
		endforeach;
	}
}


/**
 * Display navigation to next/previous set of posts when applicable.
 */ 
if ( ! function_exists( 'aqualine_paging_nav' ) ) {

	function aqualine_paging_nav( $wp_query = null ) {

		if ( ! $wp_query ) {
			$wp_query = $GLOBALS['wp_query'];
		}

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link,
		'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%',
		'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $wp_query->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 1,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => '',
			'next_text' => '',
		) );

		if ( $links ) :
		?>
		<div class="clearfix"></div>
		<nav class="navigation paging-navigation">
			<h3 class="screen-reader-text"><?php echo esc_html__( 'Posts navigation', 'aqualine' ); ?></h3>
			<div class="pagination loop-pagination">
				<?php 
				if ( $paged == 1 ) {

					echo '<a href="#" class="prev page-numbers disabled"></a>';
				}

				echo wp_kses_post( $links );
				
				if ( $paged == $wp_query->max_num_pages ) {

					echo '<a href="#" class="next page-numbers disabled"></a>';
				}
				?>
			</div>
		</nav>
		<?php
		endif;
	}
}

/**
 * Display navigation to next/previous post when applicable.
 */
if ( ! function_exists( 'aqualine_post_nav' ) ) {

	function aqualine_post_nav() {

		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '',
		true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}

		?>
		<nav class="navigation post-navigation clearfix" role="navigation">
			<h3 class="screen-reader-text"><?php echo esc_html__( 'Post navigation', 'aqualine' ); ?></h3>

			<div class="nav-links">
				<?php
					if ( !empty($previous) ) {

						previous_post_link( '%link', esc_html( '%title' ) );
					}

					if ( !empty($next) ) {

						next_post_link( '%link',  esc_html( '%title' ) );
					}
				?>
			</div>
		</nav>
		<?php

	}
}

/**
 * Find out if blog has more than one category.
 *
 * @return boolean true if blog has more than 1 category
 */
function aqualine_categorized_blog() {

	if ( false === ( $all_the_cats = get_transient( 'aqualine_category_count' ) ) ) {

		$all_the_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		$all_the_cats = count( $all_the_cats );

		set_transient( 'aqualine_category_count', $all_the_cats );
	}

	if ( 1 !== (int) $all_the_cats ) {

		return true;
	}
		else {

		return false;
	}
}

