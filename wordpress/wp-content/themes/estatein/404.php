<?php
get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404 not-found">
        <div class="container">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'estatein'); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'estatein'); ?></p>

                <div class="error-404-links">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php esc_html_e('Go to Homepage', 'estatein'); ?></a>
                    <a href="<?php echo esc_url(home_url('/properties')); ?>" class="btn btn-outline"><?php esc_html_e('Browse Properties', 'estatein'); ?></a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();

