=== Loop Post Navigation Links ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: posts, navigation, links, next, previous, portfolio, previous_post_link, next_post_link, coffee2code
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 3.6
Tested up to: 4.4
Stable tag: 2.6.1

Template tags (for use in single.php) to create post navigation loop (previous to first post is last post; next/after last post is first post).


== Description ==

This plugin provides two template tags for use in single.php to create a post navigation loop, whereby previous to the first post is the last post, and after the last post is first post. Basically, when you're on the last post and you click to go to the next post, the link takes you to the first post. Likewise, if you're on the first post and click to go to the previous post, the link takes you to the last post.

The function `c2c_next_or_loop_post_link()` is identical to WordPress's `next_post_link()` in every way except when called on the last post in the navigation sequence, in which case it links back to the first post in the navigation sequence.

The function `c2c_previous_or_loop_post_link()` is identical to WordPress's `previous_post_link()` in every way except when called on the first post in the navigation sequence, in which case it links back to the last post in the navigation sequence.

Useful for providing a looping link of posts, such as for a portfolio, or to continually present pertinent posts for visitors to continue reading.

If you are interested in getting the post itself and not just a link to the post, you can use the `c2c_get_next_or_loop_post()` and `c2c_get_previous_or_loop_post()` functions.

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/loop-post-navigation-links/) | [Plugin Directory Page](https://wordpress.org/plugins/loop-post-navigation-links/) | [GitHub](https://github.com/coffee2code/loop-post-navigation-links/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Install via the built-in WordPress plugin installer. Or install the plugin code inside the plugins directory for your site (typically `wp-content/plugins/`).
2. Activate the plugin through the 'Plugins' admin menu in WordPress.
3. Use `c2c_next_or_loop_post_link()` template tag instead of `next_post_link()`, and/or `c2c_previous_or_loop_post_link()` template tag instead of `previous_post_link()`, in your single-post template (e.g. single.php).


== Template Tags ==

The plugin provides four template tags for use in your single-post theme templates.

= Functions =

* `function c2c_next_or_loop_post_link( $format='%link &raquo;', $link='%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' )`
Like WordPress's `next_post_link()`, this function displays a link to the next chronological post (among all published posts, those in the same category, or those not in certain categories). Unlink `next_post_link()`, when on the last post in the sequence this function will link back to the first post in the sequence, creating a circular loop.

* `function c2c_get_next_or_loop_post_link( $format='%link &raquo;', $link='%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' )`
Like `c2c_next_or_loop_post_link(), but returns the value without echoing it.

* `function c2c_previous_or_loop_post_link( $format='&laquo; %link', $link='%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' )`
Like WordPress's `previous_post_link()`, this function displays a link to the previous chronological post (among all published posts, those in the same category, or those not in certain categories). Unlink `previous_post_link()`, when on the first post in the sequence this function will link to the last post in the sequence, creating a circular loop.

* `function c2c_get_previous_or_loop_post_link( $format='&laquo; %link', $link='%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' )`
Like `c2c_get_previous_or_loop_post_link(), but returns the value without echoing it.

* `function c2c_get_next_or_loop_post( $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' )`
Like WordPress's `get_adjacent_post()` when used to find the next post, except when on the last post in the sequence this function will return the first post in the sequence, creating a circular loop.

* `function c2c_get_previous_or_loop_post( $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' )`
Like WordPress's `get_adjacent_post()` when used to find the previous post, except when on the first post in the sequence this function will return the last post in the sequence, creating a circular loop.

= Arguments =

* `$format`
(optional) A percent-substitution string indicating the format of the entire output string. Use <code>%link</code> to represent the next/previous post being linked, or <code>%title</code> to represent the title of the next/previous post.

* `$link`
(optional) A percent-substitution string indicating the format of the link itself that gets created for the next/previous post. Use <code>%link</code> to represent the next/previous post being linked, or <code>%title</code> to represent the title of the next/previous post.

* `$in_same_term`
(optional) A boolean value (either true or false) indicating if the next/previous post should be in the current post's same taxonomy term.

* `$excluded_terms`
(optional) An array or comma-separated string of category or term IDs to which posts cannot belong.

* `$taxonomy`
(optional) Taxonomy, if $in_same_term is true. Default 'category'.

== Examples ==

`<div class="loop-navigation">
	<div class="alignleft"><?php c2c_previous_or_loop_post_link(); ?></div>
	<div class="alignright"><?php c2c_next_or_loop_post_link(); ?></div>
</div>`


== Filters ==

The plugin is further customizable via eleven hooks. Typically, this type of customization would be put into your active theme's functions.php file or used by another plugin.

= c2c_previous_or_loop_post_link_output, c2c_next_or_loop_post_link_output (filters) =

The 'c2c_previous_or_loop_post_link_output' and 'c2c_next_or_loop_post_link_output' filters allow you to customize the link markup generated for previous and next looping links, respectively.

Example:

  `<?php
    // Prepend "Prev:" to previous link markup.
    function my_custom_previous_or_loop_link_output( $output, $format, $link, $post, $in_same_term, $excluded_terms, $taxonomy ) {
      return 'Prev: ' . $output;
    }
    add_filter( 'c2c_previous_or_loop_post_link_output', 'my_custom_previous_or_loop_link_output', 10, 4 );
  ?>`

= c2c_previous_or_loop_post_link_get, c2c_next_or_loop_post_link_get (filters) =

The 'c2c_previous_or_loop_post_link_get' and 'c2c_next_or_loop_post_link_get' filters allow you to customize the link markups generated for previous and next looping links, respectively, but in the non-echoing functions.

= c2c_previous_or_loop_post_link, c2c_next_or_loop_post_link (actions), c2c_get_previous_or_loop_post_link, c2c_get_next_or_loop_post_link, c2c_get_adjacent_or_loop_post, c2c_get_previous_or_loop_post, c2c_get_previous_or_loop_post (actions) =

The 'c2c_previous_or_loop_post_link' and 'c2c_next_or_loop_post_link' actions allow you to use an alternative approach to safely invoke `c2c_previous_or_loop_post_link()` and `c2c_next_or_loop_post_link()`, respectively, in such a way that if the plugin were deactivated or deleted, then your calls to the functions won't cause errors in your site. The 'c2c_get_previous_or_loop_post_link' and 'c2c_get_next_or_loop_post_link' filters do the same for the non-echoing `c2c_previous_or_loop_post_link()` and `c2c_next_or_loop_post_link()`.

Arguments:

* Same as for for `c2c_previous_or_loop_post_link()` and `c2c_next_or_loop_post_link()`

Example:

Instead of:

`<?php echo c2c_previous_or_loop_post_link( '<span class="prev-or-loop-link">&laquo; %link</span>' ); ?>`

Do:

`<?php echo do_action( 'c2c_previous_or_loop_post_link', '<span class="prev-or-loop-link">&laquo; %link</span>' ); ?>`


== Changelog ==

= 2.6.1 (2016-03-10) =
* New: Add support for language packs:
    * Define 'Text Domain' header attribute.
    * Load textdomain.
* New: Add LICENSE file.
* New: Create empty index.php to prevent files from being listed if web server has enabled directory listings.
* Change: Note compatibility through WP 4.4+.
* Change: Explicitly declare methods in unit tests as public.
* Change: Update copyright date (2016).

= 2.6 (2015-07-14) =
* Feature: Add new template tags for getting the adjacent or looped post object:
  * `c2c_get_next_or_loop_post`
  * `c2c_get_previous_or_loop_post`
  * `c2c_get_adjacent_or_loop_post`
* Bugfix: Prevent a link from being shown if the post loops back to itself or is a non-post post_type
* Bugfix: Correctly invoke `c2c_adjacent_or_loop_post_link()` via `c2c_adjacent_or_loop_post_link` action hook
* Change: Create class to encapsulate some logic and data, removing use of a global variable
* Update: Add documentation for new template tags
* Update: Add more unit tests
* Update: Minor inline documentation improvements and fixes
* Update: Note compatibility through WP 4.3+
* Note: All functions deprecated since v2.0 will be removed in the next major version release

_Full changelog is available in [CHANGELOG.md](https://github.com/coffee2code/loop-post-navigation-links/blob/master/CHANGELOG.md)._


== Upgrade Notice ==

= 2.6.1 =
Trivial update: improved support for localization, minor unit test tweaks, verified compatibility through WP 4.4+, and updated copyright date (2016)

= 2.6 =
Recommended minor update: Added new template tags for getting the adjacent or looped post object; minor bug fixes; noted compatibility through WP 4.3+

= 2.5.2 =
Trivial update: noted compatibility through WP 4.1+ and updated copyright date (2015)

= 2.5.1 =
Trivial update: noted compatibility through WP 4.0+; added plugin icon.

= 2.5 =
Major update: added support for navigating by taxonomy; added non-echoing versions of functions, and more filters; added unit tests; noted compatibility through WP 3.8+; dropped compatibility with WP older than 3.6

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
