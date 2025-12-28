<?php
/**
 * Template Name: About Us Page
 */
get_header();
?>

<main id="primary" class="site-main">
    <?php get_template_part('template-parts/section', 'about-hero'); ?>
    
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <div class="container">
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php
        endwhile;
    endif;
    ?>
</main>

<?php
get_footer();
?>

