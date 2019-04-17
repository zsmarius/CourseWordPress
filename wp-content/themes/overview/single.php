<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package OverView
 */

get_header(); ?>

<?php 
if ( is_active_sidebar( 'ov-sidebar-1' ) ){?>
    <div id="primary" class="content-area overview-sidebar-layout">
<?php }
else {?>
    <div id="primary" class="content-area overview-full-layout">
<?php } ?>
<main id="main" class="site-main" role="main">

    <?php
    while ( have_posts() ) : the_post();

    get_template_part( 'template-parts/content', get_post_format() );

    the_post_navigation( array(
        'prev_text'                  => '<i class="fa fa-chevron-left overview-navigation-icon overview-navigation-arrow-prev" aria-hidden="true"></i><span class="overview-navigation-direction-span">' . __('previous', 'overview') . ' -- </span>%title',
        'next_text'                  => '<i class="fa fa-chevron-right overview-navigation-icon overview-navigation-arrow-next" aria-hidden="true"></i>%title<span class="overview-navigation-direction-span"> -- ' . __('next', 'overview') . '</span>',
        'in_same_term'               => true,
        'screen_reader_text' => __( 'Continue Reading', 'overview' ),
    ) );

    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
    comments_template();
    endif;

    endwhile; // End of the loop.
    ?>

</main><!-- #main -->
    </div><!-- #primary -->

    <?php
    if ( is_active_sidebar( 'ov-sidebar-1' ) ){?>
        <div class="overview-sidebar-main-container"><?php get_sidebar( 'ov-sidebar-1' ); ?></div>
    <?php }
    get_footer();
