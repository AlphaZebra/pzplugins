<?php

function pzfields_register() {

    $blocks = [
        [ 'name' => 'pz_textfield' ]
  //      [ 'name' => 'pzdropdown' ]
    ];

    foreach($blocks as $block) {
        if( $block['name'] == 'pz_textfield') {
            $render_prop = array( 'render_callback' => 'pz_textfield_block');
        }
        else if( $block['name'] == 'pzdropdown') {
            $render_prop = array( 'render_callback' => 'pz_dropdown');
        }
       
        else {
            $render_prop = array([]);
        }
        
            register_block_type(
                'http://suchthings.local/wp-content/plugins/pzfields/build/blocks/pztextfield/block.json',
                $render_prop
            );
        }
}


