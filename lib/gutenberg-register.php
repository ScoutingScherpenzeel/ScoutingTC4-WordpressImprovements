<?php

function scoutingimproved_acf_init() {

	if ( ! function_exists( 'acf_register_block' ) ) {
		return;
	}

	acf_register_block(
		array(
			'name'            => 'latest_news_block',
			'title'           => __( 'Laatste nieuws items', 'scoutingnl' ),
			'description'     => __( 'Gutenberg blok om de 3 laatste nieuwsitems in te voegen', 'scoutingnl' ),
			'render_callback' => 'scoutingimproved_acf_latest_news_block_render_callback',
			'category'        => 'scouting-blocks',
			'icon'            => 'screenoptions',
			'keywords'        => array( 'featured', 'blok', 'ankeiler', 'nieuws' ),
		)
	);

}

function scoutingimproved_acf_latest_news_block_render_callback() {
	$context               = Timber::get_context();
	$context['block']      = $block;
	$context['fields']     = get_fields();
	$context['is_preview'] = $is_preview;
	$context['featured'] = new Timber\PostQuery(array(
		'post_type' => 'post',
		'posts_per_page' => 3,
	));
	Timber::render( 'gutenberg-blocks/gb-latest-news-items.twig', $context );
}