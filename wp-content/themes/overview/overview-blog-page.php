<?php
/**
 * Template Name: Page and Blog
 *
 * Please note that this is the template of OverView's page plus blog
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OverView
 */

get_header();

if ( is_active_sidebar( 'ov-sidebar-1' ) ){ ?>
    <div id="primary" class="content-area overview-sidebar-layout">
<?php }
else { ?>
    <div id="primary" class="content-area overview-full-layout">
<?php } ?>
<h1 class="page-title screen-reader-text"><?php the_title(); ?></h1>
<h1 class="entry-title overview-blog-page-title"><?php the_title(); ?></h1>
<?php 
// WP standard page Loop
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div <?php post_class('overview-blog-page-content'); ?>><?php the_content(); ?></div>
<?php
endwhile;
else : ?>
<p class="overview-blog-page-no-content-found"></p>
<?php
endif;
?>
<!-- OverView Blog container -->
<main id="main" class="site-main overview-blog-container" role="main">
    <div class="overview-blog-frames-container">
        <?php
        /* OverView custom Loop */
        $overview_blog_custom_args = array(
            'post_type'              => 'post',
            'nopaging'               => false,
            'ignore_sticky_posts'    => true,
	    'posts_per_page'         => '6',
	    'order'                  => 'DESC',
	    'orderby'                => 'date',
        );
        /* OverView front page blog check */
        $overview_front_blog_check = ( is_front_page() ) ? 'page' : 'paged';
        /* set custom paged value according to template */
        $overview_blog_custom_args[ 'paged' ] = get_query_var( $overview_front_blog_check ) ? absint( get_query_var( $overview_front_blog_check ) ) : 1;
        /* OverView blog custom WP query */
        $overview_blog_custom_query = new WP_Query( $overview_blog_custom_args );
        /* setup custom pagination by substituting the original WP_Query object */
        $overview_temp_wp_query = $wp_query;
        $wp_query = NULL;
        $wp_query = $overview_blog_custom_query;
        /* Start the custom Loop */
        if ( $overview_blog_custom_query->have_posts() ) :
                    while ( $overview_blog_custom_query->have_posts() ) :
                    $overview_blog_custom_query->the_post();
        get_template_part( 'template-parts/overview-blog' );
        endwhile;
        else : ?>
            <div class="overview-unindexed-content-main-container"><?php get_template_part( 'template-parts/content', 'none' ); ?>
            </div> <!-- .overview-indexed-content-main-container -->
        <?php
        endif;
        // restore post data
        wp_reset_postdata(); ?>
    </div> <!-- .overview-blog-frames-container -->
    <?php 
    the_posts_navigation( array(
        'mid_size'                   => 2,
        'prev_text'                  => '<i class="fa fa-chevron-left overview-navigation-icon overview-navigation-arrow-prev" aria-hidden="true"></i><span class="overview-navigation-direction-span">' . __('Previous entries', 'overview'),
        'next_text'                  => '<i class="fa fa-chevron-right overview-navigation-icon overview-navigation-arrow-next" aria-hidden="true"></i><span class="overview-navigation-direction-span">' . __('Newer entries', 'overview') . '</span>',
        'screen_reader_text'         => __( 'Continue Reading', 'overview' )
    ) );
    // Reset original WP_Query object
    $wp_query = NULL;
    $wp_query = $overview_temp_wp_query;
    ?>    
</main><!-- #main -->
    </div><!-- #primary -->

    <?php
    if ( is_active_sidebar( 'ov-sidebar-1' ) ){ ?>
        <div class="overview-sidebar-main-container"><?php get_sidebar( 'ov-sidebar-1' ); ?></div>
    <?php }
    get_footer();
