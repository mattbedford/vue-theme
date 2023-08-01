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


// Handle form submission on checkout page - site_url()/wp-json/core-vue/order-submission
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/order-submission',array(
        'methods'  => 'POST',
        'callback' => 'do_order_form_submission',
        'permission_callback' => function() {
            return true;
        }
    ));
  });


// Grab a summary of order and return to thank-you page - site_url()/wp-json/core-vue/order-summary
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/order-summary',array(
        'methods'  => 'POST',
        'callback' => 'send_report_summary',
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

function do_order_form_submission($raw_data) {
    $data = $raw_data->get_json_params();

    include_once(ABSPATH . 'wp-content/themes/dagora-reports-shop/classes/OrderFormSubmission.php');
    $order = new OrderFormSubmission($data['cartItems'], $data['contact'], $data['coupon_code']);

    if($order->return_status === 'success') {
        return array(
            'status' => 'success',
            'message' => 'Order successfully submitted',
            'order_id' => $order->registration_id,
        );
    } else {
        return array(
            'status' => 'error',
            'message' => $order->return_status,
        );
    }

}


function send_report_summary($raw_data) {

    $data = $raw_data->get_json_params();

    $order_id = $data['ref'];

    if(empty($order_id)) return array("Error", "No order ID provided");

    global $wpdb;

    $table = $wpdb->prefix . 'orders';
    $order = $wpdb->get_row("SELECT * FROM $table WHERE id = '$order_id'");

    if(empty($order)) return array("Error", "Order not found");

    $payment_status = $order->payment_status;
    $coupon_code_if_used = $order->coupon_code;

    if($payment_status === 'coupon') {
        $payment_method = 'Coupon';
        $coupon_code = $coupon_code_if_used;
    } else {
        $payment_method = 'Online payment';
        $coupon_code = null;
    }

    $year = date("Y");

    $return_value = array(
        'order_id' => 'DAG' . $year . $order->id,
        'order_date' => $order->order_date,
        'order_total' => $order->payment_amount,
        'order_items' => explode(", ", $order->report_names),
        'payment_method' => $payment_method,
        'coupon_code' => $coupon_code,
    );

    return $return_value;

}