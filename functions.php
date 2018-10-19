<?php
/**
 * Demo functions and definitions
 *
 * @package WordPress
 * @subpackage Demo
 * @since Demo 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Demo 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'demo_setup' ) ) :

	function demo_setup() {

		/*
		* Make theme available for translation.
		* Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/demo
		* If you're building a theme based on demo, use a find and replace
		* to change 'demo' to the name of your theme in all the template files
		*/
		load_theme_textdomain( 'demo' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu',      'demo' ),
			'social'  => __( 'Social Links Menu', 'demo' ),
		) );

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
		* Enable support for Post Formats.
		*
		* See: https://codex.wordpress.org/Post_Formats
		*/
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
		) );

		/*
		* Enable support for custom logo.
		*
		* @since Demo 1.5
		*/
		add_theme_support( 'custom-logo', array(
			'height'      => 248,
			'width'       => 248,
			'flex-height' => true,
		) );

		
	}
endif; // demo_setup

add_action( 'after_setup_theme', 'demo_setup' );

/**
 * Register widget area.
 *
 * @since Demo 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function demo_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'demo' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'demo' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'demo_widgets_init' );


/**
 * Enqueue scripts and styles.
 *
 * @since Demo 1.0
 */
function demo_scripts() {
	
	// Load our main stylesheet.
	wp_enqueue_style( 'demo-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'demo-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

}
add_action( 'wp_enqueue_scripts', 'demo_scripts' );



function demo_post_thumbnail(){

}


function demo_entry_meta(){
	
}