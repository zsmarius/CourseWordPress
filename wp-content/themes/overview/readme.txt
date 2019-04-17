=== OverView ===

Author: _Y_Power
Tags: blog, education, one-column, two-columns, right-sidebar, left-sidebar, flexible-header, custom-background, custom-colors, custom-header, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, full-width-template, rtl-language-support, sticky-post, theme-options, threaded-comments, translation-ready
Requires at least: 4.7
Tested up to: 5.0
Requires PHP: 5.2
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html

OverView, like WordPress, is licensed under the GPL.
GPL is a friend and, if you are not familiar with it, you should really [learn more about it](https://www.gnu.org/licenses/old-licenses/gpl-2.0-faq.html).

OverView is based on the GREAT work of Underscores http://underscores.me/, (C) 2012-2016 Automattic, Inc.
Underscores is distributed under the terms of the GNU GPL v2 or later.

Normalizing styles have been helped along thanks to the fine work of
Nicolas Gallagher and Jonathan Neal http://necolas.github.io/normalize.css/

== Description ==

A minimalist yet colorful Gutenberg ready responsive theme, OverView delivers a one-page browsing experience: all posts can be dynamically shown one by one on the OverView Display -available as page templates- by clicking on simple navigation buttons, helping engagement with your content.

OverView is based on Underscores, powered by the WordPress REST API and features a grid or list blog layout, a page and blog template, an unlimited Google font selection for Site Title and document, many color schemes, several styled widgets, social menus and wide layouts with CSS grid and flex support -including fallbacks for older devices. All free (GNU GPL), because the best things in life are.

All free (GNU GPL), because the best things in life are.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the OverView's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Frequently Asked Questions ==

= How do I set the social icons? =
Create a [WordPress menu](https://codex.wordpress.org/Appearance_Menus_Screen) and add a [custom link](https://codex.wordpress.org/Appearance_Menus_Screen#Custom_Links) for each of your social accounts URL's. Cool fact: you can re-use the menu you created on any WordPress theme that supports social navigation menus.

= How can I activate the OverView Display? =
The Display is available as a WordPress page template, available in the page editor -> Page Attributes.

= I activated the OverView Display: how do I customize it? =
The Display options will be visible in the WordPress Customizer -under the **OverView options** section- when visiting a page with an active OverView Display page template.

= I activated the OverView Display template and it does not show anything/it does not work. Why? =
Some plugin might be blocking the Display: it usually depends on security plugins, blocking the WordPress REST API, on which the Display relies, by default: make sure to check your plugins options allow the WordPress REST API on your website.

= Does OverView support any plugins? =

OverView includes basic support for Gutenberg, Atomic Blocks and for Infinite Scroll in Jetpack.

== Changelog ==

= 2.1.0 - December 7 2018 =
* Fixed posts and pages titles margins
* Updated support for the Block Editor (Gutenberg)

= 2.0.5 - August 15 2018 =
* Fixed Gutenberg editor styles margins with and without active widgets sidebar

= 2.0.4 - August 12 2018 =
* Fixed Blog and Page template Gutenberg margins
* Fixed Gutenberg images wide and full widths
* Fixed Gutenberg galleries margin in pocket layout
* Removed search form from 404 template

= 2.0.3 - August 10 2018 =
* Fixed Gutenberg latest post floatings
* Added complete Gutenberg full width support
* Minor CSS changes

= 2.0.2 - August 8 2018 =
* Fixed several Gutenberg alignments

= 2.0.1 - July 28 2018 =
* Updated broken theme and theme author URLs

= 2.0.0 - July 27 2018 =
* Added Gutenberg support for basic blocks
* New, faster OverView Display
* Several CSS styles improvements

= 1.3.1 - October 14 2017 =
* Fixed OverView Display faulty posts categories and tags

= 1.3.0 - October 13 2017 =
* Added new OverView Blog layout option and page template
* Added Google font option for Site Title
* Added searchform.php and its search icon
* Added reciprocal links to header image filter and site titles background controls in the Customizer
* Several minor CSS improvements

= 1.2.0 - October 1 2017 =
* Fixed site titles padding in mobile view
* Fixed site titles print styles
* Added header image site titles background and relative opacity control

= 1.1.1 - September 29 2017 =
* Fixed site title alignment on header image
* Fixed escaping of special characters for site branding and OverView Display title
* Fixed site titles background color preview
* Corrected a few typos

= 1.1.0 - September 29 2017 =
* Fixed hide/show title and tagline preview
* Added site title on header image
* Added header image filter control
* Set header height at 680px
* Various CSS improvements

= 1.0.16 - September 27 2017 =
* Fixed featured images for pages on mobile devices
* Added footer widgets flex alignment control
* Set document fade-in effect when background image is set

= 1.0.15 - September 26 2017 =
* Fixed support for several Google fonts
* Fixed support for CodePen social icon
* Removed Google font style injection from functions.php file and moved it in header.php as WordPress documentation suggests
* Removed document head custom functions from functions.php and moved them to new ov-head-extra.php file
* Moved several functions from functions.php to extras.php
* Corrected tags list in readme.txt
* Added OverView Display basic caching system
* Improved comments entries CSS

= 1.0.14 - September 22 2017 =
* Fixed social menu depth
* Added social menu howto info in readme.txt

= 1.0.13 - September 20 2017 =
* Fixed content offset on window resize while mobile menu is active
* Added RTL support
* Added Header Text Color control
* Added ARIA support to OverView Display's container
* Added RTL and flexible header tags
* Added non-minified Font Awesome CSS file
* Added images licenses
* Removed old custom header callback function
* Improved Customizer JS for easier use

= 1.0.12 - September 13 2017 =
* Fixed NS Theme Check errors
* Fixed left sidebar layout breakpoints
* Improved default contrasts

= 1.0.11 - September 12 2017 =
* Fixed navbar mobile access with media queries
* Fixed navbar body top margin on resize
* Corrected default menu fallback
* Added left sidebar layout option
* Added credits and site copyright option
* Set background image defaults
* Added CSS flex support to search widget
* Improved galleries
* Various CSS adjustments
* Removed default header image

= 1.0.10 - September 2 2017 =
* Fixed background image / color styles
* Escaped several hard-coded urls
* Improved Customizer experience
* Added body font color option
* Added 'About' section in the Customizer

= 1.0.9 - August 31 2017 =
* Fixed post_class for pages
* Improved back-end TinyMCE preview CSS
* Set a larger main menu toggle break-point (767px)
* Updated .pot file
* Minor CSS adjustments

= 1.0.8 - August 28 2017 =
* Fixed posts classes
* Changed standard feature images CSS
* Added sticky posts styles and tag

= 1.0.7 - August 26 2017 =
* Fixed brand description option HTML
* Fixed "OverView Display below content" template's Customizer options visibility
* Fixed compatibility for a few Google fonts
* Added OverView Display's feature image rotation option
* Several minor CSS adjustments
* Changed screenshot image

= 1.0.6 - August 19 2017 =
* Fixed print media CSS
* Fixed Google fonts copy/paste and name exceptions
* Added correct licences / copyright info

= 1.0.5 - August 13 2017 =
* Fixed social menu CSS
* Included correct .pot file for translations
* Added body font size option

= 1.0.4 - July 28 2017 =
* Fixed menu and logo in mobile-layout and minor CSS changes
* Added Google fonts option and theme starter content
* Increased the amount of social services icons supported

= 1.0.3 - July 26 2017 =
* Prefixed sidebar widgets area
* Added social nav menu support

= 1.0.2 - July 25 2017 =
* Removed (by commenting) OverView Display JS console logs tests

= 1.0.1 - July 24 2017 =
* Removed unnecessary files and folders
* Added new OverView Display page template (after content)

= 1.0.0 - July 19 2017 =
* Initial release

== Credits ==

* Based on Underscores http://underscores.me/, (C) 2012-2016 Automattic, Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)
* normalize.css http://necolas.github.io/normalize.css/, (C) 2012-2016 Nicolas Gallagher and Jonathan Neal, [MIT](http://opensource.org/licenses/MIT)
* Font Awesome by Dave Gandy http://fontawesome.io [SIL Open Font License - OFL](http://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&id=OFL)
* Picture: Boat Barco Texture - Public domain via http://www.burningwell.org/gallery2/main.php?g2_view=dynamicalbum.UpdatesAlbum&g2_itemId=25774
* Picture: canola2 - Public domain via https://github.com/WPTRT/theme-unit-test
