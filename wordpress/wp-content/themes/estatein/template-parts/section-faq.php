<?php
$section_title = get_field('faq_section_title') ?: __('Frequently Asked Questions', 'estatein');
$section_description = get_field('faq_section_description') ?: __('Find answers to common questions about Estatein\'s services, property listings, and the real estate process. We\'re here to provide clarity and assist you every step of the way.', 'estatein');
$view_all_url = get_field('faq_view_all_url') ?: home_url('/faq');
$faqs_per_slide = 3; // Show 3 FAQs per slide

// Query FAQ posts
$faqs_query = new WP_Query(array(
    'post_type' => 'faq',
    'posts_per_page' => -1, // Get all FAQs for slider
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
));

$total_faqs = $faqs_query->found_posts;
$total_slides = ceil($total_faqs / $faqs_per_slide);
?>

<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <div class="section-title-group">
                <div class="section-decorative-stars">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/diamond.svg'); ?>" alt="<?php esc_attr_e('Diamond', 'estatein'); ?>" class="decorative-diamond">
                </div>
                <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
                <p class="section-description"><?php echo esc_html($section_description); ?></p>
            </div>
            <a href="<?php echo esc_url($view_all_url); ?>" class="btn btn-secondary"><?php esc_html_e('View All FAQ\'s', 'estatein'); ?></a>
        </div>

        <?php if ($faqs_query->have_posts()) : ?>
            <div class="faqs-slider-wrapper">
                <div class="faqs-slider" data-current-slide="1" data-total-slides="<?php echo esc_attr($total_slides); ?>" data-faqs-per-slide="<?php echo esc_attr($faqs_per_slide); ?>">
                    <div class="faqs-slider-track">
                        <?php 
                        $faq_index = 0;
                        $slide_opened = false;
                        
                        while ($faqs_query->have_posts()) : $faqs_query->the_post();
                            // Start new slide every 3 FAQs
                            if ($faq_index % $faqs_per_slide === 0) {
                                if ($slide_opened) {
                                    echo '</div>'; // Close faqs-grid
                                    echo '</div>'; // Close faqs-slide
                                }
                                $slide_num = floor($faq_index / $faqs_per_slide) + 1;
                                echo '<div class="faqs-slide" data-slide="' . esc_attr($slide_num) . '">';
                                echo '<div class="faqs-grid">';
                                $slide_opened = true;
                            }
                            ?>
                            <article class="faq-card">
                                <h3 class="faq-question"><?php the_title(); ?></h3>
                                <p class="faq-answer"><?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 20); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline"><?php esc_html_e('Read More', 'estatein'); ?></a>
                            </article>
                            <?php
                            $faq_index++;
                        endwhile;
                        
                        // Close the last slide if it was opened
                        if ($slide_opened) {
                            echo '</div>'; // Close faqs-grid
                            echo '</div>'; // Close faqs-slide
                        }
                        
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <div class="faqs-pagination">
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
            <p class="no-faqs"><?php esc_html_e('No FAQs found.', 'estatein'); ?></p>
        <?php endif; ?>
    </div>
</section>

