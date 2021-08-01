<div class="search-form">
	<form role="search" method="get" class="wp-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
		<div class="input-div"><input type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr__( 'Search', 'aqualine' ); ?>"></div>
		<button id="searchsubmit" type="submit"><span class="search-icon fa fa-search"></span></button>
	</form>
</div>			
