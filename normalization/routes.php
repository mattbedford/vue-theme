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


// Take a slug and return its corresponding page data - site_url()/wp-json/core-vue/get-page
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/get-page',array(
        'methods'  => 'POST',
        'callback' => 'return_single_page',
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


// Receive Stripe session ID and vaildate it - site_url()/wp-json/core-vue/stripe-check
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/stripe-check',array(
        'methods'  => 'POST',
        'callback' => 'vaildate_stripe_session_id',
        'permission_callback' => function() {
            return true;
        }
    ));
  });


// Receive order reference and provide files to download - site_url()/wp-json/core-vue/download-files
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/download-files',array(
        'methods'  => 'POST',
        'callback' => 'provide_files_downloads',
        'permission_callback' => function() {
            return true;
        }
    ));
  });


// Check Stripe has been paid and provide download url in a mail - site_url()/wp-json/core-vue/stripe-download-check
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/stripe-download-check',array(
        'methods'  => 'POST',
        'callback' => 'stripe_confirmation_and_email_send',
        'permission_callback' => function() {
            return true;
        }
    ));
  });


// Receive request to dl teaser file - site_url()/wp-json/core-vue/download-preview
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/download-preview',array(
        'methods'  => 'POST',
        'callback' => 'process_teaser_file_download',
        'permission_callback' => function() {
            return true;
        }
    ));
  });


// Actually send back teaser file - site_url()/wp-json/core-vue/teaser-file
add_action('rest_api_init', function () {
    register_rest_route( 'core-vue', '/teaser-file',array(
        'methods'  => 'POST',
        'callback' => 'return_downloadable_teaser_file',
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


function return_single_page( $request ) {

    $slug = (string) $request['slug'];
    $post_obj = get_page_by_path($slug, OBJECT, 'page');

    $return_object = array(
        'id' => $post_obj->ID,
        'slug' => $slug,
        'title' => get_the_title($post_obj->ID),
        'headline1' => get_field('headline1', $post_obj->ID),
        'headline2' => get_field('headline2', $post_obj->ID),
        'image1'    => get_field('image1', $post_obj->ID),
        'textarea1' => get_field('textarea1', $post_obj->ID),
        'textarea2' => get_field('textarea2', $post_obj->ID),
        'image2'    => get_field('image2', $post_obj->ID),
        'cta' => get_field('cta', $post_obj->ID),
        'externalLink' => get_field('externalLink', $post_obj->ID),
    );

    return $return_object;

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
  
    return array(
       'status' => $order->return_status,
       'message' => $order->return_message,
       'order_id' => $order->registration_id,
    );

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


function vaildate_stripe_session_id($raw_data) {

    $data = $raw_data->get_json_params();

    $session_id = $data['session_id'];
    $order_id = $data['order_id'];

    if(empty($session_id)) return array("error", "No session ID provided");

    require_once(ABSPATH . 'wp-content/themes/dagora-reports-shop/vendor/autoload.php');
    $global_opts = get_option('wporg_options');
    $stripe_key = $global_opts['stripe_api_key'];

    $stripe = new \Stripe\StripeClient( $stripe_key );

    $stripe_sesh = $stripe->checkout->sessions->retrieve(
        $session_id,
        []
    );

    if(empty($stripe_sesh) || !isset($stripe_sesh)) {
		//Could not find a stripe checkout session with this identifier
		return array("error", "Sorry. We could find no record of this transaction.");
	}

    if($stripe_sesh->payment_status !== 'paid') { 
        // Payment was not successful
        return array("error", "Sorry. It seems your payment was not processed correctly. Please try again."); 
    }
   

	// Session ID does in fact relate to current db order ID
	if ($stripe_sesh->client_reference_id == $order_id) {
        
        $order_id = intval($order_id);

        global $wpdb;
        $table = $wpdb->prefix . 'orders';
        $chk = $wpdb->query( $wpdb->prepare( 
            "
                UPDATE $table
                SET payment_status = 'paid'
                WHERE id = %d",
            $order_id ) );

        return array('success', 'Order confirmed!');

    }

    // If all else fails...
    return array("error", "Sorry. Your order could not be confirmed."); 

}


function provide_files_downloads($raw_data) {

    $data = $raw_data->get_json_params();
    $order_id = $data['ref'];
    $method = $data['method'];
    $checksum = $data['check'];

    if(empty($order_id) || empty($method) || empty($checksum)) return array("error", "One or more security checks failed. Please check the url and try again");

    //get order data from db
    global $wpdb;
    $table = $wpdb->prefix . 'orders';
    $order = $wpdb->get_row("SELECT * FROM $table WHERE id = $order_id");

    if(empty($order)) return array("Error", "Order not found");

    //check security
    if($method === 'coupon' && $order->coupon_code !== $checksum) return array("error", "Coupon security check failed.");
    if($method === 'stripe' && $order->payment_status !== 'paid') return array("error", "Stripe security check failed.");

    $report_ids = unserialize($order->report_ids);

    $return_array = array();
    foreach($report_ids as $single_report_id) {

        $url = get_field('full_report', $single_report_id);
        $name = get_the_title($single_report_id);
        $return_array[] = array(
            'name' => $name,
            'url' => base64_encode($url),
        );
    } 

    return $return_array;

}

// Validates request, sends email to user with correct link to access downloadables
function process_teaser_file_download($raw_data) {
    
    $data = $raw_data->get_json_params();

    include_once(ABSPATH . 'wp-content/themes/dagora-reports-shop/classes/TeaserFormSubmission.php');
    $order = new TeaserFormSubmission($data['teaser'], $data['contact']);
  
    return array(
       'status' => $order->return_status,
       'message' => $order->return_message, 
       'order_id' => $order->registration_id,
    );

}

// When teaser requester lands on thank you page, it trggers this to check all OK and send back the downloadable file
function return_downloadable_teaser_file($raw_data) {

    $data = $raw_data->get_json_params();
    $report_id = $data['ref'];
    $method = $data['method']; // "teaser"
    $checksum = $data['check']; //email address of requester

    if(empty($order_id) || empty($method) || empty($checksum)) return array("error", "One or more security checks failed. Please check the url and try again");

    //get order data from db
    global $wpdb;
    $table = $wpdb->prefix . 'orders';
    $order = $wpdb->get_row("SELECT * FROM $table WHERE id = $order_id");

    if(empty($order)) return array("Error", "Order not found");

    //check security
    if($method !== 'teaser') return array("error", "Something went wrong with your dowload. Please try again later.");
    if($order->email_address !== $checksum) return array("error", "Email address security check failed. Please try again later.");
    
    if(!is_numeric($report_id) || 'publish' !== get_post_status($report_id)) return array("error", "Report not found.");

    $return_array = array();
    
    $url = get_field('teaser', $report_id);
    $name = get_the_title($report_id) . " - preview";

    $return_array[] = array(
        'name' => $name,
        'url' => base64_encode($url),
    ); 

    return $return_array;
}



function stripe_confirmation_and_email_send($raw_data) {


    $data = $raw_data->get_json_params();

    $email = $data['email'];
    $stripe_session = $data['session_id'];

    global $wpdb;
    $table = $wpdb->prefix . 'orders';
    $order = $wpdb->get_row("SELECT * FROM $table WHERE session_id = '$stripe_session'");

    if(!empty($order) && $order->email_address == $email) {

        // Create download url
        $domain = site_url();
        $url = $domain . '/thank-you?session=' . $stripe_session . '&id=' . $order->id;
        
        require_once('MailerTool.php');
        new MailerTool($email, $order->first_name, $order->last_name, 'report', $url);
       
    }
}