<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OverView
 */

?>

<?php
$overview_post_thumbnail_class_check = ( has_post_thumbnail() ) ? 'overview-standard-indexed-entry' : 'overview-standard-indexed-entry-no-featured-img';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($overview_post_thumbnail_class_check); ?>>
    <header class="entry-header overview-standard-indexed-entry-header" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>');">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <?php if ( has_post_thumbnail() ){?>
        <div class="overview-single-post-entry-full-featured-image">
            <?php the_post_thumbnail('full'); ?>
        </div><!-- .full featured image -->
    <?php }?>

    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages( array(
	    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'overview' ),
	    'after'  => '</div>',
        ) );
        ?>
    </div><!-- .entry-content -->

    <?php if ( get_edit_post_link() ) : ?>
        <footer class="entry-footer">
	    <?php
	    edit_post_link(
	        sprintf(
		    /* translators: %s: Name of current post */
		    esc_html__( 'Edit %s', 'overview' ),
		    the_title( '<span class="screen-reader-text">"', '"</span>', false )
	        ),
	        '<span class="edit-link">',
	        '</span>'
	    );
	    ?>
    </footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->
