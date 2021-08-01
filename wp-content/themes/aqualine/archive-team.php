<?php
/**
 * Team Archive
 */

get_header();

if ( $wp_query->have_posts() ) :
?>
<div class="team-sc inner-page margin-default">
	<div class="row centered">
		<?php
		while ( $wp_query->have_posts() ) : 

			$wp_query->the_post();

			get_template_part( 'tmpl/content', 'team' );

		endwhile;
		?>  
	</div>
	<?php
		aqualine_paging_nav();
	?>        
</div>            
<?php
else :
	get_template_part( 'tmpl/content', 'none' );
endif;

get_footer();

