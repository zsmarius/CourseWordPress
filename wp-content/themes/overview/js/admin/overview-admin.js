/*
    Copyright (C) 2018 _Y_Power ( http://ypower.nouveausiteweb.fr )

    This file is part of the OverView WordPress theme package.

    The JavaScript code in this page is free software: you can
    redistribute it and/or modify it under the terms of the GNU
    General Public License (GNU GPL) as published by the Free Software
    Foundation, either version 3 of the License, or (at your option)
    any later version.  The code is distributed WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS
    FOR A PARTICULAR PURPOSE.  See the GNU GPL for more details.

    As additional permission under GNU GPL version 3 section 7, you
    may distribute non-source (e.g., minimized or compacted) forms of
    that code without the copy of the GNU GPL normally required by
    section 4, provided you include this license notice and a URL
    through which recipients can access the Corresponding Source.
*/

(function(){

    var jQ = jQuery.noConflict();
    
    jQ(document).ready(function(){

        /* OverView admin UI adjustments */
	
        /* assess header image filter tip visibility */
        function setHeadImgFilterTip(ovHeaderImgCheck){
            if ( 'remove-header' === ovHeaderImgCheck ){
                jQ( 'ul#sub-accordion-section-header_image li div.customize-section-description' ).slideDown();
            }
            else {
                jQ( 'ul#sub-accordion-section-header_image li div.customize-section-description' ).slideUp();
            }
        }

        /* site title header image filter redirect */
        jQ( 'a#overview-customizer-header-img-filter-redirect' ).click(function(){
            wp.customize.control( 'overview_header_image_filter' ).focus();
        });
        
        /* header image filter tip onload check */
        var OVHeadImgOnloadCheck = wp.customize.control( 'header_image' ).setting._value;
        setHeadImgFilterTip( OVHeadImgOnloadCheck );

        /* change visibility when setting header image */
        wp.customize( 'header_image', function( setting ){
            setting.bind(function( ovHeaderImg ){
                setHeadImgFilterTip( ovHeaderImg );
            });
        });

        /* header image site titles background opacity redirect */
        jQ('a#overview-customizer-titles-filter-redirect').click(function(){
            wp.customize.control( 'overview_site_titles_background_visibility' ).focus();
        });

        /* OverView Display footer copyright redirect */
        jQ('a#customizer-ov-options-footer-copyright-redirect').click(function(){
            wp.customize.control('overview_site_copyright').focus();
        });

        /* custom site title font copy/paste auto-focus */
        jQ('input#overview-site-title-custom-font-text-input').on('paste', function(fontName){
            setTimeout(function(){
                wp.customize.control('overview_site_title_custom_font').focus();
            }, 100);
        });

        /* custom font copy/paste auto-focus */
        jQ('input#overview-custom-font-text-input').on('paste', function(fontName){
            setTimeout(function(){
                wp.customize.control('overview_custom_font').focus();
            }, 100);
        });
        
    });
    // document ready END
    
})();
