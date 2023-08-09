<?php

if(!defined('ABSPATH')){ 
    exit; 
}    

/**
 * Controller class to govern the series of processes that occur when a user submits a teaser order form.
 * 
 * Receives: 
 * - Teaser_id (int with ID of the report for which a teaser is being requested)
 * - Contact details (array of form fields)
 * 
 * Tries to:
 * - Validate the teaser ID and contact details
 * - Store order in database
 * - Store or update user in Hubspot
 * - Send email to user with download link
 * 
 * If any of these steps fail, the process is halted and the user is redirected to the checkout page with an error message.
 * If all OK, user is provided with a success message and then downloadable content is delivered to them by email (separate process).
 *  
 */

class TeaserFormSubmission {

    public $error;
    public $teaser_id;
    public $contact;
    public $on_staging;
    public $registration_id; // From db on successful order registration
    public $return_message; // will contain error body or else file url of downloadable content
    public $return_status; // Read by front-end app to determine whether to show success or error message


    public function __construct($teaser_id, $contact){

        $domain = site_url();
	    $this->on_staging = strpos($domain, '.local');

        $this->error = false;
        $this->registration_id = null;
      
        $this->teaser_id = $teaser_id;
        $this->contact = $contact;

        $this->do_includes();
        $this->do_teaser();
        $this->do_contact();

        if($this->error === true) return;
        
		$this->save_order();
		
        // Only update hubspot if NOT on staging
        if($this->on_staging === false) {
            $hubspot_status = HubspotHelpers::hubspotExistsHandler($this->contact);
            if(!empty($hubspot_status)) {
                $this->update_with_hubspot_status($hubspot_status);
            }
        } else {
            $this->update_with_hubspot_status('staging');
        }

        // Do actual sending of report here  
        $this->do_teaser_email_send();     
        $this->handle_success();

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

        $payment_status = "teaser";
        $coupon_code = null;

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
                'payment_amount' => 0,
                'payment_status' => "preview",
                'order_date' => $date_today,
                'coupon_code' => null,
                'report_ids' => $this->teaser_id,
                'report_names' => get_the_title($this->teaser_id) . " - Preview",
                'reports_delivered' => '0',
            ) 
        );
        
        if($wpdb->insert_id !== false) {
           $this->registration_id = $wpdb->insert_id;
        } 

    }


    public function do_teaser() {

        $teaser = get_post($this->teaser_id);
        if('publish' === $teaser->post_status) {
             $this->return_status = 'success';
             $this->return_message = 'Teaser is valid.';
             $this->error = false;
        } else {
             $this->return_status = 'error';
             $this->return_message = $validated_cart->error[0];
             $this->error = true;
          	 return;
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


    public function get_order_items() {

        $order_items = '';

        foreach($this->cart_items as $item){
            $order_items .= get_the_title($item) . ', ';
        }

        return rtrim($order_items, ', ');

    }


    private function do_teaser_email_send() {

        $url = $this->create_teaser_download_url();

        require_once('MailerTool.php');
        new MailerTool($this->contact['email_address'], $this->contact['first_name'], $this->contact['last_name'], 'teaser', $url);
        $this->handle_success();

    }


    public function create_teaser_download_url() {

        $domain = site_url();
        $url = $domain . '/thank-you?teaser=' . $this->teaser_id;
        return $url;

    }



    public function do_includes(){
        
        require_once('ValidationMaster.php');
        require_once('CartValidation.php');
        require_once('ContactValidation.php');
        if($this->on_staging === false) {
            require_once('HubspotHelpers.php');
        }
        require_once('CouponValidation.php');
        require_once(ABSPATH . 'wp-content/themes/dagora-reports-shop/vendor/autoload.php');
        
    }


}

