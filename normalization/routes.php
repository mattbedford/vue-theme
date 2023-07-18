<?php

/*********************************************************
 * 
 * 	SETTING UP NEW REST API ROUTES
 * 
 * ******************************************************/

// Get extended post object on load - site_url()/wp-json/core-vue/extended
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/options-all',array(
        'methods'  => 'GET',
        'callback' => 'return_extended_post',
        'permission_callback' => function() {
            return true;
        }
    ));
  });



/*********************************************************
 * 
 * 	DOING ROUTE CALLBACKS
 * 
 * ******************************************************/

function return_extended_post() {
	
	$x = get_the_ID();
	return "The post is $x";
	
}
