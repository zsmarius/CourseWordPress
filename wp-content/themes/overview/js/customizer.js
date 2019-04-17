/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * Copyright (C) 2017 _Y_Power ( http://ypower.nouveausiteweb.fr )
 *
 * This file is part of the OverView WordPress theme package.
 */

( function( $ ) {

    /* Customizer preview functions */
    
    // switch site titles position according to header image
    function switchTitlesPosition(){
        // overview-addons.css Customizer preview classes
        $( 'div.site-branding' ).removeClass('overview-site-titles-preview-header-image overview-site-titles-preview-NO-header-image');
        // if there is an header image
        if ( 'remove-header' !== wp.customize._value.header_image() ){
            $( 'div.site-branding' ).addClass( 'overview-site-titles-preview-header-image' );
        }
        else {
            $( 'div.site-branding' ).addClass( 'overview-site-titles-preview-NO-header-image' );
        }
    }

    // checks for existence and switches site branding position
    function switchSiteBrandingPosition( noTitles ){
        if ( $( 'header#masthead p.site-branding-description-p' ) ){
            // remove previous classes
            $( 'header#masthead p.site-branding-description-p' ).removeClass( 'overview-branding-p-preview-header-image overview-branding-p-preview-NO-header-image overview-branding-p-preview-solo' );
            // if there IS an header image
            if ( 'remove-header' !== wp.customize._value.header_image() ){
                $( 'header#masthead p.site-branding-description-p' ).addClass( 'overview-branding-p-preview-header-image' );
            }
            else {
                $( 'header#masthead p.site-branding-description-p' ).addClass( 'overview-branding-p-preview-NO-header-image' );
                if ( noTitles ){
                    $( 'header#masthead p.site-branding-description-p' ).addClass( 'overview-branding-p-preview-solo' );
                }
            }
        }
    }

    /* adjust title offset on header image */
    function siteTitleOnHeader(){
        // if there IS an header image
        if ( 'remove-header' !== wp.customize._value.header_image() ){
            var headerContainer = $('div#overview-header-image-container'),
                siteTitleTagline = $('div.site-branding'),
                imgFilter = $('div#overview-header-image-filter'),
                imgOffset = headerContainer.offset(),
                imgHeight = headerContainer.outerHeight(),
                imgWidth  = headerContainer.outerWidth(),
                titlesHeight = siteTitleTagline.outerHeight();
            /* set filter dimensions */
            imgFilter.offset({
                top: imgOffset.top
            }).css({
                display: 'block',
                width: imgWidth + 'px',
                height: imgHeight + 'px'
            });
            /* set titles offset */
            // if in large layout
            if ( 'none' === $( 'nav#site-navigation button.menu-toggle' ).css( 'display' ) ){
                siteTitleTagline.offset({
                    top: imgOffset.top + ( imgHeight - titlesHeight )
                });
            }
            // smaller layout
            else {
                siteTitleTagline.offset({
                    top: imgOffset.top + imgHeight
                });
            }
        }
        else {
            $('div#overview-header-image-filter').css( 'display', 'none' );
        }
    }

    /* Customizer preview elements */
    
    // Site title and description.
    wp.customize( 'blogname', function( value ) {
	value.bind( function( to ) {
	    $( '.site-title a' ).text( to );
            /* OverView navbar logo fallback */
            $( 'a#overview-navbar-site-logo p' ).text( to );
	} );
    } );
    wp.customize( 'header_textcolor', function( value ) {
	value.bind( function( to ) {
            switchTitlesPosition();
            switchSiteBrandingPosition();
            // if WP ! display_header_text()
            if ( 'blank' === to ) {
                $( 'div.site-branding' ).hide();
                switchSiteBrandingPosition( 'no Site titles' );
            }
            else {
                $( '.site-title a' ).css({
                    color:  to
                });
                $( 'div.site-branding' ).show();
            }
            siteTitleOnHeader();
	} );
    } );
    wp.customize( 'blogdescription', function( value ) {
	value.bind( function( to ) {
	    $( '.site-description' ).text( to );
	} );
    } );

    // OverView site branding background visibility
    wp.customize( 'overview_site_titles_background_visibility', function( value ) {
        value.bind( function( to ) {
            // if titles background is visible
            if ( to ){
                $( '.site-branding' ).css({
                    backgroundColor: 'rgba(255,255,255,0.' + wp.customize.settings.values.overview_site_titles_background_opacity + ')'
                });
            }
        } );
    } );

    // OverView site branding background opacity
    wp.customize( 'overview_site_titles_background_opacity', function( value ) {
        value.bind( function( to ) {
            $( '.site-branding' ).css({
                backgroundColor: 'rgba(255,255,255,0.' + to + ')'
            });
        } );
    } );
    
    // OverView site branding description
    wp.customize( 'overview_site_branding_description', function( value ) {
        value.bind( function( to ) {
            if ( '' === to ){
                $( '.site-branding-description-p' ).remove();
            }
        } );
    } );

    // OverView header image filter
    wp.customize( 'overview_header_image_filter', function( value ) {
        value.bind( function( to ) {
            $( 'div#overview-header-image-filter' ).css({
                backgroundColor: 'rgba(0,0,0,0.' + to + ')'
            });
        } );
    } );
    
    // OverView custom font color
    wp.customize( 'overview_custom_body_color', function( value ) {
        value.bind( function( to ) {
            var OVAllContentEls = $( 'body, header#masthead div.site-branding p.site-description, header#masthead div.site-branding p.site-description, div.overview-indexed-content-main-container, article.overview-standard-indexed-entry, article.overview-standard-indexed-entry-no-featured-img, div#comments, div.page-content, div.overview-sidebar-main-container section.widget' );
            OVAllContentEls.css({
                color: to
            });
            var OVDisplayContentEl = $( 'div#overview-front-page-posts-section-content' );
            if ( '1' === wp.customize.settings.values.overview_display_bright_background ){
                OVDisplayContentEl.css({
                    color: to,
                    backgroundColor: 'transparent'
                });
            }
            else {
                OVDisplayContentEl.css({
                    color: '#404040',
                    backgroundColor: '#ffffff'
                });
            }
        } );
    } );

    // OverView custom background color
    wp.customize( 'background_color', function( value ) {
        value.bind( function( to ) {
            var OVHeaderEl = $( 'header#masthead' ).not('.site-title, p.site-description'),
                OVSiteContentElements = $( 'div.overview-indexed-content-main-container, article.overview-standard-indexed-entry, article.overview-standard-indexed-entry-no-featured-img, main.overview-blog-container, h1.overview-blog-page-title, div.overview-blog-page-content, div#comments, div.page-content, div.overview-sidebar-main-container section.widget' );
            OVHeaderEl.css( 'background-color', to );
            OVSiteContentElements.css( 'background-color', to );
            // if OverView Display does NOT have the default background
            if ( '' !== wp.customize.settings.values.overview_display_bright_background ){
                var OVDisplayContentElements = $( 'div#overview-front-page-section-content-container, div#overview-front-page-posts-section-content' );
                OVDisplayContentElements.css({
                    backgroundColor: to
                });
            }
            // if OverView Display DOES HAVE the default background
            else {
                var OVDisplayContentElement = $( 'div#overview-front-page-posts-section-content' );
                OVDisplayContentElement.css({
                    color: '#404040',
                    backgroundColor: '#ffffff'
                });
            }
        } );
    } );

    // background image
    wp.customize( 'background_image', function( value ) {
        value.bind( function( to ) {
            var ovBackgroundImgCheck = ( '' !== to ) ? true : false;
            switch( ovBackgroundImgCheck ){
                //if there IS an img
            case true:
                $( 'article.overview-standard-indexed-entry, article.overview-standard-indexed-entry-no-featured-img, main.overview-blog-container, h1.overview-blog-page-title, div.overview-blog-page-content' ).removeClass('ov-background-switch-default').addClass('ov-background-switch-changes');
                $( 'div.overview-sidebar-main-container' ).removeClass('ov-background-switch-sidebar-default').addClass('ov-background-switch-sidebar-changes');
                $( '.sticky' ).removeClass('ov-background-switch-sticky-default').addClass('ov-background-switch-sticky-changes');
                break;
                // if there is NO img
            case false:
                $( 'article.overview-standard-indexed-entry, article.overview-standard-indexed-entry-no-featured-img, main.overview-blog-container, h1.overview-blog-page-title, div.overview-blog-page-content' ).removeClass('ov-background-switch-changes').addClass('ov-background-switch-default');
                $( 'div.overview-sidebar-main-container' ).removeClass('ov-background-switch-sidebar-changes').addClass('ov-background-switch-sidebar-default');
                $( '.sticky' ).removeClass('ov-background-switch-sticky-changes').addClass('ov-background-switch-sticky-default');
                break;
                // default: remove special ( NO background img)
            default:
                $( 'article.overview-standard-indexed-entry, article.overview-standard-indexed-entry-no-featured-img, main.overview-blog-container, h1.overview-blog-page-title, div.overview-blog-page-content' ).removeClass('ov-background-switch-changes').addClass('ov-background-switch-default');
                $( 'div.overview-sidebar-main-container' ).removeClass('ov-background-switch-sidebar-changes').addClass('ov-background-switch-sidebar-default');
                $( '.sticky' ).removeClass('ov-background-switch-sticky-changes').addClass('ov-background-switch-sticky-default');
            }
        } );
    } );
    
    // body font size
    wp.customize( 'overview_body_font_size', function( value ) {
        value.bind( function( to ) {
            $( 'body' ).css( 'font-size', to );
        } );
    } );

    // titles alignment
    wp.customize( 'overview_titles_alignment', function( value ) {
        value.bind( function( to ) {
            $( '.entry-title' ).css( 'text-align', to );
        } );
    } );

} )( jQuery );
