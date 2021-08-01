<?php
/**
 * The template for displaying the footer
 */
?>
        </div>
<?php

    /**
     * Before Footer area
     */
    aqualine_the_subscribe_block();

    aqualine_the_before_footer();
    
?>
    </div>
    <div class="ltx-footer-wrapper">
<?php

    aqualine_the_footer_overlay();


    /**
     * Footer widgets area
     */
    aqualine_the_footer_widgets();

    /**
     * Copyright
     */
    aqualine_the_copyrights_section();
?>
    </div>
<?php 

    aqualine_the_go_top();

    /**
     * WordPress Core Functions
     */   
    wp_footer();
?>
</body>
</html>
