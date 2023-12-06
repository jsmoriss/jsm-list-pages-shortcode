=== JSM List Pages Shortcode ===
Plugin Name: JSM List Pages Shortcode
Plugin Slug: jsm-list-pages-shortcode
Text Domain: jsm-list-pages-shortcode
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://jsmoriss.github.io/jsm-list-pages-shortcode/assets/
Tags: shortcodes, pages, list pages, sibling pages, child pages, subpages
Contributors: jsmoriss
Requires PHP: 7.2.34
Requires At Least: 5.5
Tested Up To: 6.4.2
Stable Tag: 1.0

[list-pages], [sibling-pages] and [child-pages] shortcodes to list pages in the content.

== Description ==

[list-pages], [sibling-pages] and [child-pages] shortcodes to list pages in the content.

= Example Usage =

*List pages sorted by title:*

<code>&#91;list-pages sort_column="post_title"&#93;</code>

*List pages but exclude certain IDs and set the class of the list to "my-page-list":*

<code>&#91;list-pages exclude="17,38" class="my-page-list"&#93;</code>

*Show excerpt:*

<code>&#91;list-pages excerpt="1"&#93;</code>

*List the current page's children, but only show the top level:*

<code>&#91;child-pages depth="1"&#93;</code>

*List the current page's siblings and their subpages:*

<code>&#91;sibling-pages depth="2"&#93;</code>

= Default Arguments =

The default values are the same as for the [wp_list_pages()](http://codex.wordpress.org/Template_Tags/wp_list_pages) function except for title_li which defaults to nothing.  If a class is not specified, a default class of either "list-pages", "sibling-pages" or "child-pages" is given to the UL tag. In addition, the echo parameter has no effect.

In addition to the [wp_list_pages()](http://codex.wordpress.org/Template_Tags/wp_list_pages) arguments, you can also specify:

* **list_type** *(string)* List tag. Defaults to `<ul>`.
* **exclude_current_page** *(int)* Exclude the current page. Defaults to `0`.
* **excerpt** *(int)* Show the page excerpt. Defaults to `0`.

== Installation ==

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

== Upgrade Notice ==

