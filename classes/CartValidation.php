<?php


// Validates the content of shopping cart, which is an array.
// After instantiation, you need to call the validate_cart() method to run the validation.

class CartValidation extends ValidationMaster {


    public $cart_data;


    public function validate_cart() {

        $this->cart_data = $this->validate_cart_items();

    }


    public function validate_cart_items(){
        
        foreach( $this->validated_data as $item ){

            if( ! is_numeric($item) ){
                $this->error[] = 'Report identifier (ID: ' . $item . ') was not valid. Please remove it and try again.';
                return;
            }

            if('publish' !== get_post_status($item)){
                $this->error[] = 'One or more items in your cart are no longer available (ID: ' . $item . '). Please remove them and try again.';
                return;
            }
        }

        return $this->validated_data;

    }


}