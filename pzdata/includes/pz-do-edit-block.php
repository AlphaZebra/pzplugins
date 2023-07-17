<?php

add_action('admin_post_do-person-edit-block', 'do_person_edit_block');
add_action('admin_post_nopriv_do-person-edit-block', 'do_person_edit_block');
add_action('admin_post_nopriv_do-person-search', 'do_person_search');
add_action('admin_post_do-person-search', 'do_person_search');


function do_person_edit_block( ) {
    global $wpdb;
    $created = date("m/j/Y");


    $item = [];

    $item['id'] = null;
    $item['firstname'] = sanitize_text_field($_POST['firstname']);
    $item['lastname'] = sanitize_text_field($_POST['lastname']);
    $item['title'] = sanitize_text_field($_POST['title']);
    $item['email'] = sanitize_text_field($_POST['email']);
    $item['company'] = sanitize_text_field($_POST['company']);
    $item['tenant_ID'] = '';
    $item['addr_line1'] = '';
    $item['addr_line2'] = '';
    $item['addr_city'] = '';
    $item['addr_state'] = '';
    $item['addr_zip'] = '';
    $item['phone1'] = '';
    $item['phone1_type'] = '';
    $item['phone2'] = '';
    $item['phone2_type'] = '';
    $item['username'] = '';
    $item['has_notes'] = 0;
    $item['last_contact'] = '';
    $item['pz_level'] = '';
    $item['pz_status'] = '';
    $item['created']= $created;

    // var_dump($item);
    // exit;

    $tablnam = $wpdb->prefix . "pz_person";
    // if we're updating, we'll use a different SQL command
    if( isset($_POST['id'])) {
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
    $redirectURL = $_POST['url'] . '?pznum=' . $pz_id;
    // var_dump($redirectURL);
    // exit;
    
    wp_redirect($redirectURL);
    exit;

}

function do_person_search() {
    wp_redirect('/come-persons/?per=' . $_POST['search']);
    exit;
}