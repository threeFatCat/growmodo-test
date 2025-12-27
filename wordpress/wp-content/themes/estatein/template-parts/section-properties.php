<?php
$section_title = get_field('properties_section_title') ?: __('Featured Properties', 'estatein');
$section_description = get_field('properties_section_description') ?: __('Explore our handpicked selection of featured properties. Each listing offers a glimpse into exceptional homes and investments available through Estatein. Click \'View Details\' for more information.', 'estatein');
$view_all_url = get_field('properties_view_all_url') ?: get_post_type_archive_link('property') ?: '#';
$posts_per_page = 3; // Show 3 properties per slide

// Query property posts
$properties_query = new WP_Query(array(
    'post_type' => 'property',
    'posts_per_page' => -1, // Get all properties for slider
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
));

$total_properties = $properties_query->found_posts;
$total_slides = ceil($total_properties / $posts_per_page);
?>

<section class="properties-section">
    <div class="container">
        <div class="section-header">
            <div class="section-title-group">
                <div class="section-decorative-stars">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/diamond.svg'); ?>" alt="<?php esc_attr_e('Diamond', 'estatein'); ?>" class="decorative-diamond">
                </div>
                <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
                <p class="section-description"><?php echo esc_html($section_description); ?></p>
            </div>
            <a href="<?php echo esc_url($view_all_url); ?>" class="btn btn-secondary"><?php esc_html_e('View All Properties', 'estatein'); ?></a>
        </div>

        <?php if ($properties_query->have_posts()) : ?>
            <div class="properties-slider-wrapper">
                <div class="properties-slider" data-current-slide="1" data-total-slides="<?php echo esc_attr($total_slides); ?>" data-posts-per-slide="<?php echo esc_attr($posts_per_page); ?>">
                    <div class="properties-slider-track">
                        <?php 
                        $slide_index = 0;
                        $property_index = 0;
                        $slide_opened = false;
                        
                        while ($properties_query->have_posts()) : $properties_query->the_post();
                            // Start new slide every 3 properties
                            if ($property_index % $posts_per_page === 0) {
                                if ($slide_opened) {
                                    echo '</div>'; // Close properties-grid
                                    echo '</div>'; // Close properties-slide
                                }
                                echo '<div class="properties-slide" data-slide="' . esc_attr($slide_index + 1) . '">';
                                echo '<div class="properties-grid">';
                                $slide_index++;
                                $slide_opened = true;
                            }
                            ?>
                            <article class="property-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="property-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('large', array('class' => 'property-img')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="property-content">
                                    <div class="property-text-container">
                                        <h3 class="property-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <p class="property-excerpt"><?php 
                                            $excerpt = get_the_excerpt() ?: get_the_content();
                                            $excerpt = wp_strip_all_tags($excerpt);
                                            $excerpt = mb_substr($excerpt, 0, 75);
                                            echo esc_html($excerpt);
                                            if (mb_strlen(get_the_excerpt() ?: get_the_content()) > 75) {
                                                echo '... <a href="' . esc_url(get_permalink()) . '" class="property-read-more">' . esc_html__('Read More', 'estatein') . '</a>';
                                            }
                                        ?></p>
                                    </div>
                                    <div class="property-details">
                                        <span class="detail-item">
                                            <span class="detail-icon">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/bed.svg'); ?>" alt="<?php esc_attr_e('Bedroom', 'estatein'); ?>" width="24" height="24">
                                            </span>
                                            <span class="detail-text"><?php echo esc_html(get_field('property_bedrooms') ?: '4'); ?>-<?php esc_html_e('Bedroom', 'estatein'); ?></span>
                                        </span>
                                        <span class="detail-item">
                                            <span class="detail-icon">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/bath.svg'); ?>" alt="<?php esc_attr_e('Bathroom', 'estatein'); ?>" width="24" height="24">
                                            </span>
                                            <span class="detail-text"><?php echo esc_html(get_field('property_bathrooms') ?: '3'); ?>-<?php esc_html_e('Bathroom', 'estatein'); ?></span>
                                        </span>
                                        <span class="detail-item">
                                            <span class="detail-icon">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/building.svg'); ?>" alt="<?php esc_attr_e('Property Type', 'estatein'); ?>" width="24" height="24">
                                            </span>
                                            <span class="detail-text"><?php echo esc_html(get_field('property_type') ?: __('Villa', 'estatein')); ?></span>
                                        </span>
                                    </div>
                                    <div class="property-footer">
                                        <div class="property-price-group">
                                            <span class="property-price-label"><?php esc_html_e('Price', 'estatein'); ?></span>
                                            <span class="property-price">$<?php echo esc_html(get_field('property_price') ?: '550,000'); ?></span>
                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm"><?php esc_html_e('View Property Details', 'estatein'); ?></a>
                                    </div>
                                </div>
                            </article>
                            <?php
                            $property_index++;
                        endwhile;
                        
                        // Close the last slide if it was opened
                        if ($slide_opened) {
                            echo '</div>'; // Close properties-grid
                            echo '</div>'; // Close properties-slide
                        }
                        
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <div class="properties-pagination">
                    <span class="pagination-info">
                        <span class="pagination-current">01</span> <?php esc_html_e('of', 'estatein'); ?> <span class="pagination-total"><?php echo esc_html(str_pad($total_slides, 2, '0', STR_PAD_LEFT)); ?></span>
                    </span>
                    <div class="pagination-nav">
                        <button class="nav-arrow nav-prev" aria-label="<?php esc_attr_e('Previous', 'estatein'); ?>" disabled>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow-left.svg'); ?>" alt="<?php esc_attr_e('Previous', 'estatein'); ?>" width="20" height="20">
                        </button>
                        <button class="nav-arrow nav-next" aria-label="<?php esc_attr_e('Next', 'estatein'); ?>" <?php echo $total_slides <= 1 ? 'disabled' : ''; ?>>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow-right.svg'); ?>" alt="<?php esc_attr_e('Next', 'estatein'); ?>" width="20" height="20">
                        </button>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p class="no-properties"><?php esc_html_e('No properties found.', 'estatein'); ?></p>
        <?php endif; ?>
    </div>
</section>
