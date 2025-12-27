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

require_once ESTATEIN_THEME_DIR . '/inc/acf-fields.php';
require_once ESTATEIN_THEME_DIR . '/inc/template-functions.php';

