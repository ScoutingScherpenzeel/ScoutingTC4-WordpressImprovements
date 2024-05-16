<?php

add_action('wp_enqueue_scripts', 'scouting_enqueue_styles');

function scouting_enqueue_styles()
{
	// Load the CSS improvements
	wp_enqueue_style(
		'scouting-improved-style',
		get_stylesheet_uri()
	);

	// Load all CSS of the default Scouting template
	wp_enqueue_style(
		'thema-style',
		get_parent_theme_file_uri('style.css'),
		array('bootstrap-style', 'font-awesome-5-style', 'poppins-google-fonts-style', 'roboto-google-fonts-style')
	);
}

require_once 'lib/gutenberg-register.php';