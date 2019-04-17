<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
<?php }
/* blog layout check */
if ( is_home() ) :
                        $overview_blog_layout_check = get_theme_mod( 'overview_blog_layout', 'frames' );
endif;
/* home screen reader */
if ( is_home() && ! is_front_page() && have_posts() ) : ?>
<header>
    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
</header>
<?php
endif;
?>

<main id="main" class="site-main
          <?php 
          if ( is_home() && 'frames' === $overview_blog_layout_check ) : ?>
           overview-blog-container" role="main"><div class="overview-blog-frames-container">
          <?php
          else : ?>
          " role="main">
          <?php
          endif;
          ?>

          <?php
          if ( have_posts() ) :
          
          /* Start the Loop */
          while ( have_posts() ) : the_post();

    /*
     * Include the Post-Format-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
     */
    
    if ( is_home() && 'frames' === $overview_blog_layout_check ) :
    /* get OverView blog template */
    get_template_part( 'template-parts/overview-blog' );
    /* else, get regular list */
    else : ?>
        <div class="overview-indexed-content-main-container"><?php get_template_part( 'template-parts/content', get_post_format() ); ?>
        </div> <!-- .overview-indexed-content-main-container -->
<?php
endif;
endwhile;
if ( is_home() && 'frames' === $overview_blog_layout_check ) : ?>
</div> <!-- .overview-blog-frames-container -->
<?php
endif;
the_posts_navigation( array(
    'prev_text'                  => '<i class="fa fa-chevron-left overview-navigation-icon overview-navigation-arrow-prev" aria-hidden="true"></i><span class="overview-navigation-direction-span">' . __('Previous entries', 'overview'),
    'next_text'                  => '<i class="fa fa-chevron-right overview-navigation-icon overview-navigation-arrow-next" aria-hidden="true"></i><span class="overview-navigation-direction-span">' . __('Newer entries', 'overview') . '</span>',
    'in_same_term'               => true,
    'screen_reader_text' => __( 'Continue Reading', 'overview' ),
) );
else :
?>
<div class="overview-unindexed-content-main-container"><?php get_template_part( 'template-parts/content', 'none' ); ?>
</div> <!-- .overview-indexed-content-main-container -->
    <?php 
    endif; ?>
</main><!-- #main -->
    </div><!-- #primary -->

    <?php
    if ( is_active_sidebar( 'ov-sidebar-1' ) ){ ?>
        <div class="overview-sidebar-main-container"><?php get_sidebar( 'ov-sidebar-1' ); ?></div>
    <?php }

    get_footer();
