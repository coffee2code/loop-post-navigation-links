<?php
/**
 * @package Loop_Post_Navigation_Links
 * @author Scott Reilly
 * @version 1.6
 */
/*
Plugin Name: Loop Post Navigation Links
Version: 1.6
Plugin URI: http://coffee2code.com/wp-plugins/loop-post-navigation-links
Author: Scott Reilly
Author URI: http://coffee2code.com
Description: Template tags (for use in single.php) to create post navigation loop (previous to first post is last post; next/after last post is first post).

next_or_loop_post_link() is identical to WordPress's next_post_link() in every way except when called on the last
post in the navigation sequence, in which case it links back to the first post in the navigation sequence.

previous_or_loop_post_link()` is identical to WordPress's `previous_post_link()` in every way except when called on
the first post in the navigation sequence, in which case it links back to the last post in the navigation sequence.

Useful for providing a looping link of posts, such as for a portfolio, or to continually present pertinent posts for
visitors to continue reading.

Compatible with WordPress 2.6+, 2.7+, 2.8+, 2.9+, 3.0+.

=>> Read the accompanying readme.txt file for more information.  Also, visit the plugin's homepage
=>> for more information and the latest updates

Installation:

1. Download the file http://coffee2code.com/wp-plugins/loop-post-navigation-links.zip and unzip it into your
/wp-content/plugins/ directory (or install via the built-in WordPress plugin installer).
2. Activate the plugin through the 'Plugins' admin menu in WordPress
3. Use next_or_loop_post_link() template tag instead of next_post_link(), and/or previous_or_loop_post_link() template tag
instead of previous_post_link(), in your single-post template (single.php).

*/

/*
Copyright (c) 2008-2010 by Scott Reilly (aka coffee2code)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/
$c2c_loop_navigation_find = false;

/**
 * Display next post link that is adjacent to the current post, or if none, then the first post in the series.
 *
 * @param string $format (optional) Link anchor format. Default is '%link &raquo;'.
 * @param string $link (optional) Link permalink format. Default is '%title'.
 * @param bool $in_same_cat (optional) Whether link should be in same category. Default is false.
 * @param string $excluded_categories (optional) Excluded categories IDs. Default is ''.
 * @return void
 */
function next_or_loop_post_link( $format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '' ) {
	adjacent_or_loop_post_link($format, $link, $in_same_cat, $excluded_categories, false);
}

/**
 * Display previous post link that is adjacent to the current post, or if none, then the last post in the series.
 *
 * @param string $format (optional) Link anchor format. Default is '&laquo; %link'.
 * @param string $link (optional) Link permalink format. Default is '%title'.
 * @param bool $in_same_cat (optional) Whether link should be in same category. Default is false.
 * @param string $excluded_categories (optional) Excluded categories IDs. Default is ''.
 * @return void
 */
function previous_or_loop_post_link( $format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '' ) {
	adjacent_or_loop_post_link($format, $link, $in_same_cat, $excluded_categories, true);
}

/**
 * Display adjacent post link or the post link for the post at the opposite end of the series.
 *
 * Can be either next post link or previous.
 *
 * @param string $format Link anchor format.
 * @param string $link Link permalink format.
 * @param bool $in_same_cat (optional) Whether link should be in same category. Default is false.
 * @param string $excluded_categories (optional) Excluded categories IDs. Default is ''.
 * @param bool $previous (optional) Whether to display link to previous post. Default is true.
 * @return void
 */
function adjacent_or_loop_post_link( $format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true ) {
	if ( $previous && is_attachment() && is_object( $GLOBALS['post'] ) )
		$post = & get_post($GLOBALS['post']->post_parent);
	else
		$post = get_adjacent_post($in_same_cat, $excluded_categories, $previous);

	// The only modification of adjacent_post_link() -- get the last/first post if there isn't a legitimate previous/next post
	if ( !$post ) {
		global $c2c_loop_navigation_find;
		$c2c_loop_navigation_find = true;
		$post = get_adjacent_post( $in_same_cat, $excluded_categories, $previous );
		$c2c_loop_navigation_find = false;
	}

	if ( empty( $post ) )
		return;

	$title = $post->post_title;

	if ( empty($post->post_title) )
		$title = $previous ? __('Previous Post') : __('Next Post');

	$title = apply_filters('the_title', $title, $post->ID);
	$date = mysql2date(get_option('date_format'), $post->post_date);
	$rel = $previous ? 'prev' : 'next';

	$string = '<a href="'.get_permalink($post).'" rel="'.$rel.'">';
	$link = str_replace('%title', $title, $link);
	$link = str_replace('%date', $date, $link);
	$link = $string . $link . '</a>';

	$format = str_replace('%link', $link, $format);

	$adjacent = $previous ? 'previous' : 'next';
	echo apply_filters("{$adjacent}_or_loop_post_link", apply_filters("{$adjacent}_post_link", $format, $link), $format, $link);
}

/**
 * Modifies the SQL WHERE clause used by WordPress when getting a previous/next post to accommodate looping navigation.
 *
 * Can be either next post link or previous.
 *
 * @param string $where SQL WHERE clause generated by WordPress
 * @param string $link Link permalink format.
 * @param bool $in_same_cat (optional) Whether link should be in same category. Default is false.
 * @param string $excluded_categories (optional) Excluded categories IDs. Default is ''.
 * @param bool $previous (optional) Whether to display link to previous post. Default is true.
 * @return void
 */
function c2c_modify_nextprevious_post_where( $where ) {
	// The incoming WHERE statement generated by WordPress is a condition for the date, relative to the current
	//	post's date.  To find the post we want, we just need to get rid of that condition (which is the first) and retain the others.
	if ( $GLOBALS['c2c_loop_navigation_find'] )
		$where = preg_replace('/WHERE (.+) AND/imsU', 'WHERE', $where);
	return $where;
}

/*
 * Register actions to filter WHERE clause when previous or next post query is being processed.
 */
add_filter('get_next_post_where', 'c2c_modify_nextprevious_post_where');
add_filter('get_previous_post_where', 'c2c_modify_nextprevious_post_where');

?>