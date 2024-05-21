<?php

add_action('wp_enqueue_scripts', 'scouting_enqueue_styles');
add_action('wp_enqueue_scripts', 'scouting_enqueue_scripts');

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

function scouting_enqueue_scripts() {
	wp_enqueue_script('animation', get_stylesheet_directory_uri() . '/assets/js/animation.js', array('jquery'), '1.3.2', true); 
}

require_once 'lib/acf.php';
require_once 'lib/rss.php';