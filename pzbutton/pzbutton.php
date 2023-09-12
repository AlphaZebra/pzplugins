<?php
/**
 * Plugin Name:       pzbutton
 * Description:       Block that creates a submit button.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Robert Richardson
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pzbocks
 *
 * @package           pzbutton
 */

//normally this line will be commented out
// defined('DEMO') || define('DEMO', true);


function create_block_pzbutton_block_init() {
	register_block_type( __DIR__ . '/build' , array(
		'render_callback' => 'pz_button_block'
	));
}
add_action( 'init', 'create_block_pzbutton_block_init' );


function pz_button_block($attributes) {
	global $wpdb;

	// the script we're enqueueing here handles actual rending of all the pz field blocks
	wp_enqueue_script('pzbutton', plugin_dir_url(__FILE__) . 'build/pzbutton.js', array('wp-element', 'wp-components'), null, true);
	// $user_info = wp_get_current_user();
	$attributes['siteURL'] = get_site_url();

	ob_start();
	?>
	<div class="pz-button-div" ><pre style="color: white"><?php echo wp_json_encode($attributes); ?></pre></div>
	
	<?php
	return ob_get_clean();
}

