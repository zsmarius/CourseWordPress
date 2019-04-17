<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OverView
 */

?>

	</div><!-- #content -->

<?php 
        if ( is_page_template('overview-front-page-after-content.php') ){
            get_template_part( 'template-parts/overview-display' );
        }
?>
	<footer id="colophon" class="site-footer overview-footer-container" role="contentinfo">
            <?php
            /* OverView social links menu */
            if ( has_nav_menu( 'ov-social-menu-1' ) ){
                wp_nav_menu( array(
                    'theme_location' => 'ov-social-menu-1',
                    'menu_id'        => 'ov-social-menu',
                    'before'         => '<div class="overview-social-nav-link">',
                    'link_after'     => '<div class="overview-default-social-icon"><i class="fa fa-share-alt fa-3x"></i></div>',
                    'after'          => '</div>',
                    'depth'          => 1
                )
                );
            }
            /* OverView footer widgets */
            if ( is_active_sidebar( 'ov-footer-1' ) ){?>
                <div class="overview-footer-widgets-container">
                    <?php dynamic_sidebar( 'ov-footer-1' ); ?>
                </div>
            <?php }
            $overview_site_copyright_check = get_theme_mod( 'overview_site_copyright', '1' );
            if ( '1' === $overview_site_copyright_check ){?>
                <!-- site copyright -->
                <div class="overview-footer-copyright-container">
                    <div class="overview-footer-copyright">
                        <i class="fa fa-copyright"></i>
                        <?php overview_site_copyright(); ?>
                    </div>
                </div>
            <?php }
            ?>
	    <div class="site-info">
                <?php
                $overview_wp_credits_check = get_theme_mod( 'overview_wp_credits', '1' );
                $overview_ov_credits_check = get_theme_mod( 'overview_ov_credits', '1' );
                if ( $overview_wp_credits_check || $overview_ov_credits_check ){?>
                    <div class="overview-footer-info-separator"></div>
                <?php }
                // OverView credits
                if ( $overview_wp_credits_check ){?>
                    <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'overview' ) ); ?>"><?php printf( esc_html__( 'Empowered by %s', 'overview' ), 'WordPress' ); ?></a>
                <?php }
                if ( $overview_wp_credits_check && $overview_ov_credits_check ){?>
                    <span class="sep"> | </span>
                <?php }
                if ( $overview_ov_credits_check ){
                    printf( esc_html__( 'Theme: %1$s by %2$s', 'overview' ), 'OverView', '<a href="' . esc_url( 'https://profiles.wordpress.org/_y_power/' ) . '">_Y_Power</a>' );
                }
                ?>
	    </div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
