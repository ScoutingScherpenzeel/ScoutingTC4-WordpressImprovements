<?php

/**
 * Add the post thumbnail, if available, before the content in feeds.
 * Remove as much HTML as possible, to clean up the feed for Scouting App.
 *
 * @param string $content The post content.
 *
 * @return string
 */
function scoutingimproved_rss_fixer($content)
{
    global $post;

    // Remove <div> elements but keep their content
    $content = preg_replace('/<div[^>]*>(.*?)<\/div>/is', '$1', $content);

    // Replace <p> tags with line breaks and remove closing </p> tags
    $content = preg_replace('/<p>(.*?)<\/p>/', '$1<br>', $content);

    // Remove extra line breaks
    $content = str_replace(array("\r\n", "\r", "\n"), '', $content);

    // Remove any trailing <br> tags
    $content = rtrim($content, '<br>');

    // Fallback image URL
    $fallback_image_url = get_stylesheet_directory_uri() . '/assets/img/news-placeholder.png';

    if (has_post_thumbnail($post->ID)) {
        $thumbnail_html = get_the_post_thumbnail($post->ID, 'medium');
    } else {
        $thumbnail_html = '<img src="' . esc_url($fallback_image_url) . '" alt="' . esc_attr(get_the_title($post->ID)) . '" />';
    }

    // Add the image HTML before the content
    $content = $thumbnail_html . $content;

    return $content;
}

add_filter('the_excerpt_rss', 'scoutingimproved_rss_fixer');
add_filter('the_content_feed', 'scoutingimproved_rss_fixer');
