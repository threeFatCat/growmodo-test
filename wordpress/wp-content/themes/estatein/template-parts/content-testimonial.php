<?php
/**
 * Template part for displaying testimonial cards in archive
 */
?>

<article class="testimonial-card">
    <div class="testimonial-rating">
        <?php
        $rating = intval(get_field('testimonial_rating') ?: 5);
        for ($i = 0; $i < 5; $i++) {
            $star_class = ($i < $rating) ? ' active' : '';
            echo '<div class="star-container' . esc_attr($star_class) . '">';
            echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/star.svg') . '" alt="' . esc_attr__('Star', 'estatein') . '" class="star-icon">';
            echo '</div>';
        }
        ?>
    </div>
    <h3 class="testimonial-title"><?php the_title(); ?></h3>
    <p class="testimonial-text"><?php echo wp_trim_words(get_the_content(), 30); ?></p>
    <div class="testimonial-author">
        <?php if (has_post_thumbnail()) : ?>
            <div class="author-avatar">
                <?php the_post_thumbnail('thumbnail'); ?>
            </div>
        <?php endif; ?>
        <div class="author-info">
            <span class="author-name"><?php echo esc_html(get_field('testimonial_client_name') ?: get_the_title()); ?></span>
            <span class="author-location"><?php echo esc_html(get_field('testimonial_client_location') ?: ''); ?></span>
        </div>
    </div>
</article>

