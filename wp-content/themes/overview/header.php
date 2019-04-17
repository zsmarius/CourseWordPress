<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OverView
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="overview-html-not-ready">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php
        /* OverView Google fonts */
        overview_print_head_google_fonts_link();
        wp_head();
        ?>
    </head>

    <body <?php body_class(); ?>>
        <div id="page" class="site">
	    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'overview' ); ?></a>

            <!-- OverView master header -->
	    <header id="masthead" class="site-header" role="banner">

                <!-- OverView site navigation -->
	        <nav id="site-navigation" class="main-navigation" role="navigation">
                    <!-- OverView site logo -->
                    <a id="overview-navbar-site-logo" title="<?php bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php
                        if ( get_theme_mod( 'custom_logo' ) ) {?>
                            <img alt="<?php echo bloginfo( 'name' ) . ' '  . esc_attr__( 'logo', 'overview' ); ?>" src="<?php echo esc_url( overview_custom_logo() ); ?>" />
                        <?php }
                        else {?>
                            <p class="overview-navbar-nologo-fallback"><?php bloginfo( 'name' ); ?></p>
                        <?php }
                        ?></a>

		        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars fa-2x" aria-hidden="true" title="<?php esc_attr( __('Toggle Menu', 'overview') ); ?>"></i><?php //esc_html_e( 'Primary Menu', 'overview' ); //overview removed default ?></button>
		        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'ov-menu-1',
                            'menu_id'        => 'primary-menu',
                            'fallback_cb'    => 'wp_page_menu'
                        )
                        );
                        ?>
		</nav><!-- #site-navigation -->

                <?php if ( has_header_image() ) { ?>
                    <!-- OverView header image -->
                    <div id="overview-header-image-container">
                        <?php the_header_image_tag(); ?>
                        <div id="overview-header-image-filter"></div>
                    </div>
                <?php } ?>
                
                <!-- OverView site branding -->
	        <div class="site-branding">
                    <?php if ( is_front_page() && is_home() ) : ?>
		        <h1 class="site-title font-effect-emboss"><a class="overview-site-title-a" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		    <?php else : ?>
		        <p class="site-title font-effect-emboss"><a class="overview-site-title-a" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		    <?php
		    endif;

		    $overview_site_description = get_bloginfo( 'description', 'display' );
		    if ( $overview_site_description || is_customize_preview() ) : ?>
		        <p class="site-description font-effect-3d-float"><?php echo $overview_site_description; /* WPCS: xss ok. */ ?></p>
		    <?php
		    endif;
                    ?>
	        </div><!-- .site-branding -->

                <?php
                $overview_site_branding_description_text = get_theme_mod('overview_site_branding_description', __( 'Use this space to describe your story, mission, branding and more in a longer form', 'overview' ));
                if ( $overview_site_branding_description_text !== '' ){ ?>
                    <!-- OverView site branding description -->
                    <p class="site-branding-description-p">
                        <?php echo esc_html( get_theme_mod( 'overview_site_branding_description', __( 'Use this space to describe your story, mission, branding and more in a longer form', 'overview' ) ) ); ?>
                    </p>
                <?php }
                ?>
                
	    </header><!-- #masthead -->

            <?php 
            if ( is_page_template('overview-front-page.php') || is_page_template('overview-front-no-content-page.php') ){
                get_template_part( 'template-parts/overview-display' );
            }
            ?>
            
	    <div id="content" class="site-content
                     <?php 
                     if ( is_active_sidebar('ov-sidebar-1') ){
                         echo ' overview-content-and-sidebar-layout'; 
                     }
                     ?>
                     ">
