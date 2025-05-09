<h1>JSM List Pages Shortcode</h1>

<table>
<tr><th align="right" valign="top" nowrap>Plugin Name</th><td>JSM List Pages Shortcode</td></tr>
<tr><th align="right" valign="top" nowrap>Summary</th><td>[list-pages], [sibling-pages] and [child-pages] shortcodes to list pages in the content.</td></tr>
<tr><th align="right" valign="top" nowrap>Stable Version</th><td>1.0</td></tr>
<tr><th align="right" valign="top" nowrap>Requires PHP</th><td>7.4.33 or newer</td></tr>
<tr><th align="right" valign="top" nowrap>Requires WordPress</th><td>5.9 or newer</td></tr>
<tr><th align="right" valign="top" nowrap>Tested Up To WordPress</th><td>6.8.1</td></tr>
<tr><th align="right" valign="top" nowrap>Contributors</th><td>jsmoriss</td></tr>
<tr><th align="right" valign="top" nowrap>License</th><td><a href="https://www.gnu.org/licenses/gpl.txt">GPLv3</a></td></tr>
<tr><th align="right" valign="top" nowrap>Tags / Keywords</th><td>shortcode, list pages, sibling pages, child pages, subpages</td></tr>
</table>

<h2>Description</h2>

<p>[list-pages], [sibling-pages] and [child-pages] shortcodes to list pages in the content.</p>

<h4>Example Usage</h4>

<p><em>List pages sorted by title:</em></p>

<p><code>&#91;list-pages sort_column="post_title"&#93;</code></p>

<p><em>List pages but exclude certain IDs and set the class of the list to "my-page-list":</em></p>

<p><code>&#91;list-pages exclude="17,38" class="my-page-list"&#93;</code></p>

<p><em>Show excerpt:</em></p>

<p><code>&#91;list-pages excerpt="1"&#93;</code></p>

<p><em>List the current page's children, but only show the top level:</em></p>

<p><code>&#91;child-pages depth="1"&#93;</code></p>

<p><em>List the current page's siblings and their subpages:</em></p>

<p><code>&#91;sibling-pages depth="2"&#93;</code></p>

<h4>Default Arguments</h4>

<p>The default values are the same as for the <a href="http://codex.wordpress.org/Template_Tags/wp_list_pages">wp_list_pages()</a> function except for title_li which defaults to nothing.  If a class is not specified, a default class of either "list-pages", "sibling-pages" or "child-pages" is given to the UL tag. In addition, the echo parameter has no effect.</p>

<p>In addition to the <a href="http://codex.wordpress.org/Template_Tags/wp_list_pages">wp_list_pages()</a> arguments, you can also specify:</p>

<ul>
<li><strong>list_type</strong> <em>(string)</em> List tag. Defaults to <code>&lt;ul&gt;</code>.</li>
<li><strong>exclude_current_page</strong> <em>(int)</em> Exclude the current page. Defaults to <code>0</code>.</li>
<li><strong>excerpt</strong> <em>(int)</em> Show the page excerpt. Defaults to <code>0</code>.</li>
</ul>

