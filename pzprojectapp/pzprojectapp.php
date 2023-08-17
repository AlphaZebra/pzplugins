<?php
/**
 * Plugin Name:       pzprojectapp
 * Description:       Plugin sets up template project management app.
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


 if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 register_activation_hook(
	__FILE__,
	'pz_onProjectActivate'
);

function pz_onProjectActivate() {
    //  $objPage = get_page_by_title($title_of_the_page, 'OBJECT', 'page');
    //  if( ! empty( $objPage ) )
    //  {
    //      echo "Page already exists:" . $title_of_the_page . "<br/>";
    //      exit;
    //      return $objPage->ID;
    //  }
     
     $page_id = wp_insert_post(
             array(
             'comment_status' => 'close',
             'ping_status'    => 'close',
             'post_author'    => 1,
             'post_title'     => 'PeakZebra Project list',
             'post_name'      => 'peakzebra-project-list',
             'post_status'    => 'publish',
             'post_content'   => "<!-- wp:heading {'level':5} -->
             <h5 class='wp-block-heading'\>Current Projects:</h5>
             <!-- /wp:heading -->
             
             <!-- wp:pz/pzprojectgrid /-->",
             'post_type'      => 'page',
             ),
             true  // return wp_error
         );

         if(!is_wp_error($page_id)){
            //the post is valid
          }else{
            //there was an error in the post insertion, 
            var_dump($page_id);
            exit;
          }
  
    
  
    //  $page_id = wp_insert_post(
    //          array(
    //          'comment_status' => 'close',
    //          'ping_status'    => 'close',
    //          'post_author'    => 1,
    //          'post_title'     => 'PeakZebra Project Info',
    //          'post_name'      => 'peakzebra-project-info',
    //          'post_status'    => 'publish',
    //          'post_content'   => "<!-- wp:heading {'level':5} -->
    //          <h5 class='wp-block-heading'\>Current Projects:</h5>
    //          <!-- /wp:heading -->
             
    //          <!-- wp:pz/pzprojectform /-->
             
    //          <!-- wp:pz/pztaskgrid /-->",
    //          'post_type'      => 'page',
    //          'post_parent'    =>  $parent_id //'id_of_the_parent_page_if_it_available'
    //          ),
    //          true  // return wp_error
    //      );

    //      if(!is_wp_error($page_id)){
    //         //the post is valid
    //       }else{
    //         //there was an error in the post insertion, 
    //         var_dump($page_id);
    //         exit;
    //       }

    //       $page_id = wp_insert_post(
    //         array(
    //         'comment_status' => 'close',
    //         'ping_status'    => 'close',
    //         'post_author'    => 1,
    //         'post_title'     => 'PeakZebra Task Info',
    //         'post_name'      => 'peakzebra-task-info',
    //         'post_status'    => 'publish',
    //         'post_content'   => "<!-- wp:heading {'level':5} -->
    //         <h5 class='wp-block-heading'\>Current Projects:</h5>
    //         <!-- /wp:heading -->
            
    //         <!-- wp:pz/pztaskgrid /-->",
    //         'post_type'      => 'page',
    //         'post_parent'    =>  $parent_id //'id_of_the_parent_page_if_it_available'
    //         ),
    //         true  // return wp_error
    //     );

    //     if(!is_wp_error($page_id)){
    //        //the post is valid
    //      }else{
    //        //there was an error in the post insertion, 
    //        var_dump($page_id);
    //        exit;
    //      }
  
 

 

}

 