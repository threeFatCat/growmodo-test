<?php
$banner_enabled_option = get_option('top_banner_enabled');
$banner_enabled = ($banner_enabled_option !== false && $banner_enabled_option !== '') ? (int) $banner_enabled_option : 1;

$banner_text = get_option('top_banner_text');
if (empty($banner_text)) {
    $banner_text = __('Discover Your Dream Property with Estatein', 'estatein');
}

$banner_link = get_option('top_banner_link');
if (empty($banner_link)) {
    $banner_link = '#';
}

$banner_link_text = get_option('top_banner_link_text');
if (empty($banner_link_text)) {
    $banner_link_text = __('Learn More', 'estatein');
}
?>

<?php if ($banner_enabled == 1) : ?>
<div class="top-banner" role="banner" data-banner-enabled="1">
    <div class="container">
        <div class="banner-content">
            <span class="banner-text">
                <?php echo esc_html($banner_text); ?> <a href="<?php echo esc_url($banner_link); ?>" class="banner-link"><?php echo esc_html($banner_link_text); ?></a>
            </span>
        </div>
        <button class="banner-close" aria-label="<?php esc_attr_e('Close banner', 'estatein'); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/x.svg" alt="Close banner">
        </button>
    </div>
</div>
<?php endif; ?>

