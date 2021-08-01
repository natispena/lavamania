<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * TopBar icons Shortcode
 */

global $user_ID;

$icons = fw_get_db_settings_option( 'topbar-icons' );
$items = '';

if ( !empty($icons) ) {

	foreach ($icons as $item) {

//		$li_class = ' hidden-md hidden-sm hidden-ms hidden-xs';
		
		$li_class = '';
		$custom_icon = '';
		if ( $item['icon-type']['icon_radio'] == 'fa' AND !empty($item['icon-type']['fa']['icon_fa']) ) {

			$custom_icon = $item['icon-type']['fa']['icon_fa'];
		}

		if ( $item['type']['type_radio'] == 'search') {

			if ( empty( $custom_icon ) ) $custom_icon = 'fa-search';

			$items .= '
				<li class="ltx-fa-icon ltx-nav-search  '.esc_attr($li_class).'">
					<div id="top-search" class="top-search">
						<a href="#" id="top-search-ico" class="top-search-ico fa '. esc_attr($custom_icon) .'" aria-hidden="true"></a>
						<input placeholder="'.esc_attr__( 'Search', 'lt-ext' ).'" value="" type="text">
					</div>
				</li>';
		}

		if ( $item['type']['type_radio'] == 'basket' AND aqualine_is_wc('wc_active')) {

			if ( empty( $custom_icon ) ) $custom_icon = 'fa-shopping-bag';

			$items .= '
				<li class="ltx-fa-icon ltx-nav-cart '.esc_attr($li_class).'">
					<div class="cart-navbar">
						<a href="'. wc_get_cart_url() .'" class="ltx-cart cart shop_table" title="'. esc_attr__( 'View your shopping cart', 'lt-ext' ). '">';

							if ( $item['type']['basket']['count'] == 'show' ) {

								$items .= '<span class="cart-contents header-cart-count count">'.WC()->cart->get_cart_contents_count().'</span>';
							}

							$items .= '<i class="fa '. esc_attr($custom_icon) .'" aria-hidden="true"></i>
						</a>
					</div>
				</li>';
		}

		if ( $item['type']['type_radio'] == 'profile' ) {

			if ( empty( $custom_icon ) ) $custom_icon = 'fa-user-circle-o';

			$header = '';
			$userInfo = get_userdata($user_ID);
			if ( !empty($userInfo) ) $header = $userInfo->user_login;
				else
			if ( empty($userInfo) AND !empty($item['type']['profile']['header']) ) $header = $item['type']['profile']['header'];



			$items .= '
				<li class="ltx-fa-icon ltx-nav-profile menu-item-has-children '.esc_attr($li_class).'">
					<a href="'. get_permalink( get_option('woocommerce_myaccount_page_id') ) .'"><span class="fa '. esc_attr($custom_icon) .'"></span>
					 '.esc_html($header ).'</a>';

				$items .= '</li>';
		}

		if ( $item['type']['type_radio'] == 'social' AND !empty($custom_icon)) {

			$items .= '
				<li class="ltx-fa-icon ltx-nav-social '.esc_attr($li_class).'">
					<a href="'. esc_url( $item['type']['social']['href'] ) .'" class="fa '. esc_attr($custom_icon) .'" target="_blank">
					</a>
				</li>';
		}	
	}
}

if ( !empty($items) ) {

	echo '<ul class="ltx-topbar-icons">'.$items.'</ul>';
}

