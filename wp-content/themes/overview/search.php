<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
    if ( have_posts() ) : ?>

	<header class="page-header">
	    <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'overview' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</header><!-- .page-header -->

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post();

	/**
	 * Run the loop for the search to output the results.
	 * If you want to overload this in a child theme then include a file
	 * called content-search.php and that will be used instead.
	 */
	//get_template_part( 'template-parts/content', 'search' );

        ?>
            <div class="overview-indexed-content-main-container"><?php get_template_part( 'template-parts/content', get_post_format() ); ?>
            </div> <!-- .overview-indexed-content-main-container -->
        <?php 

	endwhile;

	the_posts_navigation();

	else :

        ?>
        <div class="overview-unindexed-content-main-container"><?php get_template_part( 'template-parts/content', 'none' ); ?>
        </div> <!-- .overview-indexed-content-main-container -->
    <?php

    endif; ?>

</main><!-- #main -->
    </div><!-- #primary </section> -->

    <?php
    if ( is_active_sidebar( 'ov-sidebar-1' ) ){?>
        <div class="overview-sidebar-main-container"><?php get_sidebar( 'ov-sidebar-1' ); ?></div>
    <?php }
    get_footer();
