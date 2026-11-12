<?php

/**
 * Template for displaying the homepage.
 *
 * Used to display the theme's homepage.
 *
 * @package     WordPress
 * @subpackage  Timber
 * @since
 */

/*
Template Name: Homepagina
*/


$context           = Timber::get_context();
$home_post         = Timber::query_post();
$context['post']   = $home_post;
$banner            = get_field('banner', $home_post->ID);
$slider            = get_field('slider', $home_post->ID);
$context['banner'] = $banner;
$context['slider'] = $slider;

$templates = array(
    'front-page.twig',
    'index.twig',
);
Timber::render($templates, $context);
