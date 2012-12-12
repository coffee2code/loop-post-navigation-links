=== Loop Post Navigation Links ===
Contributors: coffee2code
Donate link: http://coffee2code.com/donate
Tags: posts, navigation, links, next, previous, portfolio, previous_post_link, next_post_link, coffee2code
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 2.6
Tested up to: 3.5
Stable tag: 2.0
Version: 2.0

Template tags (for use in single.php) to create post navigation loop (previous to first post is last post; next/after last post is first post).


== Description ==

This plugin provides two template tags for use in single.php to create a post navigation loop, whereby previous to the first post is the last post, and after the last post is first post. Basically, when you're on the last post and you click to go to the next post, the link takes you to the first post. Likewise, if you're on the first post and click to go to the previous post, the link takes you to the last post.

The function `c2c_next_or_loop_post_link()` is identical to WordPress's `next_post_link()` in every way except when called on the last post in the navigation sequence, in which case it links back to the first post in the navigation sequence.

The function `c2c_previous_or_loop_post_link()` is identical to WordPress's `previous_post_link()` in every way except when called on the first post in the navigation sequence, in which case it links back to the last post in the navigation sequence.

Useful for providing a looping link of posts, such as for a portfolio, or to continually present pertinent posts for visitors to continue reading.

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/loop-post-navigation-links/) | [Plugin Directory Page](http://wordpress.org/extend/plugins/loop-post-navigation-links/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Unzip `loop-post-navigation-links.zip` inside the `/wp-content/plugins/` directory (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. Use `c2c_next_or_loop_post_link()` template tag instead of `next_post_link()`, and/or `c2c_previous_or_loop_post_link()` template tag instead of `previous_post_link()`, in your single-post template (single.php).


== Template Tags ==

The plugin provides two template tags for use in your single-post theme templates.

= Functions =

* `function c2c_next_or_loop_post_link( $format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '' )`
Like WordPress's `next_post_link()`, this function displays a link to the next chronological post (among all published posts, those in the same category, or those not in certain categories).  Unlink `next_post_link()`, when on the last post in the sequence this function will link back to the first post in the sequence, creating a circular loop.

* `function c2c_previous_or_loop_post_link( $format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '' )`
Like WordPress's `previous_post_link()`, this function displays a link to the previous chronological post (among all published posts, those in the same category, or those not in certain categories).  Unlink `previous_post_link()`, when on the first post in the sequence this function will link to the last post in the sequence, creating a circular loop.

= Arguments =

* `$format`
(optional) A percent-substitution string indicating the format of the entire output string.  Use <code>%link</code> to represent the next/previous post being linked, or <code>%title</code> to represent the title of the next/previous post.

* `$link`
(optional) A percent-substitution string indicating the format of the link itself that gets created for the next/previous post.  Use <code>%link</code> to represent the next/previous post being linked, or <code>%title</code> to represent the title of the next/previous post.

* `$in_same_cat`
(optional) A boolean value (either true or false) indicating if the next/previous post should be in the current post's same category.

* `$excluded_categories`
(optional) A string of category IDs to which posts cannot belong.  Due to goofy a WP convention, the category IDs need to be joined by " and ", i.e. "14 and 15 and 31".


== Examples ==

`<div class="navigation">
	<div class="alignleft"><?php previous_or_loop_post_link(); ?></div>
	<div class="alignright"><?php next_or_loop_post_link(); ?></div>
</div>`


== Filters ==

The plugin is further customizable via four hooks. Typically, this type of customization would be put into your active theme's functions.php file or used by another plugin.

= c2c_previous_or_loop_post_link_output, c2c_next_or_loop_post_link_output (filters) =

The 'c2c_previous_or_loop_post_link_output' and 'c2c_next_or_loop_post_link_output' filters allow you to customize the link markup generated for previous and next looping links, respectively.

Example:

  `<?php
    // Prepend "Prev:" to previous link markup.
    function my_custom_previous_or_loop_link_output( $output, $format, $link, $post ) {
      return 'Prev: ' . $output;
    }
    add_filter( 'c2c_previous_or_loop_post_link_output', 'my_custom_previous_or_loop_link_output', 10, 4 );
  ?>`

= c2c_previous_or_loop_post_link, c2c_next_or_loop_post_link (actions) =

The 'c2c_previous_or_loop_post_link' and 'c2c_next_or_loop_post_link' actions allow you to use an alternative approach to safely invoke `c2c_previous_or_loop_post_link()` and `c2c_previous_or_loop_post_link()`, respectively, in such a way that if the plugin were deactivated or deleted, then your calls to the functions won't cause errors in your site.

Arguments:

* Same as for for `c2c_previous_or_loop_post_link()` and `c2c_next_or_loop_post_link()`

Example:

Instead of:

`<?php echo c2c_previous_or_loop_post_link( '<span class="prev-or-loop-link">&laquo; %link</span>' ); ?>`

Do:

`<?php echo do_action( 'c2c_previous_or_loop_post_link', '<span class="prev-or-loop-link">&laquo; %link</span>' ); ?>`


== Changelog ==

= 2.0 =
* Sync `adjacent_or_loop_post_link()` with most changes made to WP's `adjacent_or_post_link()`
* * Always run output through filters
* * Pass original $format to filters
* * Pass $post to filters
* * Minor code reformatting (spacing)
* * NOTE: arguments to filters have changed
* Rename `next_or_loop_post_link()` to `c2c_next_or_loop_post_link()` (but maintain a deprecated version for backwards compatibility)
* Rename `previous_or_loop_post_link()` to `c2c_previous_or_loop_post_link()` (but maintain a deprecated version for backwards compatibility)
* Rename `adjacent_or_loop_post_link()` to `c2c_adjacent_or_loop_post_link()` (but maintain a deprecated version for backwards compatibility)
* Add filter 'c2c_next_or_loop_post_link' so that users can use the do_action('c2c_next_or_loop_post_link') notation for invoking the function
* Add filter 'c2c_previous_or_loop_post_link' so that users can use the do_action('c2c_previous_or_loop_post_link') notation for invoking the function
* Add filter 'c2c_adjacent_or_loop_post_link' so that users can use the do_action('c2c_adjacent_or_loop_post_link') notation for invoking the function
* Rename filter 'previous_or_loop_post_link' to 'c2c_previous_or_loop_post_link_output' (but maintain old filter for backwards compatibility)
* Rename filter 'next_or_loop_post_link' to 'c2c_next_or_loop_post_link_output' (but maintain old filter for backwards compatibility)
* Add "Filters" section to readme.txt
* Add check to prevent execution of code if file is directly accessed
* Update documentation
* Note compatibility through WP 3.5+
* Update copyright date (2013)

= 1.6.3 =
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Remove ending PHP close tag
* Note compatibility through WP 3.4+

= 1.6.2 =
* Note compatibility through WP 3.3+
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

= 1.6.1 =
* Note compatibility through WP 3.2+
* Update copyright date (2011)
* Minor code formatting (spacing)
* Add plugin homepage and author links to description in readme.txt

= 1.6 =
* Add rel= attribute to links
* Wrap all functions in if(!function_exists()) check
* Check that GLOBALS['post'] is an object before treating it as such
* Minor code tweaks to mirror more recent changes to adjacent_post_link()
* Note compatibility with WP 3.0+
* Minor code reformatting (spacing)
* Add Upgrade Notice section to readme
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Remove trailing whitespace in header docs

= 1.5.1 =
* Add PHPDoc documentation
* Note compatibility with WP 2.9+
* Update copyright date

= 1.5 =
* Added adjacent_or_loop_post_link() and have next_or_loop_post_link() and previous_or_post_link() simply deferring to it for core operation
* Added support for %date in format string (as per WP)
* Added support for 'previous_post_link' and 'next_post_link' filters (as per WP)
* Added support for 'previous_or_loop_post_link' and 'next_or_loop_post_link' filters
* Removed two previously used global variable flags and replaced with one
* Changed description
* Noted compatibility with WP 2.8+
* Dropped support for pre-WP2.6
* Updated copyright date

= 1.0 =
* Initial release


== Upgrade Notice ==

= 2.0 =
Recommended major update: synced with changes made to WP; added filters; changed arguments to existing filters; renamed and deprecated all existing functions and filters; noted compatibility through WP 3.5+; and more. (All your old usage will still work, though)

= 1.6.3 =
Trivial update: noted compatibility through WP 3.4+; explicitly stated license

= 1.6.2 =
Trivial update: noted compatibility through WP 3.3+ and updated copyright date

= 1.6.1 =
Trivial update: noted compatibility through WP 3.2+ and updated copyright date

= 1.6 =
Minor update. Highlights: adds 'rel=' attribute to links; minor tweaks; verified WP 3.0 compatibility.