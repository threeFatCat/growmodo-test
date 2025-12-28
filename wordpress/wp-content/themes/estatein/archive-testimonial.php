<?php
/**
 * The template for displaying testimonial archives
 */
get_header();
?>

<main id="primary" class="site-main">
    <div class="testimonials-archive-container">
        <?php if (have_posts()) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php
                    if (is_post_type_archive('testimonial')) {
                        esc_html_e('Testimonials', 'estatein');
                    } else {
                        the_archive_title();
                    }
                ?></h1>
                <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
            </header>

            <div class="testimonials-archive-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/content', 'testimonial');
                endwhile;
                ?>
            </div>

            <?php
            the_posts_pagination(array(
                'prev_text' => __('Previous', 'estatein'),
                'next_text' => __('Next', 'estatein'),
            ));
            ?>
        <?php else : ?>
            <?php get_template_part('template-parts/content', 'none'); ?>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
?>

