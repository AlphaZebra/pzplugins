<?php
/**
 * Plugin Name:       pzprojectform
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

 // PZ_SECTION 1

function create_block_pzprojectform_block_init() {
	register_block_type( __DIR__ . '/build' , array(
		'render_callback' => 'pz_project_form_block'
	));
}
add_action( 'init', 'create_block_pzprojectform_block_init' );

add_action('admin_post_do-project-edit-block', 'do_project_edit_block');
add_action('admin_post_nopriv_do-project-edit-block', 'do_project_edit_block');

// PZ_SECTION 2

function pz_project_form_block($attributes) {

  // PZ_SECTION 3

	wp_enqueue_script('pzprojform', plugin_dir_url(__FILE__) . 'build/pzprojectform.js', array('wp-element', 'wp-components'), null, true);
	// $user_info = wp_get_current_user();
	// ob_start();

  // PZ_SECTION 4
  
  return( '<div class="pzdiv">Jello Dar</div>' );
	 
}

function do_project_edit_block () {
  global $wpdb;
  $created = date("m/j/Y");

  $item = [];

  $item['id'] = null;
  $item['project_name'] = sanitize_text_field($_POST['project_name']);
  $item['project_status'] = sanitize_text_field($_POST['project_status']);
  $item['project_lead'] = sanitize_text_field($_POST['project_lead']);
  $item['team_members'] = '';
  $item['project_description'] = '';
  $item['kickoff_date'] = sanitize_text_field($_POST['kickoff_date']);
  $item['due_date'] = sanitize_text_field($_POST['due_date']);
  $item['budget'] = sanitize_text_field($_POST['budget']);
  $item['tenant_ID'] = '';
  $item['created']= $created;

  // var_dump($item);
  // exit;

  $tablnam = $wpdb->prefix . "pz_project";
  // if we're updating, we'll use a different SQL command
  if( isset( $_POST['update'] ) )  {
      $item['id'] = $_POST['id'];
      $wpdb->update( $tablnam, $item, array('id' => $item['id']) );
      $pz_id = $item['id'];

  } else {
      if( $wpdb->insert( $tablnam, $item ) <= 0 ) {  
          var_dump( $wpdb );
          exit;
      }
  
      $pz_id = $wpdb->insert_id;  // this is the id number of the record we just inserted
  }

 
  // var_dump($pz_id);
  // exit;
 
  // setcookie('pz_num', $pz_id, time()+31556926);
  
  wp_redirect('/?pznum=' . $pz_id);
  exit;
}