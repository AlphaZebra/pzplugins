<?php
/**
 * Plugin Name:       pzprojectgrid
 * Description:       Block that creates data grid for the project table.
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



function create_block_pzprojectgrid_block_init() {
	register_block_type( __DIR__ . '/build' , array(
		'render_callback' => 'pz_project_grid_block'
	));
}
add_action( 'init', 'create_block_pzprojectgrid_block_init' );

add_action('admin_post_do-project-delete', 'do_project_delete');
add_action('admin_post_nopriv_do-project-delete', 'do_project_delete');



function pz_project_grid_block($attributes) {
	global $wpdb;

	// wp_enqueue_script('pzgridfront', plugin_dir_url(__FILE__) . 'build/projectgrid.js', array('wp-element', 'wp-components'), null, true);
	// $user_info = wp_get_current_user();

	$limit = 10;
    $offset = 0;

	$editURL = isset($attributes['editURL']) ? $attributes['editURL'] : '/';
	$addURL = isset($attributes['addURL']) ? trailingslashit($attributes['addURL']) . '?prj=0' : '/';
	$taskListURL = isset($attributes['taskListURL']) ? trailingslashit($attributes['taskListURL']) : '/';

	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_project ", ARRAY_A );
	if( !isset($results[0])) {
		$offset=0;
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_project LIMIT $limit OFFSET $offset ", ARRAY_A );
	};

	

	ob_start();
	?>
	<!-- <div class="pz-projectgrid-div"><pre> <?php /* echo wp_json_encode($attributes); */?></pre></div> -->
	
	<table class="pz-table-style" >
		
		<thead>
			<th> </th>
			<th><a class="chip-pending" href="<?php echo $addURL ?>" >+ Add New </a></th>
			<th>Status</th>
			<th>Tasks</th>
			<th>Team Lead</th>
			<th>   </th>
			
		</thead>

	<?php
      if(!isset($results[0])) {
        echo "<tr><td>No projects found.</td></tr>";
    } else {
        foreach($results as $result) {
			switch ($result['project_status']) {
				case "pending":
				  $classname = "chip-pending";
				  $status_text = "Pending";
				  break;
				case "inprocess":
				  $classname = "chip-inprocess";
				  $status_text = "In Process";
				  break;
				case "inreview":
				  $classname = "chip-inreview";
				  $status_text = "In Review";
				  break;
				case "done":
				  $classname = "chip-done";
				  $status_text = "Done";
				  break;
				default:
				  $classname = "";
			  }
            echo "<tr><td><a href='" . trailingslashit($editURL)  . "?prj=" . $result['id']  . "'><img src=". plugin_dir_url(__FILE__)  . "/includes/assets/pencil.png' width='20px' ></a></td><td>";
            // tooltip contains project description field
			if( $result['project_description'] == '') {
				echo $result['project_name'] . "</td><td>";
			} else {
				echo "<div class='tooltip'>" . $result['project_name'] . "<span class='tooltiptext'>" . $result['project_description'] . "</span></div></td><td>";
			}
			
            echo '<div class="' . $classname . '">' . $status_text . '</div></td><td>';
			echo "<a href=" . $taskListURL . "/?prj=" . $result['id'] . "><img src=". plugin_dir_url(__FILE__)  . "/includes/assets/tasklist.png' width='30px' ></a></td><td>";
			// get name and email for team lead
			$names = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person WHERE id = {$result['project_lead']} ", ARRAY_A );
			if(!isset($names[0])) {
				$name = array();
			} else {
				$name = $names[0];
			}
			
			if( !isset($name['email'])) {
				$avatar_image = plugin_dir_url(__FILE__)  . "/includes/assets/unassigned.png";
				$avatar_name = "Unassigned";
			} else {
				$avatar_image = get_avatar_url($name['email']);
				$avatar_name = $name['firstname'] . ' ' . $name['lastname'];
			}
			echo '<div class="chip"><img src=' . $avatar_image . '>' . $avatar_name . '</td><td>';

			?>
			<form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST" >
  			<input type="hidden" name="action" value="do-project-delete" required>
			<input type="hidden" name="id" value=<?php echo $result['id']   ?> required >
			<input type="hidden" name="postDeleteURL" value="/" required >
			<button type="submit" name="submit"  class="clearbutton"><img src="<?php echo plugin_dir_url(__FILE__) ?>/includes/assets/red-trashcan.png" width='30px' ></button>
			</td></tr>
			</form>

			<?php

        }
    }
    

	
	?>

	
	</table>
	<?php 

	return ob_get_clean();

}

function do_project_delete() {
	global $wpdb;

	$wpdb->delete( $wpdb->prefix . 'pz_project', array( 'id' => $_POST['id'] ) );
	wp_redirect( $_POST['postDeleteURL']);
	exit;
	
}