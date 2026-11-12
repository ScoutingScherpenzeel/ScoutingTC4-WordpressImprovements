<?php

$link = get_field('pagina_niet_gevonden', 'option');

$id_pagina_404 = $link ? url_to_postid($link) : 0;

if (! $id_pagina_404) {
    wp_die('404 - Pagina niet gevonden. Geen geldige pagina ingesteld in ACF.');
}

$args_404 = array(
    'post_type'   => 'page',
    'post_status' => 'publish',
    'p'           => $id_pagina_404,
);

$context         = Timber::get_context();
$context['post'] = Timber::get_post($args_404);

$templates = array(
    '404.twig',
    'content-page.twig',
    'index.twig',
);

Timber::render($templates, $context);
