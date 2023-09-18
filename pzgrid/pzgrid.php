<?php
/**
 * Plugin Name:       pzgrid
 * Description:       Block that creates data grid for tables.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Robert Richardson
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pzgrid
 *
 * @package           pzgrid
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
	$attributes['siteURL'] = get_site_url();
	
	ob_start();
	?>
	<div class="pz-target-div"><pre style="color: white"><?php echo wp_json_encode($attributes); ?></pre></div>
	
	<?php
	return ob_get_clean();
}

