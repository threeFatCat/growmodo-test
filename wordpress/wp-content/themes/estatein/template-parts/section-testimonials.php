<?php
$section_title = get_field('testimonials_section_title') ?: __('What Our Clients Say', 'estatein');
$section_description = get_field('testimonials_section_description') ?: __('Read the success stories and heartfelt testimonials from our valued clients. Discover why they chose Estatein for their real estate needs.', 'estatein');
$view_all_url = get_field('testimonials_view_all_url') ?: get_post_type_archive_link('testimonial') ?: '#';
$testimonials_per_slide = 3; // Show 3 testimonials per slide

// Query testimonial posts
$testimonials_query = new WP_Query(array(
    'post_type' => 'testimonial',
    'posts_per_page' => -1, // Get all testimonials for slider
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
));

$total_testimonials = $testimonials_query->found_posts;
$total_slides = ceil($total_testimonials / $testimonials_per_slide);
?>

<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <div class="section-title-group">
                <div class="section-decorative-stars">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/diamond.svg'); ?>" alt="<?php esc_attr_e('Diamond', 'estatein'); ?>" class="decorative-diamond">
                </div>
                <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
                <p class="section-description"><?php echo esc_html($section_description); ?></p>
            </div>
            <a href="<?php echo esc_url($view_all_url); ?>" class="btn btn-secondary"><?php esc_html_e('View All Testimonials', 'estatein'); ?></a>
        </div>

        <?php if ($testimonials_query->have_posts()) : ?>
            <div class="testimonials-slider-wrapper">
                <div class="testimonials-slider" data-current-slide="1" data-total-slides="<?php echo esc_attr($total_slides); ?>" data-testimonials-per-slide="<?php echo esc_attr($testimonials_per_slide); ?>">
                    <div class="testimonials-slider-track">
                        <?php 
                        $testimonial_index = 0;
                        $slide_opened = false;
                        
                        while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                            // Start new slide every 3 testimonials
                            if ($testimonial_index % $testimonials_per_slide === 0) {
                                if ($slide_opened) {
                                    echo '</div>'; // Close testimonials-grid
                                    echo '</div>'; // Close testimonials-slide
                                }
                                $slide_num = floor($testimonial_index / $testimonials_per_slide) + 1;
                                echo '<div class="testimonials-slide" data-slide="' . esc_attr($slide_num) . '">';
                                echo '<div class="testimonials-grid">';
                                $slide_opened = true;
                            }
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
                            <?php
                            $testimonial_index++;
                        endwhile;
                        
                        // Close the last slide if it was opened
                        if ($slide_opened) {
                            echo '</div>'; // Close testimonials-grid
                            echo '</div>'; // Close testimonials-slide
                        }
                        
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <div class="testimonials-pagination">
                    <span class="pagination-info">
                        <span class="pagination-current">01</span> <?php esc_html_e('of', 'estatein'); ?> <span class="pagination-total"><?php echo esc_html(str_pad($total_slides, 2, '0', STR_PAD_LEFT)); ?></span>
                    </span>
                    <div class="pagination-nav">
                        <button class="nav-arrow nav-prev" aria-label="<?php esc_attr_e('Previous', 'estatein'); ?>" disabled>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow-left.svg'); ?>" alt="<?php esc_attr_e('Previous', 'estatein'); ?>" width="20" height="20">
                        </button>
                        <button class="nav-arrow nav-next" aria-label="<?php esc_attr_e('Next', 'estatein'); ?>" <?php echo $total_slides <= 1 ? 'disabled' : ''; ?>>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow-right.svg'); ?>" alt="<?php esc_attr_e('Next', 'estatein'); ?>" width="20" height="20">
                        </button>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p class="no-testimonials"><?php esc_html_e('No testimonials found.', 'estatein'); ?></p>
        <?php endif; ?>
    </div>
</section>
