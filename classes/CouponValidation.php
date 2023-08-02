<?php


// Validates the coupon code, which is a string.
// After instantiation, you need to call the validate_coupon() method to run the validation.
// Check first whether or not we even have a coupon code to check though...

// If the coupon code is valid, the $coupon_code property will be set to the validated coupon code.
// If coupon code provided BUT not valid, the $error property will be set to an array of error messages.
// If no coupon code provided, this function will do nothing.

class CouponValidation extends ValidationMaster {


    public $coupon_code;


    public function validate_coupon_code(){

        if( ! is_string($this->validated_data) ){
            $this->error[] = 'Coupon code was not valid. Please try again.';
            return;
        }

        $hubspot_verified = HubspotHelpers::verify_coupon_code_with_hubspot($this->validated_data);

        if( $hubspot_verified->total != 1 ){
            $this->error[] = 'Coupon code does not seem to exist. Please check and try again.';
            return;
        }

        $this->coupon_code = $this->validated_data;

    }


}