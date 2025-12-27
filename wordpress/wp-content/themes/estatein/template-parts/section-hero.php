<?php
$hero_title = get_field('hero_title') ?: __('Discover Your Dream Property with Estatein', 'estatein');
$hero_subtitle = get_field('hero_subtitle') ?: __('Your journey to finding the perfect property begins here. Explore our listings to find the home that matches your dreams.', 'estatein');
$hero_learn_more_text = get_field('hero_learn_more_text') ?: __('Learn More', 'estatein');
$hero_learn_more_url = get_field('hero_learn_more_url') ?: '#';
$hero_browse_text = get_field('hero_browse_text') ?: __('Browse Properties', 'estatein');
$hero_browse_url = get_field('hero_browse_url') ?: home_url('/properties');
$hero_stat_1_number = get_field('hero_stat_1_number') ?: '200+';
$hero_stat_1_label = get_field('hero_stat_1_label') ?: __('Happy Customers', 'estatein');
$hero_stat_2_number = get_field('hero_stat_2_number') ?: '10k+';
$hero_stat_2_label = get_field('hero_stat_2_label') ?: __('Properties For Clients', 'estatein');
$hero_stat_3_number = get_field('hero_stat_3_number') ?: '16+';
$hero_stat_3_label = get_field('hero_stat_3_label') ?: __('Years of Experience', 'estatein');
$hero_image = get_field('hero_image');
$hero_floating_cta_enabled = get_field('hero_floating_cta_enabled');
$hero_floating_cta_image = get_field('hero_floating_cta_image');
$hero_floating_cta_link = get_field('hero_floating_cta_link') ?: '#';
?>

<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text-container">
                <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
                <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
            </div>
            <div class="hero-buttons">
                <a href="<?php echo esc_url($hero_learn_more_url); ?>" class="btn btn-outline"><?php echo esc_html($hero_learn_more_text); ?></a>
                <a href="<?php echo esc_url($hero_browse_url); ?>" class="btn btn-primary"><?php echo esc_html($hero_browse_text); ?></a>
            </div>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo esc_html($hero_stat_1_number); ?></span>
                    <span class="stat-label"><?php echo esc_html($hero_stat_1_label); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo esc_html($hero_stat_2_number); ?></span>
                    <span class="stat-label"><?php echo esc_html($hero_stat_2_label); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo esc_html($hero_stat_3_number); ?></span>
                    <span class="stat-label"><?php echo esc_html($hero_stat_3_label); ?></span>
                </div>
            </div>
        </div>
        <div class="hero-visual">
            <?php if ($hero_image) : ?>
                <?php echo wp_get_attachment_image($hero_image, 'estatein-property-large', false, array('class' => 'hero-image')); ?>
            <?php else : ?>
                <div class="hero-placeholder"></div>
            <?php endif; ?>
            <?php if ($hero_floating_cta_enabled && $hero_floating_cta_image) : ?>
                <a href="<?php echo esc_url($hero_floating_cta_link); ?>" class="hero-floating-cta" aria-label="<?php esc_attr_e('Floating CTA', 'estatein'); ?>">
                    <?php echo wp_get_attachment_image($hero_floating_cta_image, 'full', false, array('class' => 'hero-floating-cta-image')); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

