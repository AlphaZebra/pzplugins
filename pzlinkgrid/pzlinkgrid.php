<?php
/**
 * Plugin Name:       pzlinkgrid
 * Description:       Block that creates data grid for the link table.
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

//normally this line will be commented out
// defined('DEMO') || define('DEMO', true);


function create_block_pzlinkgrid_block_init() {
	register_block_type( __DIR__ . '/build' , array(
		'render_callback' => 'pz_link_grid_block'
	));
}
add_action( 'init', 'create_block_pzlinkgrid_block_init' );

add_action('admin_post_do-project-delete', 'do_project_delete');
add_action('admin_post_nopriv_do-project-delete', 'do_project_delete');



function pz_link_grid_block($attributes) {
	global $wpdb;

	wp_enqueue_script('pzlinkfront', plugin_dir_url(__FILE__) . 'build/linkgrid.js', array('wp-element', 'wp-components'), null, true);
	// $user_info = wp_get_current_user();
	$attributes['siteURL'] = get_site_url();

	ob_start();
	?>
	<div class="pz-linkgrid-div" ><pre style="color: white"><?php echo wp_json_encode($attributes); ?></pre></div>
	
	<?php
	return ob_get_clean();
}

function do_link_delete() {
	global $wpdb;

		$wpdb->delete( $wpdb->prefix . 'pz_link', array( 'id' => $_POST['id'] ) );
	
	wp_redirect( $_POST['postDeleteURL']);
	exit;
	
}