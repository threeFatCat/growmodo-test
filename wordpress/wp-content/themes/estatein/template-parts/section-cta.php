<?php
$cta_title = get_field('cta_title') ?: __('Start Your Real Estate Journey Today', 'estatein');
$cta_description = get_field('cta_description') ?: __('Your dream property is just a click away. Whether you\'re looking for a new home, a strategic investment, or expert real estate advice. Estatein is here to assist you every step of the way. Take the first step towards your real estate goals and explore our available properties or get in touch with our team for personalized assistance.', 'estatein');
$cta_button_text = get_field('cta_button_text') ?: __('Explore Properties', 'estatein');
$cta_button_link = get_field('cta_button_link') ?: home_url('/properties');
?>

<section class="footer-cta-section">
    <div class="footer-cta-container">
        <div class="footer-cta-bg-left">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/footer-cta-left-bg.svg'); ?>" alt="" aria-hidden="true">
        </div>
        <div class="footer-cta-bg-right">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/footer-cta-right-bg.svg'); ?>" alt="" aria-hidden="true">
        </div>
        <div class="footer-cta-text-container">
            <h2 class="footer-cta-heading"><?php echo esc_html($cta_title); ?></h2>
            <p class="footer-cta-description"><?php echo esc_html($cta_description); ?></p>
        </div>
        <a href="<?php echo esc_url($cta_button_link); ?>" class="footer-cta-button"><?php echo esc_html($cta_button_text); ?></a>
    </div>
</section>

