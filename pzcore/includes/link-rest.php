<?php

/**
   * REST API for retrieving resource link list... 
   */

   add_action('rest_api_init', 'set_up_link_rest_route');
   function set_up_link_rest_route() {
     register_rest_route('pz/v1', 'link', array(
       'methods' => WP_REST_SERVER::READABLE,
       'callback' => 'do_link'
     ));
    
   }
   
   function do_link($stuff) {
     global $wpdb;
     $limit = 120;
     $offset = 0;

     if (isset($_GET['cat'])) {
      $qstr = "SELECT * FROM {$wpdb->prefix}pz_link WHERE link_tag = '{$_GET['cat']}'";
     } else {
      $qstr = "SELECT * FROM {$wpdb->prefix}pz_link ";
     }
     $results = $wpdb->get_results( $qstr , ARRAY_A );
    
     return $results;
   }
  
   
