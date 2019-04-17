<?php
/**
 * OverView document head custom functions
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package OverView
 */

/* OverView EXTRA HEAD STYLES */

/* OverView custom font */
function overview_custom_main_font_color(){
    $overview_custom_body_color = get_theme_mod( 'overview_custom_body_color', '#404040' );?>
    <style id="overview-custom-body-color-css" type="text/css">
     body, header#masthead div.site-branding p.site-description, header#masthead div.site-branding p.site-description, div.overview-indexed-content-main-container, article.overview-standard-indexed-entry, article.overview-standard-indexed-entry-no-featured-img, div#comments, div.page-content, div.overview-sidebar-main-container section.widget {color: <?php echo esc_attr( $overview_custom_body_color ); ?>}
    </style>
<?php }
add_action( 'wp_head', 'overview_custom_main_font_color' );

/* OverView custom background / background color */
function overview_custom_background_styles(){
    $overview_custom_background_img = get_background_image();
    $overview_custom_body_color = get_theme_mod( 'overview_custom_body_color', '#404040' );
    $overview_custom_background_color = get_background_color();
    $overview_display_custom_background_check = get_theme_mod( 'overview_display_bright_background', '' );?>
    <style id="overview-custom-background-extra-css" type="text/css">
     body, header#masthead, div.overview-indexed-content-main-container, article.overview-standard-indexed-entry, article.overview-standard-indexed-entry-no-featured-img, main.overview-blog-container, h1.overview-blog-page-title, div.overview-blog-page-content, div#comments, div.page-content, div.overview-sidebar-main-container section.widget {background-color: #<?php echo esc_attr( $overview_custom_background_color ); ?>;}
     <?php
     /* if there is a background image, add html, OverView content, sidebar, page templates and sticky posts adjustments */
     if ( '' !== $overview_custom_background_img ){ ?>
     article.overview-standard-indexed-entry:not(.sticky),
     article.overview-standard-indexed-entry-no-featured-img:not(.sticky),
     main.overview-blog-container,
     h1.overview-blog-page-title,
     div.overview-blog-page-content {
         border-top: none;
         border-bottom: none;
         -webkit-box-shadow: 0 0 6px 0 #333;
         -moz-box-shadow: 0 0 6px 0 #333;
         -ms-box-shadow: 0 0 6px 0 #333;
         -o-box-shadow: 0 0 6px 0 #333;
         box-shadow: 0 0 6px 0 #333;
     }
     div.overview-sidebar-main-container {
         border-top: none;
         border-bottom: none;
     }
     html {
         -webkit-transition: opacity 1s ease-in;
         -moz-transition: opacity 1s ease-in;
         -ms-transition: opacity 1s ease-in;
         -o-transition: opacity 1s ease-in;
         transition: opacity 1s ease-in;
     }
     .sticky {
         -webkit-box-shadow: 0 0 6px 0 #333 inset;
         -moz-box-shadow: 0 0 6px 0 #333 inset;
         -ms-box-shadow: 0 0 6px 0 #333 inset;
         -o-box-shadow: 0 0 6px 0 #333 inset;
         box-shadow: 0 0 6px 0 #333 inset;
     }
     <?php } ?>
    </style>
    <?php 
    // if OverView Display`s custom background is OFF
    if ( '' !== $overview_display_custom_background_check ){?>
        <style id="overview-custom-background-color-extra-css">
         div#overview-front-page-section-content-container, div#overview-front-page-posts-section-content {color: <?php echo esc_attr( $overview_custom_body_color ); ?>; background-color: #<?php echo esc_attr( $overview_custom_background_color ); ?>;}
        </style>
    <?php }
    // if OverView Display`s custom background is ON
    else {?>
        <style id="overview-custom-background-color-extra-css">
         div#overview-front-page-posts-section-content {color: #404040; background-color: #fff}
        </style>
    <?php }
    }
    // background extra CSS
    add_action( 'wp_head','overview_custom_background_styles' );
    
    /* site title color */
    function overview_custom_site_title_color(){
        $ov_default_site_color = overview_get_site_title_color();
        $ov_site_title_color = get_theme_mod( 'header_textcolor', $ov_default_site_color );
        $ov_site_title_color_default_check = overview_custom_site_title_color_check();
        if ( false === $ov_site_title_color_default_check ){?>
        <style id="overview-site-title-color-extra-css">
         header#masthead div.site-branding h1.site-title a, header#masthead div.site-branding p.site-title a,
         header#masthead div.site-branding h1.site-title a:hover, header#masthead div.site-branding p.site-title a:hover {
             color: #<?php echo esc_attr( $ov_site_title_color ); ?>;
         }
        </style>
    <?php }
    }
    add_action( 'wp_head', 'overview_custom_site_title_color' );


    /* print OverView custom fonts head styles */
    function overview_print_head_google_fonts_link(){
        $overview_site_title_font_check = get_theme_mod( 'overview_site_title_custom_font', '' );
        $overview_custom_font_check = get_theme_mod( 'overview_custom_font', '' );
        $overview_site_title_custom_font_name = ( $overview_site_title_font_check === '' ) ? '' : overview_get_custom_font_name( $overview_site_title_font_check, 'not_pretty' ) . '|';
        $overview_custom_font_name = ( $overview_custom_font_check === '' ) ? 'Muli' : overview_get_custom_font_name( $overview_custom_font_check, 'not_pretty' );
        $overview_blog_font_effect_check = ( is_page_template( 'overview-blog-page.php' ) ) ? '|outline' : '';
    ?>
        <!-- Google Font -->
        <link href="<?php echo esc_url( 'https://fonts.googleapis.com/css?family=' . esc_attr( $overview_site_title_custom_font_name ) . esc_attr( $overview_custom_font_name ) . ':400,500,600,700&effect=emboss|3d-float' . $overview_blog_font_effect_check ); ?>" rel="stylesheet"> 
    <?php }
    
    /* custom font head extra style */
    function overview_add_custom_font_style() {
        $overview_site_title_font = overview_get_custom_font_name( esc_attr( get_theme_mod( 'overview_site_title_custom_font', '' ) ), 'pretty' );
        if ( '' !== $overview_site_title_font ) { ?>
        <style id="overview-site-title-custom-font-css" type="text/css">
         .site-title,
         .overview-navbar-nologo-fallback {
             font-family: "<?php echo esc_attr( $overview_site_title_font ); ?>", sans-serif;
         }
        </style>
    <?php }
    $overview_font_head_style = overview_get_custom_font_name( esc_attr( get_theme_mod( 'overview_custom_font', '' ) ), 'pretty');
    if ( $overview_font_head_style !== '' ){ ?>
        <style id="overview-custom-font-css" type="text/css">
         body {
             font-family: "<?php echo esc_attr( $overview_font_head_style ); ?>", sans-serif;
         }
        </style>
    <?php
    }
    }
    add_action( 'wp_head', 'overview_add_custom_font_style' );

    /* body font size */
    function overview_body_font_size() {
        if ( get_theme_mod( 'overview_body_font_size', '18px' ) !== '18px' ){ ?>
        <style id="overview-body-font-size" type="text/css">
         body {
             font-size: <?php echo esc_attr( get_theme_mod( 'overview_body_font_size', '18px' ) ); ?>;
         }
        </style>
    <?php
    }
    }
    add_action( 'wp_head','overview_body_font_size' );

    // OverView titles alignment
    function overview_titles_alignment(){
        $ov_titles_alignment = get_theme_mod( 'overview_titles_alignment', 'inherit' );
        if ( 'center' === $ov_titles_alignment ){?>
        <style type="text/css" id="overview-centered-titles">
         .entry-title {text-align:center;}
        </style>
    <?php }
    // default titles
    else {?>
	<style type="text/css" id="overview-standard-titles">
	 .entry-title {text-align: center;}
         @media screen and ( min-width: 768px ){
	     .entry-title {text-align:inherit; padding-left:20px; margin-right:20px;}
	 }
        </style>
	<?php }
    if ( is_single() || is_page() ){?>
        <style id="overview-single-entry-title-adjustments-css" type="text/css">
         article.overview-standard-indexed-entry header.entry-header,
         article.overview-standard-indexed-entry-no-featured-img header.entry-header,
         .entry-header.overview-standard-indexed-entry-header {
             width: 100%;
             float: none;
         }
         .overview-single-post-entry-full-featured-image {
             text-align: center;
         }
        </style>
    <?php }
    }
    add_action( 'wp_head', 'overview_titles_alignment' );
    
    // OverView left sidebar adjustments
    function overview_sidebar_extra_layout(){
        $overview_sidebar_side = get_theme_mod( 'overview_sidebar_layout', 'right' );
        if ( is_active_sidebar( 'ov-sidebar-1' ) && 'left' === $overview_sidebar_side ){ ?>
        <style type="text/css" id="overview-left-sidebar-adjustments">
         @supports (display: grid){
             @media screen and (min-width: 980px){
                 #content.overview-content-and-sidebar-layout {
                     grid-template-columns: 400px 1fr 1fr;
                     grid-template-areas: 'sidebar content content';
                 }   
             }
         }
        </style>
    <?php
    }
    }
    add_action( 'wp_head', 'overview_sidebar_extra_layout' );

    // OverView Displays extra adjustments
    function overview_displays_extra_adjustments(){
        $overview_display_check = overview_check_front_page_template();
        if ( $overview_display_check ){ ?>
        <style type="text/css" id="overview-display-extra-adjustments">
         <?php  
         if ( is_page_template( 'overview-front-page.php' ) ){ ?>
         
         article.overview-standard-indexed-entry, article.overview-standard-indexed-entry-no-featured-img, div.overview-sidebar-main-container {
             border-top: none;
         }
         <?php }
         if ( is_page_template( 'overview-front-page-after-content.php' ) ){ ?>
         article.overview-standard-indexed-entry, article.overview-standard-indexed-entry-no-featured-img {
             border-bottom: none;
         }
         <?php } ?>
        </style>
    <?php }
    }
    add_action( 'wp_head', 'overview_displays_extra_adjustments' );

    // OverView footer widgets alignment
    function overview_footer_widgets_alignment(){
        if ( is_active_sidebar( 'ov-footer-1' ) ){
            $ov_footer_alignment = get_theme_mod( 'overview_footer_widgets_alignment', 'auto' );
            if ( 'auto' !== $ov_footer_alignment ){?>
        <style type="text/css" id="overview-footer-widgets-alignment">
         @supports (display: flex) {
             footer.overview-footer-container div.overview-footer-widgets-container section.overview-footer-widget {
                 align-self:
                     <?php
                     if ( 'flex_start' !== $ov_footer_alignment && 'flex_end' !== $ov_footer_alignment ){
                         // standard alignment
                         echo esc_attr( $ov_footer_alignment );
                     }
                     else {
                         // extremities alignment
                         $ov_flex_footer_extremities = ( 'flex_start' === $ov_footer_alignment ) ? 'flex-start' : 'flex-end';
                         echo esc_attr( $ov_flex_footer_extremities );
                     }
                     ?>;
             }
         }
        </style>
    <?php }
    }
    
    }
    add_action( 'wp_head', 'overview_footer_widgets_alignment' );
