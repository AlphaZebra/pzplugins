<?php

add_action('admin_post_do-task-form', 'do_task_form');
add_action('admin_post_nopriv_do-task-form', 'do_task_form');

/**
 * pz_task_form
 */

function pz_task_form($attributes) {
	global $wpdb;

	

	$item = array(
		'id' => 0,
		'tenant_ID' =>  '',
		'project_id' => '',
		'task_name' => '',
		'task_status' => '',
		'kickoff_date' => '',
		'due_date' => '',
		'task_assignee' => '',
		'created' => '',
	);
	
	if(isset($_GET['t'])) {
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_task WHERE id = {$_GET['t']}", ARRAY_A );

		$item = $results[0];
	} else {
		
	}

	if( isset($_GET['prj'])) {
		$item['project_id'] = $_GET['prj'];
	}

	$pend_status = '';
	if( $item['task_status'] == 'pending') {
		$pend_status = 'selected';
	} 
	if( $item['task_status'] == 'inprocess') $proc_status = 'selected'; else $proc_status = '';
	if( $item['task_status'] == 'review') $review_status = 'selected'; else $review_status = '';
	if( $item['task_status'] == 'done') $done_status = 'selected'; else $done_status = '';

	ob_start();
	?>
	
	<form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST" class="form-style-1">
		<input type="hidden" name="action" value="do-task-form" required>
		<input type="hidden" name="id" value="<?php echo $item['id'] ?>" required>
		<input type="hidden" name="project_id" value="<?php echo $item['project_id'] ?>" required>
		<input type="hidden" name="tenant_ID" value="<?php echo $item['tenant_ID'] ?>" required>
		<input type="hidden" name="listURL" value="<?php echo $attributes['listURL'] ?>" required>
			
		
			<label>Task name</label>
			<input type="text" name="task_name" class="field-long" value="<?php echo $item['task_name'] ?>" />
			<label for="status">Task status</label>
			<select name="status" id="status">
			<option value="pending" <?php echo $pend_status;  ?> >Pending</option>
			<option value="inprocess" <?php echo $proc_status;  ?> >In Process</option>
			<option value="review" <?php echo $review_status;  ?> >Review</option>
			<option value="done" <?php echo $done_status;  ?> >Done</option>
			</select>
			<label>Kickoff date</label>
			<input type="date" name="kickoff_date" class="field-divided" value="<?php echo $item['kickoff_date'] ?>"  />
			<label>Due date</label>
			<input type="date" name="due_date" class="field-divided" value="<?php echo $item['due_date'] ?>"  />
			<label>Assignee</label>
			<input type="text" name="task_assignee" class="field-long" value="<?php echo $item['task_assignee'] ?>" placeholder="Team member..." />
			<input type="submit" value="Save" />
		</form>
	<div class="pz-target-div"><pre><?php /* echo wp_json_encode($attributes);*/ ?></pre></div>
	
	<?php
	return ob_get_clean();
}



function pz_task_list() {
    global $wpdb;
    //wp_enqueue_script('pztask', plugin_dir_url(__FILE__) . 'build/blocks/pz_task_list/pztask.js', array('wp-element', 'wp-components'), null, true);
    
    // get the tasks for the specific project 

    $limit = 10;
    $offset = 0;

    if (isset($_GET['prj'])) {
		$project = $_GET['prj'];
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_task WHERE project_id = $project ", ARRAY_A );

	} else {
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_task ", ARRAY_A );
		if( !isset($results[0])) {
			$offset=0;
			$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_task LIMIT $limit OFFSET $offset ", ARRAY_A );
		};
	}

   

    ob_start();

  
    ?>
    
    <table class="pz-table-style" >
		
		<thead width=600>
			<th>Edit</th>
			<th>ID</th>
			<th>Task</th>
			
		</thead>

	<?php
      if(!isset($results[0])) {
        echo "<tr><td>No tasks found for this project.</td></tr>";
    } else {
        foreach($results as $result) {
            echo "<tr><td>edit </td><td>";
            echo $result['id'] . '</td><td>';
            echo $result['task_name'] . '</td></tr>';
            
        }
    }
    

	
	?>

	
	</table>
	<?php 

	return ob_get_clean();


}

function do_task_form () {
	global $wpdb;
	$created = date("m/j/Y");
  
	$item = [];
  
	$item['id'] = sanitize_text_field($_POST['id']);
	$item['tenant_ID'] = isset($_POST['tenant_ID']) ? sanitize_text_field($_POST['tenant_ID']) : 'none';
	$item['project_id'] = isset($_POST['project_id']) ? sanitize_text_field($_POST['project_id']) : '0';
	$item['task_name'] = isset($_POST['task_name']) ? sanitize_text_field($_POST['task_name']) : 'unnamed';
	$item['kickoff_date'] = isset($_POST['kickoff_date']) ? sanitize_text_field($_POST['kickoff_date']) : 'none';
	$item['due_date'] = isset($_POST['due_date']) ? sanitize_text_field($_POST['due_date']) : 'none';
	$item['task_assignee'] = isset($_POST['task_assignee']) ? sanitize_text_field($_POST['task_assignee']) : 'none';
	$item['created']= $created;
  
  
	$tablnam = $wpdb->prefix . "pz_task";
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
  
   
	// var_dump($pz_id);
	// exit;
   
	// setcookie('pz_num', $pz_id, time()+31556926);
	
	wp_redirect( $_POST['listURL'] . '?prj=' . $item['project_id']);
	exit;
  }