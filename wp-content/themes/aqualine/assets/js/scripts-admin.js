"use strict";

/* Fixes Unyson Theme Settings closed boxes after init */	
jQuery( document ).on('click', '.fw-options-tabs-list ul li a', function(e) {

    setTimeout( // as Unyson not render all option tabs on start, we need small timeout
        function() {
                jQuery('.fw-container-type-box').removeClass('closed'); 			
        }, 500);
});