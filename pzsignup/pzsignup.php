<?php
/**
 * Plugin Name:       pzsignup
 * Description:       Block that creates newsletter name and email signup form.
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

function create_block_pzsignup_block_init() {
	register_block_type( __DIR__ . '/build' , array(
		'render_callback' => 'pz_signup_block'
	));
}
add_action( 'init', 'create_block_pzsignup_block_init' );

add_action('admin_post_do-signup-edit-block', 'do_signup_edit_block');
add_action('admin_post_nopriv_do-signup-edit-block', 'do_signup_edit_block');

// remove 'username' field from login page
add_action('login_head', function(){
  ?>
  <style>
    #registerform label[for="user_login"], #registerform input#user_login {
      display:none;
    }
  </style>
  <?php
});

// force username for new users to be their email address
add_action('login_form_register', 'pz_set_registration_username');
 
function pz_set_registration_username(){
  //if there is anything set for user email
  if( isset($_POST['user_email']) && ! empty( $_POST['user_email'] ) ){
    //replace login with user email
    $_POST['user_login'] = $_POST['user_email'];
  }
}

//Remove error for username, only show error for email only.
add_filter('registration_errors', 'pz_registration_errors', 10, 3);
 
function pz_registration_errors($wp_error, $sanitized_user_login, $user_email){
  if(isset($wp_error->errors['empty_username'])){
    unset($wp_error->errors['empty_username']);
  }
 
  return $wp_error;
}

//replace WP strings with our own custom strings
add_filter('gettext', 'pz_custom_string', 20, 3);
function pz_custom_string( $translated_text, $text, $domain ) {
  if($translated_text == 'Username or Email Address'){
    //you can add any string you want here, as a case
    return 'Your email address';
  }
 
  return $translated_text;
}
// PZ_SECTION 2

function pz_signup_block($attributes) {
  global $wpdb;
  
 
  // set up $item array either with empty values or with values from existing record we're editing
  $item = array();
  $item['id'] =  null;
  $item['name'] =  '';
  $item['email'] = '';
  $item['username'] = '';
 
   
	ob_start();
?>


<form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST" class="form-style-1">
  <input type="hidden" name="action" value="do-signup-edit-block" required>
  <input type="hidden" name="id" id="id" value="<?php echo $item['id'] ?>" required>

  <label>Name:</label>
  <input type="text" id="name" name="name"  class="field-long" placeholder="Firstname Lastname" />
  <label>Email:</label>
  <input type="text" id="email" name="email"  class="field-long" placeholder="Your email" />
  
  <input type="submit" value="Subscribe!" />
  <input type="button" value="Read one first..." />
</form>


<?php


return( ob_get_clean());
	 
}

function do_signup_edit_block () {
  global $wpdb;
  $created = date("m/j/Y");

   // create the user in WordPress core, using email as username.
   // we wouldn't ordinarily do that (don't want to expose user's email address), but 
   // in this case the username won't ever be shown on site (except admin)
   // wp_create_user( $_POST['email'], 'crap-password', $_POST['email'] );

   $userdata = array(
    'user_login' =>  $_POST['email'],
    'user_email' => $_POST['email'],
    'first_name' => $_POST['name'],
    'user_pass'  =>  'Boston' // When creating an user, `user_pass` is expected.
  );

$user_id = wp_insert_user( $userdata ) ;


 
   




  

  // $item = [];

  // $item['id'] = null;
  // $item['project_name'] = stripslashes(sanitize_text_field($_POST['project_name']));
  // $item['project_status'] = sanitize_text_field($_POST['project_status']);
  // $item['project_lead'] = sanitize_text_field($_POST['project_lead']);
  // $item['project_lead_name'] = sanitize_text_field($_POST['project_lead_name']);
  // $item['team_members'] = '';
  // $item['project_description'] = stripslashes(sanitize_text_field($_POST['project_description']));
  // $item['tasks'] = sanitize_text_field($_POST['tasks']);
  // $item['kickoff_date'] = sanitize_text_field($_POST['kickoff_date']);
  // $item['due_date'] = sanitize_text_field($_POST['due_date']);
  // $item['budget'] = '';
  // $item['tenant_ID'] = '';
  // $item['created']= $created;


  // $tablnam = $wpdb->prefix . "pz_project";
  // // if we're updating, we'll use a different SQL command
  // if(  $_POST['id'] > 0  )  {
  //     $item['id'] = $_POST['id'];
      
  //     if ($wpdb->update( $tablnam, $item, array('id' => $item['id']) ) < 0) {
  //       var_dump($wpdb);
  //       exit;
  //     }
  //     $pz_id = $item['id'];

  // } else {
  //     if( $wpdb->insert( $tablnam, $item ) <= 0 ) {  
  //         var_dump( $wpdb );
  //         exit;
  //     }

  //     $pz_id = $wpdb->insert_id;  // this is the id number of the record we just inserted
  // }


  
  wp_redirect('/' );
  exit;
}