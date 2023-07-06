<?php
/**
 * Plugin Name:       Parthenon
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       parthenon
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_parthenon_block_init() {
	register_block_type( __DIR__ . '/build' , array(
		'render_callback' => 'pz_the_block'
	));
}
add_action( 'init', 'create_block_parthenon_block_init' );

function pz_the_block($attributes) {

	wp_enqueue_script('aaa04', plugin_dir_url(__FILE__) . 'build/frontend.js', array('wp-element', 'wp-components'), null, true);
	$user_info = wp_get_current_user();
	ob_start();
	?>
	<div class="pz-target-div"><pre><?php echo wp_json_encode($attributes); ?></pre></div>
	
	<?php
	return ob_get_clean();
}

add_action('rest_api_init', 'set_up_rest_route');
function set_up_rest_route() {
	register_rest_route('pz/v1', 'cal', array(
		'methods' => WP_REST_SERVER::READABLE,
		'callback' => 'do_cal'
	));
}

function do_cal($stuff) {
	
	$slots = array(
		"1pm" => $stuff['date'],
		"2pm" => "busy",
		"3pm" => "open"
	);
	return $slots;
}