<?php

if(!defined('ABSPATH')){ 
    exit; 
}    

/**
 * Controller class to govern the series of processes that occur when a user submits an order form.
 * 
 * Receives: 
 * - Cart items (array of post IDs)
 * - Contact details (array of form fields)
 * - Coupon code (string)
 * 
 * Tries to:
 * - Validate form and check coupon exists in HS.
 * - Determine if payment required (i.e. check if coupon present and valid)
 * - If payment required, process payment
 * - Store order in database
 * - Store or update user in Hubspot
 * 
 * If any of these steps fail, the process is halted and the user is redirected to the checkout page with an error message.
 * If all OK, user is provided with a success message and then downloadable content is delivered to them by email (separate process).
 *  
 */

class OrderFormSubmission {

    public $error;
    public $cart_items;
    public $contact;
    public $coupon_code;
    public $payment_required;
    public $registration_id; // From db on successful order registration
    public $return_message; // Read by front-end app to determine whether to show success or error message
    public $return_status; // Read by front-end app to determine whether to show success or error message


    public function __construct($cart_items, $contact, $coupon_code){

        $this->error = false;
        $this->registration_id = null;
      
        $this->cart_items = $cart_items;
        $this->contact = $contact;
        $this->coupon_code = $coupon_code;
        $this->payment_required = true;

        $this->do_includes();
        $this->do_cart();
        $this->do_contact();
        $this->do_coupon();

        if($this->error === true) return;
        
		$this->save_order();
		
		$hubspot_status = HubspotHelpers::hubspotExistsHandler($this->contact);
		if(!empty($hubspot_status)) {
			$this->update_with_hubspot_status($hubspot_status);
		}
		
        if($this->payment_required === true){
            $this->do_payment();
        }

        // Do actual sending of report here
      	// Handle this as an entirely separate class, though...
        
        if($this->payment_required === false) {
        	$this->handle_success();
        }
    }

	
	public function update_with_hubspot_status($status) {
			
		global $wpdb;
        $table = $wpdb->prefix . 'orders';
        $chk = $wpdb->query( $wpdb->prepare( 
            "
                UPDATE $table
                SET hubspot_status = %s
                WHERE id = %d",
            strval($status), intval($this->registration_id )) );
	
	}
	

    public function handle_success() {

        //Send report to user via email
        //$this->update_hubspot(); MAYBE... not sure yet
        $this->return_status = 'success';
        $this->return_message = 'Your order has been successfully received. Please check your email for your download link.';

    }
    
    private function save_order() {
        global $wpdb;
	
        $presumed_payment = 0;
        $table_name = $wpdb->prefix . 'orders';
        $date_today = date("Y-m-d H:i:s");
        $order_value = $this->get_order_value();

        if($this->payment_required === true){
            $payment_status = "pending";
            $coupon_code = null;
        } else {
            $payment_status = "coupon";
            $coupon_code = $this->coupon_code;
        }

        $cart_item_titles = $this->get_order_items();
        $cart_ids = serialize($this->cart_items);

        $wpdb->insert( 
            $table_name, 
            array( 
                'name' => $this->contact['first_name'], 
                'surname' => $this->contact['last_name'],
                'email' => $this->contact['email_address'], 
                'company' => $this->contact['company_name'],
                'my_company_is' => $this->contact['company_type'],
                'job_title' => $this->contact['job_title'],
                't_and_c' => '1',
                'payment_amount' => $order_value,
                'payment_status' => $payment_status,
                'order_date' => $date_today,
                'coupon_code' => $coupon_code,
                'report_ids' => $cart_ids,
                'report_names' => $cart_item_titles,
                'reports_delivered' => '0',
            ) 
        );
        
        if($wpdb->insert_id !== false) {
           $this->registration_id = $wpdb->insert_id;
        } 

    }


    public function do_payment() {

        // Doing an http request to stripe to get our checkout URL and pass along body data
        // This can then be returned to front end, redirect to Stripe (safely)
        // then finalize purchase if required

        $global_opts = get_option('wporg_options');
        $stripe_key = $global_opts['stripe_api_key'];

        \Stripe\Stripe::setApiKey($stripe_key);
    
        header('Content-Type: application/json');
        $domain = site_url();
        $email = $this->contact['email_address'];
        $amount = $this->get_order_value() * 100;
            
        $checkout_session = \Stripe\Checkout\Session::create([
        'customer_email' => $email,
        'invoice_creation' => ['enabled' => true],
        'client_reference_id' => $this->registration_id,
        'line_items' => [[
            'price_data' => [
                'currency' => 'chf',
                'product_data' => [
                'name' => "Dagorà reports ",
                ],
                'unit_amount' => $amount,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $domain . '/thank-you?&session={CHECKOUT_SESSION_ID}&order=' . $this->registration_id,
        'cancel_url' => $domain . '/cart',
        ]);
    
        $this->return_status = 'stripe';
        $this->return_message = $checkout_session->url;

        /*
        ** TESTING **
        $url = 'https://api.stripe.com/v1/checkout/sessions';
        $args = array(
            "method" => "POST",
            "headers" => array(
                "Authorization" => "Bearer $stripe_key",
			    "Content-type" => "application/x-www-form-urlencoded"
            ),
            "body" => array(

            ),
        );
        $response = wp_remote_request( $url, $args );
        */

    }


    public function do_cart() {

        $validated_cart = new CartValidation($this->cart_items, true);
        $validated_cart->validate_cart();

        if(!empty($validated_cart->error)){
             $this->return_status = 'error';
             $this->return_message = $validated_cart->error[0];
             $this->error = true;
          	 return;
        } else {
            $this->cart_items = $validated_cart->cart_data;
        }

    }


    public function do_contact() {

        $validated_contact = new ContactValidation($this->contact, true);
        $validated_contact->validate_contact();

        if(!empty($validated_contact->error)){
            $this->return_status = 'error';
            $this->return_message = $validated_contact->error[0];
            $this->error = true;
            return;
        } else {
            $this->contact = $validated_contact->contact_data;
        }

    }


    public function do_coupon() {

        // Automatic approval for testing while on staging
        $domain = site_url();
        $on_staging = strpos($domain, '.local');
        if($on_staging !== false){
            $this->payment_required = false; // Can be set to FALSE for testing
            return;
        }

        if(empty($this->coupon_code)){
            $this->coupon_code = false; 
            $this->payment_required = true;
            return;
        }
                
        $validated_coupon = new CouponValidation($this->coupon_code, false); 
        $validated_coupon->validate_coupon_code();

        if(!empty($validated_coupon->error)){
            $this->return_status = 'error';
            $this->return_message = $validated_coupon->error[0];
            $this->error = true;
            return;
        } else {
            $this->coupon_code = $validated_coupon->coupon_code;
            $this->payment_required = false;
        }

    }

    public function get_order_value() {

        $order_value = 0;

        foreach($this->cart_items as $item){
            $order_value += get_field('price', $item);
        }

        return $order_value;

    }


    public function get_order_items() {

        $order_items = '';

        foreach($this->cart_items as $item){
            $order_items .= get_the_title($item) . ', ';
        }

        return rtrim($order_items, ', ');

    }

    public function do_includes(){
        
        require_once('ValidationMaster.php');
        require_once('CartValidation.php');
        require_once('ContactValidation.php');
        require_once('HubspotHelpers.php');
        require_once('CouponValidation.php');
        require_once(ABSPATH . 'wp-content/themes/dagora-reports-shop/vendor/autoload.php');
        
    }


}

