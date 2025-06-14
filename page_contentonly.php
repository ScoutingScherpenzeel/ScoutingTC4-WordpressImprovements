<?php

/**
 * Template Name: Content only
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
    'page-contentonly.twig',
    'index.twig',
);
Timber::render($templates, $context);
