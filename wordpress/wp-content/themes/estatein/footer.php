    <?php get_template_part('template-parts/section', 'cta'); ?>
    
    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column footer-brand">
                    <div class="site-logo">
                        <?php
                        if (has_custom_logo()) {
                            the_custom_logo();
                        } 
                        ?>
                        <span class="logo-text"><?php bloginfo('name'); ?></span>
                    </div>
                    <form class="footer-newsletter" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                        <?php wp_nonce_field('estatein_newsletter', 'estatein_newsletter_nonce'); ?>
                        <input type="hidden" name="action" value="estatein_newsletter">
                        <div class="footer-newsletter-input-wrapper">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/mail.svg'); ?>" alt="" class="footer-newsletter-icon" aria-hidden="true">
                            <input type="email" name="email" placeholder="<?php esc_attr_e('Enter Your Email', 'estatein'); ?>" required aria-label="<?php esc_attr_e('Email Address', 'estatein'); ?>">
                            <button type="submit" aria-label="<?php esc_attr_e('Subscribe', 'estatein'); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/send.svg'); ?>" alt="" class="footer-newsletter-send-icon" aria-hidden="true">
                            </button>
                        </div>
                    </form>
                </div>

                <div class="footer-menu-container">
                    <?php
                    $menu_locations = get_nav_menu_locations();
                    if (isset($menu_locations['footer']) && $menu_locations['footer'] != 0) {
                        $menu_items = wp_get_nav_menu_items($menu_locations['footer']);
                        
                        $parent_items = array();
                        foreach ($menu_items as $item) {
                            if ($item->menu_item_parent == 0) {
                                $parent_items[] = $item;
                            }
                        }
                        
                        foreach ($parent_items as $parent) {
                            // Get children of this parent
                            $children = array();
                            foreach ($menu_items as $item) {
                                if ($item->menu_item_parent == $parent->ID) {
                                    $children[] = $item;
                                }
                            }
                            
                            // Only display if it has children
                            if (!empty($children)) {
                                ?>
                                <div class="footer-column">
                                    <h3><?php echo esc_html($parent->title); ?></h3>
                                    <ul class="footer-menu">
                                        <?php
                                        foreach ($children as $child) {
                                            ?>
                                            <li><a href="<?php echo esc_url($child->url); ?>"><?php echo esc_html($child->title); ?></a></li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="footer-copyright">
                        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All Rights Reserved.', 'estatein'); ?></p>
                        <a href="<?php echo esc_url(home_url('/terms')); ?>"><?php esc_html_e('Terms & Conditions', 'estatein'); ?></a>
                    </div>
                    <div class="footer-social">
                        <a href="#" aria-label="<?php esc_attr_e('Facebook', 'estatein'); ?>" class="footer-social-link">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/fb.svg'); ?>" alt="<?php esc_attr_e('Facebook', 'estatein'); ?>" width="24" height="24">
                        </a>
                        <a href="#" aria-label="<?php esc_attr_e('LinkedIn', 'estatein'); ?>" class="footer-social-link">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/linkedin.svg'); ?>" alt="<?php esc_attr_e('LinkedIn', 'estatein'); ?>" width="24" height="24">
                        </a>
                        <a href="#" aria-label="<?php esc_attr_e('Twitter', 'estatein'); ?>" class="footer-social-link">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/xtwitter.svg'); ?>" alt="<?php esc_attr_e('Twitter', 'estatein'); ?>" width="24" height="24">
                        </a>
                        <a href="#" aria-label="<?php esc_attr_e('YouTube', 'estatein'); ?>" class="footer-social-link">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/yt.svg'); ?>" alt="<?php esc_attr_e('YouTube', 'estatein'); ?>" width="24" height="24">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>

