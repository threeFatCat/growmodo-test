<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'estatein'); ?></a>

    <?php get_template_part('template-parts/top-banner'); ?>
    
    <header id="masthead" class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php endif; ?>

                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-text">
                    <span class="logo-text"><?php bloginfo( 'name' ); ?></span>
                </a>
            </div>

            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Primary Menu', 'estatein'); ?>">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="screen-reader-text"><?php esc_html_e('Primary Menu', 'estatein'); ?></span>
                    <span class="menu-icon"></span>
                </button>
                <div class="menu-backdrop"></div>
                <div class="nav-buttons-container">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'primary-menu',
                        'fallback_cb'    => false,
                        'depth'          => 2,
                    ));
                    ?>
                </div>
            </nav>
            <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="btn-contact"><?php esc_html_e('Contact Us', 'estatein'); ?></a>
        </div>
    </header>

