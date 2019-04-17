<?php
/**
 * OverView functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package OverView
 */

if ( ! function_exists( 'overview_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function overview_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on OverView, use a find and replace
     * to change 'overview' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'overview', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus( array(
	'ov-menu-1'        => esc_html__( 'Primary', 'overview' ),
	'ov-social-menu-1' => esc_html__( 'Social', 'overview' )
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption',
    ) );

    // Set up WordPress logo feature.
    add_theme_support( 'custom-logo', array(
	'width'       => 640,
	'height'      => 360,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
    ) );
    
    // Set up the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'overview_custom_background_args', array(
	'default-color'      => 'ffffff',
	'default-image'      => '',
	'default-preset'     => 'fill',
	'default-size'       => 'cover',
	'default-position-x' => 'center',
	'default-position-y' => 'center',
	'default-repeat'     => 'no-repeat',
	'default-attachment' => 'fixed'
    ) ) );

    // Add Gutenberg support.
    add_theme_support( 'align-wide' );
    add_theme_support( 'wp-block-styles' );
    
    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    /* OverView starter content */
    add_theme_support( 'starter_content', array(
	'posts' => array(
	    'home' => array(
		'template' => 'overview-front-page.php'
	    )
	),
	'widgets' => array(
	    'ov-sidebar-1' => array(
		'calendar',
		'search'
	    ),
	    'ov-footer-1' => array(
		'categories',
		'meta',
		'recent-posts'
	    )
	),
	'nav_menus' => array(
	    'ov-social-menu-1' => array(
		'name'  => __( 'Social Menu', 'overview' ),
		'items' => array(
		    'link_facebook',
		    'link_twitter',
		    'link_linkedin',
		    'link_youtube'
		),
	    )
	),
	'theme_mods' => array(
	    'overview_site_branding_description' => __( 'Use this space to describe your story, mission, branding and more in a longer form', 'overview' ),
	    'overview_front_page_title'          => __( 'Check here our latest activities!', 'overview' )
	)
    )
    );

}
endif;
add_action( 'after_setup_theme', 'overview_setup' );


/**
 * Set the content width in pixels, based on OverView's designs and stylesheets.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function overview_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'overview_content_width', 980 );
}
add_action( 'after_setup_theme', 'overview_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function overview_widgets_init() {
    register_sidebar( array(
	'name'          => esc_html__( 'Sidebar', 'overview' ),
	'id'            => 'ov-sidebar-1',
	'description'   => esc_html__( 'Add sidebar widgets here.', 'overview' ),
	'before_widget' => '<section id="%1$s" class="widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<h2 class="widget-title">',
	'after_title'   => '</h2>',
    ) );

    /* OverView footer widgets */
    register_sidebar( array(
	'name'          => esc_html__( 'Footer', 'overview' ),
	'id'            => 'ov-footer-1',
	'description'   => esc_html__( 'Add footer widgets here. Once added, you can set the footer widgets alignment in the section ', 'overview' ) . '<em>' . esc_html__( 'OverView options', 'overview' ) . '</em>',
	'before_widget' => '<section id="%1$s" class="widget %2$s overview-footer-widget">',
	'after_widget'  => '</section>',
	'before_title'  => '<h2 class="widget-title footer-widget-title">',
	'after_title'   => '</h2>',
    ) );    
}
add_action( 'widgets_init', 'overview_widgets_init' );

/* retrieve logo */
function overview_custom_logo() {
    $overview_custom_logo_id = get_theme_mod( 'custom_logo' );
    $overview_custom_logo_image = wp_get_attachment_image_src( $overview_custom_logo_id , 'full' );
    return esc_url($overview_custom_logo_image[0]);
}


/* OverView Display check */
function overview_check_front_page_template(){
    $display_template_check = (
	is_page_template( 'overview-front-page.php' ) ||
	is_page_template( 'overview-front-no-content-page.php' ) ||
	is_page_template( 'overview-front-page-after-content.php' )
    ) ? true : false;
    return $display_template_check;
}


/* OverView blog continue reading tag */
function overview_excerpt_more( $more ) {
    return sprintf( '... <a class="read-more" href="%1$s">%2$s</a>',
		    get_permalink( get_the_ID() ),
		    esc_html__( 'Read more', 'overview' )
    );
}
add_filter( 'excerpt_more', 'overview_excerpt_more' );


/* OverView TinyMCE font */
function overview_tinymce_custom_styles( $mceInit ) {
    $ov_custom_font_check = overview_get_custom_font_name( esc_attr( get_theme_mod( 'overview_custom_font', '' ) ), 'pretty');
    $overview_selected_font = ( $ov_custom_font_check ) === '' ? 'Muli' : $ov_custom_font_check;
    $overview_custom_body_color = get_theme_mod( 'overview_custom_body_color', '#404040' );
    $overview_selected_extra_styles = "body.mce-content-body { font-family: '" . $overview_selected_font . "', sans-serif; font-size: " . get_theme_mod( 'overview_body_font_size', '18px' ) . "; color: " . esc_attr( $overview_custom_body_color ) . "; background-color: #" . esc_attr( get_background_color() ) . ";}";
    if ( isset( $mceInit['content_style'] ) ) {
	$mceInit['content_style'] .= ' ' . $overview_selected_extra_styles . ' ';
    } else {
	$mceInit['content_style'] = $overview_selected_extra_styles . ' ';
    }
    return $mceInit;
}
add_filter('tiny_mce_before_init','overview_tinymce_custom_styles');

/* OverView TinyMCE styles */
function overview_add_editor_styles() {
    $ov_custom_font_check = overview_get_custom_font_name( esc_attr( get_theme_mod( 'overview_custom_font', '' ) ), 'not-pretty');
    $overview_selected_font = ( $ov_custom_font_check ) === '' ? 'Muli' : $ov_custom_font_check;
    $overview_selected_font_url = str_replace( ',', '%2C', 'https://fonts.googleapis.com/css?family=' . $overview_selected_font . ':300,400,500,600,700,800' );
    $ov_active_color_scheme = get_theme_mod( 'overview_colors_theme', 'iced_lake' );
    add_editor_style( array(
	$overview_selected_font_url,
	'style.css',
	'/css/color-schemes/overview-' . esc_attr( $ov_active_color_scheme ) . '.css',
	'css/overview-addons.css',
	'css/overview-editor-styles.css'
    ) );
}
add_action( 'admin_init', 'overview_add_editor_styles' );

/* OverView Gutenberg post classes filter */
function overview_gutenberg_post_classes( $classes ){
    /* OverView Gutenberg check */
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    $overview_is_gutenberg_check = ! is_plugin_active( 'classic-editor/classic-editor.php' );
    if ( $overview_is_gutenberg_check ){
	$classes[] = 'ov-gutenberg-entry';
    }
    return $classes;
}
add_filter( 'post_class', 'overview_gutenberg_post_classes' );

/* OverView Gutenberg body classes filter */
function overview_gutenberg_body_classes( $classes ){
    /* OverView Gutenberg check */
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    $overview_is_gutenberg_check = ! is_plugin_active( 'classic-editor/classic-editor.php' );
    if ( is_page_template( 'overview-blog-page.php' ) && $overview_is_gutenberg_check ){
	$classes[] = 'ov-gutenberg-blog-and-page-entry';
    }
    return $classes;
}
add_filter( 'body_class', 'overview_gutenberg_body_classes' );

/* OverView Gutenberg styles */
function overview_block_editor_back_styles() {
    $ov_custom_font_check = overview_get_custom_font_name( esc_attr( get_theme_mod( 'overview_custom_font', '' ) ), 'not-pretty');
    $overview_selected_font = ( $ov_custom_font_check ) === '' ? 'Muli' : $ov_custom_font_check;
    wp_enqueue_style( 'overview-block-editor-font', 'https://fonts.googleapis.com/css?family=' . $overview_selected_font . ':300,400,500,600,700,800' );
    wp_enqueue_style( 'overview-block-editor-styles', get_theme_file_uri( '/css/overview-gutenberg-back-styles.css' ), false, '1.0', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'overview_block_editor_back_styles' );

/**
 * Enqueue scripts and styles.
 */
function overview_scripts() {
    
    /* Font Awesome */
    wp_enqueue_style( 'overview-font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css' ); // Font Awesome by Dave Gandy - http://fontawesome.io

    /* OverView core main styles (WP and _s) */
    wp_enqueue_style( 'overview-core-style', get_stylesheet_uri() );
    
    /* OverView styles */
    $ov_chosen_color_scheme = get_theme_mod( 'overview_colors_theme', 'iced_lake' );
    wp_enqueue_style( 'overview-style', get_template_directory_uri() . '/css/color-schemes/overview-' . esc_attr( $ov_chosen_color_scheme ) . '.css' );

    /* OverView addons styles */
    wp_enqueue_style( 'overview-style-addons', get_template_directory_uri() . '/css/overview-addons.css' );

    /* OverView Display addons */
    $overview_display_alt_img = get_theme_mod( 'overview_display_image_rotation', '1' );
    if ( '' !== $overview_display_alt_img ){
	wp_enqueue_style( 'overview-display-style-addons', get_template_directory_uri() . '/css/overview-display-alt-img.css' );
    }
    
    /* OverView Layout */
    $overview_layout_check = get_theme_mod( 'overview_layout', 'fixed' );
    if ( $overview_layout_check === 'fixed' ){
	wp_enqueue_style( 'overview-style-layout', get_template_directory_uri() . '/css/overview-fixed-layout.css' );
    }
    
    /* _s navigation script */
    wp_enqueue_script( 'overview-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    /* _s skip link focus fix */
    wp_enqueue_script( 'overview-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    /* OverView scripts */
    wp_enqueue_script( 'overview-scripts', get_template_directory_uri() . '/js/overview.js', array( 'jquery' ) );

    /* OvwerView general theme variables */
    $overview_theme_general_variables = array(
	/* header image check */
	'OVBannerImage' => has_header_image()
    );
    wp_localize_script( 'overview-scripts', 'OVThemeVars', $overview_theme_general_variables );
    
    /* OverView Display scripts */
    $overview_display_check = overview_check_front_page_template();
    /* OverView Gutenberg check */
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    $overview_is_gutenberg_check = ! is_plugin_active( 'classic-editor/classic-editor.php' );
    if ( $overview_display_check ) {
	if ( $overview_is_gutenberg_check ){
	    wp_enqueue_script( 'overview-display-gutenberg-scripts', get_template_directory_uri() . '/js/overview-display-gutenberg.js', array( 'jquery' ) );
	}
	// classic
	else {
	    wp_enqueue_script( 'overview-display-scripts', get_template_directory_uri() . '/js/overview-display.js', array( 'jquery', 'underscore', 'backbone', 'wp-api' ) );
	}
    }

    /* comments reply */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
    }

    /* OverView Display templates resources */
    if ( $overview_display_check ){
	/* JS vars */
	$overview_JS_variables = array(
	    /* site locale */
	    'OVSiteLocale'        => get_locale(),
	    /* custom logo url */
	    'OVSiteLogo'          => overview_custom_logo(),
	    /* set direction */
	    'OVSiteDirection'     => is_rtl(),
	    /* local language calendar */
	    'OVLocalLangCalendar' => array(
		'01'                    => __('January', 'overview'),
		'02'                    => __('February', 'overview'),
		'03'                    => __('March', 'overview'),
		'04'                    => __('April', 'overview'),
		'05'                    => __('May', 'overview'),
		'06'                    => __('June', 'overview'),
		'07'                    => __('July', 'overview'),
		'08'                    => __('August', 'overview'),
		'09'                    => __('September', 'overview'),
		'10'                    => __('October', 'overview'),
		'11'                    => __('November', 'overview'),
		'12'                    => __('December', 'overview')
	    )
	);
	if ( $overview_is_gutenberg_check ){
	    wp_localize_script( 'overview-display-gutenberg-scripts', 'OVAPIVars', $overview_JS_variables );
	}
	else {
	    wp_localize_script( 'overview-display-scripts', 'OVAPIVars', $overview_JS_variables );
	}
    }

    // admin
    if ( is_user_logged_in() && ! is_customize_preview() ){
	/* admin CSS */
	wp_enqueue_style( 'overview-admin-css', get_template_directory_uri() . '/css/overview-admin.css' );
    }
    
}
add_action( 'wp_enqueue_scripts', 'overview_scripts' );

/**
 * Admin files
 */
function overview_admin_files( $overview_admin_hook ){
    // register admin JS
    if ( is_user_logged_in() && is_customize_preview() ) {
	wp_register_script( 'overview-admin-js', get_template_directory_uri() . '/js/admin/overview-admin.js', array( 'jquery', 'customize-controls' ) );
	// enqueue
	wp_enqueue_script( 'overview-admin-js' );
    }
    $overview_roles_check = current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages');
    if ( $overview_admin_hook == 'post.php' && $overview_roles_check ){
	// Gutenberg custom settings
	if ( is_user_logged_in() && ! is_customize_preview() && ! is_plugin_active( 'classic-editor/classic-editor.php' ) ){
	    wp_enqueue_script( 'overview-admin-gutenberg-js', get_template_directory_uri() . '/js/admin/overview-admin-gutenberg.js', array( 'jquery' ) );
	    $overview_block_editor_vars = array(
		'layout'           => esc_attr( get_theme_mod( 'overview_layout', 'fixed' ) ),
		'font'             => overview_get_custom_font_name( esc_attr( get_theme_mod( 'overview_custom_font', '' ) ), 'pretty'),
		'font_size'        => esc_attr( get_theme_mod( 'overview_body_font_size', '18px' ) ),
		'titles_alignment' => esc_attr( get_theme_mod( 'overview_titles_alignment', 'inherit' ) ),
		'main_color'       => esc_attr( '#' . overview_get_site_title_color() ),
		'color'            => esc_attr( get_theme_mod( 'overview_custom_body_color', '#404040' ) ),
		'background_color' => get_background_color(),
		'active_sidebar'   => is_active_sidebar( 'ov-sidebar-1' )
	    );
	    wp_localize_script( 'overview-admin-gutenberg-js', 'OVBlockEditorVars', $overview_block_editor_vars );
	}
    }
}
add_action( 'admin_enqueue_scripts', 'overview_admin_files' );

/**
 * Custom Header
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * OverView head custom functions
 */
require get_template_directory() . '/inc/ov-head-extra.php';

/**
 * OverView custom template tags
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * OverView custom functions that act independently of the theme templates
 */
require get_template_directory() . '/inc/extras.php';

/**
 * OverView Customizer additions
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file
 */
require get_template_directory() . '/inc/jetpack.php';
