<?php

/**
   * REST API for retrieving (project) task list... 
   */

   add_action('rest_api_init', 'set_up_task_rest_route');
   function set_up_task_rest_route() {
     register_rest_route('pz/v1', 'task', array(
       'methods' => WP_REST_SERVER::READABLE,
       'callback' => 'do_task'
     ));
    //  register_rest_route('pz/v1', 'putproj', array(
    //    'methods' => 'POST',
    //    'callback' => 'do_putproj'
    //  ));
   }
   
   function do_task($stuff) {
     global $wpdb;
     $limit = 120;
     $offset = 0;

     if( isset($_GET['app'])) {
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_task WHERE app_name = '{$_GET['app']}' ", ARRAY_A );
     } else  $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_task WHERE project_id = {$_GET['prj']} ", ARRAY_A );
     
   
     return $results;
   }
  
//    function do_putproj($data) {
//     global $wpdb;
//     $item = array();
//     if( $data[id] == 0 ) {
//       $item['id'] = null;
//     } else {
//       $item['id'] = $data['id'];
//     }
//     $item['project_name'] = $data['project_name'];
//     $item['tenant_ID'] = 'TEST';
//     $item['project_status'] = $data['project_status'];
//     $item['project_lead'] = 2;
//     $item['team_members'] = '';
//     $item['team_members'] = '';
//     $item['project_description'] = 'Be a good lad, then.';
//     $item['kickoff_date'] = $data['kickoff_date'];
//     $item['due_date'] = $data['due_date'];
//     $item['budget'] = $data['budget'];
//     $item['created'] = '';

//     var_dump($item);
//     exit;

    
//       $wpdb->update( "{$wpdb->prefix}pz_project", $item, array('id' => $data['id']) );

//     return $data['project_name'];
 
    
//    }
