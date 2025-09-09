<?php

add_action('wp_enqueue_scripts', 'scouting_enqueue_styles');
add_action('wp_enqueue_scripts', 'scouting_enqueue_scripts');

// Define the version based on theme version
if (!defined('SCOUTINGNL_CHILD_THEME_VERSION')) {
	$theme = wp_get_theme(get_stylesheet());
	define('SCOUTINGNL_CHILD_THEME_VERSION', $theme->get('Version') ?: null);
}

function scouting_enqueue_styles()
{
	// Load the CSS improvements
	wp_enqueue_style(
		'scouting-improved-style',
		get_stylesheet_uri()
	);
	wp_enqueue_style(
		'scouting-butterfly-style',
		get_stylesheet_directory_uri() . '/assets/css/butterfly.css'
	);

	// Load all CSS of the default Scouting template
	wp_enqueue_style(
		'thema-style',
		get_parent_theme_file_uri('style.css'),
		array('bootstrap-style', 'font-awesome-5-style', 'poppins-google-fonts-style', 'roboto-google-fonts-style')
	);
}

function scouting_enqueue_scripts()
{
	wp_enqueue_script('animation', get_stylesheet_directory_uri() . '/assets/js/animation.js', array('jquery'), SCOUTINGNL_CHILD_THEME_VERSION, true);
}

function add_twig_file_exists_extension($twig)
{
	$twig->addFunction(new \Twig\TwigFunction('file_exists', function ($path) {
		return file_exists($path);
	}));
	return $twig;
}
add_filter('timber/twig', 'add_twig_file_exists_extension');

require_once 'lib/acf.php';
require_once 'lib/rss.php';
