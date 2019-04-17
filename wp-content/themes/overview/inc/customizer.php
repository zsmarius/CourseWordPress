<?php
/**
 * OverView Theme Customizer
 *
 * @package OverView
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function overview_customize_register( $wp_customize ) {

    /* OverView custom escaping functions */

    // layout
    function ov_escape_layout( $overview_chosen_layout ){
        $overview_layout_options = array( 'fixed', 'full' );
        $overview_chosen_layout = trim( $overview_chosen_layout );
        $overview_layout_ouput;
        for ( $ov_i = 0; $ov_i < 2; $ov_i++ ){
            if ( $overview_layout_options[$ov_i] === $overview_chosen_layout ){
                $overview_layout_ouput = $overview_layout_options[$ov_i];
            }
        }
        if ( null === $overview_layout_ouput ){
            $overview_layout_ouput = 'fixed';
        }
        return $overview_layout_ouput;
    }

    // sidebar layout
    function ov_escape_sidebar_layout( $overview_chosen_sidebar_layout ){
        $overview_sidebar_layout_options = array( 'right', 'left' );
        $overview_chosen_sidebar_layout = trim( $overview_chosen_sidebar_layout );
        $overview_sidebar_layout_ouput;
        for ( $ov_i = 0; $ov_i < 2; $ov_i++ ){
            if ( $overview_sidebar_layout_options[$ov_i] === $overview_chosen_sidebar_layout ){
                $overview_sidebar_layout_ouput = $overview_sidebar_layout_options[$ov_i];
            }
        }
        if ( null === $overview_sidebar_layout_ouput ){
            $overview_sidebar_layout_ouput = 'right';
        }
        return $overview_sidebar_layout_ouput;
    }

    /* OverView titles background opacity check */
    function overview_site_titles_background_opacity_check(){
        $ov_titles_background_visibility_check = get_theme_mod( 'overview_site_titles_background_visibility', 0 );
        return has_header_image() && $ov_titles_background_visibility_check;
    }
    
    /* OverView sidebar check */
    function ov_sidebar_check(){
        return is_active_sidebar( 'ov-sidebar-1' );
    }

    /* OverView fotter widgets check */
    function overview_footer_widgets_check(){
        return is_active_sidebar( 'ov-footer-1' );
    }
    
    
    /* OverView Display check */
    function overview_front_page_template_check(){
        $display_template_check = (
            is_page_template( 'overview-front-page.php' ) ||
            is_page_template( 'overview-front-no-content-page.php' ) ||
            is_page_template( 'overview-front-page-after-content.php' )
        ) ? true : false;
        return $display_template_check;
    }
    

    /* OverView WordPress customizer SETTINGS */

    // site title and description background visibility
    $wp_customize->add_setting( 'overview_site_titles_background_visibility', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => 0,
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
    ) );

    // site title and description background opacity
    $wp_customize->add_setting( 'overview_site_titles_background_opacity', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => 50,
        'transport'         => 'postMessage',
        'sanitize_callback' => 'esc_attr'
    ) );

    // site branding
    $wp_customize->add_setting( 'overview_site_branding_description', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => __( 'Use this space to describe your story, mission, branding and more in a longer form', 'overview' ),
        'transport'         => 'postMessage',
        'sanitize_callback' => 'esc_html'
    ) );

    // body main color
    $wp_customize->add_setting( 'overview_custom_body_color', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '#404040',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color'
    ) );
    
    // colors themes
    $wp_customize->add_setting( 'overview_colors_theme', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => 'iced_lake',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
    ) );

    // header image filter
    $wp_customize->add_setting( 'overview_header_image_filter', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => 10,
        'transport'         => 'postMessage',
        'sanitize_callback' => 'esc_attr'
    ) );

    // layouts
    $wp_customize->add_setting( 'overview_layout', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => 'fixed',
        'transport'         => 'refresh',
        'sanitize_callback' => 'ov_escape_layout'
    ) );

    // blog layout
    $wp_customize->add_setting( 'overview_blog_layout', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => 'frames',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
    ) );
    
    // sidebar layout
    $wp_customize->add_setting( 'overview_sidebar_layout', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => 'right',
        'transport'         => 'refresh',
        'sanitize_callback' => 'ov_escape_sidebar_layout'
    ) );    

    // site title custom font
    $wp_customize->add_setting( 'overview_site_title_custom_font', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_textarea'
    ) );
    
    // body custom font
    $wp_customize->add_setting( 'overview_custom_font', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_textarea'
    ) );

    // body font size
    $wp_customize->add_setting( 'overview_body_font_size', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '18px',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'esc_attr'
    ) );

    // entry titles alignment
    $wp_customize->add_setting( 'overview_titles_alignment', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => 'inherit',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'esc_attr'
    ) );

    // front page template description
    $wp_customize->add_setting( 'overview_front_page_title', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'esc_html'
    ) );

    // front page template display background
    $wp_customize->add_setting( 'overview_display_bright_background', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
    ) );

    // front page template image rotatation
    $wp_customize->add_setting( 'overview_display_image_rotation', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '1',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
    ) );

    // OverView footer widgets alignment
    $wp_customize->add_setting( 'overview_footer_widgets_alignment', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => 'auto',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
    ) );

    // show WordPress credits
    $wp_customize->add_setting( 'overview_wp_credits', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '1',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
    ) );

    // show OverView credits
    $wp_customize->add_setting( 'overview_ov_credits', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '1',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
    ) );
    
    // OverView site copyright
    $wp_customize->add_setting( 'overview_site_copyright', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '1',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
    ) );    
    
    // OverView about
    $wp_customize->add_setting( 'overview_about', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_textarea'
    ) );    
    

    /* OverView WordPress customizer SECTIONS */
    
    // general options
    $wp_customize->add_section( 'overview_options', array(
        'title'       => __( 'OverView options', 'overview' ),
        'description' => '<em>' . __( 'Note: if the page you are previewing has an active OverView Display page template, the OverView Display settings will be shown below the control', 'overview' ) . ' <a id="customizer-ov-options-footer-copyright-redirect">' . __( 'Footer Copyright', 'overview' ) . '</em></a>.',
        'priority'    => 80,
        'capability'  => 'edit_theme_options'
    ) );

    // about ' . esc_url( 'https://wordpress.org/support/theme/handcraft-expo/reviews/#new-post' ) . '
    $wp_customize->add_section( 'overview_about_section', array(
        'title'       => __( 'About', 'overview' ),
        'description' => __( 'Thank you for using OverView, a completely free (as in FREEDOM) WordPress theme!', 'overview' ) . '<ul><br /><strong><em>' . __( 'Some useful links', 'overview' ) . '</em></strong><li><a href="' . esc_url( 'https://codex.wordpress.org/Themes' ) . '">' . __( 'using WordPress themes', 'overview' ) . '</a></li><li><a href="' . esc_url( 'https://wordpress.org/support/theme/overview' ) .'">' . __( 'OverView support forum', 'overview' ) . '</a></li><li><a href="' . esc_url( 'https://wordpress.org/support/' ) .'">' . __( 'WordPress support', 'overview' ) . '</a></li><li><a href="' . esc_url( 'https://codex.wordpress.org/Child_Themes' ) . '">' . __( 'WordPress child themes', 'overview' ) . '</a></li><li><a href="' . esc_url( 'https://wordpress.org/support/theme/overview/reviews/#new-post' ) . '">' . __( 'rate OverView', 'overview' ) . '</a></li></ul><br />' . __( 'You can learn more about the wonderful world of Free Software and why it matters to you by visting the', 'overview' ) . ' <a href="' . esc_url( 'http://www.fsf.org/about/what-is-free-software' ) . '">' . __( 'Free Software Foundation', 'overview' ) . '</a>.',
        'priority'    => 220,
        'capability'  => 'edit_theme_options'
    ) );
    
    /* OverView WordPress customizer CONTROLS */

    // site titles background visibility
    $wp_customize->add_control( 'overview_site_titles_background_visibility', array(
        'type'            => 'checkbox',
        'priority'        => 45,
        'section'         => 'title_tagline',
        'label'           => __( 'Site Titles background', 'overview' ),
        'input_attrs'     => array(
            'class' => 'overview-site-titles-background-visibility',
            'style' => 'border: 1px solid gray;'
        ),
        'active_callback' => 'has_header_image'
    ) );

    // site titles background opacity
    $wp_customize->add_control( 'overview_site_titles_background_opacity', array(
        'type'            => 'range',
        'priority'        => 45,
        'section'         => 'title_tagline',
        'label'           => __( 'Site Titles background opacity ', 'overview' ),
        'description'     => __( 'Note: to enhance contrast, also use the <strong>Filter opacity</strong> control, in the section', 'overview' ) . '<a id="overview-customizer-header-img-filter-redirect"><em>' . ' ' . __( 'Header Image', 'overview' ) . '</em></a>.',
        'input_attrs'     => array(
            'class' => 'overview-site-titles-background-opacity',
            'min'   => 10,
            'max'   => 95,
            'step'  => 1
        ),
        'active_callback' => 'overview_site_titles_background_opacity_check'
    ) );

    // site branding
    $wp_customize->add_control( 'overview_site_branding_description', array(
        'type'        => 'textarea',
        'priority'    => 50,
        'section'     => 'title_tagline',
        'label'       => __( 'Site branding description', 'overview' ),
        'description' => __( 'Describe your brand and/or mission', 'overview' ),
        'input_attrs' => array(
            'class'      => 'overview-site-branding-description-text',
            'style'      => 'border: 1px solid gray;'
        ),
    ) );

    // main body color
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'overview_custom_body_color', array(
        'label'    => __( 'Text color', 'overview' ),
        'section'  => 'colors',
        'priority' => 10
    ) ) );
    
    // colors themes    
    $wp_customize->add_control( 'overview_colors_theme', array(
        'type'        => 'select',
        'priority'    => 30,
        'section'     => 'colors',
        'label'       => __( 'Colors scheme', 'overview' ),
        'input_attrs' => array(
            'class'      => 'overview-colors-themes',
            'style'      => 'border: 1px solid gray;'
        ),
        'choices' => array(
            'iced_lake'           => __( 'Iced Lake' , 'overview' ),
            'amazon_rainforest'   => __( 'Amazon Rainforest' , 'overview' ),
            'chessnuts_field'     => __( 'Chessnuts Field' , 'overview' ),
            'terracotta_road'     => __( 'Terracotta Road' , 'overview' ),
            'japanese_maple_hill' => __( 'Japanese Maple Hill' , 'overview' ),
            'sunset_desert'       => __( 'Sunset Desert' , 'overview' ),
            'orchid_cliff'        => __( 'Orchid Cliff' , 'overview' ),
            'lavander_island'     => __( 'Lavander Island' , 'overview' ),
            'mariana_trench'      => __( 'Mariana Trench' , 'overview' ),
            'countryside_oasis'   => __( 'Countryside Oasis' , 'overview' )
        )
    ) );

    // header image filter opacity
    $wp_customize->add_control( 'overview_header_image_filter', array(
        'type'            => 'range',
        'section'         => 'header_image',
        'priority'        => 1,
        'label'           => __( 'Filter opacity', 'overview' ),
        'description'     => __( 'Note: to enhance contrast with titles, also use the <strong>Site titles background opacity</strong> control, now visible in the section', 'overview' ) . '<a id="overview-customizer-titles-filter-redirect"><em>' . ' ' . __( 'Site Identity', 'overview' ) . '</em></a>.',
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 90,
            'step'  => 1
        ),
        'active_callback' => 'has_header_image'
    ) );

    // site title custom font
    $wp_customize->add_control( 'overview_site_title_custom_font', array(
        'type'        => 'text',
        'priority'    => 45,
        'section'     => 'title_tagline',
        'label'       => __( 'Site Title Google&reg; font', 'overview' ),
        'description' => '<a href="' . esc_url( 'https://fonts.google.com' ) . '" target="_blank">' . __( 'See all available Google fonts', 'overview' ) . '</a><br /><p><strong>' . __( 'Google is a registred trademark and belongs to its owners.', 'overview' ) . '</strong></p><p>' . __( 'OverView\'s default font is ', 'overview' ) . '<a href="' . esc_url( 'https://fonts.google.com/specimen/Muli' ) . '" target="_blank">Muli</a>. '. __( 'Enter the name of the Google font you have picked here:', 'overview' ) .'</p>',
        'input_attrs' => array(
            'id'         => 'overview-site-title-custom-font-text-input',
            'style'      => 'border: 1px solid gray;'
        ),
    ) );
    
    // custom font
    $wp_customize->add_control( 'overview_custom_font', array(
        'type'        => 'text',
        'priority'    => 20,
        'section'     => 'overview_options',
        'label'       => __( 'Google&reg; font', 'overview' ),
        'description' => '<a href="' . esc_url( 'https://fonts.google.com' ) . '" target="_blank">' . __( 'See all available Google fonts', 'overview' ) . '</a><br /><p><strong>' . __( 'Google is a registred trademark and belongs to its owners.', 'overview' ) . '</strong></p><p>' . __( 'OverView\'s default font is ', 'overview' ) . '<a href="' . esc_url( 'https://fonts.google.com/specimen/Muli' ) . '" target="_blank">Muli</a>. '. __( 'Enter the name of the Google font you have picked here:', 'overview' ) .'</p>',
        'input_attrs' => array(
            'id'         => 'overview-custom-font-text-input',
            'style'      => 'border: 1px solid gray;'
        ),
    ) );

    // layout
    $wp_customize->add_control( 'overview_layout', array(
        'type'        => 'radio',
        'priority'    => 10,
        'section'     => 'overview_options',
        'label'       => __( 'Choose layout', 'overview' ),
        'input_attrs' => array(
            'class'      => 'overview-layouts',
            'style'      => 'border: 1px solid gray;'
        ),
        'choices' => array(
            'fixed' => __( 'Fixed' , 'overview' ),
            'full'  => __( 'Full-width' , 'overview' )
        )
    ) );

    // blog layout
    $wp_customize->add_control( 'overview_blog_layout', array(
        'type'        => 'radio',
        'priority'    => 11,
        'section'     => 'overview_options',
        'label'       => __( 'Blog layout', 'overview' ),
        __( 'Note: older browsers may always show a list', 'overview' ),
        'input_attrs' => array(
            'class'      => 'overview-blog-layouts',
            'style'      => 'border: 1px solid gray;'
        ),
        'choices' => array(
            'frames' => __( 'Frames' , 'overview' ),
            'list'  => __( 'List' , 'overview' )
        )
    ) );
    
    // sidebar layout
    $wp_customize->add_control( 'overview_sidebar_layout', array(
        'type'            => 'radio',
        'priority'        => 12,
        'section'         => 'overview_options',
        'label'           => __( 'Sidebar shown on', 'overview' ),
        'description'     => __( 'Note: older browsers may always show the sidebar on the right', 'overview' ),
        'input_attrs'     => array(
            'class'          => 'overview-layouts',
            'style'          => 'border: 1px solid gray;'
        ),
        'choices'         => array(
            'right'          => __( 'Right' , 'overview' ),
            'left'           => __( 'Left' , 'overview' )
        ),
        'active_callback' => 'ov_sidebar_check'
    ) );
    
    // font-size
    $wp_customize->add_control( 'overview_body_font_size', array(
        'type'        => 'select',
        'priority'    => 15,
        'section'     => 'overview_options',
        'label'       => __( 'Main font size', 'overview' ),
        'description' => __( 'Note: some elements need a page refresh', 'overview' ),
        'input_attrs' => array(
            'class'      => 'overview-main-font-size',
            'style'      => 'border: 1px solid gray;'
        ),
        'choices' => array(
            '14px' => __('14 Pixels', 'overview'),
            '15px' => __('15 Pixels', 'overview'),
            '16px' => __('16 Pixels', 'overview'),
            '17px' => __('17 Pixels', 'overview'),
            '18px' => __('18 Pixels', 'overview'),
            '19px' => __('19 Pixels', 'overview'),
            '20px' => __('20 Pixels', 'overview'),
            '21px' => __('21 Pixels', 'overview'),
            '22px' => __('22 Pixels', 'overview'),
            '23px' => __('23 Pixels', 'overview'),
            '24px' => __('24 Pixels', 'overview'),
        )
    ) );

    // 
    $wp_customize->add_control( 'overview_titles_alignment', array(
        'type'            => 'radio',
        'priority'        => 18,
        'section'         => 'overview_options',
        'label'           => __( 'Titles alignment', 'overview' ),
        'input_attrs'     => array(
            'class'          => 'overview-titles-alignment',
            'style'          => 'border: 1px solid gray;'
        ),
        'choices'         => array(
            'inherit'          => __( 'Standard' , 'overview' ),
            'center'           => __( 'Center' , 'overview' )
        )
    ) );

    // footer widgets alignment
    $wp_customize->add_control( 'overview_footer_widgets_alignment', array(
        'type'        => 'select',
        'priority'    => 22,
        'section'     => 'overview_options',
        'label'       => __( 'Footer widgets alignment', 'overview' ),
        'description' => __( 'Note: might not display correctly on older browsers', 'overview' ),
        'input_attrs' => array(
            'class'      => 'overview-footer-widgets-alignment',
            'style'      => 'border: 1px solid gray;'
        ),
        'choices' => array(
            'auto'       => __('Automatic', 'overview'),
            'baseline'   => __('Base line', 'overview'),
            'center'     => __('Center', 'overview'),
            'stretch'    => __('Stretch', 'overview'),
            'flex_start' => __('Widgets start', 'overview'),
            'flex_end'   => __('Widgets end', 'overview')
        ),
        'active_callback' => 'overview_footer_widgets_check'
    ) );

    // WordPress credits
    $wp_customize->add_control( 'overview_wp_credits', array(
        'type'        => 'checkbox',
        'priority'    => 23,
        'section'     => 'overview_options',
        'label'       => __( 'Show your support for WordPress!', 'overview' ),
        'input_attrs' => array(
            'class'       => 'overview-wp-credits-checkbox',
            'style'       => 'border: 1px solid gray;'
        )
    ) );

    // OverView credits
    $wp_customize->add_control( 'overview_ov_credits', array(
        'type'        => 'checkbox',
        'priority'    => 24,
        'section'     => 'overview_options',
        'label'       => __( 'Show your support for OverView!', 'overview' ),
        'input_attrs' => array(
            'class'       => 'overview-ov-credits-checkbox',
            'style'       => 'border: 1px solid gray;'
        )
    ) );

    // OverView site copyright
    $wp_customize->add_control( 'overview_site_copyright', array(
        'type'        => 'checkbox',
        'priority'    => 25,
        'section'     => 'overview_options',
        'label'       => __( 'Show footer copyright', 'overview' ),
        'input_attrs' => array(
            'class'       => 'overview-site-copyright-checkbox',
            'style'       => 'border: 1px solid gray;'
        )
    ) );

    
    // TEMPLATES ONLY CONTROLS
    
    // front page template display title
    $wp_customize->add_control( 'overview_front_page_title', array(
        'type'        => 'textarea',
        'priority'    => 30,
        'section'     => 'overview_options',
        'label'       => __( 'Detected an active "OverView Display" template for this page', 'overview' ),
        'description' => '<strong>' . __('Set the OverView Display\'s options', 'overview') . '</strong><br /><em>' . __( 'This section is only visible on pages with an active "OverView Display" template: you can change templates in the specific page\'s editor.', 'overview' ) . '</em><p>' . __( 'Display\'s title or description:', 'overview' ) . '</p>',
        'input_attrs' => array(
            'class'      => 'overview-front-template-title-text',
            'style'      => 'border: 1px solid gray;'
        ),
        'active_callback' => 'overview_front_page_template_check'
    ) );

    // front page template display background
    $wp_customize->add_control( 'overview_display_bright_background', array(
        'type'        => 'checkbox',
        'priority'    => 40,
        'section'     => 'overview_options',
        'label'       => __( 'Standard background', 'overview' ),
        'input_attrs' => array(
            'class'       => 'overview-front-template-bright-display-checkbox',
            'style'       => 'border: 1px solid gray;'
        ),
        'active_callback' => 'overview_front_page_template_check'
    ) );

    // overview_display_image_rotation
    $wp_customize->add_control( 'overview_display_image_rotation', array(
        'type'        => 'checkbox',
        'priority'    => 50,
        'section'     => 'overview_options',
        'label'       => __( 'Rotate featured images', 'overview' ),
        'description' => '<em>' . __('Note: NO rotation will be applied on smaller devices and effect changes angle at different screen sizes', 'overview') . '</em>',
        'input_attrs' => array(
            'class'       => 'overview-front-template-rotate-img-checkbox',
            'style'       => 'border: 1px solid gray;'
        ),
        'active_callback' => 'overview_front_page_template_check'
    ) );

    // about OverView
    $wp_customize->add_control( 'overview_about', array(
        'type'        => 'range',
        'priority'    => 10,
        'section'     => 'overview_about_section',
        'description' => '_Y_Power',
        'input_attrs' => array(
            'class'       => 'overview-hidden-about-control',
            'style'       => 'display: none;',
            'min'         => 1,
            'max'         => 1,
            'step'        => 1
        )
    ) );
    
    
    /* OverView WordPress customizer PARTIALS */

    /* partials output functions */

    // get branding
    function ov_branding_output(){
        $ov_branding_description =  get_theme_mod( 'overview_site_branding_description', __( 'Use this space to describe your story, mission, branding and more in a longer form', 'overview' ) );
        echo esc_html( $ov_branding_description );
    }

    // get OverView Display title
    function ov_display_title_output(){
        $ov_display_title = get_theme_mod('overview_front_page_title', '');
        echo esc_html( $ov_display_title );
    }
    
    // site branding output
    $wp_customize->selective_refresh->add_partial( 'overview_site_branding_description', array(
        'selector'            => '.site-branding-description-p',
        'container_inclusive' => false,
        'render_callback'     => 'ov_branding_output'
    ) );
    
    // OverView Display template title output
    $wp_customize->selective_refresh->add_partial( 'overview_front_page_title', array(
        'selector'            => '.overview-front-page-title',
        'container_inclusive' => false,
        'render_callback'     => 'ov_display_title_output'
    ) );

    /* default WP core settings */
    $wp_customize->get_setting( 'blogname' )->transport             = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport      = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport     = 'postMessage';
    $wp_customize->get_setting( 'background_image' )->transport     = 'postMessage';
    /* default WP sections */
    $wp_customize->get_section( 'header_image' )->description       = '<em>' . __( 'Once an header image is selected, a "Filter opacity" control will appear just below', 'overview' ) . '.</em>';
    /* default WP core controls */
    $wp_customize->get_control( 'custom_logo' )->description        = __( 'Note: OverView strongly suggests logos with a 16:9 ratio', 'overview' );
    $wp_customize->get_control( 'header_textcolor' )->description   = __( 'Set to \'Default\' to add the site title to the preview when switching color schemes: save and refresh the page to switch default colors', 'overview' );
    $wp_customize->get_control( 'background_color' )->priority      = 20;
    $wp_customize->get_control( 'background_image' )->description   = __( 'Note: OverView will apply a fading effect on all pages when a background image is set', 'overview' );
    
}
add_action( 'customize_register', 'overview_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function overview_customize_preview_js() {
    wp_enqueue_script( 'overview_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'jquery', 'customize-preview' ) );
}
add_action( 'customize_preview_init', 'overview_customize_preview_js' );
