<?php
get_header();
?>

<main id="primary" class="site-main">
    <?php get_template_part('template-parts/section', 'hero'); ?>
    <?php get_template_part('template-parts/section', 'features'); ?>
    <?php get_template_part('template-parts/section', 'properties'); ?>
    <?php get_template_part('template-parts/section', 'testimonials'); ?>
    <?php get_template_part('template-parts/section', 'faq'); ?>
</main>

<?php
get_footer();

