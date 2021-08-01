<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Functions which displays html parts of theme on output
 */


/**
 * Single comment function
 */
if ( !function_exists( 'aqualine_single_comment' ) ) {

	function aqualine_single_comment( $comment, $args, $depth ) {

		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) {
			case 'pingback' :
				?>
				<li class="trackback">
				<?php
					esc_html_e( 'Trackback:', 'aqualine' );
					comment_author_link();
					edit_comment_link( esc_html__( 'Edit', 'aqualine' ), '<span class="edit-link">', '<span>' );
				break;
			case 'trackback' :
				?>
				<li class="pingback">
				<?php
					esc_html_e( 'Pingback:', 'aqualine' );
					comment_author_link();
					edit_comment_link( esc_html__( 'Edit', 'aqualine' ), '<span class="edit-link">', '<span>' );
				break;
			default :
				$author_id = $comment->user_id;
				$author_link = get_author_posts_url( $author_id );
				?>
				<li <?php comment_class( 'comment_item' ); ?>>
					<article id="comment-<?php comment_ID(); ?>" class="comment-body comment-single">
						<div class="comment-author-avatar">
							<?php
								echo get_avatar( $comment, 64 );
							?>
						</div>
						<div class="comment-content">
							<div class="comment-info">
	                            <span class="comment-date-time">
	                            	<span class="comment-date">
	                            		<span class="date-value">
		                            		<span class="comment_date_value">
		                            		<?php
		                            			echo get_comment_date( get_option( 'date_format' ) );
		                            		?> 
		                            		</span>
			                            	<?php echo esc_html__( 'at', 'aqualine' ); ?>
			                            	<span class="comment-time">
			                            	<?php
			                            		echo get_comment_date( get_option( 'time_format' ) );
			                            	?>
			                            	</span>
		                            	</span>
	                            	</span>
	                            </span>
	                            <h6 class="comment-author">
	                            <?php
                            		echo ( ! empty( $author_id ) ? '<a href="' . esc_url( $author_link ) . '">' : '') . comment_author() . ( ! empty( $author_id ) ? '</a>' : '');
                            	?>
	                            </h6>
								<?php if ( $comment->comment_approved == 0 ): ?>
								<div class="comment_not_approved"><?php esc_html_e( 'Your comment is awaiting moderation.', 'aqualine' ); ?></div>
								<?php endif; ?>	                            
							</div>
							<div class="comment_text_wrap">
								<div class="comment-text"><?php comment_text(); ?></div>
							</div>
							<?php if ( $depth < $args['max_depth'] ): ?>
								<div class="comment-reply">
								<?php
									comment_reply_link( array_merge( $args, array(
									'depth' => $depth,
									'max_depth' => $args['max_depth'],
									) ) );
								?>
								</div>
							<?php endif; ?>
						</div>
					</article>
				<?php
				break;
		}
	}
}


/**
 * Display html code of "before footer" section
 */
if ( !function_exists( 'aqualine_the_before_footer' ) ) {
	
	function aqualine_the_before_footer() {

		global $wp_query;

		if ( is_404() ) {

			return false;
		}

	    if ( function_exists( 'FW' ) ) {

	    	$layout_page = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'before-footer-layout' );

	    	// Getting global settings
        	if ( !empty( $layout_page ) AND $layout_page != 'default' ) {

        		$id = $layout_page;
        	}
        		else
        	if ( $layout_page !== '' ) {

        		$id = fw_get_db_settings_option( 'before-footer-section' );
       		}

        	if ( !empty( $id ) ) {

        		$section = get_page( $id );
				$custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
        	}	    	

	        if ( !empty($section) ) {

	            echo '<div class="ltx-before-footer-wrapper"><div class="ltx-before-footer"><div class="container">'.do_shortcode($section->post_content).'</div></div></div>';
	        }        	
	    }

	    return true;
	}
}

/**
 * Print html code with footer subscribe section
 */
if ( !function_exists( 'aqualine_the_subscribe_block' ) ) {
	
	function aqualine_the_subscribe_block() {

		global $wp_query;

	    if ( function_exists( 'FW' ) ) {

	        $copyright_layout = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'footer-layout' );
	        if ( $copyright_layout == 'simple' OR $copyright_layout == 'copyright' OR $copyright_layout == 'copyright-transparent' ) {

	        	return false;
	        }    	

	        if ( is_404() ) {

	        	return false;
	        }

	    	$subscribe_layout = 'visible';

	        $subscribe_layout_global = fw_get_db_settings_option( 'subscribe-section' );

	        if ( !empty($subscribe_layout_global) ) {

	        	$subscribe_layout = 'visible';
	        }
	            else
	        if ( $subscribe_layout_global == 'hidden' OR empty($subscribe_layout_global) ) {

	        	$subscribe_layout = 'disabled';
	        }

	        if ( $subscribe_layout != 'disabled' ) {

	        	// If default visibility, cheking page settings
	        	$subscribe_layout_page = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'subscribe-layout' );

		        if ( $subscribe_layout_global == 'default' OR $subscribe_layout_page == 'disabled' ) {

		        	$subscribe_layout = $subscribe_layout_page;
		        }

	        	$subscribe_id = fw_get_db_settings_option( 'subscribe-section' );

	        	if ( !empty( $subscribe_id ) ) {

	        		$subscribe_section = get_page( $subscribe_id );

					$page_id = apply_filters( 'wpml_object_id', $subscribe_section->ID, 'page' );

					if ( empty($page_id) ) $page_id = $subscribe_id;
					$page_data = get_page( $page_id );	        		
	        	}
	        }

	        if ( !empty($subscribe_id) ) {

				$shortcodes_custom_css = get_post_meta( $subscribe_id, '_wpb_shortcodes_custom_css', true );
				if ( ! empty( $shortcodes_custom_css ) ) {

				    $ltx_custom_css = strip_tags( $shortcodes_custom_css );
				}	        
		        

		        if ( !empty($subscribe_section) AND !empty($subscribe_layout) AND $subscribe_layout != 'disabled' ) {

		            echo '<div class="subscribe-wrapper"><div class="container"><div class="subscribe-block">';
		            echo apply_filters('the_content', $page_data->post_content);
		            echo '</div></div></div>';
		        }
		    }
	    }

	    return true;
	}
}


/**
 * Print html code with topbar section
 */
if ( !function_exists( 'aqualine_the_topbar_block' ) ) {

	function aqualine_the_topbar_block( $navbar_layout ) {

		global $wp_query;

	    if ( function_exists( 'FW' ) ) {

	    	$topbar_layout = 'hidden';
	        $topbar_layout = fw_get_db_settings_option( 'topbar' );

	        if ( $topbar_layout != 'hidden' ) {

	        	$topbar_id = fw_get_db_settings_option( 'topbar-section' );
	        	if ( !empty( $topbar_id ) ) {

	        		$topbar_section = get_page( $topbar_id );
	        	}

	        	// If default visibility, cheking page settings
	        	$topbar_layout_page = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'topbar-layout' );
    	
		        if ( $topbar_layout_page == 'hidden' ) {

		        	unset($topbar_section);
		        }
		        	else
				if ( !empty($topbar_layout_page) AND $topbar_layout_page != 'default' ) {

					$topbar_id = $topbar_layout_page;
					$topbar_section = get_page( $topbar_layout_page );
				}

        		$custom_css = get_post_meta( $topbar_id, '_wpb_shortcodes_custom_css', true );
	        }

	        if ( !empty($topbar_section) ) {

	        	if ($topbar_layout == 'desktop') {

	        		$topbar_class = ' hidden-ms hidden-xs hidden-sm';
	        	}
	        		else
	        	if ($topbar_layout == 'desktop-tablet') {

	        		$topbar_class = ' hidden-ms hidden-xs';
	        	}	    
	        		else
	        	if ($topbar_layout == 'mobile') {

	        		$topbar_class = ' visible-ms visible-xs';
	        	}	    	        	    	
	        		else {

	        		$topbar_class = '';
	        	}

	            echo '<div class="ltx-topbar-block'.esc_attr($topbar_class).' ltx-topbar-before-'.esc_attr($navbar_layout).'"><div class="container">'.apply_filters('the_content', $topbar_section->post_content).'</div></div>';
	        }
	    }

	    return true;
	}
}

/**
 * Prints Footer widgets block
 */
if ( !function_exists( 'aqualine_the_footer_logo_section' ) ) {

	function aqualine_the_footer_logo_section() {

		if ( !function_exists( 'FW' ) ) {

			return false;
		}

		$section_layout = fw_get_db_settings_option( 'footer_top_layout' );
		if ( empty ($section_layout) OR $section_layout == 'hidden' ) {

			return false;
		}

        $aqualine_logo = fw_get_db_settings_option( 'logo' );
		?>
		<section id="ltx-logo-footer">

			<div class="container">
	            <?php

					if ( !empty($aqualine_logo) ) {

						echo '<span class="logo-footer">'.wp_get_attachment_image( $aqualine_logo['attachment_id'], 'full' ).'</span>';
					}

					aqualine_the_social_footer();
	            ?>
			</div>
		</section>
		<?php		
	}
}


/**
 * Displays footer social icons
 */
if ( !function_exists( 'aqualine_the_footer_icons' ) ) {

	function aqualine_the_footer_icons() {

		if ( !function_exists( 'FW' ) ) {

			return false;
		}

		$icons = fw_get_db_settings_option( 'footer-icons' );

		$target = "_blank";
		
		if ( !empty($icons) ) {

			if ( sizeof($icons) >= 3) {

				$col = 'col-lg-3 col-md-6 col-sm-6';
			}
				else
			if ( sizeof($icons) == 3) {

				$col = 'col-md-4';
			}
				else
			if ( sizeof($icons) == 2) {

				$col = 'col-md-6';
			}
				else {

				$col = 'col-md-12';
			}

			echo '<div class="ltx-footer-social">';

				echo '<div class="container">';
					echo '<div class="row">';
						foreach ($icons as $item ) {

							if ( !empty($item['href']) ) {

								echo '<div class="'.esc_attr($col).'"><a href="'. esc_url( $item['href'] ) .'" target="'.esc_attr( $target ).'" class="item" data-mh="ltx-social-footer"><span class="icon '. esc_attr( $item['icon_v2']['icon-class'] ) .'"></span><span class="header">'.esc_html($item['text']).'</span></a></div>';
							}
								else {

								echo '<div class="'.esc_attr($col).'"><span class="item" data-mh="ltx-social-footer"><span class="icon'. esc_attr( $item['icon_v2']['icon-class'] ) .'"></span><span class="header">'.esc_html($item['text']).'</span></span></div>';
							}
						}
					echo '</div>';

				echo '</div>';
			echo '</div>';
		}		
	}
}



/**
 * Prints Footer widgets block
 */
if ( !function_exists( 'aqualine_the_footer_widgets' ) ) {

	function aqualine_the_footer_widgets( $layout = null ) {

		global $wp_query;

		$footer_class = '';
		if ( function_exists( 'FW' ) ) {

	        $copyright_layout = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'footer-layout' );
	        if ( $copyright_layout == 'simple' OR $copyright_layout == 'copyright' OR $copyright_layout == 'copyright-transparent' ) {

	        	return false;
	        }

	        $footer_class = 'ltx-fw';
		}

        if ( is_404() ) {

        	return false;
        }

	    $aqualine_footer_cols = aqualine_get_footer_cols_num();
	    if ( $aqualine_footer_cols['num'] > 0 ): ?>
		<section id="ltx-widgets-footer" class="<?php echo esc_attr($footer_class); ?>" >
			<div class="container">
				<div class="row row-center-x">
	                <?php
	                for ($x = 1; $x <= 4; $x++): ?>
	                    <?php if ( !isset($aqualine_footer_cols['hidden'][ $x ]) && is_active_sidebar( 'footer-' . $x ) ): ?>
						<div class="<?php echo esc_attr( $aqualine_footer_cols['classes'][$x] ).' '.esc_attr( $aqualine_footer_cols['hidden_mobile'][$x] ).' '.esc_attr( $aqualine_footer_cols['hidden_md'][$x] ); ?> clearfix">    
							<div class="footer-widget-area">
								<?php
	                                dynamic_sidebar( 'footer-' . $x );
	                            ?>
							</div>
						</div>
						<?php endif; ?>
	                <?php
	                endfor; ?>
				</div>
			</div>
		</section>
	    <?php endif;
	}
}


/**
 * Display logo
 */
if ( !function_exists( 'aqualine_get_the_logo' ) ) {

	function aqualine_get_the_logo( $layout = null ) {

		$srcset = '';

		$html = '';
		$html .= '<a class="logo" href="'. esc_url( home_url( '/' ) ) .'">';

		if ( function_exists( 'FW' ) ) {

			$current_scheme =  apply_filters ('aqualine_current_scheme', array());
			
			if ($current_scheme == 'default') {

				$current_scheme = 1;
			}

			$color_schemes = array();
			$color_schemes_ = fw_get_db_settings_option( 'items' );
			if ( !empty($color_schemes_) ) {

				foreach ($color_schemes_ as $v) {

					$color_schemes[$v['slug']] = $v;
				}			
			}

			if ( !empty($current_scheme) AND $current_scheme != 'default' ) {

				if (!empty( $color_schemes[$current_scheme]['logo'])) {

					if ( empty($layout) OR $layout == 'black' ) {

						$logo = $color_schemes[$current_scheme]['logo'];
						$logo_2x = $color_schemes[$current_scheme]['logo_2x'];
					}
						else
					if ( $layout == 'white' ) {

						$logo = $color_schemes[$current_scheme]['logo_white'];
						$logo_2x = $color_schemes[$current_scheme]['logo_white_2x'];
					}

				}
			}

			
			if ( empty($logo) ) {

				if ( empty($layout) OR $layout == 'black') {

					$logo = fw_get_db_settings_option( 'logo' );	
					$logo_2x = fw_get_db_settings_option( 'logo_2x' );	
				}
					else
				if ( $layout == 'white' ) {

					$logo = fw_get_db_settings_option( 'logo_white' );	
					$logo_2x = fw_get_db_settings_option( 'logo_white_2x' );	
				}
			}

			if ( !empty($logo) ) {

				$logo = $logo['url'];
			}

			if ( !empty($logo_2x) ) {

				$logo_2x = $logo_2x['url'];
			}

			if ( !empty($logo) AND !empty($logo_2x) ) {

				$srcset = array();
				$srcset[] = $logo .' 1x';
				$srcset[] = $logo_2x .' 2x';

				$srcset = implode(',', $srcset);
			}

		}

		if ( empty( $logo ) ) {

			if ( !empty($layout) AND $layout == 'white' ) {

				$logo = get_template_directory_uri() . '/assets/images/logo-white.png';
			}
				else {

				$logo = get_template_directory_uri() . '/assets/images/logo.png';
			}
		}

		if ( !empty($srcset) ) {

			$html .= '<img src="'. esc_url( $logo ) . '" alt="' . esc_attr( get_bloginfo( 'title' ) ) . '" srcset="'.esc_attr($srcset).'">';
		}
			else {

			$html .= '<img src="'. esc_url( $logo ) . '" alt="' . esc_attr( get_bloginfo( 'title' ) ) . '">';
		}


		$html .= '</a>';

		return $html;
	}

	function aqualine_the_logo( $layout = null ) {

		echo aqualine_get_the_logo($layout);
	}
}

/**
 * Display H1 header
*/
if ( !function_exists( 'aqualine_the_h1' ) ) {

	function aqualine_the_h1() {

		$title = aqualine_get_the_h1();
		if ( !empty($title) ) echo '<div class="ltx-header-h1-wrapper"><h1 class="header">' . wp_kses( $title, 'header' ) . '</h1></div>';
	}
}

/**
 * Prints page overlay, if enabled
 * also adds theme page loader code
 */
if ( !function_exists( 'aqualine_the_pageloader_overlay' ) ) {

	function aqualine_the_pageloader_overlay() {

		if ( function_exists( 'FW' ) ) {

			$pace = fw_get_db_settings_option( 'page-loader' );

			if ( !empty($pace) AND ((!empty($pace['loader']) AND $pace['loader'] != 'disabled') OR 
			   ( !empty($pace) AND $pace['loader'] != 'disabled') ) ) {

				echo '<div id="ltx-preloader" data-loader="'.esc_html__( 'Loading...', 'aqualine' ).'"></div>';
			}
		}
	}
}

/**
 * Print copyrights in footer
 */
if ( !function_exists( 'aqualine_the_copyrights' ) ) {

	function aqualine_the_copyrights() {

		if ( function_exists( 'FW' ) ) {

			$aqualine_copyrights = fw_get_db_settings_option( 'copyrights' );

			if ( !empty($aqualine_copyrights) ) {

				echo wp_kses_post( $aqualine_copyrights );	
			}
				else {
				
				echo '<p>'. esc_html__( 'Like-themes &copy; All Rights Reserved - 2020', 'aqualine' ) .'</p>';
			}
		}
			else {

			echo '<p>'. esc_html__( 'Like-themes &copy; All Rights Reserved - 2020', 'aqualine' ) .'</p>';
		}
	}
	
}

/**
 * Footer overlay
 */
if ( !function_exists( 'aqualine_the_footer_overlay' ) ) {

	function aqualine_the_footer_overlay() {

		global $wp_query;

		$copyright_layout = 'default';
	    if ( function_exists( 'FW' ) ) {

	        $copyright_layout = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'footer-layout' );
	    }

	    if ( $copyright_layout == 'default' ) {

			echo '<div class="ltx-overlay-main-waves"></div>
	        <div class="ltx-overlay-black-waves"></div>';
	    }
	}
}


/**
 * Footer copyright block
 */
if ( !function_exists( 'aqualine_the_copyrights_section' ) ) {

	function aqualine_the_copyrights_section() {

		global $wp_query;

	    $copyright_layout = 'default';
	    if ( function_exists( 'FW' ) ) {

	        $copyright_layout = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'footer-layout' );
	        $aqualine_logo = fw_get_db_settings_option( 'logo' );	     
	    }

	    if ( $copyright_layout != 'disabled'):

		?>
		<footer class="copyright-block <?php echo 'copyright-layout-'.esc_attr($copyright_layout); ?>">
			<div class="container">
	            <?php

					if ( !empty($copyright_layout) AND $copyright_layout == 'simple' ) {

						if ( !empty($aqualine_logo) ) {

							echo '<span class="logo-footer">'.wp_get_attachment_image( $aqualine_logo['attachment_id'], 'full' ).'</span>';
						}

						aqualine_the_social_footer();
					}

	                aqualine_the_copyrights();
	            ?>
			</div>
		</footer>
		<?php
		endif;
	}
}

/**
 * Displays go top icon
 */
if ( !function_exists( 'aqualine_the_go_top' ) ) {

	function aqualine_the_go_top() {

		if ( function_exists( 'FW' ) ) {

           	$class = array();
    		$go_top = fw_get_db_settings_option( 'go_top_visibility');
	        $go_top_pos = fw_get_db_settings_option( 'go_top_pos');
	        $go_top_img = fw_get_db_settings_option( 'go_top_img');
	        $go_top_icon = fw_get_db_settings_option( 'go_top_icon');
	        $go_top_text = fw_get_db_settings_option( 'go_top_text');

			if ( $go_top != 'hidden' ) {

				$class[] = $go_top_pos;

        		if ( $go_top == 'desktop' ) {

        			$class[] = 'hidden-xs hidden-ms';
        		}	
        			else
        		if ( $go_top == 'mobile' ) {

        			$class[] = 'visbile-xs visible-ms';
       			}

	            if ( !empty($go_top_img) ) {
	                
	                $class[] = 'ltx-go-top-img';
	            }

	            if ( !empty($go_top_icon) ) {
	                
	                $class[] = 'ltx-go-top-icon';
	            }

            	echo '<a href="#" class="ltx-go-top '.esc_attr(implode(' ', $class)).'">';

            		if ( !empty($go_top_img) ) {

                		echo wp_get_attachment_image( $go_top_img['attachment_id'], 'full' );
                	}
  
                	if ( empty( $go_top_text ) ) {

                		$go_top_text = esc_html__( 'Go Top', 'aqualine' );

                	}

                	if ( !empty($go_top_icon) AND $go_top_icon['type'] != 'none' ) {

            			echo '<span class="go-top-icon-v2 '.esc_attr($go_top_icon['icon-class']).'"></span>';
            		}

                	echo '<span class="txt">'.esc_html($go_top_text).'</span>';

            	echo '</a>';
			}
		}
	}
}

/**
 * Blog related posts
 */
if ( !function_exists( 'aqualine_related_posts' ) ) {

	function aqualine_related_posts($id) {

		if ( !function_exists('FW') ) {

			return false;
		}

		$tags = wp_get_post_tags($id);

		if ( !empty( $tags ) ) {

			$tags_in = array();
			foreach ( $tags as $t ) {

				$tags_in[] = $t->term_id;
			}

			$args = array(

				'tag__in' => $tags_in,
				'post__not_in' => array($id),
				'posts_per_page' => 3,
				'meta_query' => array(array('key' => '_thumbnail_id')),
				'ignore_sticky_posts' => 1
			);

			$my_query = new WP_Query($args);

			if ( $my_query->have_posts() ) {

				set_query_var( 'aqualine_featured_disabled', true );
				echo '<div class="ltx-related blog blog-block layout-two-cols">';
				echo '<div class="heading has-subheader text-align-center subcolor-main">';
					echo sprintf(
 					'<h2 class="header">%1$s<span>%2$s</span></h2>',
 					esc_html__( 'Related ', 'aqualine' ),
 					esc_html__( 'posts', 'aqualine' )
 				);
				echo '</div>';

				echo '<div class="row">';

				$class = $class_add = '';	
				if ( $my_query->found_posts == 3 ) {

					$class = 'col-xl-4 col-lg-4 col-md-6';
				}
					else {

					$class = 'col-xl-6 col-lg-6 col-md-6';
				}
				
				$x = 0;
				while ($my_query->have_posts()) {

					$x++;
					$my_query->the_post();

					$class_add = '';
					if ( $x == 3) {

						$class_add = ' hidden-md';
					}

					echo '<div class="'.esc_attr($class.$class_add).'">';
						get_template_part( 'tmpl/post-formats/list' );				
					echo '</div>';
				}

				echo '</div>';

				echo '</div>';				
			}

			wp_reset_postdata();
			set_query_var( 'aqualine_featured_disabled', false );
		}
	}
}

/**
 * Blog post author info block
 */
if ( !function_exists( 'aqualine_author_bio' ) ) {

	function aqualine_author_bio( ) {
	 
		global $post;
	 
		$content = '';

		if ( is_single() && isset( $post->post_author ) ) {
	 
			$display_name = get_the_author_meta( 'display_name', $post->post_author );

	 		if ( empty( $display_name ) ) {

	 			$display_name = get_the_author_meta( 'nickname', $post->post_author );
	 		}
	 
			$user_description = get_the_author_meta( 'user_description', $post->post_author );

			// No author info, nothing no show
			if ( empty( $user_description ) ) {

				return false;
			}
	 
			$user_website = get_the_author_meta('url', $post->post_author);
	 
			$user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author));

			$author_details = '';

			if ( ! empty( $user_description ) ) {

				$author_details .= '<p class="author-details">' . wp_kses( nl2br( $user_description ), 'header' ). '</p>';
			}
	  
			$author_details .= '<p class="author-links">';

				if ( ! empty( $user_website ) ) {
				 
					$author_details .= '<a href="' . esc_url( $user_website ) .'" class="btn btn-main color-hover-white btn-xs" target="_blank" rel="nofollow">'. esc_html__( 'Website', 'aqualine' ) . '</a>';
				}

				$author_details .= '<a href="'. esc_url( $user_posts ) .'" class="btn btn-xs btn-main">'. esc_html__( 'All posts', 'aqualine' ) . '</a>';  
		 
			$author_details .= '</p>';

	 
			$content = '<section class="ltx-author-bio">';
				$content .= '<div class="author-image">';
					$content .= get_avatar( get_the_author_meta('user_email'), 210 );
	  			 
				$content .= '</div>';
				$content .= '<div class="author-info">';
					if ( ! empty( $display_name ) ) {

						$content .= '<span><p class="author-name">'. esc_html__( 'Author', 'aqualine' ) . '</p><h5>'. $display_name . '</h5></span>';
					}				
					$content .= $author_details;
				$content .= '</div>';
			$content .= '</section>';
		}

		echo wp_kses_post( $content );
	}
}

/**
 * Displays post top info
 */

if ( !function_exists( 'aqualine_get_the_post_headline' ) ) {

	function aqualine_get_the_post_headline( $headline = 'inline' ) {

		echo '<div class="ltx-post-headline">';

			aqualine_get_the_cats_archive();

		echo '</div>';
	}

	function aqualine_get_the_post_headline_left() {

		echo '<div class="ltx-post-headline">';

		echo '<div class="ltx-user">'.get_avatar( get_the_author_meta('user_email'), 50 ).'<span class="info">'. esc_html__( 'by', 'aqualine' ) . ' ' .get_the_author_link().'</span></div>';		

			aqualine_get_the_cats_archive();
    
		echo '</div>';
	}	
}

/**
 * Displays blog date and additioanl information
 */

if ( !function_exists( 'aqualine_the_blog_date' ) ) {

	function aqualine_the_blog_date( $args = array() ) {

		if ( !empty($args['wrap'])) {

			$tag = 'li';
		}
			else {

			$tag = 'span';
		}

		echo '<a href="'.esc_url(get_the_permalink()).'" class="ltx-date"><span class="dt">'.get_the_date().'</span></a>';
	}
}

/**
 * Displays cats for posts archive
 */

if ( !function_exists( 'aqualine_get_the_cats_archive' ) ) {

	function aqualine_get_the_cats_archive() {

		if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && aqualine_categorized_blog() ) {

			$categories = get_the_category();
			
			echo '<span class="ltx-cats">';
				if ( !empty($categories) )  {

					echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
				}
			echo '</span>';
		}

	}
}

/**
 * Displays Blog post info icons block
 * 
 */
if ( !function_exists( 'aqualine_the_post_info' ) ) {

	function aqualine_the_post_info( $fullInfo = 'hidden' ) {

		$wrapper = true;
		$showText = false;

		if ( $fullInfo == 'hidden' ) {

			$fullInfo = false;
		}

	    if ( $wrapper ) {

	    	echo '<ul class="ltx-post-info">';
	    }

	    echo '<li class="ltx-post-date">';

			aqualine_the_blog_date();

		echo '</li>';

		if ( !empty($fullInfo) AND function_exists( 'pvc_post_views' ) ) {

			$count = (int)(strip_tags( pvc_post_views(get_the_ID(), false) ));

			if ( !empty($showText) ) {

				echo '<li class="ltx-icon-fav">
					<span>' . esc_html( $count ) . ' ' . _n( 'View', 'Views', (int)($count), 'aqualine' ) .'</span>
				</li>';
			}
				else {

				echo '<li class="ltx-icon-fav">
					<span>' . esc_html( $count ) .'</span>
				</li>';
			}
		}

	    
	    if ( !empty($fullInfo) AND  ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

	    	echo '<li class="ltx-icon-comments">';

	    	if ( $showText ) {

		    	echo '<span>'.get_comments_number_text( 
		    		esc_html__('0 comments', 'aqualine'), esc_html__('1 Comment', 'aqualine'), esc_html__('% Comments', 'aqualine')
		    	).'</span>';
	    	}
	    		else {

	    		echo '<span>'.get_comments_number().'</span>';
    		}

	    	echo '</li>';
	    }

	    if ( $wrapper ) {

	    	echo '</ul>';
	    }

	    if ( !empty($authorby) ) {

			echo '<div class="ltx-user">'.get_avatar( get_the_author_meta('user_email'), 50 ).'<span class="info">'. esc_html__( 'by', 'aqualine' ) . ' ' .get_the_author_link().'</span></div>';
		}

	}
}

/**
 * Displays Navigation bar icons
 * 
 */
if ( !function_exists( 'aqualine_get_the_navbar_icons' ) ) {

	function aqualine_get_the_navbar_icons( $layout = null, $mobile = false ) {

		global $user_ID;

		if ( !function_exists( 'FW' ) ) { return false; }

		$basket_icon = fw_get_db_settings_option( 'basket-icon' );
		$icons = fw_get_db_settings_option( 'navbar-icons' );
		$basket_only = false;

		if ( $mobile ) {

		}
			else
		if ( $layout == 'basket-only' AND $basket_icon == 'mobile' ) {

			$basket_only = true;
		}

		$icons_to_show = array();
		if ( is_array($layout) AND !empty($layout['icons']) ) {

			$icons_to_show = explode(',', $layout['icons']);
		}

		$items = '';
		if ( !empty($icons) ) {

			foreach ($icons as $item) {

				if ( !empty($icons_to_show) AND !in_array($item['type']['type_radio'], $icons_to_show) ) continue;

				if ( !empty( $basket_only ) AND $item['type']['type_radio'] != 'basket' ) continue;

				$li_class = '';
				if ( empty($mobile) AND empty( $basket_only ) ) {

					if ( empty($item['icon-visible']) || $item['icon-visible'] != 'visible-mob' ) {

						$li_class = ' hidden-sm hidden-ms hidden-xs';
					}
						else {

						$li_class = ' hidden-xs';
					}				
				}

				$custom_icon = '';
				if ( $item['icon-type']['icon_radio'] == 'fa' AND !empty($item['icon-type']['fa']) ) {

					$custom_icon = $item['icon-type']['fa']['icon_v2']['icon-class'];
				}

				if ( $item['type']['type_radio'] == 'search') {

					if ( empty( $custom_icon ) ) { $custom_icon = 'fa fa-search'; }

					if ( !empty($mobile) ) {

						$id = ' id="top-search-ico-mobile" ';
						$close = '';
					}	
						else {

						$id = ' id="top-search-ico" ';
						$close = '<a href="#" class="top-search-ico-close " aria-hidden="true">&times;</a>';
					}

					$items .= '
					<li class="ltx-fa-icon ltx-nav-search  '.esc_attr($li_class).'">
						<div class="top-search" data-base-href="'. esc_url( home_url( '/' ) ) .'">
							<a href="#" '.$id.' class="top-search-ico '. esc_attr($custom_icon) .'" aria-hidden="true"></a>
							'.$close.'
							<input placeholder="'.esc_attr__( 'Search', 'aqualine' ).'" value="'. esc_attr( get_search_query() ) .'" type="text">
						</div>
					</li>';
				}

				if ( $item['type']['type_radio'] == 'basket' AND aqualine_is_wc('wc_active')) {

					if ( empty( $custom_icon ) ) { $custom_icon = 'fas fa-cart-arrow-down'; }

					$items .= '
						<li class="ltx-fa-icon ltx-nav-cart '.esc_attr($li_class).'">
							<div class="cart-navbar">
								<a href="'. wc_get_cart_url() .'" class="ltx-cart cart shop_table" title="'. esc_attr__( 'View your shopping cart', 'aqualine' ). '">';

									if ( $item['type']['basket']['count'] == 'show' ) {

										$items .= '<span class="cart-contents header-cart-count count">'.WC()->cart->get_cart_contents_count().'</span>';
									}

									$items .= '<span class="ltx-icon-cart '. esc_attr($custom_icon) .'"></span>
								</a>
							</div>
						</li>';
				}

				if ( $item['type']['type_radio'] == 'profile' ) {

					if ( empty( $custom_icon ) ) { $custom_icon = 'fa fa-user-circle'; }

					$header = '';
					$userInfo = get_userdata($user_ID);

					$items .= '
						<li class="ltx-fa-icon ltx-nav-profile menu-item-has-children '.esc_attr($li_class).'">
							<a href="'. get_permalink( get_option('woocommerce_myaccount_page_id') ) .'"><span class="fa '. esc_attr($custom_icon) .'"></span>
							 '.esc_html( $header ).'</a>';

						$items .= '</li>';
				}

				if ( $item['type']['type_radio'] == 'social' AND !empty($custom_icon)) {

					$items .= '
						<li class="ltx-fa-icon ltx-nav-social '.esc_attr($li_class).'">
							<a href="'. esc_url( $item['type']['social']['href'] ) .'" class="'. esc_attr($custom_icon) .'" target="_blank">';

						if ( !empty($item['type']['social']['text']) ) {

							$items .= '<h6 class="header">'.esc_html($item['type']['social']['text']).'</h6>';
						}

						if ( !empty($item['type']['social']['subheader']) ) {

							$items .= '<h6 class="subheader">'.esc_html($item['type']['social']['subheader']).'</h6>';
						}

					$items .= '</a>
						</li>';
				}	
			}
		}

		if ( !empty($items) ) {

			if ( empty( $mobile ) ) {

				return '<div class="ltx-navbar-icons"><ul>'.$items.'</ul></div>';
			}
				else {

				return '<div><ul>'.$items.'</ul></div>';
			}
		}
	}

	function aqualine_the_navbar_icons( $layout = null, $mobile = false ) {

		echo aqualine_get_the_navbar_icons( $layout, $mobile );
	}
}

/**
 * Get page breadcrumbs
 */
if ( !function_exists( 'aqualine_the_breadcrumbs' ) ) {

	function aqualine_the_breadcrumbs() {

		if ( function_exists( 'bcn_display' ) && !is_front_page() ) {

			echo '<ul class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">';
			bcn_display_list();
			echo '</ul>';
		}
	}
}


/**
 * Tagline in header
 */
if ( !function_exists( 'aqualine_the_tagline_header' ) ) {

	function aqualine_the_tagline_header() {

		if ( shortcode_exists('ltx-header-tagline') ) {

			do_shortcode('[ltx-header-tagline]');
		}
	}
}

/**
 * Social icons in header
 */
if ( !function_exists( 'aqualine_the_social_header' ) ) {

	function aqualine_the_social_header() {

		if ( function_exists( 'FW' ) ) {
			
			$aqualine_social = fw_get_db_settings_option( 'header-social' );
			$aqualine_social_text = fw_get_db_settings_option( 'header-social-text' );

			if ( $aqualine_social == 'enabled' ) {

				do_shortcode('[ltx-social]');
			}
		}
	}
}
	
/**
 * Social icons in footer
 */
if ( !function_exists( 'aqualine_the_social_footer' ) ) {

	function aqualine_the_social_footer() {

		// In this theme we are using same markup as a header
		aqualine_the_social_header();
	}
}		

/**
 * Social icons in navbar
 */
if ( !function_exists( 'aqualine_the_navbar_social' ) ) {

	function aqualine_the_navbar_social() {

		global $wp_query;

		if ( function_exists( 'FW' ) ) {

			$social_header = fw_get_db_settings_option( 'social-header' );

			echo '<div class="ltx-navbar-social">';
			
				if ( !empty($social_header) ) {

					echo do_shortcode('[ltx-social text-before="'.esc_attr($social_header).'"]');
				}
					else {

					echo do_shortcode('[ltx-social]');
				}

			echo '</div>';
		}
	}
}

