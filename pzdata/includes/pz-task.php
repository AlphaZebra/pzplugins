<?php

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