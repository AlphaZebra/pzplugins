<?php
/**
 * Plugin Name:       pzinteractiongrid
 * Description:       Block that creates data grid for the interaction table.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Robert Richardson
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pzgrid
 *
 * @package           pzprojectgrid
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */



function create_block_pzinteractiongrid_block_init() {
	$outcome = register_block_type( __DIR__ . '/build' , array(
		'render_callback' => 'pz_interaction_grid_block'
	));
	if( $outcome === false ) {
		var_dump($outcome);
		exit;
	}
}
add_action( 'init', 'create_block_pzinteractiongrid_block_init' );

add_action('admin_post_do-interaction-delete', 'do_pz_interaction_delete');
add_action('admin_post_nopriv_do-interaction-delete', 'do_pz_interaction_delete');



function pz_interaction_grid_block($attributes) {
	global $wpdb;

	wp_enqueue_script('pzinteractiongrid', plugin_dir_url(__FILE__) . 'build/interactiongrid.js', array('wp-element', 'wp-components'), null, true);
	// $user_info = wp_get_current_user();
	if( isset($_GET['per']) ) {
		$attributes['per'] = $_GET['per'];
	} else $attributes['per'] = 1;
	// if( isset($_GET['app']) ) {
	// 	$attributes['app'] = $_GET['app'];
	// }
	$attributes['siteURL'] = get_site_url();


	ob_start();
	?>

	<div class="pz-interactiongrid-div"><pre><?php echo wp_json_encode($attributes); ?></pre></div>
	
	<?php
	return ob_get_clean();
}

function do_pz_interaction_delete() {
	global $wpdb;

	$wpdb->delete( $wpdb->prefix . 'pz_interaction', array( 'id' => $_POST['id'] ) );
	wp_redirect( $_POST['postDeleteURL']);
	exit;
	
}