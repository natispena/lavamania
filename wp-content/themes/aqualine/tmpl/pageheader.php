<?php
	$header_wrapper = aqualine_get_pageheader_wrapper();
	$header_class = aqualine_get_pageheader_class();
	$pageheader_layout = aqualine_get_pageheader_layout();
	$pageheader_class = aqualine_get_pageheader_parallax_class();
	$navbar_layout = aqualine_get_navbar_layout();
?>
<div class="ltx-content-wrapper <?php echo esc_attr($header_wrapper.' '.$navbar_layout); ?>">
	<div class="header-wrapper <?php echo esc_attr($header_class .' ltx-pageheader-'. $pageheader_layout); ?>">
	<?php
		get_template_part( 'tmpl/navbar' );

		if ( $pageheader_layout != 'disabled' AND $pageheader_layout != 'narrow' ) : ?>
		<header class="<?php echo esc_attr($pageheader_class); ?>">
			<?php aqualine_the_tagline_header(); ?>
		    <div class="container">
		    	<?php	
			    	aqualine_the_h1();			
					aqualine_the_breadcrumbs();
				?>	 
			    <?php aqualine_the_social_header(); ?>
		    </div>
		</header>
		<?php endif; ?>
	</div>