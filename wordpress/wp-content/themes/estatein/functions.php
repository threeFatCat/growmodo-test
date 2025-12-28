<?php
if (!defined('ABSPATH')) {
    exit;
}

define('ESTATEIN_VERSION', '1.0.0');
define('ESTATEIN_THEME_DIR', get_template_directory());
define('ESTATEIN_THEME_URI', get_template_directory_uri());


function estatein_setup() {
    load_theme_textdomain('estatein', ESTATEIN_THEME_DIR . '/languages');
    
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    
    // Register custom image sizes
    add_image_size('estatein-property-large', 800, 600, true);
    add_image_size('estatein-property-thumb', 400, 300, true);
    add_image_size('estatein-hero', 1920, 1080, true);
    
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('customize-selective-refresh-widgets');
    
    // Enable SVG upload support
    function estatein_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter('upload_mimes', 'estatein_mime_types');
    
    function estatein_fix_svg_thumb_display() {
        echo '<style>
            td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
                width: 100% !important;
                height: auto !important;
            }
        </style>';
    }
    add_action('admin_head', 'estatein_fix_svg_thumb_display');
    
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'estatein'),
        'footer'  => esc_html__('Footer Menu', 'estatein'),
    ));
}
add_action('after_setup_theme', 'estatein_setup');

function estatein_content_width() {
    $GLOBALS['content_width'] = apply_filters('estatein_content_width', 1200);
}
add_action('after_setup_theme', 'estatein_content_width', 0);

function estatein_scripts() {
    // Preconnect to Google Fonts for better performance
    add_action('wp_head', function() {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    }, 1);
    
    wp_enqueue_style('estatein-google-fonts', 'https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700;800;900&display=swap', array(), null);
    
    wp_enqueue_style('estatein-style', get_stylesheet_uri(), array('estatein-google-fonts'), ESTATEIN_VERSION);
    wp_enqueue_style('estatein-main', ESTATEIN_THEME_URI . '/assets/css/main.css', array('estatein-google-fonts'), ESTATEIN_VERSION);
    
    wp_enqueue_script('estatein-main', ESTATEIN_THEME_URI . '/assets/js/main.js', array(), ESTATEIN_VERSION, true);
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'estatein_scripts');

function estatein_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'estatein'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'estatein'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'estatein_widgets_init');

function estatein_newsletter_handler() {
    // Security check: Verify nonce
    if (!isset($_POST['estatein_newsletter_nonce']) || 
        !wp_verify_nonce($_POST['estatein_newsletter_nonce'], 'estatein_newsletter')) {
        wp_die(__('Security check failed. Please try again.', 'estatein'));
    }
    
    if (!isset($_POST['email']) || !is_email($_POST['email'])) {
        wp_redirect(home_url('/?newsletter=error'));
        exit;
    }

    $email = sanitize_email($_POST['email']);
    
    $to = get_option('admin_email');
    $subject = __('New Newsletter Subscription', 'estatein');
    $message = sprintf(__('New newsletter subscription from: %s', 'estatein'), $email);
    $headers = array('Content-Type: text/html; charset=UTF-8');

    wp_mail($to, $subject, $message, $headers);
    
    wp_redirect(home_url('/?newsletter=success'));
    exit;
}
add_action('admin_post_estatein_newsletter', 'estatein_newsletter_handler');
add_action('admin_post_nopriv_estatein_newsletter', 'estatein_newsletter_handler');

// Register Property Custom Post Type
function estatein_register_property_post_type() {
    $labels = array(
        'name'                  => _x('Properties', 'Post Type General Name', 'estatein'),
        'singular_name'         => _x('Property', 'Post Type Singular Name', 'estatein'),
        'menu_name'             => __('Properties', 'estatein'),
        'name_admin_bar'        => __('Property', 'estatein'),
        'archives'              => __('Property Archives', 'estatein'),
        'attributes'            => __('Property Attributes', 'estatein'),
        'parent_item_colon'     => __('Parent Property:', 'estatein'),
        'all_items'             => __('All Properties', 'estatein'),
        'add_new_item'          => __('Add New Property', 'estatein'),
        'add_new'               => __('Add New', 'estatein'),
        'new_item'              => __('New Property', 'estatein'),
        'edit_item'             => __('Edit Property', 'estatein'),
        'update_item'           => __('Update Property', 'estatein'),
        'view_item'             => __('View Property', 'estatein'),
        'view_items'            => __('View Properties', 'estatein'),
        'search_items'          => __('Search Property', 'estatein'),
        'not_found'             => __('Not found', 'estatein'),
        'not_found_in_trash'    => __('Not found in Trash', 'estatein'),
        'featured_image'        => __('Property Image', 'estatein'),
        'set_featured_image'    => __('Set property image', 'estatein'),
        'remove_featured_image' => __('Remove property image', 'estatein'),
        'use_featured_image'    => __('Use as property image', 'estatein'),
        'insert_into_item'       => __('Insert into property', 'estatein'),
        'uploaded_to_this_item' => __('Uploaded to this property', 'estatein'),
        'items_list'             => __('Properties list', 'estatein'),
        'items_list_navigation' => __('Properties list navigation', 'estatein'),
        'filter_items_list'     => __('Filter properties list', 'estatein'),
    );
    $args = array(
        'label'                 => __('Property', 'estatein'),
        'description'           => __('Property listings', 'estatein'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-building',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'      => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'  => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type('property', $args);
}
add_action('init', 'estatein_register_property_post_type', 0);

// Register Testimonial Custom Post Type
function estatein_register_testimonial_post_type() {
    $labels = array(
        'name'                  => _x('Testimonials', 'Post Type General Name', 'estatein'),
        'singular_name'         => _x('Testimonial', 'Post Type Singular Name', 'estatein'),
        'menu_name'             => __('Testimonials', 'estatein'),
        'name_admin_bar'        => __('Testimonial', 'estatein'),
        'archives'              => __('Testimonial Archives', 'estatein'),
        'attributes'            => __('Testimonial Attributes', 'estatein'),
        'parent_item_colon'     => __('Parent Testimonial:', 'estatein'),
        'all_items'             => __('All Testimonials', 'estatein'),
        'add_new_item'          => __('Add New Testimonial', 'estatein'),
        'add_new'               => __('Add New', 'estatein'),
        'new_item'              => __('New Testimonial', 'estatein'),
        'edit_item'             => __('Edit Testimonial', 'estatein'),
        'update_item'           => __('Update Testimonial', 'estatein'),
        'view_item'             => __('View Testimonial', 'estatein'),
        'view_items'            => __('View Testimonials', 'estatein'),
        'search_items'          => __('Search Testimonial', 'estatein'),
        'not_found'             => __('Not found', 'estatein'),
        'not_found_in_trash'    => __('Not found in Trash', 'estatein'),
        'featured_image'        => __('Client Avatar', 'estatein'),
        'set_featured_image'    => __('Set client avatar', 'estatein'),
        'remove_featured_image' => __('Remove client avatar', 'estatein'),
        'use_featured_image'    => __('Use as client avatar', 'estatein'),
        'insert_into_item'       => __('Insert into testimonial', 'estatein'),
        'uploaded_to_this_item' => __('Uploaded to this testimonial', 'estatein'),
        'items_list'             => __('Testimonials list', 'estatein'),
        'items_list_navigation' => __('Testimonials list navigation', 'estatein'),
        'filter_items_list'     => __('Filter testimonials list', 'estatein'),
    );
    $args = array(
        'label'                 => __('Testimonial', 'estatein'),
        'description'           => __('Client testimonials', 'estatein'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-testimonial',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type('testimonial', $args);
}
add_action('init', 'estatein_register_testimonial_post_type', 0);

// Check for ACF plugin dependency
if (!function_exists('get_field')) {
    add_action('admin_notices', function() {
        ?>
        <div class="notice notice-error">
            <p><strong><?php esc_html_e('Estatein Theme', 'estatein'); ?>:</strong> <?php esc_html_e('This theme requires the Advanced Custom Fields (ACF) plugin to function properly. Please install and activate it.', 'estatein'); ?></p>
        </div>
        <?php
    });
} else {
    require_once ESTATEIN_THEME_DIR . '/inc/acf-fields.php';
}

require_once ESTATEIN_THEME_DIR . '/inc/template-functions.php';
require_once ESTATEIN_THEME_DIR . '/inc/schema-markup.php';

/**
 * Add current-menu-item class to custom menu items that match post type archives
 * Using wp_nav_menu_objects filter which runs earlier and allows us to modify the item object
 */
function estatein_nav_menu_objects($sorted_menu_items, $args) {
    // Only process primary menu
    if (isset($args->theme_location) && $args->theme_location !== 'primary') {
        return $sorted_menu_items;
    }
    
    // Check if we're on a post type archive page
    if (is_post_type_archive()) {
        $post_type = get_query_var('post_type');
        if (is_array($post_type)) {
            $post_type = reset($post_type);
        }
        
        if ($post_type) {
            // Get the archive URL for this post type
            $archive_url = get_post_type_archive_link($post_type);
            
            if ($archive_url) {
                // Normalize archive URL path
                $archive_path = untrailingslashit(parse_url($archive_url, PHP_URL_PATH));
                $archive_path_no_slash = ltrim($archive_path, '/');
                
                // Get current request path
                $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
                $current_path = untrailingslashit(parse_url($request_uri, PHP_URL_PATH));
                $current_path_no_slash = ltrim($current_path, '/');
                
                foreach ($sorted_menu_items as $item) {
                    // Skip if already marked as current
                    if (in_array('current-menu-item', $item->classes)) {
                        continue;
                    }
                    
                    // Normalize menu item URL path
                    $item_path = untrailingslashit(parse_url($item->url, PHP_URL_PATH));
                    $item_path_no_slash = ltrim($item_path, '/');
                    
                    // Multiple comparison methods
                    $matches = false;
                    
                    // Direct path comparison
                    if ($item_path === $archive_path || $item_path === $current_path) {
                        $matches = true;
                    }
                    
                    // Path without leading slash
                    if ($item_path_no_slash === $archive_path_no_slash || $item_path_no_slash === $current_path_no_slash) {
                        $matches = true;
                    }
                    
                    // Check if URL contains post type slug
                    if (strpos($item->url, '/' . $post_type) !== false || 
                        strpos($item->url, $post_type . '/') !== false ||
                        $item_path === '/' . $post_type) {
                        $matches = true;
                    }
                    
                    // Full URL comparison (normalized)
                    $item_url_normalized = untrailingslashit(str_replace(array('http://', 'https://'), '', $item->url));
                    $archive_url_normalized = untrailingslashit(str_replace(array('http://', 'https://'), '', $archive_url));
                    if ($item_url_normalized === $archive_url_normalized) {
                        $matches = true;
                    }
                    
                    if ($matches) {
                        $item->classes[] = 'current-menu-item';
                        $item->current = true;
                    }
                }
            }
        }
    }
    
    // Also check for single post type pages (add ancestor class)
    if (is_singular('property') || is_singular('testimonial')) {
        $post_type = get_post_type();
        $archive_url = get_post_type_archive_link($post_type);
        
        if ($archive_url) {
            $archive_path = untrailingslashit(parse_url($archive_url, PHP_URL_PATH));
            $archive_path_no_slash = ltrim($archive_path, '/');
            
            foreach ($sorted_menu_items as $item) {
                if (in_array('current-menu-ancestor', $item->classes)) {
                    continue;
                }
                
                $item_path = untrailingslashit(parse_url($item->url, PHP_URL_PATH));
                $item_path_no_slash = ltrim($item_path, '/');
                
                $matches = false;
                
                if ($item_path === $archive_path || 
                    $item_path_no_slash === $archive_path_no_slash ||
                    strpos($item->url, '/' . $post_type) !== false ||
                    $item_path === '/' . $post_type) {
                    $matches = true;
                }
                
                if ($matches) {
                    $item->classes[] = 'current-menu-ancestor';
                }
            }
        }
    }
    
    return $sorted_menu_items;
}
add_filter('wp_nav_menu_objects', 'estatein_nav_menu_objects', 10, 2);

/**
 * Fallback: Also use nav_menu_css_class filter as backup
 */
function estatein_nav_menu_css_class($classes, $item) {
    // Check if we're on a post type archive page
    if (is_post_type_archive()) {
        $post_type = get_query_var('post_type');
        if (is_array($post_type)) {
            $post_type = reset($post_type);
        }
        
        if ($post_type) {
            // Get the archive URL for this post type
            $archive_url = get_post_type_archive_link($post_type);
            
            if ($archive_url) {
                // Normalize URLs - remove scheme and trailing slashes
                $item_url_normalized = untrailingslashit(str_replace(array('http://', 'https://'), '', $item->url));
                $archive_url_normalized = untrailingslashit(str_replace(array('http://', 'https://'), '', $archive_url));
                
                // Get paths
                $item_path = untrailingslashit(parse_url($item->url, PHP_URL_PATH));
                $archive_path = untrailingslashit(parse_url($archive_url, PHP_URL_PATH));
                
                // Get current request URI
                $current_uri = untrailingslashit($_SERVER['REQUEST_URI']);
                $current_path = untrailingslashit(parse_url($current_uri, PHP_URL_PATH));
                
                // Multiple comparison methods
                if ($item_url_normalized === $archive_url_normalized || 
                    $item_path === $archive_path || 
                    $item_path === $current_path ||
                    $item_path === '/' . $post_type ||
                    strpos($item->url, '/' . $post_type) !== false) {
                    $classes[] = 'current-menu-item';
                }
            }
        }
    }
    
    // Also check for single post type pages (add ancestor class)
    if (is_singular('property') || is_singular('testimonial')) {
        $post_type = get_post_type();
        $archive_url = get_post_type_archive_link($post_type);
        
        if ($archive_url) {
            $item_url_normalized = untrailingslashit(str_replace(array('http://', 'https://'), '', $item->url));
            $archive_url_normalized = untrailingslashit(str_replace(array('http://', 'https://'), '', $archive_url));
            
            $item_path = untrailingslashit(parse_url($item->url, PHP_URL_PATH));
            $archive_path = untrailingslashit(parse_url($archive_url, PHP_URL_PATH));
            
            if ($item_url_normalized === $archive_url_normalized || 
                $item_path === $archive_path || 
                $item_path === '/' . $post_type ||
                strpos($item->url, '/' . $post_type) !== false) {
                $classes[] = 'current-menu-ancestor';
            }
        }
    }
    
    return $classes;
}
add_filter('nav_menu_css_class', 'estatein_nav_menu_css_class', 20, 2);

/**
 * Add SEO meta tags (description, Open Graph)
 */
function estatein_seo_meta_tags() {
    if (is_singular()) {
        $description = get_the_excerpt() ?: wp_trim_words(get_the_content(), 30);
        $title = get_the_title();
        $url = get_permalink();
        $image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : '';
    } elseif (is_archive()) {
        $description = get_the_archive_description() ?: wp_trim_words(get_the_archive_title(), 30);
        $title = get_the_archive_title();
        $url = get_term_link(get_queried_object()) ?: get_post_type_archive_link(get_post_type());
        $image = '';
    } elseif (is_home() || is_front_page()) {
        $description = get_bloginfo('description');
        $title = get_bloginfo('name');
        $url = home_url('/');
        $image = '';
    } else {
        $description = get_bloginfo('description');
        $title = get_bloginfo('name');
        $url = home_url('/');
        $image = '';
    }
    
    // Clean up description
    $description = wp_strip_all_tags($description);
    $description = esc_attr(wp_trim_words($description, 30));
    
    // Meta description
    if ($description) {
        echo '<meta name="description" content="' . $description . '">' . "\n";
    }
    
    // Open Graph tags
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    if ($description) {
        echo '<meta property="og:description" content="' . $description . '">' . "\n";
    }
    echo '<meta property="og:type" content="' . (is_singular() ? 'article' : 'website') . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    if ($image) {
        echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    }
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
}
add_action('wp_head', 'estatein_seo_meta_tags', 2);
