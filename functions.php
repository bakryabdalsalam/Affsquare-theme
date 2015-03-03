<?php
/**
 * @package WordPress
 * @subpackage customtheme
 */

load_theme_textdomain( 'themename', get_template_directory() . '/languages' );


$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 960;

/**
 * Remove code from the <head>
 */
remove_filter( 'the_content', 'capital_P_dangit' ); // Get outta my Wordpress codez dangit!
remove_filter( 'the_title', 'capital_P_dangit' );
remove_filter( 'comment_text', 'capital_P_dangit' );

/**
 * This theme uses wp_nav_menus() for the header menu, utility menu and footer menu.

register_nav_menus( array(
	'mainmenu' => __( 'Primary Menu', 'themename' ),
	'footermenu' => __( 'Footer Menu', 'themename' ),
) );
 */
/** 
 * Add default posts and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/**
 * This theme uses post thumbnails
 */
add_theme_support( 'post-thumbnails' );

/**
 *	This theme supports editor styles
 */

add_editor_style("/css/layout-style.css");

/**
 * Disable the admin bar in 3.1
 */
//show_admin_bar( false );

/**
 * This enables post formats. If you use this, make sure to delete any that you aren't going to use.
 */
//add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'video', 'gallery', 'chat', 'link', 'quote', 'status' ) );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function swg_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar', 'themename' ),
		'id' => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s" role="complementary">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'init', 'swg_widgets_init' );


/**
 * excerpt code 
 */
function swg_auto_excerpt_more( $more ) {
	return ' &hellip;' . swg_continue_reading_link();
}
add_filter( 'excerpt_more', 'swg_auto_excerpt_more' );

function swg_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= swg_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'swg_custom_excerpt_more' );

function swg_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'swg_excerpt_length' );

function swg_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Read More', 'swg' ) . '</a>';
}

/* change Search Form input type from "text" to "search" and add placeholder text */
function swg_search_form ( $form ) {
		$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
		<div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
		<input type="search" placeholder="Search for..." value="' . get_search_query() . '" name="s" id="s" />
		<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
		</div>
		</form>';
		return $form;
	}
add_filter( 'get_search_form', 'swg_search_form' );

function swg_complete_version_removal() {
		return '';
	}
add_filter('the_generator', 'swg_complete_version_removal');

function add_custom_lib(){
	$ROOT = get_template_directory_uri();
	wp_register_script('bkplugins',$ROOT . '/js/jquery.plugins.js',array('jquery'),'1.0' );
	wp_register_script('bkscript',$ROOT . '/js/bkscript.js',array('jquery'),'1.0' );
	wp_enqueue_script("jquery");
	wp_enqueue_script('bkplugins');
	wp_enqueue_script('bkscript');
}
?>