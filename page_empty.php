<?php

/**
 * Template Name: Empty page
 *
 * @package     WordPress
 * @subpackage  Timber
 * @since
 */

$context           = Timber::get_context();
$page_post         = Timber::query_post();
$context['post']   = $page_post;
$banner            = get_field('banner', $page_post->ID);
$context['banner'] = $banner;

$templates = array(
    'page-empty.twig',
    'index.twig',
);
Timber::render($templates, $context);
