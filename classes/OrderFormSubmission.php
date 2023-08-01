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

    public $cart_items;
    public $contact;
    public $coupon_code;
    public $payment_required;
    public $registration_id; // From db on successful order registration
    public $return_status; // Read by front-end app to determine whether to show success or error message


    public function __construct($cart_items, $contact, $coupon_code){

        $this->cart_items = $cart_items;
        $this->contact = $contact;
        $this->coupon_code = $coupon_code;

        $this->do_includes();    
        $this->do_cart();
        $this->do_contact();
        $this->do_coupon();
        
        if($this->payment_required === true){
            $this->do_payment();
        }

        $this->save_order();

        // Do actual sending of report here
                
        $this->handle_success();
        
    }


    public function handle_success() {

        //$this->update_hubspot(); MAYBE... not sure yet
        $this->redirect_to_success();

    }
    

    public function redirect_to_success() {

        $this->return_status = 'success';

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

        // Process payment

    }


    public function do_cart() {

        $validated_cart = new CartValidation($this->cart_items, true);
        $validated_cart->validate_cart();

        if(!empty($validated_cart->error)){
            // Handle error here
        } else {
            $this->cart_items = $validated_cart->cart_data;
        }

    }


    public function do_contact() {

        $validated_contact = new ContactValidation($this->contact, true);
        $validated_contact->validate_contact();

        if(!empty($validated_contact->error)){
            // Handle error here
        } else {
            $this->contact = $validated_contact->contact_data;
        }

    }


    public function do_coupon() {

        if(empty($this->coupon_code)){
            $this->coupon_code = false; // should this be false or null?
            $this->payment_required = false; // forced to false ONLY for testing
            return;
        }
                
        $validated_coupon = new CouponValidation($this->coupon_code, false); 
        $validated_coupon->validate_coupon_code();

        if(!empty($validated_coupon->error)){
            // Handle error here
        } else {
            $this->coupon_code = $validated_coupon->coupon_code;
        }

        if($validated_coupon->coupon_code !== false){
            $this->payment_required = true;
        } else {
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
        require_once(get_stylesheet_directory_uri() . '/vendor/autoload.php');
        
    }


}