<?php
/**
 * Template Name: OverView Display
 *
 * Please note that this is the template of OverView's front page
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

    get_template_part( 'template-parts/content', 'page' );

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
