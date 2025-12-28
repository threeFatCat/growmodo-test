<?php
// Custom post types and taxonomies will be added here as needed during development

// Register ACF Field Group for Hero Section
// Note: Free ACF doesn't support Options Pages, so fields are assigned to Front Page
// Users can edit the Front Page to modify hero content
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_hero_section',
        'title' => __('Hero Section', 'estatein'),
        'fields' => array(
            array(
                'key' => 'field_hero_title',
                'label' => __('Hero Title', 'estatein'),
                'name' => 'hero_title',
                'type' => 'text',
                'default_value' => __('Discover Your Dream Property with Estatein', 'estatein'),
                'placeholder' => __('Enter hero title...', 'estatein'),
            ),
            array(
                'key' => 'field_hero_subtitle',
                'label' => __('Hero Subtitle', 'estatein'),
                'name' => 'hero_subtitle',
                'type' => 'textarea',
                'default_value' => __('Your journey to finding the perfect property begins here. Explore our listings to find the home that matches your dreams.', 'estatein'),
                'placeholder' => __('Enter hero subtitle...', 'estatein'),
                'rows' => 3,
            ),
            array(
                'key' => 'field_hero_learn_more_text',
                'label' => __('Learn More Button Text', 'estatein'),
                'name' => 'hero_learn_more_text',
                'type' => 'text',
                'default_value' => __('Learn More', 'estatein'),
            ),
            array(
                'key' => 'field_hero_learn_more_url',
                'label' => __('Learn More Button URL', 'estatein'),
                'name' => 'hero_learn_more_url',
                'type' => 'url',
                'default_value' => '#',
            ),
            array(
                'key' => 'field_hero_browse_text',
                'label' => __('Browse Properties Button Text', 'estatein'),
                'name' => 'hero_browse_text',
                'type' => 'text',
                'default_value' => __('Browse Properties', 'estatein'),
            ),
            array(
                'key' => 'field_hero_browse_url',
                'label' => __('Browse Properties Button URL', 'estatein'),
                'name' => 'hero_browse_url',
                'type' => 'url',
                'default_value' => home_url('/properties'),
            ),
            array(
                'key' => 'field_hero_image',
                'label' => __('Hero Image', 'estatein'),
                'name' => 'hero_image',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_hero_stats_heading',
                'label' => __('Statistics', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => __('Configure the three statistics displayed in the hero section.', 'estatein'),
            ),
            array(
                'key' => 'field_hero_stat_1_number',
                'label' => __('Stat 1 - Number', 'estatein'),
                'name' => 'hero_stat_1_number',
                'type' => 'text',
                'default_value' => '200+',
            ),
            array(
                'key' => 'field_hero_stat_1_label',
                'label' => __('Stat 1 - Label', 'estatein'),
                'name' => 'hero_stat_1_label',
                'type' => 'text',
                'default_value' => __('Happy Customers', 'estatein'),
            ),
            array(
                'key' => 'field_hero_stat_2_number',
                'label' => __('Stat 2 - Number', 'estatein'),
                'name' => 'hero_stat_2_number',
                'type' => 'text',
                'default_value' => '10k+',
            ),
            array(
                'key' => 'field_hero_stat_2_label',
                'label' => __('Stat 2 - Label', 'estatein'),
                'name' => 'hero_stat_2_label',
                'type' => 'text',
                'default_value' => __('Properties For Clients', 'estatein'),
            ),
            array(
                'key' => 'field_hero_stat_3_number',
                'label' => __('Stat 3 - Number', 'estatein'),
                'name' => 'hero_stat_3_number',
                'type' => 'text',
                'default_value' => '16+',
            ),
            array(
                'key' => 'field_hero_stat_3_label',
                'label' => __('Stat 3 - Label', 'estatein'),
                'name' => 'hero_stat_3_label',
                'type' => 'text',
                'default_value' => __('Years of Experience', 'estatein'),
            ),
            array(
                'key' => 'field_hero_floating_cta_heading',
                'label' => __('Floating CTA', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => __('Add a floating circular CTA button that appears in the hero section.', 'estatein'),
            ),
            array(
                'key' => 'field_hero_floating_cta_enabled',
                'label' => __('Enable Floating CTA', 'estatein'),
                'name' => 'hero_floating_cta_enabled',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ),
            array(
                'key' => 'field_hero_floating_cta_image',
                'label' => __('Floating CTA Image', 'estatein'),
                'name' => 'hero_floating_cta_image',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_hero_floating_cta_enabled',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'instructions' => __('Upload an image for the floating CTA. PNG, JPG, or SVG formats are supported. Recommended size: 129x129px or larger.', 'estatein'),
            ),
            array(
                'key' => 'field_hero_floating_cta_link',
                'label' => __('Floating CTA Link', 'estatein'),
                'name' => 'hero_floating_cta_link',
                'type' => 'url',
                'default_value' => '#',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_hero_floating_cta_enabled',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
    ));
    // Features Section
    acf_add_local_field_group(array(
        'key' => 'group_features_section',
        'title' => __('Features Section', 'estatein'),
        'fields' => array(
            array(
                'key' => 'field_features_info',
                'label' => __('Features', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => __('Configure up to 4 features. Upload an icon image (PNG, JPG, or SVG) for each feature. Recommended size: 24x24px.', 'estatein'),
            ),
            // Feature 1
            array(
                'key' => 'field_feature_1_heading',
                'label' => __('Feature 1', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => '',
            ),
            array(
                'key' => 'field_feature_1_icon_image',
                'label' => __('Feature 1 - Icon Image', 'estatein'),
                'name' => 'feature_1_icon_image',
                'type' => 'image',
                'instructions' => __('Upload an icon image (PNG, JPG, or SVG). Recommended size: 24x24px.', 'estatein'),
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_feature_1_title',
                'label' => __('Feature 1 - Title', 'estatein'),
                'name' => 'feature_1_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_feature_1_link',
                'label' => __('Feature 1 - Link URL', 'estatein'),
                'name' => 'feature_1_link',
                'type' => 'url',
                'default_value' => '#',
            ),
            // Feature 2
            array(
                'key' => 'field_feature_2_heading',
                'label' => __('Feature 2', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => '',
            ),
            array(
                'key' => 'field_feature_2_icon_image',
                'label' => __('Feature 2 - Icon Image', 'estatein'),
                'name' => 'feature_2_icon_image',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_feature_2_title',
                'label' => __('Feature 2 - Title', 'estatein'),
                'name' => 'feature_2_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_feature_2_link',
                'label' => __('Feature 2 - Link URL', 'estatein'),
                'name' => 'feature_2_link',
                'type' => 'url',
                'default_value' => '#',
            ),
            // Feature 3
            array(
                'key' => 'field_feature_3_heading',
                'label' => __('Feature 3', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => '',
            ),
            array(
                'key' => 'field_feature_3_icon_image',
                'label' => __('Feature 3 - Icon Image', 'estatein'),
                'name' => 'feature_3_icon_image',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_feature_3_title',
                'label' => __('Feature 3 - Title', 'estatein'),
                'name' => 'feature_3_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_feature_3_link',
                'label' => __('Feature 3 - Link URL', 'estatein'),
                'name' => 'feature_3_link',
                'type' => 'url',
                'default_value' => '#',
            ),
            // Feature 4
            array(
                'key' => 'field_feature_4_heading',
                'label' => __('Feature 4', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => '',
            ),
            array(
                'key' => 'field_feature_4_icon_image',
                'label' => __('Feature 4 - Icon Image', 'estatein'),
                'name' => 'feature_4_icon_image',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array(
                'key' => 'field_feature_4_title',
                'label' => __('Feature 4 - Title', 'estatein'),
                'name' => 'feature_4_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_feature_4_link',
                'label' => __('Feature 4 - Link URL', 'estatein'),
                'name' => 'feature_4_link',
                'type' => 'url',
                'default_value' => '#',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    // Properties Section
    acf_add_local_field_group(array(
        'key' => 'group_properties_section',
        'title' => __('Properties Section', 'estatein'),
        'fields' => array(
            array(
                'key' => 'field_properties_section_title',
                'label' => __('Section Title', 'estatein'),
                'name' => 'properties_section_title',
                'type' => 'text',
                'default_value' => __('Featured Properties', 'estatein'),
            ),
            array(
                'key' => 'field_properties_section_description',
                'label' => __('Section Description', 'estatein'),
                'name' => 'properties_section_description',
                'type' => 'textarea',
                'default_value' => __('Explore our handpicked selection of featured properties. Each listing offers a glimpse into exceptional homes and investments available through Estatein. Click \'View Details\' for more information.', 'estatein'),
                'rows' => 3,
            ),
            array(
                'key' => 'field_properties_view_all_url',
                'label' => __('View All Properties Button URL', 'estatein'),
                'name' => 'properties_view_all_url',
                'type' => 'url',
                'default_value' => '#',
            ),
            array(
                'key' => 'field_properties_info',
                'label' => __('Properties', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => __('Configure up to 3 featured properties. Each property requires an image, title, description, and details.', 'estatein'),
            ),
            // Property 1
            array(
                'key' => 'field_property_1_heading',
                'label' => __('Property 1', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => '',
            ),
            array(
                'key' => 'field_property_1_image',
                'label' => __('Property 1 - Image', 'estatein'),
                'name' => 'property_1_image',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_property_1_title',
                'label' => __('Property 1 - Title', 'estatein'),
                'name' => 'property_1_title',
                'type' => 'text',
                'default_value' => __('Seaside Serenity Villa', 'estatein'),
            ),
            array(
                'key' => 'field_property_1_description',
                'label' => __('Property 1 - Description', 'estatein'),
                'name' => 'property_1_description',
                'type' => 'textarea',
                'default_value' => __('A stunning 4-bedroom, 3-bathroom villa in a peaceful suburban neighborhood... Read More', 'estatein'),
                'rows' => 3,
            ),
            array(
                'key' => 'field_property_1_bedrooms',
                'label' => __('Property 1 - Bedrooms', 'estatein'),
                'name' => 'property_1_bedrooms',
                'type' => 'text',
                'default_value' => '4',
            ),
            array(
                'key' => 'field_property_1_bathrooms',
                'label' => __('Property 1 - Bathrooms', 'estatein'),
                'name' => 'property_1_bathrooms',
                'type' => 'text',
                'default_value' => '3',
            ),
            array(
                'key' => 'field_property_1_type',
                'label' => __('Property 1 - Property Type', 'estatein'),
                'name' => 'property_1_type',
                'type' => 'text',
                'default_value' => __('Villa', 'estatein'),
            ),
            array(
                'key' => 'field_property_1_price',
                'label' => __('Property 1 - Price', 'estatein'),
                'name' => 'property_1_price',
                'type' => 'text',
                'default_value' => '550,000',
            ),
            array(
                'key' => 'field_property_1_link',
                'label' => __('Property 1 - Link URL', 'estatein'),
                'name' => 'property_1_link',
                'type' => 'url',
                'default_value' => '#',
            ),
            // Property 2
            array(
                'key' => 'field_property_2_heading',
                'label' => __('Property 2', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => '',
            ),
            array(
                'key' => 'field_property_2_image',
                'label' => __('Property 2 - Image', 'estatein'),
                'name' => 'property_2_image',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_property_2_title',
                'label' => __('Property 2 - Title', 'estatein'),
                'name' => 'property_2_title',
                'type' => 'text',
                'default_value' => __('Metropolitan Haven', 'estatein'),
            ),
            array(
                'key' => 'field_property_2_description',
                'label' => __('Property 2 - Description', 'estatein'),
                'name' => 'property_2_description',
                'type' => 'textarea',
                'default_value' => __('A chic and fully-furnished 2-bedroom apartment with panoramic city views... Read More', 'estatein'),
                'rows' => 3,
            ),
            array(
                'key' => 'field_property_2_bedrooms',
                'label' => __('Property 2 - Bedrooms', 'estatein'),
                'name' => 'property_2_bedrooms',
                'type' => 'text',
                'default_value' => '2',
            ),
            array(
                'key' => 'field_property_2_bathrooms',
                'label' => __('Property 2 - Bathrooms', 'estatein'),
                'name' => 'property_2_bathrooms',
                'type' => 'text',
                'default_value' => '2',
            ),
            array(
                'key' => 'field_property_2_type',
                'label' => __('Property 2 - Property Type', 'estatein'),
                'name' => 'property_2_type',
                'type' => 'text',
                'default_value' => __('Villa', 'estatein'),
            ),
            array(
                'key' => 'field_property_2_price',
                'label' => __('Property 2 - Price', 'estatein'),
                'name' => 'property_2_price',
                'type' => 'text',
                'default_value' => '550,000',
            ),
            array(
                'key' => 'field_property_2_link',
                'label' => __('Property 2 - Link URL', 'estatein'),
                'name' => 'property_2_link',
                'type' => 'url',
                'default_value' => '#',
            ),
            // Property 3
            array(
                'key' => 'field_property_3_heading',
                'label' => __('Property 3', 'estatein'),
                'name' => '',
                'type' => 'message',
                'message' => '',
            ),
            array(
                'key' => 'field_property_3_image',
                'label' => __('Property 3 - Image', 'estatein'),
                'name' => 'property_3_image',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_property_3_title',
                'label' => __('Property 3 - Title', 'estatein'),
                'name' => 'property_3_title',
                'type' => 'text',
                'default_value' => __('Rustic Retreat Cottage', 'estatein'),
            ),
            array(
                'key' => 'field_property_3_description',
                'label' => __('Property 3 - Description', 'estatein'),
                'name' => 'property_3_description',
                'type' => 'textarea',
                'default_value' => __('An elegant 3-bedroom, 2.5-bathroom townhouse in a gated community... Read More', 'estatein'),
                'rows' => 3,
            ),
            array(
                'key' => 'field_property_3_bedrooms',
                'label' => __('Property 3 - Bedrooms', 'estatein'),
                'name' => 'property_3_bedrooms',
                'type' => 'text',
                'default_value' => '3',
            ),
            array(
                'key' => 'field_property_3_bathrooms',
                'label' => __('Property 3 - Bathrooms', 'estatein'),
                'name' => 'property_3_bathrooms',
                'type' => 'text',
                'default_value' => '3',
            ),
            array(
                'key' => 'field_property_3_type',
                'label' => __('Property 3 - Property Type', 'estatein'),
                'name' => 'property_3_type',
                'type' => 'text',
                'default_value' => __('Villa', 'estatein'),
            ),
            array(
                'key' => 'field_property_3_price',
                'label' => __('Property 3 - Price', 'estatein'),
                'name' => 'property_3_price',
                'type' => 'text',
                'default_value' => '550,000',
            ),
            array(
                'key' => 'field_property_3_link',
                'label' => __('Property 3 - Link URL', 'estatein'),
                'name' => 'property_3_link',
                'type' => 'url',
                'default_value' => '#',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    // Property Post Type Fields
    acf_add_local_field_group(array(
        'key' => 'group_property_fields',
        'title' => __('Property Details', 'estatein'),
        'fields' => array(
            array(
                'key' => 'field_property_bedrooms',
                'label' => __('Bedrooms', 'estatein'),
                'name' => 'property_bedrooms',
                'type' => 'text',
                'placeholder' => __('e.g., 4', 'estatein'),
            ),
            array(
                'key' => 'field_property_bathrooms',
                'label' => __('Bathrooms', 'estatein'),
                'name' => 'property_bathrooms',
                'type' => 'text',
                'placeholder' => __('e.g., 3', 'estatein'),
            ),
            array(
                'key' => 'field_property_type',
                'label' => __('Property Type', 'estatein'),
                'name' => 'property_type',
                'type' => 'text',
                'placeholder' => __('e.g., Villa, Apartment, House', 'estatein'),
            ),
            array(
                'key' => 'field_property_price',
                'label' => __('Price', 'estatein'),
                'name' => 'property_price',
                'type' => 'text',
                'placeholder' => __('e.g., 550,000', 'estatein'),
                'instructions' => __('Enter price without currency symbol (e.g., 550,000)', 'estatein'),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'property',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    // Testimonials Section Settings (Front Page Only)
    acf_add_local_field_group(array(
        'key' => 'group_testimonials_section_settings',
        'title' => __('Testimonials Section Settings', 'estatein'),
        'fields' => array(
            array(
                'key' => 'field_testimonials_section_title',
                'label' => __('Section Title', 'estatein'),
                'name' => 'testimonials_section_title',
                'type' => 'text',
                'default_value' => __('What Our Clients Say', 'estatein'),
            ),
            array(
                'key' => 'field_testimonials_section_description',
                'label' => __('Section Description', 'estatein'),
                'name' => 'testimonials_section_description',
                'type' => 'textarea',
                'default_value' => __('Read the success stories and heartfelt testimonials from our valued clients. Discover why they chose Estatein for their real estate needs.', 'estatein'),
                'rows' => 3,
            ),
            array(
                'key' => 'field_testimonials_view_all_url',
                'label' => __('View All Testimonials Button URL', 'estatein'),
                'name' => 'testimonials_view_all_url',
                'type' => 'url',
                'default_value' => '#',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
        'menu_order' => 3,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    // Testimonial Post Type Fields
    acf_add_local_field_group(array(
        'key' => 'group_testimonial_fields',
        'title' => __('Testimonial Details', 'estatein'),
        'fields' => array(
            array(
                'key' => 'field_testimonial_rating',
                'label' => __('Rating', 'estatein'),
                'name' => 'testimonial_rating',
                'type' => 'number',
                'default_value' => 5,
                'min' => 1,
                'max' => 5,
                'instructions' => __('Rate from 1 to 5 stars', 'estatein'),
            ),
            array(
                'key' => 'field_testimonial_client_name',
                'label' => __('Client Name', 'estatein'),
                'name' => 'testimonial_client_name',
                'type' => 'text',
                'placeholder' => __('e.g., John Doe', 'estatein'),
            ),
            array(
                'key' => 'field_testimonial_client_location',
                'label' => __('Client Location', 'estatein'),
                'name' => 'testimonial_client_location',
                'type' => 'text',
                'placeholder' => __('e.g., USA, California', 'estatein'),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'testimonial',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    // About Page Hero Section
    acf_add_local_field_group(array(
        'key' => 'group_about_hero_section',
        'title' => __('About Page Hero Section', 'estatein'),
        'fields' => array(
            array(
                'key' => 'field_about_hero_title',
                'label' => __('Title', 'estatein'),
                'name' => 'about_hero_title',
                'type' => 'text',
                'default_value' => __('Our Journey', 'estatein'),
                'placeholder' => __('Enter title...', 'estatein'),
            ),
            array(
                'key' => 'field_about_hero_description',
                'label' => __('Description', 'estatein'),
                'name' => 'about_hero_description',
                'type' => 'textarea',
                'default_value' => __('Our story is one of continuous growth and evolution. We started as a small team with big dreams, determined to create a real estate platform that transcended the ordinary. Over the years, we\'ve expanded our reach, forged valuable partnerships, and gained the trust of countless clients.', 'estatein'),
                'placeholder' => __('Enter description...', 'estatein'),
                'rows' => 4,
            ),
            array(
                'key' => 'field_about_hero_image',
                'label' => __('Hero Image', 'estatein'),
                'name' => 'about_hero_image',
                'type' => 'image',
                'instructions' => __('Upload the hero image (hand holding house model)', 'estatein'),
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_about_stat_1_number',
                'label' => __('Statistic 1 - Number', 'estatein'),
                'name' => 'about_stat_1_number',
                'type' => 'text',
                'default_value' => '200+',
            ),
            array(
                'key' => 'field_about_stat_1_label',
                'label' => __('Statistic 1 - Label', 'estatein'),
                'name' => 'about_stat_1_label',
                'type' => 'text',
                'default_value' => __('Happy Customers', 'estatein'),
            ),
            array(
                'key' => 'field_about_stat_2_number',
                'label' => __('Statistic 2 - Number', 'estatein'),
                'name' => 'about_stat_2_number',
                'type' => 'text',
                'default_value' => '10k+',
            ),
            array(
                'key' => 'field_about_stat_2_label',
                'label' => __('Statistic 2 - Label', 'estatein'),
                'name' => 'about_stat_2_label',
                'type' => 'text',
                'default_value' => __('Properties For Clients', 'estatein'),
            ),
            array(
                'key' => 'field_about_stat_3_number',
                'label' => __('Statistic 3 - Number', 'estatein'),
                'name' => 'about_stat_3_number',
                'type' => 'text',
                'default_value' => '16+',
            ),
            array(
                'key' => 'field_about_stat_3_label',
                'label' => __('Statistic 3 - Label', 'estatein'),
                'name' => 'about_stat_3_label',
                'type' => 'text',
                'default_value' => __('Years of Experience', 'estatein'),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-about-us.php',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => 'page',
                ),
                array(
                    'param' => 'page_slug',
                    'operator' => '==',
                    'value' => 'about-us',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => 'page',
                ),
                array(
                    'param' => 'page_slug',
                    'operator' => '==',
                    'value' => 'about',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
});

function estatein_add_theme_settings_page() {
    add_theme_page(
        __('Theme Settings', 'estatein'),
        __('Theme Settings', 'estatein'),
        'manage_options',
        'theme-settings',
        'estatein_theme_settings_page'
    );
}
add_action('admin_menu', 'estatein_add_theme_settings_page');

function estatein_theme_settings_page() {
    if (isset($_POST['estatein_save_settings']) && check_admin_referer('estatein_settings_nonce')) {
        $bannerEnabledValue = isset($_POST['top_banner_enabled']) ? 1 : 0;
        $bannerTextValue = isset($_POST['top_banner_text']) ? sanitize_text_field(wp_unslash($_POST['top_banner_text'])) : '';
        $bannerLinkValue = isset($_POST['top_banner_link']) ? esc_url_raw(wp_unslash($_POST['top_banner_link'])) : '#';
        $bannerLinkTextValue = isset($_POST['top_banner_link_text']) ? sanitize_text_field(wp_unslash($_POST['top_banner_link_text'])) : __('Learn More', 'estatein');
        
        update_option('top_banner_enabled', $bannerEnabledValue);
        update_option('top_banner_text', $bannerTextValue);
        update_option('top_banner_link', $bannerLinkValue);
        update_option('top_banner_link_text', $bannerLinkTextValue);
        echo '<div class="notice notice-success"><p>' . esc_html__('Settings saved!', 'estatein') . '</p></div>';
    }
    
    $bannerEnabled = get_option('top_banner_enabled', 1);
    $bannerText = get_option('top_banner_text', __('Discover Your Dream Property with Estatein', 'estatein'));
    $bannerLink = get_option('top_banner_link', '#');
    $bannerLinkText = get_option('top_banner_link_text', __('Learn More', 'estatein'));
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Theme Settings', 'estatein'); ?></h1>
        <form method="post" action="">
            <?php wp_nonce_field('estatein_settings_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="top_banner_enabled"><?php echo esc_html__('Enable Top Banner', 'estatein'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="top_banner_enabled" name="top_banner_enabled" value="1" <?php checked($bannerEnabled, 1); ?>>
                        <p class="description"><?php echo esc_html__('Show or hide the top banner on all pages', 'estatein'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="top_banner_text"><?php echo esc_html__('Banner Text', 'estatein'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="top_banner_text" name="top_banner_text" value="<?php echo esc_attr($bannerText); ?>" class="regular-text" placeholder="<?php echo esc_attr__('Enter banner text...', 'estatein'); ?>">
                        <p class="description"><?php echo esc_html__('Enter the text to display in the top banner', 'estatein'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="top_banner_link"><?php echo esc_html__('Banner Link URL', 'estatein'); ?></label>
                    </th>
                    <td>
                        <input type="url" id="top_banner_link" name="top_banner_link" value="<?php echo esc_attr($bannerLink); ?>" class="regular-text" placeholder="#">
                        <p class="description"><?php echo esc_html__('URL where the banner should link to', 'estatein'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="top_banner_link_text"><?php echo esc_html__('Banner Link Text', 'estatein'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="top_banner_link_text" name="top_banner_link_text" value="<?php echo esc_attr($bannerLinkText); ?>" class="regular-text" placeholder="<?php echo esc_attr__('Learn More', 'estatein'); ?>">
                        <p class="description"><?php echo esc_html__('Text for the clickable link (e.g., "Learn More")', 'estatein'); ?></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(__('Save Settings', 'estatein'), 'primary', 'estatein_save_settings'); ?>
        </form>
    </div>
    <?php
}


