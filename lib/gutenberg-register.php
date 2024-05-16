<?php


function remove_parent_acf_register() {
    remove_action( 'acf/init', 'scoutingnl_acf_init' );
}
add_action('wp_loaded', 'remove_parent_acf_register');

function scoutingimproved_acf_init() {

	if ( ! function_exists( 'acf_register_block' ) ) {
		return;
	}

	acf_register_block(
		array(
			'name'            => 'featured_block',
			'title'           => __( 'Featured items', 'scoutingnl' ),
			'description'     => __( 'Gutenberg blok om featured items in te voegen', 'scoutingnl' ),
			'render_callback' => 'scoutingnl_acf_featured_block_render_callback',
			'category'        => 'scouting-blocks',
			'icon'            => 'screenoptions',
			'keywords'        => array( 'featured', 'blok', 'ankeiler', 'nieuws' ),
		)
	);

	acf_register_block(
		array(
			'name'            => 'news_block',
			'title'           => __( 'Nieuws items', 'scoutingnl' ),
			'description'     => __( 'Gutenberg blok om nieuwsitems in te voegen', 'scoutingnl' ),
			'render_callback' => 'scoutingnl_acf_news_block_render_callback',
			'category'        => 'scouting-blocks',
			'icon'            => 'screenoptions',
			'keywords'        => array( 'featured', 'blok', 'ankeiler', 'nieuws' ),
		)
	);

	acf_register_block(
		array(
			'name'            => 'callout_block',
			'title'           => __( 'Callout', 'scoutingnl' ),
			'description'     => __( 'Gutenberg blok om een callout (groen blok met links een afbeelding en rechts een titel, tekst en een knop) in te voegen', 'scoutingnl' ),
			'render_callback' => 'scoutingnl_acf_callout_block_render_callback',
			'category'        => 'scouting-blocks',
			'icon'            => 'screenoptions',
			'keywords'        => array( 'tekst', 'blok', 'ankeiler', 'callout', 'cta' ),
		)
	);

	acf_register_block(
		array(
			'name'            => 'two_columns_block',
			'title'           => __( '2 kolommen', 'scoutingnl' ),
			'description'     => __( 'Gutenberg blok met twee kolommen. Links met een kop + beeld, tekst en een knop. Rechts met een kop, WYSIWYG tekst en een knop', 'scoutingnl' ),
			'render_callback' => 'scoutingnl_acf_two_columns_block_render_callback',
			'category'        => 'scouting-blocks',
			'icon'            => 'screenoptions',
			'keywords'        => array( 'tekst', 'blok', 'WYSIWYG' ),
		)
	);

	acf_register_block(
		array(
			'name'            => 'calendar_block',
			'title'           => __( 'Activiteitenkalender', 'scoutingnl' ),
			'description'     => __( 'Gutenberg blok om de aankomende activiteiten weer te geven', 'scoutingnl' ),
			'render_callback' => 'scoutingnl_acf_calendar_block_render_callback',
			'category'        => 'scouting-blocks',
			'icon'            => 'screenoptions',
			'keywords'        => array( 'kalender', 'blok', 'agenda' ),
		)
	);

	acf_register_block(
		array(
			'name'            => 'gmap_block',
			'title'           => __( 'Google Map', 'scoutingnl' ),
			'description'     => __( 'Gutenberg blok om een Google Map in te voegen', 'scoutingnl' ),
			'render_callback' => 'scoutingnl_acf_gmap_block_render_callback',
			'category'        => 'scoutingnl-blocks',
			'icon'            => 'location',
			'keywords'        => array( 'kaart', 'google maps' ),
		)
	);

}

add_action( 'acf/init', 'scoutingimproved_acf_init' );
