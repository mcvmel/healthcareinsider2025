<?php
/**
 * healthcareinsider2025 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package healthcareinsider2025
 */

if ( ! defined( 'HCI_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'HCI_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function healthcareinsider2025_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on healthcareinsider2025, use a find and replace
		* to change 'healthcareinsider2025' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'healthcareinsider2025', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary', 'healthcareinsider2025' ),
            'footer_1'  => 'Footer 1',
            'footer_2'  => 'Footer 2',
            'footer_3'  => 'Footer 3',
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'healthcareinsider2025_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'healthcareinsider2025_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function healthcareinsider2025_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'healthcareinsider2025_content_width', 640 );
}
add_action( 'after_setup_theme', 'healthcareinsider2025_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function healthcareinsider2025_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'healthcareinsider2025' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'healthcareinsider2025' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'healthcareinsider2025_widgets_init' );


// remove admin bar bump
add_action('get_header', 'healthcareinsider2025_remove_admin_bump');

function healthcareinsider2025_remove_admin_bump()
{
    remove_action('wp_head', '_admin_bar_bump_cb');
}

function custom_trim_excerpt_by_chars($excerpt) {
    $char_limit = 80;

    $excerpt = strip_tags($excerpt); // remove any HTML
    if (strlen($excerpt) > $char_limit) {
        $excerpt = substr($excerpt, 0, $char_limit);
        $excerpt = rtrim($excerpt, " \t\n\r\0\x0B.,!?"); // clean up trailing punctuation
        $excerpt .= '…'; // append ellipsis
    }

    return $excerpt;
}
add_filter('get_the_excerpt', 'custom_trim_excerpt_by_chars');

/**
 * Enqueue scripts and styles.
 */
function healthcareinsider2025_scripts() {

    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'global-styles' );
    wp_dequeue_style('dashicons');
    wp_deregister_script('wp-polyfill-dom-rect');

    wp_deregister_script('wp-polyfill-element-closest');
    wp_deregister_script('wp-polyfill-fetch');
    wp_deregister_script('wp-polyfill-formdata');
    wp_deregister_script('wp-polyfill-node-contains');
    wp_deregister_script('wp-polyfill-object-fit');
    wp_deregister_script('wp-polyfill-url');
    wp_deregister_script('regenerator-runtime');


	wp_enqueue_style( 'healthcareinsider2025-style', get_stylesheet_uri(), array(), HCI_VERSION );
	wp_style_add_data( 'healthcareinsider2025-style', 'rtl', 'replace' );

	wp_enqueue_script( 'healthcareinsider2025-navigation', get_template_directory_uri() . '/js/navigation.js', array(), HCI_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    wp_enqueue_script( 'healthcareinsider2025-mainjs', get_template_directory_uri() . '/js/main.min.js', array('jquery'), HCI_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'healthcareinsider2025_scripts' );





// Add Shortcode
function find_plans_cta_shortcode($atts) {
    global $post;

    // Default values
    $defaults = array(
        'headline'  => 'Searching For Health Plans?',
        'paragraph' => 'Explore ACA Marketplace or Short-Term Medical Health Plans',
        'content'   => 'default'
    );

    // Merge defaults with attributes
    $atts = shortcode_atts($defaults, $atts, 'find_plans_cta');

    // Get current page slug
    $page_slug = $post ? $post->post_name : '';

    // Get first category slug (or empty if none)
    $category_slug = '';
    $categories = get_the_category($post->ID);
    if (!empty($categories) && !is_wp_error($categories)) {
        $category_slug = $categories[0]->slug;
    }

    // Build URL
    $cta_url = 'https://www.healthcare.com/mp2/healthcare-insurance/survey/?utm_source=hci';
    $cta_url .= '&utm_medium=' . urlencode($page_slug);
    $cta_url .= '&utm_campaign=' . urlencode($category_slug);
    $cta_url .= '&utm_content=' . urlencode($atts['content']);

    // Output HTML
    ob_start();
    ?>
    <div class="find-plans-cta">
		<div class="find-plans-cta__inner">
			<span class="find-plans-cta__inner__heading"><?php echo esc_html($atts['headline']); ?></span>
			<p><?php echo esc_html($atts['paragraph']); ?></p>
			<div class="btn-container btn-container--left">
				<a href="<?php echo esc_url($cta_url); ?>" target="_blank" class="btn btn--secondary">Learn More</a>
			</div>
		</div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('find_plans_cta', 'find_plans_cta_shortcode');


function call_today_cta_shortcode($atts) {
	global $post;

	// Default values
	$defaults = array(
		'headline'  => 'Find Out How Much You Could Save On Health Insurance',
		'paragraph' => 'A team of license insurance agents are here to help you compare plans',
		'content'   => 'default'
	);

	// Merge defaults with attributes
	$atts = shortcode_atts($defaults, $atts, 'call_today_cta');

	// Get current page slug
	$page_slug = $post ? $post->post_name : '';

	// Get first category slug (or empty if none)
	$category_slug = '';
	$categories = get_the_category($post->ID);
	if (!empty($categories) && !is_wp_error($categories)) {
		$category_slug = $categories[0]->slug;
	}

	// Build URL
	$cta_url = 'tel:855-599-3110';

	// Output HTML
	ob_start();
	?>
	<div class="call-today-cta">
		<div class="call-today-cta__inner">
			<span class="call-today-cta__inner__heading"><?php echo esc_html($atts['headline']); ?></span>
			<p><?php echo esc_html($atts['paragraph']); ?></p>
			<div class="btn-container btn-container--left">
				<a href="<?php echo esc_url($cta_url); ?>" target="_blank" class="btn btn--secondary">Call Today</a>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('call_today_cta', 'call_today_cta_shortcode');



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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

