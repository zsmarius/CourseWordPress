<?php
/**
 * OverView Blog template part
 *
 * Displays single posts in 'Six Pack' layout
 *
 * @package OverView
 */
?>
<!-- OverView Blog Single entry -->
<div class="overview-blog-indexed-entry" id="overview-blog-post-<?php the_ID(); ?>">

    <header class="overview-blog-entry-header">
        <a class="overview-single-entry-link" href="<?php the_permalink(); ?>">
            <!-- Entry image -->
            <div class="overview-single-entry-image" style="background-image: url('<?php
                                                                                   $overview_blog_empty_image_check = false;
                                                                                   if ( has_post_thumbnail() ) {
                                                                                       $overview_blog_single_entry_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "large" );
                                                                                       echo esc_url( $overview_blog_single_entry_image[0] );
                                                                                   }
                                                                                   else {
                                                                                       // if there is a site logo, use that
                                                                                       if ( get_theme_mod( 'custom_logo' ) ) {
                                                                                           echo esc_url( overview_custom_logo() );
                                                                                       }
                                                                                       else {
                                                                                           // if no image is available
                                                                                           $overview_blog_empty_image_check = true;
                                                                                       }
                                                                                   } ?>')">
                <?php
                if ( true === $overview_blog_empty_image_check ){ ?>
                    <h5 class="overview-blog-entry-no-image-fallback font-effect-outline"><?php the_author(); ?><i class="fa fa-pencil-square fa-3x overview-blog-no-img-icon" aria-hidden="true"></i></h5>
                <?php }
                ?>
            </div>
            <!-- Entry title --> 
            <h4 class="overview-blog-entry-title">
                <?php the_title(); ?>
            </h4>
        </a>
    </header> <!-- .overview-blog-entry-header -->

    <div class="entry-meta overview-blog-post-entry-meta">
        <?php overview_posted_on(); ?>
    </div><!-- .entry-meta -->

    <article class="overview-blog-post-content">
        <?php the_excerpt(); ?>
    </article>

</div> <!-- .overview-indexed-content-main-container -->
<?php
