<?php
/**
 * Plugin Name: Loop Post Navigation Links
 * Version:     3.0
 * Plugin URI:  http://coffee2code.com/wp-plugins/loop-post-navigation-links/
 * Author:      Scott Reilly
 * Author URI:  http://coffee2code.com/
 * Text Domain: loop-post-navigation-links
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Template tags (for single.php) to create post navigation loop (previous to first post is last post; next/after last post is first post).
 *
 * Compatible with WordPress 4.9 through 5.3.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Also, visit the plugin's homepage for additional information and updates.
 * =>> Or visit: https://wordpress.org/plugins/loop-post-navigation-links/
 *
 * @package Loop_Post_Navigation_Links
 * @author  Scott Reilly
 * @version 3.0
 */

/*
	Copyright (c) 2008-2020 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'c2c_LoopPostNavigationLinks' ) ) :

class c2c_LoopPostNavigationLinks {

	/**
	 * Flag to indicate if loop navigation is currently enanbled.
	 *
	 * @since 2.6
	 * @var bool
	 */
	public static $loop_navigation_find = false;

	/**
	 * Returns version of the plugin.
	 *
	 * @since 2.6
	 */
	public static function version() {
		return '3.0';
	}

	/**
	 * Class constructor: initializes class variables and adds actions and filters.
	 *
	 * @since 2.6
	 */
	public static function init() {
		// Load plugin textdomain.
		load_plugin_textdomain( 'loop-post-navigation-links' );

		/*
		 * Register actions to filter WHERE clause when previous or next post query is being processed.
		 */
		add_filter( 'get_next_post_where',     array( __CLASS__, 'modify_nextprevious_post_where' ) );
		add_filter( 'get_previous_post_where', array( __CLASS__, 'modify_nextprevious_post_where' ) );
	}

	/**
	 * Modifies the SQL WHERE clause used by WordPress when getting a previous/next post to accommodate looping navigation.
	 *
	 * Can be either next post link or previous.
	 *
	 * @param string $where SQL WHERE clause generated by WordPress
	 */
	public static function modify_nextprevious_post_where( $where ) {
		// The incoming WHERE statement generated by WordPress is a condition for the
		// date, relative to the current post's date. To find the post we want, we
		// just need to get rid of that condition (which is the first) and retain the
		// others.
		if ( self::$loop_navigation_find ) {
			$where = preg_replace( '/WHERE (.+) AND/imsU', 'WHERE', $where );
		}

		return $where;
	}

} // end c2c_LoopPostNavigationLinks

add_action( 'plugins_loaded', array( 'c2c_LoopPostNavigationLinks', 'init' ) );

endif; // end if !class_exists()



/*
 *
 * TEMPLATE FUNCTIONS
 *
 */


if ( ! function_exists( 'c2c_get_next_or_loop_post_link' ) ) :
/**
 * Gets next post link that is adjacent to the current post, or if none, then
 * the first post in the series.
 *
 * @since 2.5
 *
 * @param string       $format         Optional. Link anchor format. Default is '%link &raquo;'.
 * @param string       $link           Optional. Link permalink format. Default is '%title'.
 * @param bool         $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param string       $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 */
function c2c_get_next_or_loop_post_link( $format='%link &raquo;', $link='%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ) {
	return c2c_get_adjacent_or_loop_post_link( $format, $link, $in_same_term, $excluded_terms, false, $taxonomy );
}
add_action( 'c2c_get_next_or_loop_post_link', 'c2c_get_next_or_loop_post_link', 10, 5 );
endif;


if ( ! function_exists( 'c2c_next_or_loop_post_link' ) ) :
/**
 * Displays next post link that is adjacent to the current post, or if none, then
 * the first post in the series.
 *
 * @since 2.0
 *
 * @param string       $format         Optional. Link anchor format. Default is '%link &raquo;'.
 * @param string       $link           Optional. Link permalink format. Default is '%title'.
 * @param bool         $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param string       $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 */
function c2c_next_or_loop_post_link( $format='%link &raquo;', $link='%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ) {
	c2c_adjacent_or_loop_post_link( $format, $link, $in_same_term, $excluded_terms, false, $taxonomy );
}
add_action( 'c2c_next_or_loop_post_link', 'c2c_next_or_loop_post_link', 10, 5 );
endif;


if ( ! function_exists( 'c2c_get_previous_or_loop_post_link' ) ) :
/**
 * Gets previous post link that is adjacent to the current post, or if none,
 * then the last post in the series.
 *
 * @since 2.5
 *
 * @param string       $format         Optional. Link anchor format. Default is '&laquo; %link'.
 * @param string       $link           Optional. Link permalink format. Default is '%title'.
 * @param bool         $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param string       $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 */
function c2c_get_previous_or_loop_post_link( $format='&laquo; %link', $link='%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ) {
	return c2c_get_adjacent_or_loop_post_link( $format, $link, $in_same_term, $excluded_terms, true, $taxonomy );
}
add_action( 'c2c_previous_or_loop_post_link', 'c2c_previous_or_loop_post_link', 10, 5 );
endif;


if ( ! function_exists( 'c2c_previous_or_loop_post_link' ) ) :
/**
 * Display previous post link that is adjacent to the current post, or if none,
 * then the last post in the series.
 *
 * @since 2.0
 *
 * @param string       $format         Optional. Link anchor format. Default is '&laquo; %link'.
 * @param string       $link           Optional. Link permalink format. Default is '%title'.
 * @param bool         $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param string       $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 */
function c2c_previous_or_loop_post_link( $format='&laquo; %link', $link='%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ) {
	c2c_adjacent_or_loop_post_link( $format, $link, $in_same_term, $excluded_terms, true, $taxonomy );
}
add_action( 'c2c_previous_or_loop_post_link', 'c2c_previous_or_loop_post_link', 10, 5 );
endif;


if ( ! function_exists( 'c2c_get_adjacent_or_loop_post_link' ) ) :
/**
 * Gets adjacent post link or the post link for the post at the opposite end of the series.
 *
 * Can be either next post link or previous.
 *
 * @since 2.5
 *
 * @param string       $format         Link anchor format.
 * @param string       $link           Link permalink format.
 * @param bool         $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param bool         $previous       Optional. Display link to previous post? Default is true.
 * @param string       $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 */
function c2c_get_adjacent_or_loop_post_link( $format, $link, $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' ) {
	$post = c2c_get_adjacent_or_loop_post( $in_same_term, $excluded_terms, $previous, $taxonomy );

	// Most of what follows was lifted from `get_adjacent_post_link()` (except
	// for passing `$output` through a couple additional filters).

	if ( ! $post ) {
		$output = '';
	} else {
		$title = $post->post_title;

		if ( empty( $post->post_title ) ) {
			$title = $previous ? __( 'Previous Post' ) : __( 'Next Post' );
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $title, $post->ID );

		$date = mysql2date( get_option( 'date_format' ), $post->post_date );
		$rel = $previous ? 'prev' : 'next';

		$string = '<a href="' . get_permalink( $post ) . '" rel="' . $rel . '">';
		$inlink = str_replace( '%title', $title, $link );
		$inlink = str_replace( '%date', $date, $inlink );
		$inlink = $string . $inlink . '</a>';

		$output = str_replace( '%link', $inlink, $format );
	}

	$adjacent = $previous ? 'previous' : 'next';

	/** This filter is documented in wp-includes/link-template.php */
	$output = apply_filters( "{$adjacent}_post_link", $output, $format, $link, $post, $adjacent );

	/**
	 * Filters the adjacent post link.
	 *
	 * The dynamic portion of the hook name, `$adjacent`, refers to the type
	 * of adjacency, 'next' or 'previous'.
	 *
	 * Equivalent to WP's '{$adjacent}_post_link' filter.
	 *
	 * @since 1.5
	 * @since 3.0 Added the `$adjacent` parameter.
	 * @deprecated 2.0 Use 'c2c_{$adjacent}_or_loop_post_link_get'
	 *
	 * @param string  $output   The adjacent post link.
	 * @param string  $format   Link anchor format.
	 * @param string  $link     Link permalink format.
	 * @param WP_Post $post     The adjacent post.
	 * @param string  $adjacent Whether the post is previous or next.
	 */
	$output = apply_filters_deprecated( "{$adjacent}_or_loop_post_link", array( $output, $format, $link, $post, $adjacent ), '2.0', "c2c_{$adjacent}_or_loop_post_link_get" );

	/**
	 * Filters the adjacent post link.
	 *
	 * The dynamic portion of the hook name, `$adjacent`, refers to the type
	 * of adjacency, 'next' or 'previous'.
	 *
	 * Similar to WP's '{$adjacent}_post_link' filter.
	 *
	 * @since 2.5
	 * @since 3.0 Added the `$adjacent` parameter.
	 *
	 * @param string       $output         The adjacent post link.
	 * @param string       $format         Link anchor format.
	 * @param string       $link           Link permalink format.
	 * @param WP_Post      $post           The adjacent post.
	 * @param bool         $in_same_term   Whether link should be in a same taxonomy term. Default is false.
	 * @param array|string $excluded_terms Array or comma-separated list of excluded term IDs. Default is ''.
	 * @param bool         $previous       Whether to display link to previous or next post. Default is true.
	 * @param string       $taxonomy       Taxonomy, if $in_same_term is true. Default 'category'.
	 * @param string       $adjacent       Whether the post is previous or next.
	 */
	return apply_filters( "c2c_{$adjacent}_or_loop_post_link_get", $output, $format, $link, $post, $in_same_term, $excluded_terms, $taxonomy, $adjacent );
}
add_action( 'c2c_get_adjacent_or_loop_post_link', 'c2c_get_adjacent_or_loop_post_link', 10, 6 );
endif;


if ( ! function_exists( 'c2c_adjacent_or_loop_post_link' ) ) :
/**
 * Displays adjacent post link or the post link for the post at the opposite end of the series.
 *
 * Can be either next post link or previous.
 *
 * @param string       $format         Link anchor format.
 * @param string       $link           Link permalink format.
 * @param bool         $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param bool         $previous       Optional. Whether to display link to previous or next post. Default is true.
 * @param string       $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 */
function c2c_adjacent_or_loop_post_link( $format, $link, $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' ) {
	$adjacent = $previous ? 'previous' : 'next';

	/**
	 * Filters the adjacent post link or the post link for the post at the
	 * opposite end of the series.
	 *
	 * @since 2.0
	 * @since 3.0 Added the `$adjacent` parameter and removed `$post` parameter.
	 *
	 * @param string       $format         Link anchor format.
	 * @param string       $link           Link permalink format.
	 * @param bool         $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
	 * @param array|string $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
	 * @param bool         $previous       Optional. Whether to display link to previous or next post. Default is true.
	 * @param string       $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
	 * @param string       $adjacent       Whether the post is previous or next.
	 */
	echo apply_filters(
		"c2c_{$adjacent}_or_loop_post_link_output",
		c2c_get_adjacent_or_loop_post_link( $format, $link, $in_same_term, $excluded_terms, $previous, $taxonomy ),
		$format,
		$link,
		$in_same_term,
		$excluded_terms,
		$previous,
		$taxonomy,
		$adjacent
	);
}
add_action( 'c2c_adjacent_or_loop_post_link', 'c2c_adjacent_or_loop_post_link', 10, 6 );
endif;

if ( ! function_exists( 'c2c_get_adjacent_or_loop_post' ) ) :
/**
 * Returns adjacent post or the post at the opposite end of the series.
 *
 * Can be either next post or previous post.
 *
 * @since 2.6
 *
 * @param bool          $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string  $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param bool          $previous       Optional. Whether to display link to previous or next post. Default is true.
 * @param string        $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 *
 * @return WP_Post|null The post, or null if the post loops back to itself.
 */
function c2c_get_adjacent_or_loop_post( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' ) {
	if ( $previous && is_attachment() ) {
		$post = get_post( get_post()->post_parent );
	} else {
		$post = get_adjacent_post( $in_same_term, $excluded_terms, $previous, $taxonomy );
	}

	if ( ! $post ) {
		c2c_LoopPostNavigationLinks::$loop_navigation_find = true;
		$post = get_adjacent_post( $in_same_term, $excluded_terms, $previous, $taxonomy );
		c2c_LoopPostNavigationLinks::$loop_navigation_find = false;
		// Don't loop to itself.
		if ( $post == get_post() ) {
			$post = null;
		}
	}

	return $post;
}
add_action( 'c2c_get_adjacent_or_loop_post', 'c2c_get_adjacent_or_loop_post', 10, 4 );
endif;

if ( ! function_exists( 'c2c_get_next_or_loop_post' ) ) :
/**
 * Returns next post or the post at the beginning of the series.
 *
 * @since 2.6
 *
 * @param bool          $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string  $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param string        $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 *
 * @return WP_Post|null The post, or null if the post loops back to itself.
 */
function c2c_get_next_or_loop_post( $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ) {
	return c2c_get_adjacent_or_loop_post( $in_same_term, $excluded_terms, false, $taxonomy );
}
add_action( 'c2c_get_next_or_loop_post', 'c2c_get_next_or_loop_post', 10, 3 );
endif;

if ( ! function_exists( 'c2c_get_previous_or_loop_post' ) ) :
/**
 * Returns previous post or the post at the end of the series.
 *
 * @since 2.6
 *
 * @param bool          $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string  $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param string        $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 *
 * @return WP_Post|null The post, or null if the post loops back to itself.
 */
function c2c_get_previous_or_loop_post( $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ) {
	return c2c_get_adjacent_or_loop_post( $in_same_term, $excluded_terms, true, $taxonomy );
}
add_action( 'c2c_get_previous_or_loop_post', 'c2c_get_previous_or_loop_post', 10, 3 );
endif;

if ( ! function_exists( 'c2c_get_next_or_loop_post_url' ) ) :
/**
 * Returns the URL for the next post or the post at the beginning of the series.
 *
 * @since 3.0
 *
 * @param bool          $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string  $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param string        $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 *
 * @return WP_Post|null The post, or null if the post loops back to itself.
 */
function c2c_get_next_or_loop_post_url( $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ) {
	$url = '';
	$post = c2c_get_adjacent_or_loop_post( $in_same_term, $excluded_terms, false, $taxonomy );
	if ( $post ) {
		$url = get_permalink( $post );
	}
	return $url;
}
endif;

if ( ! function_exists( 'c2c_get_previous_or_loop_post_url' ) ) :
/**
 * Returns the URL for the previous post or the post at the end of the series.
 *
 * @since 3.0
 *
 * @param bool          $in_same_term   Optional. Whether link should be in a same taxonomy term. Default is false.
 * @param array|string  $excluded_terms Optional. Array or comma-separated list of excluded term IDs. Default is ''.
 * @param string        $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 *
 * @return WP_Post|null The post, or null if the post loops back to itself.
 */
function c2c_get_previous_or_loop_post_url( $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ) {
	$url = '';
	$post = c2c_get_adjacent_or_loop_post( $in_same_term, $excluded_terms, true, $taxonomy );
	if ( $post ) {
		$url = get_permalink( $post );
	}
	return $url;
}
endif;


/*****
 * DEPRECATED FUNCTIONS
 *****/

if ( ! function_exists( 'next_or_loop_post_link' ) ) :
	/**
	 * Display next post link that is adjacent to the current post, or if none,
	 * then the first post in the series.
	 *
	 * @since 1.0
	 * @deprecated 2.0 Use c2c_next_or_loop_post_link() instead
	 */
	function next_or_loop_post_link( $format='%link &raquo;', $link='%title', $in_same_term = false, $excluded_terms = '' ) {
		_deprecated_function( 'next_or_loop_post_link', '2.0', 'c2c_next_or_loop_post_link' );
		return c2c_next_or_loop_post_link( $format, $link, $in_same_term, $excluded_terms );
	}
endif;

if ( ! function_exists( 'previous_or_loop_post_link' ) ) :
	/**
	 * Display previous post link that is adjacent to the current post, or if
	 * none, then the last post in the series.
	 *
	 * @since 1.0
	 * @deprecated 2.0 Use c2c_previous_or_loop_post_link() instead
	 */
	function previous_or_loop_post_link( $format='&laquo; %link', $link='%title', $in_same_term = false, $excluded_terms = '' ) {
		_deprecated_function( 'previous_or_loop_post_link', '2.0', 'c2c_previous_or_loop_post_link' );
		return c2c_previous_or_loop_post_link( $format, $link, $in_same_term, $excluded_terms );
	}
endif;

if ( ! function_exists( 'adjacent_or_loop_post_link' ) ) :
	/**
	 * Display previous post link that is adjacent to the current post, or if
	 * none, then the last post in the series.
	 *
	 * @since 1.0
	 * @deprecated 2.0 Use c2c_adjacent_or_loop_post_link() instead
	 */
	function adjacent_or_loop_post_link( $format, $link, $in_same_term = false, $excluded_terms = '', $previous = true ) {
		_deprecated_function( 'adjacent_or_loop_post_link', '2.0', 'c2c_adjacent_or_loop_post_link' );
		return c2c_adjacent_or_loop_post_link( $format, $link, $in_same_term, $excluded_terms, $previous );
	}
endif;
