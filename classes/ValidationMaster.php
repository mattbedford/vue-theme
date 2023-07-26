<?php

/** 
* Master validation class to check if data was provided when it was supposed to be and to sanitize inputs.
* Can be extended to include other validation methods.
* 
* $validated_data will hold a sanitized version of input if all OK or FALSE if not provided and not required.
* $error will hold an array of error messages if any errors were encountered.All Errors are considered fatal. 
* 
* */

class ValidationMaster {

    public $original_data;
    public $validated_data;
    public $error;
    public $required;

    public function __construct($original_data, $required){

        $this->original_data = $original_data;
        $this->required = $required;
        $this->run_sanitization_checks();
    
    }

    public function run_sanitization_checks() {

        if(empty($this->original_data) && $this->required === true){
            $this->error[] = 'No data was provided. Please complete all fields and try again.';
            return;
        }

        if(empty($this->original_data) && $this->required === false){
            $this->validated_data = false;
            return;
        }

        if(is_array($this->original_data)){
            $this->validated_data = array_map('sanitize_field', $this->original_data);
        } else {
            $this->validated_data = $this->sanitize_field($this->original_data);
        }

    }


    public function sanitize_field($original_data){
       
        $sanitized_data = stripslashes(strip_tags(trim($original_data)));
        return $sanitized_data;

    }


}