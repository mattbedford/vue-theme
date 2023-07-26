<?php


// Validates the content of the contact array.
// After instantiation, you need to call the validate_contact() method to run the validation.

class ContactValidation extends ValidationMaster {


    public $contact_data;


    public function validate_contact() {

        $this->contact_data = $this->validate_contact_data();

    }


    private function validate_contact_data() {

        if( ! is_email($this->validated_data['email']) ){
            $this->error[] = 'Please enter a valid email address.';
            return;
        }

        switch ($this->validated_data['company_type']) {

            case 'brand':
                $this->validated_data['company_type'] = "Brand, Retailer, Manufacturer or Online Shop";
                break;

            case 'investor':
                $this->validated_data['company_type'] = "Investor, Family Office,";
                break;

            case 'media':
                $this->validated_data['company_type'] = "Media & Press";
                break;

            case 'institution':
                $this->validated_data['company_type'] = "Public Administration / Institution";
                break;

            case 'research':
                $this->validated_data['company_type'] = "Research Institute, University, School";
                break;

            case 'vendor':
                $this->validated_data['company_type'] = "Vendor / Supplier of Services";
                break;
            
            case 'other':
                $this->validated_data['company_type'] = "Other";
                break;
            
            default:
            $this->error[] = 'Please enter a valid company type.';
            return;
        }

        return $this->validated_data;

    }


}