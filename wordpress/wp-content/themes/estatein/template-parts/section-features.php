<?php
// Build features array from individual ACF fields (Free ACF compatible)
$features = array();

for ($i = 1; $i <= 4; $i++) {
    $icon_image = get_field("feature_{$i}_icon_image");
    $title = get_field("feature_{$i}_title");
    $link = get_field("feature_{$i}_link") ?: '#';
    
    // Only add feature if it has a title and icon image
    if ($title && $icon_image) {
        $features[] = array(
            'icon_image' => $icon_image,
            'title' => $title,
            'link' => $link,
        );
    }
}
?>

<section class="features-section">
    <div class="container">
        <div class="features-grid">
            <?php foreach ($features as $feature) : ?>
                <div class="feature-card">
                    <div class="feature-icon-container">
                        <?php if (!empty($feature['icon_image'])) : ?>
                            <?php echo wp_get_attachment_image($feature['icon_image'], 'thumbnail', false, array('class' => 'feature-icon')); ?>
                        <?php endif; ?>
                    </div>
                    <h3 class="feature-title"><?php echo esc_html($feature['title'] ?? ''); ?></h3>
                    <a href="<?php echo esc_url($feature['link'] ?? '#'); ?>" class="feature-link" aria-label="<?php echo esc_attr($feature['title'] ?? ''); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-up-right.svg" alt="Arrow Up Right" class="arrow">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

