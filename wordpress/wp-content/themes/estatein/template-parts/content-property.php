<?php
/**
 * Template part for displaying property cards in archive
 */
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
                $truncated_excerpt = mb_substr($excerpt, 0, 75);
                echo esc_html($truncated_excerpt);
                if (mb_strlen($excerpt) > 75) {
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

