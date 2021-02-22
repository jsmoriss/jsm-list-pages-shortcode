=== JSM's List Pages Shortcode ===
Plugin Name: JSM's List Pages Shortcode
Plugin Slug: jsm-list-pages-shortcode
Text Domain: jsm-list-pages-shortcode
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://jsmoriss.github.io/jsm-list-pages-shortcode/assets/
Tags: shortcodes, pages, list pages, sibling pages, child pages, subpages
Contributors: jsmoriss
Requires PHP: 7.0
Requires At Least: 4.5
Tested Up To: 5.6.2
Stable Tag: 1.0

[list-pages], [sibling-pages] and [child-pages] shortcodes to list pages in the content.

== Description ==

[list-pages], [sibling-pages] and [child-pages] shortcodes to list pages in the content.

= Example Usage =

*List pages sorted by title:*

`[list-pages sort_column="post_title"]`

*List pages but exclude certain IDs and set the class of the list to "my-page-list":*

`[list-pages exclude="17,38" class="my-page-list"]`

*Show excerpt:*

`[list-pages excerpt="1"]`

*List the current page's children, but only show the top level:*

`[child-pages depth="1"]`

*List the current page's siblings and their subpages:*

`[sibling-pages depth="2"]`

= Default Arguments =

The default values are the same as for the [wp_list_pages()](http://codex.wordpress.org/Template_Tags/wp_list_pages) function except for title_li which defaults to nothing.  If a class is not specified, a default class of either "list-pages", "sibling-pages" or "child-pages" is given to the UL tag. In addition, the echo parameter has no effect.

In addition to the [wp_list_pages()](http://codex.wordpress.org/Template_Tags/wp_list_pages) arguments, you can also specify:

* **list_type** *(string)* List tag. Defaults to `<ul>`.
* **exclude_current_page** *(int)* Exclude the current page. Defaults to `0`.
* **excerpt** *(int)* Show the page excerpt. Defaults to `0`.

= Need a Boost to your Social and Search Ranking? =

Check out [the WPSSO Core plugin](https://wordpress.org/plugins/wpsso/) to present your content at its best on social sites and in search results, no matter how webpages are shared, re-shared, messaged, posted, embedded, or crawled.

== Installation ==

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

== Upgrade Notice ==

