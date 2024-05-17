<?php


/**
 * ACF: ACF JSON location
 */

function scoutingimproved_acf_json_save_point($path)
{

	$path = get_stylesheet_directory() . '/acf-json';
	return $path;
}


function scoutingimproved_acf_json_load_point($paths)
{

	// Remove original path (optional)
	unset($paths[0]);

	// Add the parent theme acf-json path
	$paths[] = get_template_directory() . '/acf-json';

	// Add the child theme acf-json path
	$paths[] = get_stylesheet_directory() . '/acf-json';

	return $paths;
}

/**
 * Ensure ACF JSON paths are correctly set for both parent and child themes.
 */
add_action( 'after_setup_theme', 'scoutingimproved_modify_acf_json_paths' );
function scoutingimproved_modify_acf_json_paths() {
    // Save ACF JSON in the child theme directory
    add_filter( 'acf/settings/save_json', 'scoutingimproved_acf_json_save_point' );

    // Add the child theme's acf-json path to the load paths
    add_filter( 'acf/settings/load_json', 'scoutingimproved_acf_json_load_point' );
}


add_action('acf/init', 'scoutingimproved_acf_init');
function scoutingimproved_acf_init()
{

	if (!function_exists('acf_register_block')) {
		return;
	}

	acf_register_block(
		array(
			'name'            => 'latest_news_block',
			'title'           => __('Laatste nieuws items', 'scoutingnl'),
			'description'     => __('Gutenberg blok om de 3 laatste nieuwsitems in te voegen', 'scoutingnl'),
			'render_callback' => 'scoutingimproved_acf_latest_news_block_render_callback',
			'category'        => 'scouting-blocks',
			'icon'            => 'screenoptions',
			'keywords'        => array('featured', 'blok', 'ankeiler', 'nieuws'),
		)
	);
}

function scoutingimproved_acf_latest_news_block_render_callback($block, $content = '', $is_preview = false)
{
	$context               = Timber::get_context();
	$context['block']      = $block;
	$context['fields']     = get_fields();
	$context['is_preview'] = $is_preview;
	$context['featured'] = new Timber\PostQuery(array(
		'post_type' => 'post',
		'posts_per_page' => 3,
	));
	Timber::render('gutenberg-blocks/gb-latest-news-items.twig', $context);
}
