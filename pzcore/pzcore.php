<?php
/**
 * Plugin Name:       Pzcore
 * Description:       PeakZebra core tables and includes for REST api. Activate this before installing/activating other
 *                    PZ plugins.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Robert Richardson
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pzcore
 *
 * @package           pzcore
 *
 */

 require_once( 'includes/core-config.php');
 require_once( 'includes/task-rest.php');
 
 if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 register_activation_hook(
	__FILE__,
	'pz_onActivate'
);

function pz_onActivate() {
  global $wpdb;
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

  $charset = $wpdb->get_charset_collate();
  $table_str = $wpdb->prefix . "pz_table_str";

  // this table contains the field definitions for all the other tables in the pz system. 
  dbDelta("CREATE TABLE $table_str (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    table_name varchar(255) NOT NULL DEFAULT '',
    field_string varchar(1200) NOT NULL DEFAULT '',
    created varchar(12) NOT NULL DEFAULT '',
    PRIMARY KEY  (id)
  ) $charset;");

  // fill the table with field definition records for all the tables... 
  // start with person

  $table_name = $wpdb->prefix . "pz_person";

  $item = array();
  $item['id'] = null;
  $item['table_name'] = 'pz_person';
  $item['field_string'] = "CREATE TABLE $table_name ( 
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
    last_contact varchar(12) NOT NULL DEFAULT '',
    pz_level varchar(12) NOT NULL DEFAULT '',
    pz_status varchar(10) NOT NULL DEFAULT '', 
    created varchar(12) NOT NULL DEFAULT '',
      PRIMARY KEY  (id)
  ) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);
//handle_form_render();




$table_name = $wpdb->prefix . "pz_configuration";

// configuration table


$item['table_name'] = 'pz_configuration';
$item['field_string'] = "CREATE TABLE $table_name (
  config_key varchar(255) NOT NULL DEFAULT '',
  config_value varchar(255) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (config_key)
) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);

// handle_render_callback();



// interaction table
$table_name = $wpdb->prefix . "pz_interaction";

// interaction table
$item = array();
$item['id'] = null;
$item['table_name'] = 'pz_interaction';
$item['field_string'] = "CREATE TABLE $table_name (
  int_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  id bigint(20) NOT NULL DEFAULT 1,
  summary varchar(255) NOT NULL DEFAULT '',
  details varchar(800) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (int_id)
) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);



// request_type
$table_name = $wpdb->prefix . "pz_request_type";

$item = array();
$item['id'] = null;
$item['table_name'] = 'pz_request_type';
$item['field_string'] = "CREATE TABLE $table_name (
  slug varchar(20) NOT NULL DEFAULT '',
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  category varchar(20) NOT NULL DEFAULT '',
  display_name varchar(60) NOT NULL DEFAULT '',
  request_description varchar(500) NOT NULL DEFAULT '',
  request_level varchar(10) NOT NULL DEFAULT 'one',
  post_url varchar(255) NOT NULL DEFAULT 'admin-post.php',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (slug)
) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);



// project
$table_name = $wpdb->prefix . "pz_project";

$item = array();
$item['id'] = null;
$item['table_name'] = 'pz_project';
$item['field_string'] = "CREATE TABLE $table_name (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  project_name varchar(80) NOT NULL DEFAULT '',
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  project_status varchar(20) NOT NULL DEFAULT '',
  project_lead bigint(20) NOT NULL DEFAULT 1,
  project_lead_name varchar(120) NOT NULL DEFAULT '',
  team_members varchar(40) NOT NULL DEFAULT '',
  project_description varchar(500) NOT NULL DEFAULT '',
  kickoff_date varchar(12) NOT NULL DEFAULT '',
  due_date varchar(12) NOT NULL DEFAULT '',
  budget varchar(20) NOT NULL DEFAULT '',
  tasks smallint(5) unsigned NOT NULL DEFAULT 0, 
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (id)
) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);



// request_queue
$table_name = $wpdb->prefix . "pz_request_queue";

$item = array();
$item['id'] = null;
$item['table_name'] = 'pz_request_type';
$item['field_string'] = "CREATE TABLE $table_name (
  requestID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  username varchar(60) NOT NULL DEFAULT '',
  category varchar(20) NOT NULL DEFAULT '',
  slug varchar(20) NOT NULL DEFAULT '',
  display_name varchar(60) NOT NULL DEFAULT '',
  req_status varchar(20) NOT NULL DEFAULT '',
  req_priority bigint(10) unsigned DEFAULT 100,
  request_description varchar(500) NOT NULL DEFAULT '',
  request_detail varchar(1500) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (requestID)
) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);



// calendar
$table_name = $wpdb->prefix . "pz_calendar";

$item = array();
$item['id'] = null;
$item['table_name'] = 'pz_calendar';
$item['field_string'] = "CREATE TABLE $table_name (
  cal_event_ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  clientID bigint(20) unsigned NOT NULL,
  category varchar(20) NOT NULL DEFAULT '',
  event_name varchar(60) NOT NULL DEFAULT '',
  event_detail varchar(500) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (cal_event_id)
) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);



// cal_meeting_type
$table_name = $wpdb->prefix . "pz_cal_meeting_type";

$item = array();
$item['id'] = null;
$item['table_name'] = 'pz_cal_meeting_type';
$item['field_string'] = "CREATE TABLE $table_name (
  cal_event_type_ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  clientID bigint(20) unsigned NOT NULL,
  meeting_name varchar(60) NOT NULL DEFAULT '',
  meeting_description varchar(500) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (cal_event_type_id)
) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);



// cal_availability
$table_name = $wpdb->prefix . "pz_cal_availability";

$item = array();
$item['id'] = null;
$item['table_name'] = 'pz_cal_availability';
$item['field_string'] = "CREATE TABLE $table_name (
  cal_avail_date_ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  tenant_ID varchar(20) NOT NULL DEFAULT '',
  clientID bigint(20) unsigned NOT NULL DEFAULT 1,
  cal_event_type_id bigint(20) unsigned NOT NULL DEFAULT 1,
  cal_avail_slots varchar(100) NOT NULL DEFAULT '',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (cal_avail_date_ID)
) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);



// cal_roadmap
$table_name = $wpdb->prefix . "pz_roadmap";

$item = array();
$item['id'] = null;
$item['table_name'] = 'pz_roadmap';
$item['field_string'] = "CREATE TABLE $table_name (
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
) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);


// task
$table_name = $wpdb->prefix . "pz_task";

$item = array();
$item['id'] = null;
$item['table_name'] = 'pz_task';
$item['field_string'] = "CREATE TABLE $table_name (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  tenant_id varchar(20) NOT NULL DEFAULT '',
  app_id varchar(20) NOT NULL DEFAULT '',
  project_id bigint(20) unsigned NOT NULL DEFAULT 1,
  task_name varchar(200) NOT NULL DEFAULT '',
  kickoff_date varchar(12) NOT NULL DEFAULT '',
  due_date varchar(12) NOT NULL DEFAULT '',
  task_assignee varchar(180) NOT NULL DEFAULT 'unassigned',
  created varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY  (id)
) $charset;";

handle_def_record($item);
dbDelta($item['field_string']);




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
 * Create all tables for initialization
 * or optionally use parameter to create a single table
 */

function createPZTables() {
  global $wpdb;
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

  $charset = $wpdb->get_charset_collate();
  $tablnam = $wpdb->prefix . "pz_person";



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
  
    if( isset($_GET['per'])) {
      $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person WHERE id = {$_GET['per']} ", ARRAY_A );
      return $results;
    }
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person WHERE firstname = 'Mary' ", ARRAY_A );
    if( !isset($results[0])) {
      $offset=0;
      //$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_person LIMIT $limit OFFSET $offset ", ARRAY_A );
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
    if( $data[id] == 0 ) {
      $item['id'] = null;
    } else {
      $item['id'] = $data['id'];
    }
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

    var_dump($item);
    exit;

    
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


  function handle_def_record($item) {
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pz_table_str WHERE table_name = '{$item['table_name']}'", ARRAY_A );
   
    if( isset($results[0])) {
      $wpdb->update( "{$wpdb->prefix}pz_table_str", $item, array('table_name' => $item['table_name']) );
    } else {
      if( $wpdb->insert( "{$wpdb->prefix}pz_table_str", $item ) <= 0 ) {  
        var_dump( $wpdb );
        exit;
      }
    }
    return true;
  }


  function handle_render_callback() {
    // open file
    if( !is_dir('C:\Users\Rugge\Local Sites\suchthings\app\public\wp-content\plugins\pzcore\includes')) {
      mkdir('C:\Users\Rugge\Local Sites\suchthings\app\public\wp-content\plugins\pzcore\includes');
    }
    $myfile = fopen('C:\Users\Rugge\Local Sites\suchthings\app\public\wp-content\plugins\pzcore\includes\personform.php', 'w');
    if($myfile == false) die("dead");
    // $contents = handle_form_render();
    //write contents
    fwrite($myfile, $contents);
    //close file
    fclose($myfile);
  }


  function handle_form_render() {
    global $wpdb;
    // get the definition for each field for each table, then create a file 
    // that writes the html for a form with an input for each field

    $results = $wpdb->get_results( "DESCRIBE {$wpdb->prefix}pz_person ", ARRAY_A );
    ob_start();
    echo( "<?php\n")
    ?> 
    
  function pz_person_form( $attributes ) {
  ob_start();
	?>
	
	<form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST" class="form-style-1">
		<input type="hidden" name="action" value="do-person-edit-block" required>
	
    <?php 
    foreach($results as $result) {
      if($result['Field'] != 'id' && $result['Field'] != 'tenant_ID') {
        // create field
        $fieldstuff = "<input type='text' name=" . $result['Field'] . ">" ;
        echo($fieldstuff . "<br>\n");
      }
    }
    echo("</form>\n");
    echo("<?php\n");
    echo( "return ob_get_clean();");
    echo( "}");
    

    return ob_get_clean();


  }

/**
   * REST API for validating a primary key value is unique prior to form submission... 
   */

   add_action('rest_api_init', 'set_up_validation_rest_route');
   function set_up_validation_rest_route() {
     register_rest_route('pz/v1', 'unique', array(
       'methods' => WP_REST_SERVER::READABLE,
       'callback' => 'do_unique'
     ));
   }
   
   function do_unique($stuff) {
     global $wpdb;
     $limit = 120;
     $offset = 0;
     // var_dump($_GET);
     // exit;
     $tablnam = $wpdb->prefix . $_GET['table'];
     $keyval = $_GET['value'];
     $results = $wpdb->get_results( "SELECT * FROM $tablnam WHERE slug = '$keyval' ", ARRAY_A );
     if( isset($results[0])) {
       return( false );
     };
   
     return true;
   }

  add_filter( 'block_categories_all' , function( $categories ) {

    // Adding a new category.
	$categories[] = array(
		'slug'  => 'peak-zebra',
		'title' => 'PeakZebra'
	);

	return $categories;
} );