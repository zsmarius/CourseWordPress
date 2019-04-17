<?php
/**
 * Template part for displaying posts
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
    <?php
    if ( is_single() ) :
    the_title( '<h1 class="entry-title overview-single-post-title">', '</h1>' );
    else :
    the_title( '<h2 class="entry-title overview-default-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
    endif; ?>
</header><!-- .entry-header -->

<?php if ( has_post_thumbnail() ){
    if ( ! is_single() ){?>
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="overview-default-post-entry-featured-image-aside"><?php the_post_thumbnail('medium'); ?></a><!-- .featured-image-anchor -->
<?php }
else { ?>
    <div class="overview-single-post-entry-full-featured-image">
        <?php the_post_thumbnail('full'); ?>
    </div><!-- .full featured image -->
    <?php }
    }
    
    if ( 'post' === get_post_type() ) : ?>
        <div class="entry-meta overview-default-post-entry-meta">
            <?php overview_posted_on(); ?>
        </div><!-- .entry-meta -->
    <?php
    endif;
    
    ?>
    
    <div class="entry-content overview-default-entry-content">
	<?php
	the_content( sprintf(
	    /* translators: %s: Name of current post. */
	    wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'overview' ), array( 'span' => array( 'class' => array() ) ) ),
	    the_title( '<span class="screen-reader-text">"', '"</span>', false )
	) );

	wp_link_pages( array(
	    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'overview' ),
	    'after'  => '</div>',
	) );
	?>
    </div><!-- .entry-content -->

    <footer class="entry-footer overview-default-entry-footer">
	<?php overview_entry_footer(); ?>
    </footer><!-- .entry-footer -->
    </article><!-- #post-## -->
