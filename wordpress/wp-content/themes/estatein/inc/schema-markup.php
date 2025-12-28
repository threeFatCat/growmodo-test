<?php
/**
 * Schema.org Structured Data Markup
 * 
 * Implements JSON-LD structured data for better SEO and rich snippets
 * 
 * @package Estatein
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Output Organization Schema
 */
function estatein_schema_organization() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'logo' => has_custom_logo() ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '',
        'description' => get_bloginfo('description'),
        'sameAs' => array(
            // Add social media URLs here if available
            // 'https://www.facebook.com/estatein',
            // 'https://www.linkedin.com/company/estatein',
            // 'https://twitter.com/estatein',
        ),
    );
    
    // Remove empty logo
    if (empty($schema['logo'])) {
        unset($schema['logo']);
    }
    
    // Remove empty sameAs if no social links
    if (empty($schema['sameAs'])) {
        unset($schema['sameAs']);
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
}

/**
 * Output WebSite Schema with SearchAction
 */
function estatein_schema_website() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'description' => get_bloginfo('description'),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => array(
                '@type' => 'EntryPoint',
                'urlTemplate' => home_url('/?s={search_term_string}'),
            ),
            'query-input' => 'required name=search_term_string',
        ),
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
}

/**
 * Output RealEstateAgent Schema
 */
function estatein_schema_real_estate_agent() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'RealEstateAgent',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'logo' => has_custom_logo() ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '',
        'description' => get_bloginfo('description'),
    );
    
    // Remove empty logo
    if (empty($schema['logo'])) {
        unset($schema['logo']);
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
}

/**
 * Output Property Schema for single property posts
 */
function estatein_schema_property() {
    if (!is_singular('property')) {
        return;
    }
    
    global $post;
    
    // Get property details from ACF
    $bedrooms = get_field('property_bedrooms');
    $bathrooms = get_field('property_bathrooms');
    $property_type = get_field('property_type');
    $price = get_field('property_price');
    
    // Clean price - remove commas and currency symbols
    $price_clean = $price ? preg_replace('/[^0-9]/', '', $price) : '';
    
    // Get featured image
    $image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : '';
    
    // Build schema
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => get_the_title(),
        'description' => get_the_excerpt() ?: wp_trim_words(get_the_content(), 30),
        'image' => $image ?: '',
        'url' => get_permalink(),
        'offers' => array(
            '@type' => 'Offer',
            'price' => $price_clean ?: '0',
            'priceCurrency' => 'USD',
            'availability' => 'https://schema.org/InStock',
            'url' => get_permalink(),
        ),
        'additionalProperty' => array(),
    );
    
    // Add property-specific details
    if ($bedrooms) {
        $schema['additionalProperty'][] = array(
            '@type' => 'PropertyValue',
            'name' => 'Bedrooms',
            'value' => $bedrooms,
        );
    }
    
    if ($bathrooms) {
        $schema['additionalProperty'][] = array(
            '@type' => 'PropertyValue',
            'name' => 'Bathrooms',
            'value' => $bathrooms,
        );
    }
    
    if ($property_type) {
        $schema['additionalProperty'][] = array(
            '@type' => 'PropertyValue',
            'name' => 'Property Type',
            'value' => $property_type,
        );
    }
    
    // Add Real Estate Listing schema (more specific for real estate)
    $real_estate_schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => get_the_title(),
        'description' => get_the_excerpt() ?: wp_trim_words(get_the_content(), 30),
        'image' => $image ?: '',
        'url' => get_permalink(),
        'category' => 'Real Estate',
        'brand' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
        ),
        'offers' => array(
            '@type' => 'Offer',
            'price' => $price_clean ?: '0',
            'priceCurrency' => 'USD',
            'availability' => 'https://schema.org/InStock',
            'url' => get_permalink(),
        ),
    );
    
    // Add number of bedrooms and bathrooms
    if ($bedrooms) {
        $real_estate_schema['numberOfBedrooms'] = intval($bedrooms);
    }
    
    if ($bathrooms) {
        $real_estate_schema['numberOfBathroomsTotal'] = floatval($bathrooms);
    }
    
    // Remove empty image
    if (empty($real_estate_schema['image'])) {
        unset($real_estate_schema['image']);
    }
    
    // Remove empty offers price
    if (empty($real_estate_schema['offers']['price']) || $real_estate_schema['offers']['price'] === '0') {
        unset($real_estate_schema['offers']);
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($real_estate_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
}

/**
 * Output BreadcrumbList Schema
 */
function estatein_schema_breadcrumbs() {
    if (is_front_page()) {
        return; // No breadcrumbs on homepage
    }
    
    $breadcrumbs = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => array(),
    );
    
    $position = 1;
    
    // Home
    $breadcrumbs['itemListElement'][] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => __('Home', 'estatein'),
        'item' => home_url('/'),
    );
    
    // Archive pages
    if (is_post_type_archive('property')) {
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __('Properties', 'estatein'),
            'item' => get_post_type_archive_link('property'),
        );
    } elseif (is_post_type_archive('testimonial')) {
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __('Testimonials', 'estatein'),
            'item' => get_post_type_archive_link('testimonial'),
        );
    } elseif (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $term->name,
            'item' => get_term_link($term),
        );
    }
    
    // Single posts
    if (is_singular()) {
        global $post;
        
        // Add post type archive if it exists
        if (get_post_type_archive_link(get_post_type())) {
            $post_type_obj = get_post_type_object(get_post_type());
            $breadcrumbs['itemListElement'][] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $post_type_obj->labels->name,
                'item' => get_post_type_archive_link(get_post_type()),
            );
        }
        
        // Current page
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    }
    
    // Only output if we have more than just home
    if (count($breadcrumbs['itemListElement']) > 1) {
        echo '<script type="application/ld+json">' . wp_json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}

/**
 * Main function to output all schema markup
 */
function estatein_output_schema_markup() {
    // Organization schema - on all pages
    estatein_schema_organization();
    
    // WebSite schema - on all pages
    estatein_schema_website();
    
    // RealEstateAgent schema - on all pages (for real estate business)
    estatein_schema_real_estate_agent();
    
    // Property schema - only on single property pages
    if (is_singular('property')) {
        estatein_schema_property();
    }
    
    // Breadcrumbs - on all pages except homepage
    estatein_schema_breadcrumbs();
}
add_action('wp_head', 'estatein_output_schema_markup', 5);

