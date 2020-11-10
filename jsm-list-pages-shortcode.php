<?php
/**
 * Plugin Name: JSM's List Pages Shortcode
 * Text Domain: jsm-list-pages-shortcode
 * Domain Path: /languages
 * Plugin URI: https://surniaulula.com/extend/plugins/jsm-list-pages-shortcode/
 * Assets URI: https://jsmoriss.github.io/jsm-list-pages-shortcode/assets/
 * Author: JS Morisset
 * Author URI: https://surniaulula.com/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl.txt
 * Description: [list-pages], [sibling-pages] and [child-pages] shortcodes to list pages in the content.
 * Requires PHP: 5.6
 * Requires At Least: 4.2
 * Tested Up To: 5.4.1
 * Version: 1.0
 *
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2020 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

add_shortcode( 'child-pages', array( 'List_Pages_Shortcode', 'shortcode_list_pages' ) );

add_shortcode( 'sibling-pages', array( 'List_Pages_Shortcode', 'shortcode_list_pages' ) );

add_shortcode( 'list-pages', array( 'List_Pages_Shortcode', 'shortcode_list_pages' ) );

add_filter( 'list_pages_shortcode_excerpt', array( 'List_Pages_Shortcode', 'excerpt_filter' ) );

class List_Pages_Shortcode {

	public static $children = 0;

	public function __construct() {}

	static function shortcode_list_pages( $atts, $content, $tag ) {

		global $post;

		/**
		 * Child pages.
		 */
		$child_of = 0;

		if ( 'child-pages' === $tag ) {

			$child_of = $post->ID;

		} elseif ( 'sibling-pages' === $tag ) {

			$child_of = $post->post_parent;
		}

		/**
		 * Set defaults.
		 */
		$defaults = array(
			'class'                => 'list-pages-shortcode ' . $tag . ' child-0',
			'depth'                => 0,
			'show_date'            => '',
			'date_format'          => get_option( 'date_format' ),
			'exclude'              => '',
			'include'              => '',
			'child_of'             => $child_of,
			'list_type'            => 'ul',
			'title_li'             => '',
			'authors'              => '',
			'sort_column'          => 'menu_order,post_title',
			'sort_order'           => 'ASC',
			'link_before'          => '',
			'link_after'           => '',
			'exclude_tree'         => '',
			'meta_key'             => '',
			'meta_value'           => '',
			'walker'               => new List_Pages_Shortcode_Walker_Page,
			'post_type'            => 'page',
			'offset'               => '',
			'post_status'          => 'publish',
			'exclude_current_page' => 0,
			'excerpt'              => 0
		);

		/**
		 * Merge user provided atts with defaults.
		 */
		$allowed_atts = shortcode_atts( $defaults, $atts );

		$allowed_atts[ 'title_li' ] = html_entity_decode( $allowed_atts[ 'title_li' ] );

		if ( $allowed_atts[ 'exclude_current_page' ] && absint( $post->ID ) ) {

			if ( ! empty( $allowed_atts[ 'exclude' ] ) ) {

				$allowed_atts[ 'exclude' ] .= ',';
			}

			$allowed_atts[ 'exclude' ] .= $post->ID;
		}

		$allowed_atts[ 'echo' ] = 0;

		/**
		 * Catch <ul> tags in wp_list_pages().
		 */
		$allowed_atts[ 'list_type' ] = self::validate_list_type( $allowed_atts[ 'list_type' ] );

		if ( 'ul' !== $allowed_atts[ 'list_type' ] ) {

			add_filter( 'wp_list_pages', array( 'List_Pages_Shortcode', 'ul2list_type' ), 10, 2 );
		}

		/**
		 * Create output.
		 */
		$list_pages_atts = $allowed_atts;

		$list_pages_atts[ 'shortcode_tag' ] = $tag;

		if ( empty( $list_pages_atts[ 'list_type' ] ) ) {

			$list_pages_atts[ 'list_type' ] = 'ul';
		}

		$output = wp_list_pages( $list_pages_atts );

		if ( 'ul' !== $allowed_atts[ 'list_type' ] ) {
		
			remove_filter( 'wp_list_pages', array( 'List_Pages_Shortcode', 'ul2list_type' ), 10 );
		}

		if ( ! empty( $output ) && ! empty( $allowed_atts[ 'list_type' ] ) ) {

			$output = '<' . $allowed_atts[ 'list_type' ] . ' class="' . $allowed_atts[ 'class' ] . '">' . $output . '</' . $allowed_atts[ 'list_type' ] . '>';

			/**
			 * Start from largest number and inverse the child-# class name with a parent-# class name.
			 */
			$parent = 0;

			foreach ( array_reverse( range( 0, self::$children ) ) as $num ) {

				$output = preg_replace( '/child-' . $num . '/', '$0 parent-' . $parent, $output );

				$parent++;
			}
		}

		return $output;
	}

	/**
	 * UL 2 List Type
	 * Replaces all <ul> tags with <{list_type}> tags.
	 *
	 * @param string $output Output of wp_list_pages().
	 * @param array $args shortcode_list_pages() args.
	 * @return string HTML output.
	 */
	static function ul2list_type( $output, $args = null ) {

		$list_type = self::validate_list_type( $args[ 'list_type' ] );

		if ( 'ul' !== $list_type ) {

			// <ul>
			$output = str_replace( '<ul>', '<' . $list_type . '>', $output );
			$output = str_replace( '<ul ', '<' . $list_type . ' ', $output );
			$output = str_replace( '</ul> ', '</' . $list_type . '>', $output );

			// <li>
			$list_type = 'span' == $list_type ? 'span' : 'div';

			$output = str_replace( '<li>', '<' . $list_type . '>', $output );
			$output = str_replace( '<li ', '<' . $list_type . ' ', $output );
			$output = str_replace( '</li> ', '</' . $list_type . '>', $output );

		}

		return $output;

	}

	/**
	 * Excerpt Filter
	 * Add a <div> around the excerpt by default.
	 *
	 * @param string $excerpt Excerpt.
	 * @return string Filtered excerpt.
	 */
	static function excerpt_filter( $text ) {

		if ( ! empty( $text ) ) {

			return ' <div class="excerpt">' . $text . '</div>';
		}

		return $text;
	}

	/**
	 * Validate List Type
	 *
	 * @param   string  $list_type  List type tag.
	 * @return  string              Valid tag.
	 */
	public static function validate_list_type( $list_type ) {

		if ( empty( $list_type ) || ! in_array( $list_type, array( 'ul', 'div', 'span', 'article', 'aside', 'section' ) ) ) {

			$list_type = 'ul';
		}

		return $list_type;

	}
}

/**
 * Create HTML list of pages.
 */
class List_Pages_Shortcode_Walker_Page extends Walker_Page {

	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		$id_field = $this->db_fields['id'];
		$id       = $element->$id_field;

		/**
		 * Maybe re-sort the children if we have the same shortcode with different sort attributes in the post content.
		 */
		if ( ! empty( $args[ 0 ][ 'shortcode_tag' ] ) && ! empty( $children_elements[ $id ] ) ) {

			$tag     = $args[ 0 ][ 'shortcode_tag' ];
			$pattern = get_shortcode_regex( array( $tag ) );

			if ( preg_match( '/' . get_shortcode_regex() . '/', $element->post_content, $matches ) ) {

				$atts = shortcode_parse_atts( $matches[ 3 ] );

				if ( ! empty( $atts ) ) {

					$def_orderby = $new_orderby = $args[ 0 ][ 'sort_column' ];
					$def_order   = $new_order   = $args[ 0 ][ 'sort_order' ];

					$new_orderby = empty( $atts[ 'sort_column' ] ) ? $def_orderby : $atts[ 'sort_column' ];
					$new_order   = empty( $atts[ 'sort_order' ] ) ? $def_orderby : $atts[ 'sort_order' ];

					if ( $def_orderby !== $new_orderby || $def_order !== $new_order ) {

						$children_elements[ $id ] = wp_list_sort( $children_elements[ $id ], $new_orderby, $new_order );
					}
				}
			}
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * @see Walker::start_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $child Depth of page. Used for padding.
	 */
	function start_lvl( &$output, $child = 0, $args = array() ) {

		$indent = str_repeat( "\t", $child );

		$list_type = List_Pages_Shortcode::validate_list_type( $args[ 'list_type' ] );

		$output .= "\n" . $indent . '<' . $list_type . ' class="children child-' . ( $child + 1 ) . '">' . "\n";

		if ( $child + 1 > List_Pages_Shortcode::$children ) {

			List_Pages_Shortcode::$children = $child + 1;
		}
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $child Depth of page. Used for padding.
	 */
	function end_lvl( &$output, $child = 0, $args = array() ) {

		$indent = str_repeat( "\t", $child );

		$list_type = List_Pages_Shortcode::validate_list_type( $args[ 'list_type' ] );

		$output .= $indent . '</' . $list_type . '>' . "\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object.
	 * @param int $child Depth of page. Used for padding.
	 * @param int $current_page Page ID.
	 * @param array $args
	 */
	function start_el( &$output, $page, $child = 0, $args = array(), $current_page = 0 ) {

		if ( $child ) {

			$indent = str_repeat( "\t", $child );

		} else {

			$indent = '';
		}

		extract( $args, EXTR_SKIP );

		$css_class = array( 'page-item', 'page-item-' . $page->ID, 'child-' . $child );

		if ( isset( $args[ 'pages_with_children' ][ $page->ID ] ) ) {

			$css_class[] = 'page_item_has_children';
		}

		if ( ! empty( $current_page ) ) {

			$_current_page = get_page( $current_page );

			if ( in_array( $page->ID, $_current_page->ancestors ) ) {

				$css_class[] = 'current_page_ancestor';
			}

			if ( $page->ID == $current_page ) {

				$css_class[] = 'current_page_item';

			} elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {

				$css_class[] = 'current_page_parent';
			}

		} elseif ( $page->ID == get_option( 'page_for_posts' ) ) {

			$css_class[] = 'current_page_parent';
		}

		$css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $child, $args, $current_page ) );

		if ( '' === $page->post_title ) {

			$page->post_title = sprintf( __( '#%d (no title)' ), $page->ID );
		}

		$item = '<a href="' . get_permalink( $page->ID ) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';

		if ( ! empty( $show_date ) ) {

			if ( 'modified' == $show_date ) {

				$time = $page->post_modified;

			} else {

				$time = $page->post_date;
			}

			$item .= ' ' . mysql2date( $date_format, $time );
		}

		if ( $args[ 'excerpt' ] ) {

			$item .= apply_filters( 'list_pages_shortcode_excerpt', $page->post_excerpt, $page, $child, $args, $current_page );
		}

		$output .= $indent . '<li class="' . $css_class . '">' . apply_filters( 'list_pages_shortcode_item', $item, $page, $child, $args, $current_page );
	}
}
