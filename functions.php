<?php
/**
 * BasicTheme functions and definitions
 *
 * @package WordPress
 * @subpackage BasicTheme
 * @since BasicTheme 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since BasicTheme 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'basictheme_setup' ) ) :

	function basictheme_setup() {

		/*
		* Make theme available for translation.
		* Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/basictheme
		* If you're building a theme based on basictheme, use a find and replace
		* to change 'basictheme' to the name of your theme in all the template files
		*/
		load_theme_textdomain( 'basictheme' );

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
			'primary' => __( 'Primary Menu',      'basictheme' ),
			'social'  => __( 'Social Links Menu', 'basictheme' ),
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
		* @since BasicTheme 1.5
		*/
		add_theme_support( 'custom-logo', array(
			'height'      => 248,
			'width'       => 248,
			'flex-height' => true,
		) );

		
	}
endif; // basictheme_setup

add_action( 'after_setup_theme', 'basictheme_setup' );

/**
 * Register widget area.
 *
 * @since BasicTheme 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function basictheme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'basictheme' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'basictheme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'basictheme_widgets_init' );


/**
 * Enqueue scripts and styles.
 *
 * @since BasicTheme 1.0
 */
function basictheme_scripts() {
	
	// Load our main stylesheet.
	wp_enqueue_style( 'basictheme-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'basictheme-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

}
add_action( 'wp_enqueue_scripts', 'basictheme_scripts' );


function basictheme_post_thumbnail(){
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'widgets' );
}
add_action( 'after_setup_theme', 'basictheme_post_thumbnail' );


function basictheme_entry_meta(){
	
}

function nexmag_customize_register( $wp_customize ) {

    $wp_customize->add_panel('custom_theme_panel',array(
            'priority'=>100,
            'title'=>'Theme Settings',
            'description'=>'Custom Theme options'
     ));

    $config = [
        "General" => [
            "google_font" => "Google Font",
            "google_font_sizes" => [
                "label" => "Google Font Sizes",
                "default" => "400;600"
            ],
            "show_title" => [
                "label" => "Show title",
                "type" => "checkbox",
                "default" => '1'
            ],
            "show_desc" => [
                "label" => "Show description",
                "type" => "checkbox"
            ]
        ],
        "Extra Header" => [
            "extraheader1" => "Left section1",
            "extraheader2" => "Center section",
            "extraheader3" => "Right section"
        ],
        "Main Menu" => [
            "show_home" => [
                "label" => "Show Home",
                "type" => "checkbox"
            ],
            "show_categories" => [
                "label" => "Show categories",
                "type" => "checkbox"
            ],
            "show_tags" => [
                "label" => "Show tags",
                "type" => "checkbox"
            ],
            "show_search" => [
                "label" => "Show search",
                "type" => "checkbox"
            ]
        ],
        "Content" => [
            "show_header_image" => [
                "label" => "Show Header Post Image",
                "type" => "checkbox"
            ],
            "show_header_full" => [
                "label" => "Full Width Header Image",
                "type" => "checkbox"
            ],
            "header_default_height" => [
                "label" => "Default Header Image Height",
                "type" => "number"
            ] 
        ]
    ];
    $i = 1;
    foreach($config as $section => $options){
        $sectionid = 'extra_header_section'.$i;
        $wp_customize->add_section($sectionid,array(
            'priority'=>$i,
            'title'=>$section,
            'panel'=>'custom_theme_panel'
        ));
        foreach($options as $optkey => $optprops) {
            $optlabel = $optprops;
            $opttype = 'text';
            $optchoices = [];
            $default = '';
            if (gettype($optprops)=="array"){
                $optlabel = @$optprops["label"]?:$optkey;
                $opttype = @$optprops["type"]?:$opttype;
                $default = @$optprops["default"]?:$default;
            }
            $s_opts = array(
                'default'=>$default,
                'type' => 'option',
                'transport' => 'refresh'
            );
            $c_opts = array(
                'type'=>$opttype,
                'label'=>$optlabel,
                'section'=>$sectionid,
                'settings'=>$optkey,
            );
            if ($opttype=="checkbox") {
                $opttype="select";
                $c_opts["type"] = "select";
                $optchoices=["No","Yes"];
            }
            if ($opttype=="select") {
                $c_opts["choices"] = $optchoices;
            }
            $wp_customize->add_setting($optkey, $s_opts);
            $wp_customize->add_control($optkey.'control',$c_opts);    
        }
        $i++;
    }

}
   
add_action( 'customize_register', 'nexmag_customize_register' );


function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

add_theme_support( 'widgets' );

function theme_sidebars() {

	register_sidebar( array(
		'name'          => 'Footer section 1',
		'id'            => 'footer_section_1',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => 'Footer section 2',
		'id'            => 'footer_section_2',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => 'Footer section 3',
		'id'            => 'footer_section_3',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'theme_sidebars' );