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
    add_filter( 'acf/settings/save_json', 'childtheme_acf_json_save_point' );

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
			'description'     => __('Gutenberg blok om de laatste nieuwsitems in te voegen', 'scoutingnl'),
			'render_callback' => 'scoutingimproved_acf_latest_news_block_render_callback',
			'category'        => 'scouting-blocks',
			'icon'            => 'screenoptions',
			'keywords'        => array('featured', 'blok', 'ankeiler', 'nieuws'),
		)
	);

	acf_register_block(
		array(
			'name'            => 'button_block',
			'title'           => __('Knop', 'scoutingnl'),
			'description'     => __('Gutenberg blok om een knop in te voegen', 'scoutingnl'),
			'render_callback' => 'scoutingimproved_acf_button_block_render_callback',
			'category'        => 'scouting-blocks',
			'icon'            => 'screenoptions',
			'keywords'        => array('knop', 'button', 'block'),
		)
	);
}

function scoutingimproved_acf_latest_news_block_render_callback($block, $content = '', $is_preview = false)
{
	$context               = Timber::get_context();
	$context['block']      = $block;
	$context['fields']     = get_fields();
	$context['is_preview'] = $is_preview;

    // Get the custom field 'post_count', with a default value of 3 if not set
    $post_count = !empty($context['fields']['post_count']) ? $context['fields']['post_count'] : 3;
	$context['featured'] = new Timber\PostQuery(array(
		'post_type' => 'post',
		'posts_per_page' => $post_count,
	));

	Timber::render('gutenberg-blocks/gb-latest-news-items.twig', $context);
}

function scoutingimproved_acf_button_block_render_callback($block, $content = '', $is_preview = false)
{
	$context               = Timber::get_context();
	$context['block']      = $block;
	$context['fields']     = get_fields();
	$context['is_preview'] = $is_preview;

	Timber::render('gutenberg-blocks/gb-button.twig', $context);
}
