<?php
/**
 * The Template for displaying all single portfolio posts
 */

get_header();


while ( have_posts() ) : 

	the_post();

?>
<div class="ltx-portfolio-single inner-page margin-default">
    <div class="row centered">  
        <div class="col-lg-12">
        	<?php 
  	      		the_content();
			?>                            
        </div>
    </div>
</div>
<?php

endwhile;

get_footer();
