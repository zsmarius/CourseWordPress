<?php
/**
 * OverView Custom Header
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package OverView
 */

/**
 * Set up the WordPress core custom header feature.
 */
function overview_custom_header_setup() {
    $ov_default_site_color = overview_get_site_title_color();
    $ov_site_title_color_default_check = overview_custom_site_title_color_check();
    if ( true === $ov_site_title_color_default_check ) {
        // if it is a default value, update theme setting
        set_theme_mod( 'header_textcolor', $ov_default_site_color );
    }
    add_theme_support( 'custom-header', apply_filters( 'overview_custom_header_args', array(
	'default-image'          => '',
	'default-text-color'     => overview_get_site_title_color(),
        'flex-width'             => true,
	'width'                  => 1920,
        'flex-height'            => true,
	'height'                 => 680,
        'wp-head-callback'       => 'overview_header_style'
    ) ) );
}
add_action( 'after_setup_theme', 'overview_custom_header_setup' );

if ( ! function_exists( 'overview_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see overview_custom_header_setup().
 */
function overview_header_style() { ?>
    <style id="overview-custom-header-css" type="text/css">
     <?php
     // Has the text been hidden?
     if ( ! display_header_text() ) :
     ?>
     .site-branding {
         display: none;
     }
     /*
     .site-title,
     .site-description {
	 position: absolute;
	 clip: rect(1px, 1px, 1px, 1px);
     }
     */
     header#masthead p.site-branding-description-p {
         display: block;
         float: none;
         width: 100%;
         margin: 0 auto;
         -webkit-border-radius: 0;
         -moz-border-radius: 0;
         -ms-border-radius: 0;
         -o-border-radius: 0;
         border-radius: 0;
     }
     <?php
     // If the user has set a custom color for the text use that.
     else :
     if ( has_header_image() ) {
         $ov_header_image_filter_value = get_theme_mod( 'overview_header_image_filter', 10 );
         $ov_site_titles_background_visibility = get_theme_mod( 'overview_site_titles_background_visibility', 0 );
         $ov_site_titles_background_opacity_value = get_theme_mod( 'overview_site_titles_background_opacity', 50 );
     ?>
     /*
        .site-title a {
	color: #<?php // echo esc_attr( $overview_header_text_color ); ?>;
        }
      */
     div.site-branding {
         position: absolute;
         width: 100%;
         max-width: 100%;
     }
     @media screen and (max-width: 767px){
         div.site-branding {
             position: relative;
         }
         h1.site-title,
         p.site-title {
             padding-top: 15px;
         }
         h1.site-title,
         p.site-title,
         p.site-description {
             margin-bottom: 0;
         }
     }
     div#overview-header-image-filter {
         display: block;
         background-color: rgba(0,0,0,0.<?php echo esc_attr( intval( $ov_header_image_filter_value ) ); ?>);
     }
         <?php
         if ( $ov_site_titles_background_visibility ){?>
     .site-branding {
         background-color: rgba(255,255,255,0.<?php echo esc_attr( intval( $ov_site_titles_background_opacity_value ) ); ?>);
     }
     @media screen and (max-width: 767px){
         .site-branding {
             padding-bottom: 12px;
         }
     }
         <?php }
         ?>
     h1.site-title,
     p.site-title,
     p.site-description {
         text-align: center;
         background-color: transparent !important;
     }
     h1.site-title a,
     p.site-title a,
     p.site-description a {
         padding-left: 0;
     }
     /* header image title and tagline padding */
     h1.site-title a,
     p.site-title a,
     p.site-description {
         padding: 0;
     }

     a.overview-site-title-a {
         padding: 12px !important;
     }

     div.site-branding .site-title,
     header#masthead div.site-branding p.site-description {
         background-color: transparent !important;
     }

     header#masthead p.site-branding-description-p {
         display: block;
         float: none;
         width: 100%;
         margin: 0 auto;
         -webkit-border-radius: 0;
         -moz-border-radius: 0;
         -ms-border-radius: 0;
         -o-border-radius: 0;
         border-radius: 0;
     }
     <?php }
     endif; ?>
    </style>
<?php
}
endif;
