=== Loop Post Navigation Links ===
Contributors: coffee2code
Donate link: http://coffee2code.com
Tags: posts, navigation, links, next, previous, portfolio
Requires at least: 2.0
Tested up to: 2.5
Stable tag: trunk
Version: 1.0

Adds next_or_loop_post_link() and previous_or_loop_post_link() template tags to loop back to the beginning/end post when at the end/beginning post single page.

== Description ==

Adds `next_or_loop_post_link()` and `previous_or_loop_post_link()` template tags to loop back to the beginning/end post when at the end/beginning post single page.

`next_or_loop_post_link()` is identical to WordPress's `next_post_link()` in every way except when called on the last post in the sequence, in which case it links back to the first post in the sequence.

`previous_or_loop_post_link()` is identical to WordPress's `previous_post_link()` in every way except when called on the first post in the sequence, in which case it links back to the last post in the sequence.

Useful for providing a looping link of posts, such as for a portfolio, or to continually present pertinent posts for visitors to continue reading.

== Installation ==

1. Unzip `loop-post-navigation-links.zip` inside the `/wp-content/plugins/` directory, or upload `loop-post-navigation-links.php` into `/wp-content/plugins/`
1. Activate the plugin through the 'Plugins' admin menu in WordPress
1. Use `next_or_loop_post_link()` template tag instead of `next_post_link()`, and/or `previous_or_loop_post_link()` template tag instead of `previous_post_link()`, in your single-post template (single.php).

== Template Tags ==

The plugin provides two template tags for use in your single-post theme templates.

= Functions =

* `function next_or_loop_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '')`
Like WordPress's `next_post_link()`, this function displays a link to the next chronological post (among all published posts, those in the same category, or those not in certain categories).  Unlink `next_post_link()`, when on the last post in the sequence this function will link back to the first post in the sequence, creating a circular loop.

* `function previous_or_loop_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '')`
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
