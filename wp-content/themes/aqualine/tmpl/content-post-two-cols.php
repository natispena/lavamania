<?php
/**
 * The default template for displaying content 2-cols layout
 *
 * Used for both single and index/archive/search.
 */

$div_class = '';
if ( has_post_thumbnail() OR get_post_format() == 'video' ) {

	$div_class = 'div-thumbnail';
}

?>
<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 item <?php echo esc_attr( $div_class ); ?>">
	<?php get_template_part( 'tmpl/post-formats/list', get_post_format() ); ?>
</div>
