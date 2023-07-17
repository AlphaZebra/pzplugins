<?php

function pz_interaction_block($attributes) {
	global $wpdb;
	global $pz_cur_person;
    $pz_cur_interaction = 1;

	// wp_enqueue_script('aaa04', plugin_dir_url(__FILE__) . 'build/blocks/pz_person_edit/frontend.js', array('wp-element', 'wp-components'), null, true);
	
    ob_start();
    ?>
    <form class="form-style-1">
        <label>Summary</label>
        <input
            type="text"
            class="field-long"
            placeholder="Basic description of interaction..."
        />
        <label>Details</label>
        <textarea cols="85" rows="8"></textarea>
        <input type="submit" value="Save" />
    </form>
    <?php

    return ob_get_clean();
    

}


function pz_inter_list ($attributes) {
    global $wpdb;
	global $pz_cur_person;

    $page = 0;
    $limit = /* $attributes['numRows']; */ 12;
	$offset = $limit * $page;


	
	if (isset($_GET['per'])) {
		$person = $_GET['per'];
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_interaction WHERE id IS $person ", ARRAY_A );

	} else {
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_interaction LIMIT $limit OFFSET $offset ", ARRAY_A );
		if( !isset($results[0])) {
			$offset=0;
			$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_interaction LIMIT $limit OFFSET $offset ", ARRAY_A );
		};
	}
	
	

    ob_start();
	if( !isset($results[0])) { return( pz_interaction_block($attributes)); }
	?>
	<table class="pz-table-style" >
		
		<thead>
			<th>Edit</th>
			<th>ID</th>
			<th>Summary</th>
			<th>Details</th>
		</thead>

	<?php

	foreach($results as $result) {
		echo '<tr><td><a href="\"><image src=' . plugin_dir_url(__FILE__) . './pencil.png width="40%"></a></td><td>';
		echo $result['int_id'] . '</td><td>';
		echo $result['summary'] . '</td><td>';
		echo $result['details'] . '</td></tr>';
		
		

	}
	?>

	<tr>
		<td><img src="<?php echo plugin_dir_url(__FILE__) ?>./left-arrow.png" width="80%"></td>
		<td></td>
		<td><img src="<?php echo plugin_dir_url(__FILE__) ?>./right-arrow.png" width="80%"></td>
	</tr>
	</table>
	<?php 

	return ob_get_clean();
}



