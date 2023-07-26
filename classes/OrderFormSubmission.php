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


    public function __construct($cart_items, $contact, $coupon_code){

        $this->do_includes();    
        $this->do_cart();
        $this->do_contact();
        $this->do_coupon();
        
        if($this->payment_required){
            $this->do_payment();
        }

        $this->save_order();
                
        
    }


    private function save_order() {

        // Save order to database

    }


    public function do_payment() {

        // Process payment

    }


    public function do_cart() {

        $validated_cart = new CartValidation($cart_items, true);
        $validated_cart->validate_cart();

        if(!empty($validated_cart->error)){
            // Handle error here
        } else {
            $this->cart_items = $validated_cart->cart_data;
        }

    }


    public function do_contact() {

        $validated_contact = new ContactValidation($contact, true);
        $validated_contact->validate_contact();

        if(!empty($validated_contact->error)){
            // Handle error here
        } else {
            $this->contact = $validated_contact->contact_data;
        }

    }


    public function do_coupon() {
        
        $validated_coupon = new CouponValidation($coupon_code, false); 
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


    public function do_includes(){
        
        require_once('ValidationMaster.php');
        require_once('CartValidation.php');
        require_once('ContactValidation.php');
        require_once('HubspotHelpers.php');
        require_once('CouponValidation.php');
        require_once(get_stylesheet_directory_uri() . '/vendor/autoload.php');
        
    }


}