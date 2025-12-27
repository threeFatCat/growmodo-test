<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) {
            the_title('<h1 class="entry-title">', '</h1>');
        } else {
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        }

        if ('post' === get_post_type()) {
            ?>
            <div class="entry-meta">
                <span class="posted-on"><?php echo get_the_date(); ?></span>
                <span class="byline"><?php esc_html_e('by', 'estatein'); ?> <?php the_author(); ?></span>
            </div>
            <?php
        }
        ?>
    </header>

    <?php if (has_post_thumbnail() && !is_singular()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('large'); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        if (is_singular()) {
            the_content();
        } else {
            the_excerpt();
        }

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'estatein'),
            'after'  => '</div>',
        ));
        ?>
    </div>

    <?php if (!is_singular()) : ?>
        <footer class="entry-footer">
            <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More', 'estatein'); ?></a>
        </footer>
    <?php endif; ?>
</article>

