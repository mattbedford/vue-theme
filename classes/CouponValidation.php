<?php


// Validates the coupon code, which is a string.
// After instantiation, you need to call the validate_coupon_code() method to run the validation.
// Check first whether or not we even have a coupon code to check though...

class CouponValidation extends ValidationMaster {


    public $coupon_code;


    public function validate_cart() {

        $this->coupon_code = $this->validate_coupon_code();

    }


    private function validate_coupon_code(){

        if( ! is_string($this->validated_data) ){
            $this->error[] = 'Coupon code was not valid. Please try again.';
            return;
        }

        $hubspot_verified = HubspotHelpers::verify_coupon_code_with_hubspot($this->validated_data);

        if( $hubspot_verified->total != 1 ){
            $this->error[] = 'Coupon code does not seem to exist. Please check and try again.';
            return;
        }

        return $this->validated_data;

    }


}