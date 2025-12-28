<?php
$about_title = get_field('about_hero_title') ?: __('Our Journey', 'estatein');
$about_description = get_field('about_hero_description') ?: __('Our story is one of continuous growth and evolution. We started as a small team with big dreams, determined to create a real estate platform that transcended the ordinary. Over the years, we\'ve expanded our reach, forged valuable partnerships, and gained the trust of countless clients.', 'estatein');
$about_stat_1_number = get_field('about_stat_1_number') ?: '200+';
$about_stat_1_label = get_field('about_stat_1_label') ?: __('Happy Customers', 'estatein');
$about_stat_2_number = get_field('about_stat_2_number') ?: '10k+';
$about_stat_2_label = get_field('about_stat_2_label') ?: __('Properties For Clients', 'estatein');
$about_stat_3_number = get_field('about_stat_3_number') ?: '16+';
$about_stat_3_label = get_field('about_stat_3_label') ?: __('Years of Experience', 'estatein');
$about_image = get_field('about_hero_image');
?>

<section class="about-hero-section">
    <div class="container">
        <div class="about-hero-content">
            <div class="about-hero-text">
                <div class="about-hero-header">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/diamond.svg'); ?>" alt="" class="about-hero-diamond-icon" aria-hidden="true">
                </div>
                <h1 class="about-hero-title"><?php echo esc_html($about_title); ?></h1>
                <p class="about-hero-description"><?php echo esc_html($about_description); ?></p>
                
                <div class="about-hero-stats">
                    <div class="about-stat-card">
                        <div class="about-stat-number"><?php echo esc_html($about_stat_1_number); ?></div>
                        <div class="about-stat-label"><?php echo esc_html($about_stat_1_label); ?></div>
                    </div>
                    <div class="about-stat-card">
                        <div class="about-stat-number"><?php echo esc_html($about_stat_2_number); ?></div>
                        <div class="about-stat-label"><?php echo esc_html($about_stat_2_label); ?></div>
                    </div>
                    <div class="about-stat-card">
                        <div class="about-stat-number"><?php echo esc_html($about_stat_3_number); ?></div>
                        <div class="about-stat-label"><?php echo esc_html($about_stat_3_label); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="about-hero-image">
                <?php if ($about_image) : ?>
                    <?php
                    $image_id = is_array($about_image) ? $about_image['ID'] : $about_image;
                    $image_url = wp_get_attachment_image_url($image_id, 'large');
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: __('About Us', 'estatein');
                    ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                <?php else : ?>
                    <div class="about-hero-image-placeholder">
                        <?php esc_html_e('About Us Image', 'estatein'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

