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

    if (has_post_thumbnail($post->ID)) {
        $content = get_the_post_thumbnail($post->ID) . $content;
    }

    return $content;
}

add_filter('the_excerpt_rss', 'scoutingimproved_rss_fixer');
add_filter('the_content_feed', 'scoutingimproved_rss_fixer');