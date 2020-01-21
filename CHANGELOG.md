# Changelog

# _(in-progress)_
* New: Add CHANGELOG.md file and move all but most recent changelog entries into it
* New: Add GitHub link to readme.txt
* Unit tests:
    * Change: Update unit test install script and bootstrap to use latest WP unit test repo
    * Change: Enable more error output for unit tests
    * Change: Comment out unit tests that weren't actually testing anything
    * Fix: Don't declare `$posts` as being static since it's never referenced as if it was
* Change: Update License URI to be HTTPS
* Change: Update copyright date (2020)
* Change: Update installation instruction to prefer built-in installer over .zip file

## 2.6.1 _(2016-03-10)_
* New: Add support for language packs:
    * Define 'Text Domain' header attribute.
    * Load textdomain.
* New: Add LICENSE file.
* New: Create empty index.php to prevent files from being listed if web server has enabled directory listings.
* Change: Note compatibility through WP 4.4+.
* Change: Explicitly declare methods in unit tests as public.
* Change: Update copyright date (2016).

## 2.6 _(2015-07-14)_
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

## 2.5.2 _(2015-02-12)_
* Update: Note compatibility through WP 4.1+
* Update: Extend copyright date (2015)

## 2.5.1 _(2014-08-25)_
* Minor plugin header reformatting
* Minor documentation syncing between `c2c_get_adjacent_or_loop_post_link()` and `get_adjacent_post_link()`
* Minor code reformatting (spacing, bracing)
* Change documentation links to wp.org to be https
* Note compatibility through WP 4.0+
* Add plugin icon

## 2.5 _(2013-12-31)_
* Support looping through any taxonomy (not just categories)
  * Add `$taxonomy` arg to nav functions (default is 'categories')
  * Rename arg $in_same_cat to `$in_same_term`
  * Rename arg `$excluded_categories` to `$excluded_terms`
* Add function `c2c_get_adjacent_or_loop_post_link()` as non-echoing version of `c2c_adjacent_or_loop_post_link()`
* Add function `c2c_get_next_or_loop_post_link()` as non-echoing version of `c2c_next_or_loop_post_link()`
* Add function `c2c_get_previous_or_loop_post_link()` as non-echoing version of `c2c_previous_or_loop_post_link()`
* Add action `c2c_get_next_or_loop_post_link`
* Add action `c2c_get_previous_or_loop_post_link`
* Add action `c2c_get_adjacent_or_loop_post_link`
* Add filter `c2c_next_or_loop_post_link_get`
* Add filter `c2c_previous_or_loop_post_link_get`
* Add unit tests
* Adjust all existing `do_action()` calls to send an additional arg
* Minor re-syncing with adjacent_post_link()
* Improve phpDoc formatting (spacing)
* Note compatibility through WP 3.8+
* Drop compatibility with versions of WP older than 3.6
* Update copyright date (2014)
* Change donate link
* Minor readme.txt tweaks (mostly spacing)
* Add banner

## 2.0
* Sync `adjacent_or_loop_post_link()` with most changes made to WP's `adjacent_or_post_link()`
  * Always run output through filters
  * Pass original $format to filters
  * Pass `$post` to filters
  * Minor code reformatting (spacing)
  * NOTE: arguments to filters have changed
* Rename `next_or_loop_post_link()` to `c2c_next_or_loop_post_link()` (but maintain a deprecated version for backwards compatibility)
* Rename `previous_or_loop_post_link()` to `c2c_previous_or_loop_post_link()` (but maintain a deprecated version for backwards compatibility)
* Rename `adjacent_or_loop_post_link()` to `c2c_adjacent_or_loop_post_link()` (but maintain a deprecated version for backwards compatibility)
* Add filter `c2c_next_or_loop_post_link` so that users can use the `do_action('c2c_next_or_loop_post_link')` notation for invoking the function
* Add filter `c2c_previous_or_loop_post_link` so that users can use the `do_action('c2c_previous_or_loop_post_link')` notation for invoking the function
* Add filter `c2c_adjacent_or_loop_post_link` so that users can use the `do_action('c2c_adjacent_or_loop_post_link')` notation for invoking the function
* Rename filter `previous_or_loop_post_link` to `c2c_previous_or_loop_post_link_output` (but maintain old filter for backwards compatibility)
* Rename filter `next_or_loop_post_link` to `c2c_next_or_loop_post_link_output` (but maintain old filter for backwards compatibility)
* Add "Filters" section to readme.txt
* Add check to prevent execution of code if file is directly accessed
* Update documentation
* Note compatibility through WP 3.5+
* Update copyright date (2013)

## 1.6.3
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Remove ending PHP close tag
* Note compatibility through WP 3.4+

## 1.6.2
* Note compatibility through WP 3.3+
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

## 1.6.1
* Note compatibility through WP 3.2+
* Update copyright date (2011)
* Minor code formatting (spacing)
* Add plugin homepage and author links to description in readme.txt

## 1.6
* Add rel= attribute to links
* Wrap all functions in `if(!function_exists())` check
* Check that `$GLOBALS['post']` is an object before treating it as such
* Minor code tweaks to mirror more recent changes to adjacent_post_link()
* Note compatibility with WP 3.0+
* Minor code reformatting (spacing)
* Add Upgrade Notice section to readme
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Remove trailing whitespace in header docs

## 1.5.1
* Add PHPDoc documentation
* Note compatibility with WP 2.9+
* Update copyright date

## 1.5
* Added `adjacent_or_loop_post_link()` and have `next_or_loop_post_link()` and `previous_or_post_link()` simply deferring to it for core operation
* Added support for %date in format string (as per WP)
* Added support for `previous_post_link` and `next_post_link` filters (as per WP)
* Added support for `previous_or_loop_post_link` and `next_or_loop_post_link` filters
* Removed two previously used global variable flags and replaced with one
* Changed description
* Noted compatibility with WP 2.8+
* Dropped support for pre-WP2.6
* Updated copyright date

## 1.0
* Initial release
