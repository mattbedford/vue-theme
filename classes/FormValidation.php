<?php

if(!defined('ABSPATH')){ 
    exit; 
}

class FormValidation {


    private $original_cart_items;
    private $original_contact;
    private $original_coupon_code;
    public $validated_cart_items;
    public $validated_contact;
    public $validated_coupon_code;
    public $error;

    public function __construct($cart_items, $contact, $coupon_code){
        $this->original_cart_items = $cart_items;
        $this->original_contact = $contact;
        $this->original_coupon_code = $coupon_code;
        $this->run_validation();
    }

    private function run_validation(){
        $this->validate_cart_items();
        if(!empty($this->error)){
            return;
        }
        $this->validate_contact();
        if(!empty($this->error)){
            return;
        }
        $this->validate_coupon_code();
        return;
    }

    private function validate_cart_items(){
        
        foreach( $this->original_cart_items as $item ){

            if( ! is_numeric($item) ){
                $this->error[] = 'Report identifier (ID: ' . $item . ') was not valid. Please remove it and try again.';
                return;
            }

            if('publish' !== get_post_status($item)){
                $this->error[] = 'One or more items in your cart are no longer available (ID: ' . $item . '). Please remove them and try again.';
                return;
            }
        }

        $this->validated_cart_items = $this->original_cart_items;

    }


    private function validate_contact() {

        foreach( $this-> original_contact as $key => $value ){
            if( empty($value) ){
                $this->error[] = 'Please complete all fields.';
                return;
            }
            
            $this->validated_contact[$key] = stripslashes(strip_tags(trim($value)));
            
        }

        if( ! is_email($this->validated_contact['email']) ){
            $this->error[] = 'Please enter a valid email address.';
            return;
        }

        switch ($this->validated_contact['company_type']) {

            case 'brand':
                $this->validated_contact['company_type'] = "Brand, Retailer, Manufacturer or Online Shop";
                break;

            case 'investor':
                $this->validated_contact['company_type'] = "Investor, Family Office,";
                break;

            case 'media':
                $this->validated_contact['company_type'] = "Media & Press";
                break;

            case 'institution':
                $this->validated_contact['company_type'] = "Public Administration / Institution";
                break;

            case 'research':
                $this->validated_contact['company_type'] = "Research Institute, University, School";
                break;

            case 'vendor':
                $this->validated_contact['company_type'] = "Vendor / Supplier of Services";
                break;
            
            case 'other':
                $this->validated_contact['company_type'] = "Other";
                break;
            
            default:
            $this->error[] = 'Please enter a valid company type.';
            return;
        }

        return;

    }


    private function validate_coupon_code(){

        if( empty($this->original_coupon_code) ){
            $this->validated_coupon_code = '';
            return;
        }

        $this->validated_coupon_code = stripslashes(strip_tags(trim($this->original_coupon_code)));

        FormValidation::validate_coupon_code_in_hubspot($this->validated_coupon_code);

        if( ! is_string($this->validated_coupon_code) ){
            $this->error[] = 'Coupon code was not valid. Please try again.';
            return;
        }

        return;

    }


    public static function validate_coupon_code_in_hubspot($coupon_code){

        $validated_coupon_code = stripslashes(strip_tags(trim($coupon_code)));

        if( ! is_string($validated_coupon_code) ){
            return false;
        }

        $hubspot_api_key = get_option('hubspot_api_key');

        

        return true;

    }

}