<?php
/**
 * Plugin Name:       Pzdata
 * Description:       PeakZebra core tables and REST api. Activate this before installing/activating other
 *                    PZ plugins.
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

 
 if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 register_activation_hook(
	__FILE__,
	'pz_onActivate'
);

function pz_onActivate() {
  global $wpdb;
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

 

  $tablnam = $wpdb->prefix . "pz_person";
  $charset = $wpdb->get_charset_collate();
  

  dbDelta("CREATE TABLE wp_pz_person ( 
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    tenant_ID varchar(20) NOT NULL DEFAULT '',
    firstname varchar(20) NOT NULL DEFAULT '',
    lastname varchar(30) NOT NULL DEFAULT '',
    title varchar(30) NOT NULL DEFAULT '',
    company varchar(60) NOT NULL DEFAULT '',
    addr_line1 varchar(60) NOT NULL DEFAULT '',
    addr_line2 varchar(60) NOT NULL DEFAULT '',
    addr_city varchar(60) NOT NULL DEFAULT '',
    addr_state varchar(2) NOT NULL DEFAULT '',
    addr_zip varchar(12) NOT NULL DEFAULT '',
    email varchar(60) NOT NULL DEFAULT '',
    phone1 varchar(20) NOT NULL DEFAULT '',
    phone1_type varchar(20) NOT NULL DEFAULT '', 
    phone2 varchar(20) NOT NULL DEFAULT '',
    phone2_type varchar(20) NOT NULL DEFAULT '',
    username varchar(20) NOT NULL DEFAULT '',
    has_notes int(4) NOT NULL DEFAULT 0,
    pz_level varchar(12) NOT NULL DEFAULT '',
    pz_status varchar(10) NOT NULL DEFAULT '', 
    created varchar(12) NOT NULL DEFAULT '',
      PRIMARY KEY  (id)
  ) $charset;");

  // TODO - add check on whether there were errors creating table... 

  $tablnam = $wpdb->prefix . "pz_configuration";

  // the configuration file holds unique key pairs that store app-specific configuration settings. 
  dbDelta("CREATE TABLE $tablnam (
    config_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    config_key varchar(255) NOT NULL DEFAULT '',
    config_value varchar(255) NOT NULL DEFAULT '',
    created varchar(12) NOT NULL DEFAULT '',
    PRIMARY KEY  (config_id)
  ) $charset;");

  $tablnam = $wpdb->prefix . "pz_interaction";

  // tracking for interactions with people. 
  dbDelta("CREATE TABLE $tablnam (
    int_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    id bigint(20) NOT NULL DEFAULT 1,
    summary varchar(255) NOT NULL DEFAULT '',
    details varchar(800) NOT NULL DEFAULT '',
    created varchar(12) NOT NULL DEFAULT '',
    PRIMARY KEY  (int_id)
  ) $charset;");

  $tablnam = $wpdb->prefix . "pz_request_type";

  dbDelta("CREATE TABLE $tablnam (
    slug varchar(20) NOT NULL DEFAULT '',
    tenant_ID varchar(20) NOT NULL DEFAULT '',
    category varchar(20) NOT NULL DEFAULT '',
    display_name varchar(60) NOT NULL DEFAULT '',
    request_description varchar(500) NOT NULL DEFAULT '',
    created varchar(12) NOT NULL DEFAULT '',
    PRIMARY KEY  (slug)
  ) $charset;");

$tablnam = $wpdb->prefix . "pz_project";

$delta_string = "CREATE TABLE $tablnam (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  project_name varchar(80) NOT NULL DEFAULT '',
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  project_status varchar(20) NOT NULL DEFAULT '',
  project_lead bigint(20) NOT NULL DEFAULT 1,
  team_members varchar(40) NOT NULL DEFAULT '',
  project_description varchar(500) NOT NULL DEFAULT '',
  kickoff_date varchar(12) NOT NULL DEFAULT '',
  due_date varchar(12) NOT NULL DEFAULT '',
  budget varchar(20) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (project_id)
) $charset;";

dbDelta($delta_string);

$tablnam = $wpdb->prefix . "pz_request_queue";

dbDelta("CREATE TABLE $tablnam (
  requestID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  clientID bigint(20) unsigned NOT NULL,
  category varchar(20) NOT NULL DEFAULT '',
  slug varchar(20) NOT NULL DEFAULT '',
  display_name varchar(60) NOT NULL DEFAULT '',
  req_status varchar(20) NOT NULL DEFAULT '',
  req_priority bigint(10) unsigned DEFAULT 100,
  request_description varchar(500) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (requestID)
) $charset;");

$tablnam = $wpdb->prefix . "pz_calendar";

dbDelta("CREATE TABLE $tablnam (
  cal_event_ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  clientID bigint(20) unsigned NOT NULL,
  category varchar(20) NOT NULL DEFAULT '',
  event_name varchar(60) NOT NULL DEFAULT '',
  event_detail varchar(500) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (cal_event_id)
) $charset;");

$tablnam = $wpdb->prefix . "pz_cal_meeting_type";

dbDelta("CREATE TABLE $tablnam (
  cal_event_type_ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  clientID bigint(20) unsigned NOT NULL,
  meeting_name varchar(60) NOT NULL DEFAULT '',
  meeting_description varchar(500) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (cal_event_type_id)
) $charset;");

$tablnam = $wpdb->prefix . "pz_cal_availability";

dbDelta("CREATE TABLE $tablnam (
  cal_avail_date_ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  clientID bigint(20) unsigned NOT NULL DEFAULT 1,
  cal_event_type_id bigint(20) unsigned NOT NULL DEFAULT 1,
  cal_avail_slots varchar(100) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (cal_avail_date_ID)
) $charset;");

$tablnam = $wpdb->prefix . "pz_roadmap";

dbDelta("CREATE TABLE $tablnam (
  roadmap_ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  clientID bigint(20) unsigned NOT NULL DEFAULT 1,
  feature_name varchar(100) NOT NULL DEFAULT '',
  objectives varchar(15) NOT NULL DEFAULT '',
  key_result varchar(15) NOT NULL DEFAULT '',
  effort varchar(15) NOT NULL DEFAULT '',
  feature_status varchar(15) NOT NULL DEFAULT '',
  team varchar(40) NOT NULL DEFAULT '',
  release_quarter varchar(4) NOT NULL DEFAULT '',
  feature_description varchar(400) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (roadmap_ID)
) $charset;");

fillPersonTable();

  }

/**
 * Utility function for creating test data in person table
 */

  function fillPersonTable() {
    global $wpdb;
    $item = array();
  
    $firstnames = array(
      'Peter', 'Mary', 'Rosemary', 'Tal', 'Smoky', 'Penny', 'Luke', 'Hank', 'Patsy', 'Dolores'
    );
    $lastnames = array(
      'Parsifal', 'Mondrian', 'Telluride', 'Johnson', 'Mackie', 'Jansen', 'Moriarty', 'Clydesman', 'Sheeran', 'Booker'
    );
    $tenants = array(
      'AA1', 'AA2', 'BB', 'CC', 'DD3', 'LLL', 'HORS4', 'LKI', '779', 'PONY'
    );
    $titles = array (
      'Director',
      'Fun Captain',
      'Sargeant at Arms',
      'Horse Trader',
      'President',
      'Assistant Representative',
      'Tawdry Sales Guy',
      'Owner and Founder',
      'Chief Marketing Officer',
      'Chaplain'
    );
    $companies = array (
      'Gargantua',
      'Pelham Corporation',
      'Badger Depot',
      'Tartar and Sauce, LLC',
      'The Rock Salon',
      'Thrust Auto Body',
      'CoughSecure Inc.',
      'Regions Uncharted',
      'Peel and Pit',
      'Tortoise and Sons'
    );
  
    
  
    $item['id'] = null;
    $tablnam = $wpdb->prefix . "pz_person";

    
  
    for ($x = 0; $x <= 10; $x++) {
      $item['firstname'] = $firstnames[rand(0,9)];
      $item['lastname'] = $lastnames[rand(0,9)];
      $item['title'] = $titles[rand(0,9)];
      $item['company'] = $companies[rand(0,9)];
      if( $wpdb->insert( $tablnam, $item ) <= 0 ) {  
          var_dump( $wpdb );
          exit;
      }
      }
  
   
  }
  
  /**
   * REST API for retrieving person list... 
   */

  add_action('rest_api_init', 'set_up_person_rest_route');
  function set_up_person_rest_route() {
    register_rest_route('pz/v1', 'person', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => 'do_person'
    ));
  }
  
  function do_person($stuff) {
    global $wpdb;
    $limit = 120;
    $offset = 0;
  
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person ", ARRAY_A );
    if( !isset($results[0])) {
      $offset=0;
      $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person LIMIT $limit OFFSET $offset ", ARRAY_A );
    };
  
    return $results;
  }

  /**
   * REST API for retrieving project list... 
   */

   add_action('rest_api_init', 'set_up_project_rest_route');
   function set_up_project_rest_route() {
     register_rest_route('pz/v1', 'project', array(
       'methods' => WP_REST_SERVER::READABLE,
       'callback' => 'do_project'
     ));
     register_rest_route('pz/v1', 'putproj', array(
       'methods' => 'POST',
       'callback' => 'do_putproj'
     ));
   }
   
   function do_project($stuff) {
     global $wpdb;
     $limit = 120;
     $offset = 0;
   
     $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_project ", ARRAY_A );
     if( !isset($results[0])) {
       $offset=0;
       $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_project LIMIT $limit OFFSET $offset ", ARRAY_A );
     };
   
     return $results;
   }
  
   function do_putproj($data) {
    global $wpdb;
    $item = array();
    $item['id'] = $data['id'];
    $item['project_name'] = $data['project_name'];
    $item['tenant_ID'] = 'TEST';
    $item['project_status'] = $data['project_status'];
    $item['project_lead'] = 2;
    $item['team_members'] = '';
    $item['team_members'] = '';
    $item['project_description'] = 'Be a good lad, then.';
    $item['kickoff_date'] = $data['kickoff_date'];
    $item['due_date'] = $data['due_date'];
    $item['budget'] = $data['budget'];
    $item['created'] = '';


    
      $wpdb->update( "{$wpdb->prefix}pz_project", $item, array('id' => $data['id']) );

    return $data['project_name'];
 
    
   }

   /**
   * REST API for retrieving table structure... 
   */

  add_action('rest_api_init', 'set_up_structure_rest_route');
  function set_up_structure_rest_route() {
    register_rest_route('pz/v1', 'structure', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => 'do_structure'
    ));
  }
  
  function do_structure($stuff) {
    global $wpdb;
    $limit = 120;
    $offset = 0;
    // var_dump($_GET);
    // exit;
    $squery = "DESCRIBE " . $wpdb->prefix . $_GET['table'];
    $results = $wpdb->get_results( $squery, ARRAY_A );
    if( !isset($results[0])) {
      $offset=0;
      $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person LIMIT $limit OFFSET $offset ", ARRAY_A );
    };
  
    return $results;
  }
