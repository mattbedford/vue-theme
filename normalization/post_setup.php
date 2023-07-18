<?php


//Create custom post type for photo galleries
function report_post_type() {
    register_post_type( 'report',
        array(
            'labels' => array(
                'name' => __( 'Reports' ),
                'singular_name' => __( 'Report' )
            ),
			'menu_icon' => 'dashicons-feedback',
            'public' => true,
            'show_in_rest' => true,
	    	'supports' => array('title')
        )
    );
}
add_action( 'init', 'report_post_type' );
