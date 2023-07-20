<?php

/*********************************************************
 * 
 * 	SETTING UP NEW REST API ROUTES
 * 
 * ******************************************************/

// Get extended post object on load - site_url()/wp-json/core-vue/extended
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/get-reports',array(
        'methods'  => 'GET',
        'callback' => 'return_reports_data',
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

function return_reports_data() {
	
	// Get all posts
    $reports_list = get_posts([
        'post_type' => 'report',
        'posts_per_page' => -1,
        'fields' => 'ids',
    ]);

    // Loop through posts and add custom fields
    foreach($reports_list as $single) {
        $report_objects[] = array(
            'id' => $single,
            'title' => get_the_title($single),
            'cover_image' => get_field('cover_image', $single),
            'short_desc' => get_field('report_description_short', $single),
            'price' => get_field('price', $single),
            'release_date' => get_field('release_date', $single),
            'expiry_date' => get_field('expiry_date', $single),
        );
    }

    // Return posts
    return $report_objects;
	
}
