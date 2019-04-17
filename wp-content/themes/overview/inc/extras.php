<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package OverView
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function overview_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
	$classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
	$classes[] = 'hfeed';
    }

    return $classes;
}
add_filter( 'body_class', 'overview_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function overview_pingback_header() {
    if ( is_singular() && pings_open() ) {
	echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'overview_pingback_header' );

/**
 * Assign icons to social menu links.
 */
function overview_social_nav_menu_icons( $item_output, $item, $depth, $args ) {
    /**
     * Define social icons.
     */
    $overview_social_icons_set = array(
        '@'                  => 'at',
        'facebook.com'       => 'facebook-square',
        'github.com'         => 'github-square',
        'last.fm'            => 'lastfm-square',
        'linkedin.com'       => 'linkedin-square',
        'ok.ru'              => 'odnoklassniki-square',
        'plus.google'        => 'google-plus-square',
        'pinterest.com'      => 'pinterest-square',
        'reddit.com'         => 'reddit-square',
        'steam.com'          => 'steam-square',
        'tumblr.com'         => 'tumblr-square',
        'twitter.com'        => 'twitter-square',
        'xing.com'           => 'xing-square',
        'youtube.com'        => 'youtube-square',
        'amazon.com'         => 'amazon',
        'bandcamp.com'       => 'bandcamp',
        'codepen.io'         => 'codepen',
        'deviantart.com'     => 'deviantart',
        'digg.com'           => 'digg',
        'dribble.com'        => 'dribble',
        'etsy.com'           => 'etsy',
        'forumbee.com'       => 'forumbee',
        'foursquare.com'     => 'foursquare',
        'freecodecamp.com'   => 'free-code-camp',
        'flickr.com'         => 'flickr',
        'instagram.com'      => 'instagram',
        'paypal.com'         => 'paypal',
        'producthunt.com'    => 'producthunt',
        'quora.com'          => 'quora',
        'ravelry.com'        => 'ravelry',
        'renren.com'         => 'renren',
        'scribd.com'         => 'scribd',
        'sellsy.com'         => 'sellsy',
        'slack.com'          => 'slack',
        'soundcloud.com'     => 'soundcloud',
        'skype.com'          => 'skype',
        'snapchat.com'       => 'snapchat',
        'spotify.com'        => 'spotify',
        'stackexchange.com'  => 'stack-exchange',
        'stackoverflow.com'  => 'stackoverflow',
        'stumbleupon.com'    => 'stumbleupon-circle',
        'telegram.com'       => 'telegram',
        'trello.com'         => 'trello',
        'tripadvisor.com'    => 'tripadvisor',
        'twitch.com'         => 'twitch',
        'vk.com'             => 'vk',
        'viadeo.com'         => 'viadeo',
        'vimeo.com'          => 'vimeo',
        'vine.com'           => 'vine',
        'wechat.com'         => 'wechat',
        'weibo.com'          => 'weibo',
        'weixin.com'         => 'weixin',
        'whatsapp.com'       => 'whatsapp',
        'wordpress'          => 'wordpress',
        'wpbeginner.com'     => 'wpbeginner',
        'wpexplorer.com'     => 'wpexplorer',
        'yahoo'              => 'yahoo',
        'yelp.com'           => 'yelp'
    );
    // check and setup menu
    if ( 'ov-social-menu-1' === $args->theme_location ) {
        // check service url and output the relevant icon
        foreach ( $overview_social_icons_set as $ov_social_link_attr => $ov_social_attr_value ) {
            if ( false !== strpos( $item_output, $ov_social_link_attr ) ) {
                $item_output = str_replace( $args->link_after, '<div class="overview-social-nav-icon"><i class="fa fa-3x fa-' . esc_attr( $ov_social_attr_value ) . '"></i></div>', $item_output  );
            }
        }        
    }
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'overview_social_nav_menu_icons', 10, 4 );


/* 
 * OverView custom font name
 */
function overview_get_custom_font_name( $overview_font_name, $overview_pretty_print_check ){
    $overview_font_name = trim( $overview_font_name );
    $overview_font_name = explode( " ", strtolower( $overview_font_name ) );
    // for each word in the font name
    for ( $wi = 0; $wi < count( $overview_font_name ); $wi++ ){
        // fonts exceptions
        if ( strlen( $overview_font_name[$wi] ) <= 2 ){
            // one-letter exceptions list
            if ( 'a' === $overview_font_name[$wi] ){
                // exceptions list
                if ( 'Dawning' === $overview_font_name[$wi - 2] &&
                     'of' === $overview_font_name[$wi - 1]
                ){
                    $overview_font_name[$wi] = 'a';
                }
                // default
                else {
                    $overview_font_name[$wi] = 'A';
                }
            }
            // two-letters exceptions list
            else if ( 'de' === $overview_font_name[$wi] ){
                // exceptions list
                if ( 'Mr' === $overview_font_name[$wi - 1] ){
                    $overview_font_name[$wi] = 'De';
                }
                // default
                else {
                    $overview_font_name[$wi] = 'DE';
                }
            }
            else if ( 'do' === $overview_font_name[$wi] ){
                $overview_font_name[$wi] = 'Do';
            }
            else if ( 'by' === $overview_font_name[$wi] ){
                // exceptions list
                if ( 'Loved' === $overview_font_name[$wi - 1] ){
                    $overview_font_name[$wi] = 'by';
                }
                // default
                else {
                    $overview_font_name[$wi] = 'By';
                }
            }
            else if ( 'if' === $overview_font_name[$wi] ){
                $overview_font_name[$wi] = 'If';
            }
            else if ( 'of' === $overview_font_name[$wi] ){
                // exceptions list
                if ( 'Dawning' === $overview_font_name[$wi - 1] &&
                     'a' === $overview_font_name[$wi + 1]
                ){
                    $overview_font_name[$wi] = 'of';
                }
                else if ( 'Mountains' === $overview_font_name[$wi - 1] &&
                          'christmas' === $overview_font_name[$wi + 1]
                ){
                    $overview_font_name[$wi] = 'of';
                }
                // default
                else {
                    $overview_font_name[$wi] = 'OF';
                }
            }
            else if ( '2p' === $overview_font_name[$wi] ){
                $overview_font_name[$wi] = '2P';
            }
            else if ( 'me' === $overview_font_name[$wi] ){
                // exceptions list
                if ( 'Just' === $overview_font_name[$wi - 1] &&
                     'again' === $overview_font_name[$wi + 1]
                ){
                    $overview_font_name[$wi] = 'Me';
                }
                else if ( 'Text' === $overview_font_name[$wi - 1] &&
                          'one' === $overview_font_name[$wi + 1] ){
                    $overview_font_name[$wi] = 'Me';
                }
                // default
                else {
                    $overview_font_name[$wi] = 'ME';
                }
            }
            else if ( 'mr' === $overview_font_name[$wi] ){
                $overview_font_name[$wi] = 'Mr';
            }
            else if ( 'ya' === $overview_font_name[$wi] && 'like' === $overview_font_name[$wi + 1] ){
                $overview_font_name[$wi] = 'Ya';
            }
            // default one/two letters exception
            else {
                $overview_font_name[$wi] = strtoupper( $overview_font_name[$wi] );
            }
        }
        // int exceptions
        else if ( $overview_font_name[$wi][0] === intval( $overview_font_name[$wi][0] ) ) {
            $overview_font_name[$wi] = $overview_font_name[$wi];
        }
        // ad-hoc exceptions
        else if ( 'abeezee' === $overview_font_name[$wi] ){
            $overview_font_name[$wi] = 'ABeeZee';
        }
        else if ( 'benchnine' === $overview_font_name[$wi] ){
            $overview_font_name[$wi] = 'BenchNine';
        }
        else if ( 'biorhyme' === $overview_font_name[$wi] ){
            $overview_font_name[$wi] = 'BioRhyme';
        }
        else if ( 'medievalsharp' === $overview_font_name[$wi] ){
            $overview_font_name[$wi] = 'MedievalSharp';
        }
        else if ( $overview_font_name[$wi] === 'unifrakturcook' ){
            $overview_font_name[$wi] = 'UnifrakturCook';
        }
        else if ( $overview_font_name[$wi] === 'unifrakturmaguntia' ){
            $overview_font_name[$wi] = 'UnifrakturMaguntia';
        }
        else if ( $overview_font_name[$wi] === 'vt323' ){
            $overview_font_name[$wi] = 'VT323';
        }
        // if word lenght is => 3
        else {
            // three-letters exceptions
            if ( $overview_font_name[$wi] === 'the' ){
                // exceptions list
                if ( 0 === $wi &&
                     'girl' === $overview_font_name[$wi + 1] ){
                    $overview_font_name[$wi] = 'The';
                }
                // default
                else {
                    $overview_font_name[$wi] = 'the';
                }
            }
            else if ( $overview_font_name[$wi] === 'for' ){
                // exceptions list
                if ( 'Waiting' === $overview_font_name[$wi - 1] &&
                     'sunrise' === $overview_font_name[$wi + 2] ){
                    $overview_font_name[$wi] = 'for';
                }
                // default
                else {
                    $overview_font_name[$wi] = 'For';
                }
            }
            else if ( $overview_font_name[$wi] === 'ntr' ){
                $overview_font_name[$wi] = 'NTR';
            }
            else if ( $overview_font_name[$wi] === 'gfs' ){
                $overview_font_name[$wi] = 'GFS';
            }
            // default font word output
            else {
                $overview_font_name[$wi] = strtoupper( mb_substr( $overview_font_name[$wi], 0, 1 ) ) . mb_substr( $overview_font_name[$wi], 1 );
            }
        }
    }
    // return desired output
    if ( 'pretty' === $overview_pretty_print_check ){
        return implode( " ", $overview_font_name );
    }
    else {
        return implode( "+", $overview_font_name );
    }
}


/*
 * Check site title color for OverView color schemes default values
 */
function overview_custom_site_title_color_check(){
    /* OverView color schemes defaults */
    $overview_colors_schemes_title_hex_defaults = array(
        'iced_lake'           => '2369f2',
        'amazon_rainforest'   => '467658',
        'chessnuts_field'     => '817658',
        'terracotta_road'     => 'ad763c',
        'japanese_maple_hill' => 'bf3a3f',
        'sunset_desert'       => 'c3765e',
        'orchid_cliff'        => 'b676b0',
        'lavander_island'     => '8776bd',
        'mariana_trench'      => '455283',
        'countryside_oasis'   => '4f6124'
    );
    $ov_default_site_color = overview_get_site_title_color();
    $ov_site_title_color = get_theme_mod( 'header_textcolor', $ov_default_site_color );
    // check if color is scheme default
    $ov_site_title_color_default_check = false;
    // for all the color schemes
    foreach ( $overview_colors_schemes_title_hex_defaults as $ov_color_scheme => $ov_color_default ){
        // if a default color is found
        if ( $ov_color_default === $ov_site_title_color ){
            $ov_site_title_color_default_check = true;
        }
    }
    return $ov_site_title_color_default_check;
}

/*
 * Get site title custom color from OverView color scheme
 */
function overview_get_site_title_color(){
    $ov_chosen_color_scheme = get_theme_mod( 'overview_colors_theme', 'iced_lake' );
    switch ( $ov_chosen_color_scheme ) {
        case 'iced_lake':
            return '2369f2';
            break;
        case 'amazon_rainforest':
            return '467658';
            break;
        case 'chessnuts_field':
            return '817658';
            break;
        case 'terracotta_road':
            return 'ad763c';
            break;
        case 'terracotta_road':
            return 'ad763c';
            break;
        case 'japanese_maple_hill';
            return 'bf3a3f';
            break;
        case 'sunset_desert':
            return 'c3765e';
            break;
        case 'orchid_cliff':
            return 'b676b0';
            break;
        case 'lavander_island':
            return '8776bd';
            break;
        case 'mariana_trench':
            return '455283';
            break;
        case 'countryside_oasis':
            return '4f6124';
            break;
        default:
            return '2369f2';
    }
}

/*
 * OverView site copyright
 */
function overview_site_copyright(){
    $overview_copyright_years = ( mysql2date( 'Y', get_user_option('user_registered', 1 ) ) === date( 'Y' ) ) ? esc_attr( date( 'Y' ) ) : esc_attr( mysql2date( 'Y', get_user_option('user_registered', 1 ) ) ) . ' - ' . esc_attr( date( 'Y' ) );
    $overview_copyright_notice = ' ' . bloginfo( 'name' ) . $overview_copyright_years;
    echo esc_attr( $overview_copyright_notice );
}
