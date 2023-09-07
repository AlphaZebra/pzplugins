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

// normally commented out... 
// defined('DEMO') || define( 'DEMO', true );

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
  global $wpdb;
  
  // we'll get a url parameter telling us which project id to edit. If 0, we're creating a new project.
  $row = array();
  if( isset($_GET['prj'])) {
    if( $_GET['prj'] != '0') {
      // query for the record
      $rows = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_project WHERE id = {$_GET['prj']} ", ARRAY_A );
      $row = $rows[0];
    }
  } 

  // set up $item array either with empty values or with values from existing record we're editing
  $item = array();
  $item['id'] = isset($row['id']) ? $row['id'] : null;
  $item['project_name'] = isset($row['project_name']) ? $row['project_name'] : '';
  $item['project_status'] = isset($row['project_status']) ? $row['project_status'] : 'pending';
  $item['tasks'] = isset($row['tasks']) ? $row['tasks'] : 0;
  $item['project_lead'] = isset($row['project_lead']) ? $row['project_lead'] : '';
  $item['project_lead_name'] = isset($row['project_lead_name']) ? $row['project_lead_name'] : '';
  $item['project_description'] = isset($row['project_description']) ? $row['project_description'] : '';
  $item['kickoff_date'] = isset($row['kickoff_date']) ? $row['kickoff_date'] : '';
  $item['due_date'] = isset($row['due_date']) ? $row['due_date'] : '';
   
	ob_start();
?>


<form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST" class="form-style-1">
  <input type="hidden" name="action" value="do-project-edit-block" required>
  <input type="hidden" name="id" id="id" value="<?php echo $item['id'] ?>" required>
  <input type="hidden" name="tasks" id="tasks" value="<?php echo $item['tasks'] ?>" required>

  <label>Project name</label>
  <input type="text" id="project_name" name="project_name" value="<?php echo $item['project_name']  ?>" class="field-long" placeholder="Do the things..." />
  <label for="project_status">Status</label>

  <select name="project_status" id="project_status" >
    <option value="pending" <?php echo $item['project_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
    <option value="inprogress" <?php echo $item['project_status'] == 'inprocess' ? 'selected' : '' ?>>In Process</option>
    <option value="inreview" <?php echo $item['project_status'] == 'inreview' ? 'selected' : '' ?> >Review</option>
    <option value="done" <?php echo $item['project_status'] == 'done' ? 'selected' : '' ?>>Done</option>
  </select>


  <label>Project lead</label>
  <input type="text" id="project_lead_name" name="project_lead_name" value="<?php echo $item['project_lead_name']  ?>" class="field-long" placeholder="Team leader..." />

  <label>Project description</label>
  <textarea id="project_description" name="project_description" cols="100" rows="10" >
    <?php 
    if ( isset($item['project_description'])) {
      echo $item['project_description'];
    }
    ?> 
  </textarea>
  <p></p>

  <label>Kickoff date</label>
  <input type="date" id="kickoff_date" name="kickoff_date" value="<?php echo $item['kickoff_date']  ?>"/>
  <label>Due date</label>
  <input type="date" id="due_date" name="due_date" value="<?php echo $item['due_date']  ?>"/>
  <p></p>
  <input type="submit" value="Save" />
  <input type="button" onClick="window.history.go(-1);" value="Cancel" />
</form>


<?php


return( ob_get_clean());
	 
}

function do_project_edit_block () {
  global $wpdb;
  $created = date("m/j/Y");

  // if( defined( 'DEMO' )) {
  //   wp_redirect('/?pznum=0' );
  //   exit;
  // }
  

  $item = [];

  $item['id'] = null;
  $item['project_name'] = stripslashes(sanitize_text_field($_POST['project_name']));
  $item['project_status'] = sanitize_text_field($_POST['project_status']);
  $item['project_lead'] = sanitize_text_field($_POST['project_lead']);
  $item['project_lead_name'] = sanitize_text_field($_POST['project_lead_name']);
  $item['team_members'] = '';
  $item['project_description'] = stripslashes(sanitize_text_field($_POST['project_description']));
  $item['tasks'] = sanitize_text_field($_POST['tasks']);
  $item['kickoff_date'] = sanitize_text_field($_POST['kickoff_date']);
  $item['due_date'] = sanitize_text_field($_POST['due_date']);
  $item['budget'] = '';
  $item['tenant_ID'] = '';
  $item['created']= $created;


  $tablnam = $wpdb->prefix . "pz_project";
  // if we're updating, we'll use a different SQL command
  if(  $_POST['id'] > 0  )  {
      $item['id'] = $_POST['id'];
      
      if ($wpdb->update( $tablnam, $item, array('id' => $item['id']) ) < 0) {
        var_dump($wpdb);
        exit;
      }
      $pz_id = $item['id'];

  } else {
      if( $wpdb->insert( $tablnam, $item ) <= 0 ) {  
          var_dump( $wpdb );
          exit;
      }

      $pz_id = $wpdb->insert_id;  // this is the id number of the record we just inserted
  }


  
  wp_redirect('/?pznum=' . $pz_id);
  exit;
}