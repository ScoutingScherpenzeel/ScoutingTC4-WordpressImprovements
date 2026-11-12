<?php

if (! class_exists('Timber')) {
    echo 'Timber not activated.';
    return;
}

$context = Timber::get_context();

// Stel paginatie en query-args in voor blogposts
$num_records   = AANTAL_RESULTATEN_PER_PAGINA_ARCHIEF;
$current_paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $num_records,
    'paged'          => $current_paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
];

// Haal posts op via Timber\PostQuery
$posts_query = new Timber\PostQuery($args);
$context['posts'] = $posts_query;
$context['pagination'] = Timber::get_pagination(['pagination' => $posts_query]);

// Haal expliciet de pagina op die als "Berichtpagina" is ingesteld
$page_for_posts_id = get_option('page_for_posts');
$context['post'] = Timber::get_post($page_for_posts_id);

// Render de juiste Twig-template
$templates = ['home.twig', 'index.twig'];
Timber::render($templates, $context);
