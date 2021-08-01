<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * @var string $before_widget
 * @var string $after_widget
 */

echo wp_kses_post( $before_widget );

if ( !empty($params['title']) )  {

	echo wp_kses_post( $before_title ) . esc_html( apply_filters( 'widget_title', $params['title'] ) ) . wp_kses_post( $after_title );
}

if ( $params['target'] == 'self' ) {

	$target = '';
}
	else {

	$target = ' target="_blank" ';
}

?>
<?php if ( is_array( $params['items'] ) ) : ?>
	<?php if ( $params['list-type'] == 'icons-top' ) : ?><ul class="ltx-social-icons-top"><?php endif; ?>
	<?php if ( $params['list-type'] == 'icons-list' ) : ?><ul class="ltx-social-icons-list"><?php endif; ?>
	<?php if ( $params['list-type'] == 'icons-inline-large' ) : ?><ul class="ltx-social-big"><?php endif; ?>
	<?php if ( $params['list-type'] == 'icons-inline-small' ) : ?><ul class="ltx-social-small"><?php endif; ?>
		<?php foreach ( $params['items'] as $item ) : ?>
			<?php
				$item['header'] = str_replace(array('{{', '}}'), array('<strong>', '</strong>'), $item['header']);
				$item['text'] = str_replace(array('{{', '}}'), array('<strong>', '</strong>'), $item['text']);
			?>
			<?php if ( $params['list-type'] == 'icons-top' ) : ?>
				<?php if ( empty( $item['href'] ) ) : ?>
				<li>
					<span class="ltx-ic <?php echo esc_attr( $item['icon']['icon-class'] ); ?>"></span><span class="ltx-header"><?php echo wp_kses_post( nl2br($item['header']) ); ?></span><span class="txt"><?php echo wp_kses_post( nl2br($item['text']) ); ?></span>
				</li>
				<?php else : ?>
				<li>
					<a href="<?php echo esc_url( $item['href'] ); ?>" <?php echo $target ?>><span class="ltx-ic <?php echo esc_attr( $item['icon']['icon-class'] ); ?>"></span><span class="ltx-header"><?php echo wp_kses_post( nl2br($item['header']) ); ?></span><span class="txt"><?php echo wp_kses_post( nl2br($item['text']) ); ?></span></a>
				</li>
				<?php endif; ?>	
			<?php elseif ( $params['list-type'] == 'icons-list' ) : ?>
				<?php if ( empty( $item['href'] ) ) : ?>
				<li>
					<span class="<?php echo esc_attr( $item['icon']['icon-class'] ); ?>"></span><?php echo wp_kses_post( nl2br($item['text']) ); ?>
				</li>
				<?php else : ?>
				<li>
					<a href="<?php echo esc_url( $item['href'] ); ?>" <?php echo $target ?>><span class="ltx-ic <?php echo esc_attr( $item['icon']['icon-class'] ); ?>"></span><span class="txt"><?php echo wp_kses_post( nl2br($item['text']) ); ?></span></a>
				</li>
				<?php endif; ?>
			<?php elseif ( $params['list-type'] == 'icons-inline-large' ) : ?>
				<li>
					<a href="<?php echo esc_url( $item['href'] ); ?>" class="<?php echo esc_attr( $item['icon']['icon-class'] ); ?>" <?php echo $target ?>></a>
				</li>
			<?php else : ?>
				<li>
					<a href="<?php echo esc_url( $item['href'] ); ?>" class="<?php echo esc_attr( $item['icon']['icon-class'] ); ?>" <?php echo $target ?>></a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
<?php echo wp_kses_post( $after_widget ) ?>
