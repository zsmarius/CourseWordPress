<?php
$overview_search_form_markup = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >
<label for="s">
<span class="screen-reader-text">' . esc_attr__( 'Search for...', 'overview' ) . '</span><input class="search-field"  placeholder="' . esc_attr__( 'Search for...', 'overview' ) . '" value="' . get_search_query() . '" name="s" type="search">
</label>
<input class="search-submit" value="&#xf002;" type="submit">
</form>';
echo $overview_search_form_markup;
