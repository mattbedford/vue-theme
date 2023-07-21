<?php

/*********************************************************
 * 
 * 	SETTING UP NEW REST API ROUTES
 * 
 * ******************************************************/

// Get series of extended post objects on load - site_url()/wp-json/core-vue/extended
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/get-reports',array(
        'methods'  => 'GET',
        'callback' => 'return_reports_data',
        'permission_callback' => function() {
            return true;
        }
    ));
  });


// Return previews of the array of items in the cart when hitting cart/checkout page - site_url()/wp-json/core-vue/cart
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/cart',array(
        'methods'  => 'POST',
        'callback' => 'return_cart_items',
        'permission_callback' => function() {
            return true;
        }
    ));
  });


// Return single report page in full - site_url()/wp-json/core-vue/single-report/{slug}
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/single-report/(?P<slug>[a-zA-Z0-9-]+)',array(
        'methods'  => 'GET',
        'callback' => 'return_single_report',
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
	
    $reports_list = get_posts([
        'post_type' => 'report',
        'posts_per_page' => -1,
        'fields' => 'ids',
    ]);

    foreach($reports_list as $single) {
        $report_objects[] = array(
            'id' => $single,
            'slug' => get_post_field('post_name', $single),
            'title' => get_the_title($single),
            'cover_image' => get_field('cover_image', $single),
            'short_desc' => get_field('report_description_short', $single),
            'price' => get_field('price', $single),
            'release_date' => get_field('release_date', $single),
            'expiry_date' => get_field('expiry_date', $single),
        );
    }

    return $report_objects;
	
}


function return_single_report( $request ) {
    
    $slug = (string) $request['slug'];
    $post_obj = get_page_by_path($slug, OBJECT, 'report');

    if('publish' !== get_post_status($post_obj->ID) || null === $post_obj) {
        return array("error", "No report with that ID exists");
    }

    $id = $post_obj->ID;

    $single_report = array(
        'id' => $id,
        'slug' => $slug,
        'title' => get_the_title($id),
        'cover_image' => get_field('cover_image', $id),
        'long_desc' => get_field('report_description_long', $id),
        'price' => get_field('price', $id),
        'release_date' => get_field('release_date', $id),
        'expiry_date' => get_field('expiry_date', $id),
        'teaser_file' => get_field('teaser', $id),
    );

    return $single_report;

}


function return_cart_items($raw_data) {
    $data = $raw_data->get_json_params();

    $reports_array = $data['cartItems'];    
    $return_array = array();

    foreach($reports_array as $item) {
        $item = intval($item);

        if('publish' !== get_post_status($item)) continue;

        $return_array[] = array(
            'id' => $item,
            'title' => get_the_title($item),
            'cover_image' => get_field('cover_image', $item),
            'price' => get_field('price', $item)
        );
    }

    return $return_array;
}