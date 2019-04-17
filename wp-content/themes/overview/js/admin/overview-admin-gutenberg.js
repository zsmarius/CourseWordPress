/*
    Copyright (C) 2017-2018 _Y_Power ( ypower.nouveausiteweb.fr )

    This file is part of the OverView WordPress theme package.

    The JavaScript code in this page is free software: you can
    redistribute it and/or modify it under the terms of the GNU
    General Public License (GNU GPL) as published by the Free Software
    Foundation, either version 2 of the License, or (at your option)
    any later version.  The code is distributed WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS
    FOR A PARTICULAR PURPOSE.  See the GNU GPL for more details.

    As additional permission under GNU GPL version 3 section 7, you
    may distribute non-source (e.g., minimized or compacted) forms of
    that code without the copy of the GNU GPL normally required by
    section 4, provided you include this license notice and a URL
    through which recipients can access the Corresponding Source.
*/

(function(){

    var jQ = jQuery.noConflict();

    jQ(document).ready(function(){

	// gutenberg back editor styles
	var OVActiveSidebarMargin = OVBlockEditorVars.active_sidebar == '1' ? '2000px' : '1600px',
	    OVLayoutProp = OVBlockEditorVars.layout == 'fixed' ? '.editor-writing-flow { max-width: 980px; margin-left: auto; margin-right: auto; padding: 16px 0; } @media screen and (min-width: ' + OVActiveSidebarMargin + '){ .editor-writing-flow { width: 1150px; max-width: 1150px; } } ' : '.editor-writing-flow .editor-block-list__layout { padding-left: 1px; padding-right: 1px; }',
	    OVTitleMargins = OVBlockEditorVars.titles_alignment.trim() == 'inherit' ? '; margin-left: 16px;' : '',
	    OVContentFont = OVBlockEditorVars.font == "" ? 'Muli' : OVBlockEditorVars.font,
	    OVFontProp = 'font-family: "' + OVContentFont + '", sans-serif !important;',
	    OVColorProp = 'color: ' + OVBlockEditorVars.color + ';',
	    OVBackgroundColorProp = 'background-color: #' + OVBlockEditorVars.background_color + ';',
	    OVGutenbergTag = '<style id="overview-block-editor-preview" type="text/css" media="all">' + OVLayoutProp + '*[class*=\'wp-block-\'], *[class^=\'wp-block-\'], *[class*=\'editor-post-\'] *, *[class^=\'editor-post-\'] *, *[class*=\'editor-page-\'] *, *[class^=\'editor-page-\'] *, .edit-post-visual-editor { ' + OVFontProp + ' ' + OVColorProp + ' ' + OVBackgroundColorProp + ' } .edit-post-visual-editor * { ' + OVFontProp + ' } .edit-post-visual-editor p, .edit-post-visual-editor p.wp-block-subhead { font-size: ' + OVBlockEditorVars.font_size + '; ' + OVColorProp + ' } .edit-post-visual-editor .editor-post-title__block, .edit-post-visual-editor .editor-post-title__block textarea { text-align: ' + OVBlockEditorVars.titles_alignment + OVTitleMargins + ' } .wp-block-paragraph { font-size: ' + OVBlockEditorVars.font_size + '; } body.gutenberg-editor-page .editor-block-list__block a { color: ' + OVBlockEditorVars.main_color + ' } blockquote.wp-block-quote cite, blockquote.wp-block-pullquote cite { background-color: ' + shadeColor( OVBlockEditorVars.main_color, 0.7 ) + '; } .editor-block-list__block input[type="button"], .editor-block-list__block input[type="search"], .editor-block-list__block input[type="select"], .editor-block-list__block select, .editor-block-list__block input[type="submit"], .editor-block-list__block input[type="reset"] { background-color: ' + OVBlockEditorVars.main_color + '; } .editor-block-list__block input[type="button"]:hover, .editor-block-list__block input[type="search"]:hover, .editor-block-list__block input[type="select"]:hover, .editor-block-list__block select:hover, .editor-block-list__block input[type="submit"]:hover, .editor-block-list__block input[type="reset"]:hover { color: ' + OVBlockEditorVars.main_color + '; }</style>';
	jQ( 'head' ).append( OVGutenbergTag );

	// shade color
	function shadeColor( color, percent ) {   
	    var f=parseInt(color.slice(1),16),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=f>>16,G=f>>8&0x00FF,B=f&0x0000FF;
	    return "#"+(0x1000000+(Math.round((t-R)*p)+R)*0x10000+(Math.round((t-G)*p)+G)*0x100+(Math.round((t-B)*p)+B)).toString(16).slice(1);
	}

    });
    // ./document ready

})();
