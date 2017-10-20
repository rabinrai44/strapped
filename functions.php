<?php
/**
 * Strapped functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Strapped
 */

if ( ! function_exists( 'strapped_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function strapped_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Strapped, use a find and replace
		 * to change 'strapped' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'strapped', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/* Custom Logo Support */
		add_theme_support( 'custom-logo' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'strapped' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'strapped_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'strapped_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function strapped_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'strapped_content_width', 640 );
}
add_action( 'after_setup_theme', 'strapped_content_width', 0 );

if ( !function_exists( 'strapped_the_custom_logo' ) ) :
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 *
	 */
	function strapped_the_custom_logo() {
		// Try to retrieve the Custom Logo
		$output = '';
		if (function_exists('get_custom_logo'))
			$output = get_custom_logo();
	
		// Nothing in the output: Custom Logo is not supported, or there is no selected logo
		// In both cases we display the site's name
		if (empty($output))
			$output = '<a class="navbar-brand" href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
	
		echo $output;
	}
	endif;

/**
 * Editing the Tag Widget
 */
function my_widget_tag_cloud_args( $args ) {
	$args['largest'] = 11;
	$args['smallest'] = 11;
	$args['unit'] = 'px';
	return $args;
  }
  add_filter( 'widget_tag_cloud_args', 'my_widget_tag_cloud_args' );

/**
 * Widgets 
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/scripts.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
/**
 * Bootstrap Menu - Custom Walker
 */
require get_template_directory() . '/inc/bootstrap-walker.php';

