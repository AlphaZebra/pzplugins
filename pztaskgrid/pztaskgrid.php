<?php
/**
 * Plugin Name:       pzptaskgrid
 * Description:       Block that creates data grid for the task table.
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



function create_block_pztaskgrid_block_init() {
	$outcome = register_block_type( __DIR__ . '/build' , array(
		'render_callback' => 'pz_task_grid_block'
	));
	if( $outcome === false ) {
		var_dump($outcome);
		exit;
	}
}
add_action( 'init', 'create_block_pztaskgrid_block_init' );

add_action('admin_post_do-task-delete', 'do_task_delete');
add_action('admin_post_nopriv_do-task-delete', 'do_task_delete');



function pz_task_grid_block($attributes) {
	global $wpdb;

	wp_enqueue_script('pztaskgrid', plugin_dir_url(__FILE__) . 'build/taskgrid.js', array('wp-element', 'wp-components'), null, true);
	$user_info = wp_get_current_user();
	if( isset($_GET['prj']) ) {
		$attributes['prj'] = $_GET['prj'];
	}
	if( isset($_GET['app']) ) {
		$attributes['app'] = $_GET['app'];
	}
	

	ob_start();
	?>

	<div class="pz-taskgrid-div"><pre><?php echo wp_json_encode($attributes); ?></pre></div>
	
	<?php
	return ob_get_clean();
}

function do_task_delete() {
	global $wpdb;

	$wpdb->delete( $wpdb->prefix . 'pz_task', array( 'id' => $_POST['id'] ) );
	wp_redirect( $_POST['postDeleteURL']);
	exit;
	
}