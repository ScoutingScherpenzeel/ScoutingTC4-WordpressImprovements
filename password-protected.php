<?php
/**
 * Template Name: Password protected
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

// Ensure the password form is available in the context
$context['password_form'] = get_the_password_form( $context['post'] );

// Timber::render('password-protected.twig', $context);
$templates = array(
    'password-protected.twig',
    'index.twig',
);
Timber::render($templates, $context);
