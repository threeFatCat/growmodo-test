<?php
function estatein_get_excerpt($length = 55) {
    $excerpt = get_the_excerpt();
    if (empty($excerpt)) {
        $excerpt = get_the_content();
    }
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $length);
    $excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
    $excerpt = $excerpt . '...';
    return $excerpt;
}

function estatein_sanitize_html($string) {
    return wp_kses_post($string);
}

