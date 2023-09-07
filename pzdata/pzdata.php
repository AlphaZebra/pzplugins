<?php
/**
 * Plugin Name:       Pzdata
 * Description:       Creates core tables for PeakZebra along with REST api.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Robert Richardson
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pzdata
 *
 * @package           pzdata
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */


 define('PZ_PLUGIN_DIR', plugin_dir_path(__FILE__));


 // Includes

 include( PZ_PLUGIN_DIR . 'includes/register-blocks.php');
 include( PZ_PLUGIN_DIR . 'includes/pz-do-edit-block.php');
 include( PZ_PLUGIN_DIR . 'includes/pz-interaction.php');
 include( PZ_PLUGIN_DIR . 'includes/pz-task.php');
 include( PZ_PLUGIN_DIR . 'includes/pz-request_type.php');
 include( PZ_PLUGIN_DIR . 'includes/pz-queue.php');
 include( PZ_PLUGIN_DIR . 'includes/pz-logic.php');


 // Hooks


 add_action('init', 'pzdata_register');



function pz_person_block($attributes) {
	global $wpdb;
	global $pz_cur_person;

	// wp_enqueue_script('aaa04', plugin_dir_url(__FILE__) . 'build/blocks/pz_person_edit/frontend.js', array('wp-element', 'wp-components'), null, true);
	
	if( isset($_GET['per'])) {
		$person = $_GET['per'];
	} else $person = 0; // we're setting up a new person record

	$item = array(
		'id' => null,
		'firstname' => '',
		'lastname' => '',
		'title' => '',
		'company' => '',
		'email' => ''
	);
	
	$update = false;
	if( $person > 0 ) {  // existing person record
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person WHERE id = $person", ARRAY_A );
		if ( $wpdb->last_error || $results == null ) {
			echo 'wpdb error: ' . $wpdb->last_error;
			echo 'person = ' . $person;
			exit;
		  }
		$item = $results[0];
		if( !isset($item['id'])) {
			var_dump($item);
			exit;
		}
	} else if (isset($_GET['per'])) {
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person WHERE id = {$_GET['per']}", ARRAY_A );
		$item = $results[0];
		$update = true;
	}

	// mustBeNew causes check to ensure person with same email isn't already enrolled. If email is a duplicate, 
	// an error is shown and user must re-edit form. 
	if( $attributes['mustBeNew']) {

	}

	ob_start();
	?>
	
	<form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST" class="form-style-1">
		<input type="hidden" name="action" value="do-person-edit-block" required>
		<input type="hidden" name="url" value="<?php echo $attributes['redirectURL'];  ?>" required>
		<?php if( $update == "update" ) { ?>
		<input type="hidden" name="id" value="<?php echo $_GET['per'];  ?>" required>
		<?php } ?>
		
			<!-- <label>ID</label>
			<input type="text" name="id" class="field-divided" value="<?php /*echo $item['id']*/ ?>" placeholder="9" />
			-->
			<label>Name</label>
			<input type="text" name="firstname" class="field-divided" value="<?php echo $item['firstname'] ?>" placeholder="First" />
			<input type="text" name="lastname" class="field-divided" value="<?php echo $item['lastname'] ?>" placeholder="Last" />
			<label>Title</label>
			<input type="text" name="title" class="field-long" value="<?php echo $item['title'] ?>" placeholder="..." />
			<label>Company</label>
			<input type="text" name="company" class="field-long" value="<?php echo $item['company'] ?>" placeholder="Your Company Name" />
			<label>Email</label>
			<input type="text" name="email" class="field-long" value="<?php echo $item['email'] ?>" placeholder="you@yourcompany.com" />
			<input type="submit" value="Save" />
		</form>
	<div class="pz-target-div"><pre><?php /* echo wp_json_encode($attributes);*/ ?></pre></div>
	
	<?php
	return ob_get_clean();
}

$pz_cur_person = array(
    'id' => null,
    'firstname' => '',
    'lastname' => ''
  );


  /** 
   * Person table listing render function
   */

  function pz_person_list($attributes) {
	global $wpdb;
	global $pz_cur_person;

	wp_enqueue_script('aaa04', plugin_dir_url(__FILE__) . 'build/blocks/frontend.js', array('wp-element', 'wp-components'));
	
	// if flag is set, we should read in and prefill the current person record
	$item = array(
		'id' => null,
		'firstname' => '',
		'lastname' => ''
	);
	
	$per = null;
	if( isset($_GET['pzp'])) {
		$page = $_GET['pzp'];
	} else $page = 0;
	if( isset($_GET['per'])) {
		$per = $_GET['per'];
	}
	
	

	$limit = $attributes['numRows'];
	$offset = $limit * $page;
	

	if($per != null) {
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person WHERE lastname LIKE '$per' LIMIT $limit OFFSET $offset ", ARRAY_A );
	} else {
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person LIMIT $limit OFFSET $offset ", ARRAY_A );
		if( !isset($results[0])) {
			$offset=0;
			$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person LIMIT $limit OFFSET $offset ", ARRAY_A );
		};
	}
	

	

	ob_start();
	?>
	<form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST" class="form-style-1">
		<input type="hidden" name="action" value="do-person-search" required>
		<input type="text" name="search" style="text-align: right;" class="field-long" placeholder="Search..." >
	</form>
	<table class="pz-table-style" >
		
		<thead>
			<th>Edit</th>
			<th>Int.</th>
			<th>ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Title</th>
			<th>Company</th>
			<th>Email</th>
			<th>Phone</th>
		</thead>

	<?php

	foreach($results as $result) {
		$title = ($result['title'] == '') ? "-" : $result['title'];
		echo '<tr><td><a href=' . $attributes['editURL'] . '?per=' .$result['id'] . '><image src=' . plugin_dir_url(__FILE__) . 'includes\pencil.png width="40%"></a></td><td>';
		echo '<a href=' . '/interactions-all' .'/?per=' .$result['id'] . '><image src=' . plugin_dir_url(__FILE__) . 'includes\note.png width="80%"></a></td><td>';
		echo $result['id'] . '</td><td>';
		echo $result['firstname'] . '</td><td>';
		echo $result['lastname'] . '</td><td>';
		echo $title . '</td><td>';
		echo $result['company'] . '</td><td>';
		echo $result['email'] . '</td><td>';
		echo $result['phone1'] . '</td></tr>';
		

	}
	?>

	<tr>
		<td><a href="?pzp=<?php echo $page-1; ?>"><img src="<?php echo plugin_dir_url(__FILE__) ?>includes/left-arrow.png" width="80%"></a></td>
		<td></td>
		<td><a href="?pzp=<?php echo $page+1; ?>"><img src="<?php echo plugin_dir_url(__FILE__) ?>includes/right-arrow.png" width="40%"></a></td>
	</tr>
	</table>
	<?php 

	return ob_get_clean();
}

function pz_add_person() {
	ob_start();
	?>
	<form class="form-style-1" action="/add-a-person">
		<input type="submit" value="Add Person" >
</form>

	<?php
	return ob_get_clean();
}


// add_action('rest_api_init', 'set_up_person_rest_route');
// function set_up_person_rest_route() {
// 	register_rest_route('pz/v1', 'person', array(
// 		'methods' => WP_REST_SERVER::READABLE,
// 		'callback' => 'do_person'
// 	));
// }

// function do_person($stuff) {
// 	global $wpdb;
// 	$limit = 120;
// 	$offset = 0;

// 	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person ", ARRAY_A );
// 	if( !isset($results[0])) {
// 		$offset=0;
// 		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person LIMIT $limit OFFSET $offset ", ARRAY_A );
// 	};

// 	return $results;
// }


function pz_access_control () {
	if( !is_user_logged_in()) {
		return( "<h4>You gotta be logged in...</h4>");
		exit;
		// auth_redirect(); return to this -- Local seems to have a problem with logins right now... 
	}
}