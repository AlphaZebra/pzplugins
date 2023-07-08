<?php
/**
 * Plugin Name:       pzprojectgrid
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
function create_block_pzprojectgrid_block_init() {
	register_block_type( __DIR__ . '/build' , array(
		'render_callback' => 'pz_project_grid_block'
	));
}
add_action( 'init', 'create_block_pzprojectgrid_block_init' );

function pz_project_grid_block($attributes) {

	wp_enqueue_script('pzgridfront', plugin_dir_url(__FILE__) . 'build/frontend.js', array('wp-element', 'wp-components'), null, true);
	$user_info = wp_get_current_user();
	ob_start();
	?>
<style>

.form-style-1 {
	margin: 10px auto;
	max-width: 400px;
	min-width: 200px;

	font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.form-style-1 li {
	padding: 0;
	display: block;
	list-style: none;
	margin: 10px 0 0 0;
}
.form-style-1 label {
	margin: 10px 0 3px 0;
	padding: 0px;
	display: block;
	font-weight: bold;
}
.form-style-1 input[type="text"],
.form-style-1 input[type="date"],
.form-style-1 input[type="datetime"],
.form-style-1 input[type="number"],
.form-style-1 input[type="search"],
.form-style-1 input[type="time"],
.form-style-1 input[type="url"],
.form-style-1 input[type="email"],
textarea,
select {
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	border: 1px solid #bebebe;
	padding: 7px;
	margin: 0px;
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
	-moz-transition: all 0.3s ease-in-out;
	-ms-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	outline: none;
}
.form-style-1 input[type="text"]:focus,
.form-style-1 input[type="date"]:focus,
.form-style-1 input[type="datetime"]:focus,
.form-style-1 input[type="number"]:focus,
.form-style-1 input[type="search"]:focus,
.form-style-1 input[type="time"]:focus,
.form-style-1 input[type="url"]:focus,
.form-style-1 input[type="email"]:focus,
.form-style-1 textarea:focus,
.form-style-1 select:focus {
	-moz-box-shadow: 0 0 8px #88d5e9;
	-webkit-box-shadow: 0 0 8px #88d5e9;
	box-shadow: 0 0 8px #88d5e9;
	border: 1px solid #88d5e9;
}
.form-style-1 .field-divided {
	width: 49%;
}

.form-style-1 .field-long {
	width: 100%;
}
.form-style-1 .field-select {
	width: 100%;
}
.form-style-1 .field-textarea {
	height: 100px;
}
.form-style-1 input[type="submit"],
.form-style-1 input[type="button"] {
	background: #4b99ad;
	margin-top: 20px;
	padding: 8px 15px 8px 15px;
	border: none;
	color: #fff;
}
.form-style-1 input[type="submit"]:hover,
.form-style-1 input[type="button"]:hover {
	background: #4691a4;
	box-shadow: none;
	-moz-box-shadow: none;
	-webkit-box-shadow: none;
}
.form-style-1 .required {
	color: red;
}


/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  padding-left: 200px;
  border: 1px solid #888;
  width: 60%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>



<h2>RyeCo Internal Project Management</h2>

<!-- Trigger/Open The Modal -->
<!-- <button id="myBtn">Open Modal</button> -->

<!-- The Modal -->
<div id="myModal" class="modal alignfull">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Some text in the Modal..</p>
	<form class="form-style-1">
		<input type="hidden" id="theid" />
		<input type="text" id="projectName" class="field-long">
		<input type="submit" value="Save">
	</form>
  </div>

</div>


	<div class="pz-target-div"><pre><?php echo wp_json_encode($attributes); ?></pre></div>
	
	<?php
	return ob_get_clean();
}

