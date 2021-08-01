<?php
/**
 * Navigation Bar
 */
$navbar_logo = $navlogo_class = $navbar_affix = '';
$navbar_logo = '';
$navbar_layout = 'white';
$basket_icon = 'disabled';
$navbar_class = 'navbar-mobile-white navbar-collapse collapse';
$navbar_mobile_width = '1198';

if ( function_exists( 'FW' ) ) {

	$navbar_affix = fw_get_db_settings_option( 'navbar-affix' );
	$navbar_breakpoint = fw_get_db_settings_option( 'navbar-breakpoint' );

	if ( !empty($navbar_breakpoint) ) {

		$navbar_mobile_width = $navbar_breakpoint;
	}

	// Current page layout
	$navbar_layout = aqualine_get_navbar_layout('transparent');

	if ( $navbar_layout == 'full-width' OR $navbar_layout == 'hamburger' OR $navbar_layout == 'hamburger-transparent' OR $navbar_layout == 'hamburger-left' ) {

		$navbar_mobile_width = '4000';
		$navbar_logo = 'white';
	}

	if ( $navbar_layout == 'transparent' OR  $navbar_layout == 'transparent-overlay' OR $navbar_layout == 'desktop-center-transparent' ) {

		$navbar_logo = 'white';
	}	

	if ( $navbar_layout == 'white' OR $navbar_layout == 'hamburger-left' ) {

		$navbar_logo = 'black';
	}	


	$basket_icon = fw_get_db_settings_option( 'basket-icon' );
	if ( empty($basket_icon) ) {

		$basket_icon = 'disabled';
	}	
}


if ( $navbar_layout != 'disabled' ):

	aqualine_the_topbar_block( $navbar_layout );

?>
<div id="nav-wrapper" class="navbar-layout-<?php echo esc_attr($navbar_layout);?>">
	<nav class="navbar" data-spy="<?php echo esc_attr($navbar_affix); ?>" data-offset-top="0">
		<div class="container">
			<?php
				if ( $navbar_layout == 'desktop-center' OR $navbar_layout == 'desktop-center-transparent' OR $navbar_layout == 'hamburger' OR $navbar_layout == 'full-width' OR $navbar_layout == 'hamburger-left' ) {

					aqualine_the_navbar_social($navbar_layout);
				}
			?>				
			<div class="navbar-logo <?php echo esc_attr($navlogo_class); ?>">	
				<?php
					aqualine_the_logo($navbar_logo);

					if ( $navbar_layout == 'hamburger-transparent' ) {

						echo '<div class="ltx-logo-dark">';
							aqualine_the_logo();
						echo '</div>';
					}					
				?>
			</div>	
			<?php
				if ( $navbar_layout == 'desktop-center' OR $navbar_layout == 'desktop-center-transparent' OR $navbar_layout == 'full-width' OR $navbar_layout == 'hamburger' OR $navbar_layout == 'hamburger-transparent' ) {

					aqualine_the_navbar_icons( $navbar_layout );
				}
			?>					
			<div id="navbar" class="<?php echo esc_attr( $navbar_class ); ?>" data-mobile-screen-width="<?php echo esc_attr( $navbar_mobile_width ); ?>">
				<div class="toggle-wrap">
					<?php
						aqualine_the_logo();
					?>						
					<button type="button" class="navbar-toggle collapsed">
						<span class="close">&times;</span>
					</button>							
					<div class="clearfix"></div>
				</div>
				<?php
					aqualine_get_wp_nav_menu();

					if ( $navbar_layout != 'desktop-center' AND $navbar_layout != 'desktop-center-transparent' ) {

						aqualine_the_navbar_icons( $navbar_layout );
					}
				?>
				<div class="mobile-controls">
					<?php
						echo aqualine_the_navbar_icons( $navbar_layout, true );
					?>				
				</div>				
			</div>
			<div class="navbar-controls">	
				<button type="button" class="navbar-toggle collapsed">
					<span class="icon-bar top-bar"></span>
					<span class="icon-bar middle-bar"></span>
					<span class="icon-bar bottom-bar"></span>
				</button>			
			</div>	
		</div>
	</nav>
</div>
<?php

endif;

