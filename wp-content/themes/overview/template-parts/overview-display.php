<?php 

$overview_front_page_title_check = get_theme_mod( 'overview_front_page_title', '' );
if ( '' !== $overview_front_page_title_check ){?>
    <h2 class="overview-front-page-title"><?php echo esc_html( $overview_front_page_title_check ); ?></h2>
<?php  }?>
<!-- overview POSTS main container START -->
<div id="overview-front-page-posts-section-container" class="overview-single-box-container
         <?php 
         $overview_display_background_option = esc_attr( get_theme_mod( 'overview_display_bright_background', '' ) );
         if ( ! $overview_display_background_option ){
             echo 'overview-dark-display';
         }
         else {
             echo 'overview-bright-display';
         }
         ?>" aria-live="assertive">

    <!-- overview splash screen -->
    <div id="overview-front-page-posts-section-splash-screen" class="overview-single-box-container-splash-screen overview-splash-active"></div>

    <?php while ( have_posts() ) : the_post(); // Begin the Loop ?>

	<!-- overview posts display (Backbone posts model element) -->
	<div id="overview-front-page-section-content-container" class="overview-front-page-display-container"></div>

    <?php 
    endwhile; // End the loop.
    ?>
    
</div>
<!-- overview POSTS main container END -->

<!-- overview POSTS navigation START -->
<div class="overview-front-page-display-navigation-container">
    <div class="overview-front-page-display-navigation">
	<div class="overview-front-page-display-navigation-prev">
	    <button id="overview-front-page-display-navigation-prev-button"><i class="fa fa-2x fa-angle-left" aria-hidden="true"></i></button>
	</div>
	<div class="overview-front-page-display-navigation-next">
	    <button id="overview-front-page-display-navigation-next-button"><i class="fa fa-2x fa-angle-right" aria-hidden="true"></i></button>
	</div>
    </div>
</div>
<!-- overview POSTS navigation END -->

<?php
