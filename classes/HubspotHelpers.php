<?php


// A series of helpers to communicate with Hubspot.

class HubspotHelpers {
	
	
	public static function hubspotExistsHandler($data) {

        // Return array of HS user id and sync status.

        $existing_user = self::checkEmailInHubspot($data['email_address']);

        if($existing_user->total == 1) {
            
            return "Already exists in HubSpot";

        } else {

            $hs_contact_id = self::createNewHubspotPerson($data);

            if($hs_contact_id === null) {
                return "Problem syncing with HubSpot";
            }
            return "Added new user to hubSpot";
        }

    }


	 public static function checkEmailInHubspot($email) {

        $url = "https://api.hubapi.com/crm/v3/objects/contacts/search";
        $data = array(
            "limit" => 1,
            "filterGroups" => array(
                array( 
                    "filters" => array(
                        array(
                            "value" => $email,
                            "propertyName" => "email",
                            "operator" => "EQ"
                        )
                    )
                )
            ),
        );
    
        $existing = self::triggerHubspotCurl($url, json_encode($data));

        return $existing;

    }
	
	
	 public static function createNewHubspotPerson($data) {
        $url = "https://api.hubapi.com/contacts/v1/contact/createOrUpdate/email/" . $data['email_address'];

        $fields = array(
            'properties' => array(
                array(
                    'property' => 'email',
                    'value'	=> $data['email_address']
                ),
                array(
                    'property' => 'company',
                    'value'	=> $data['company_name']
                ),
                array(
                    'property' => 'jobtitle',
                    'value'	=> $data['job_title']
                ),
                array(
                    'property' => 'firstname',
                    'value'	=> $data['first_name']
                ),
                array(
                    'property' => 'lastname',
                    'value'	=> $data['last_name']
                ),
            ),
        );

        //Pushing optional fields into submitted data                
        if(!empty($data['company_type'])) {
            $fields['properties'][] = array(
                'property' => 'company_type',
                'value' => $data['company_type']
            );
        }
        
        $fields_string = json_encode($fields);

        $response = self::triggerHubspotCurl($url, $fields_string);
		 
		if(isset($response->vid)) {
            return $response->vid;
        } else {
            return null;
        }

    }

	

    // Triggers API call to HS and returns with a count of 1 if the coupon code is found.
    public static function verify_coupon_code_with_hubspot($coupon_code) {

        $url = "https://api.hubapi.com/crm/v3/objects/companies/search";
        $data = array(
            "limit" => 1,
            "filterGroups" => array(
                array( 
                    "filters" => array(
                        array(
                            "value" => $coupon_code,
                            "propertyName" => "observatory_portal_code",
                            "operator" => "EQ"
                        )
                    )
                )
            ),
            "sorts" => array("id"),
            "properties" => array("id"),
            "after" => 0,
        );
    
        $existing = self::triggerHubspotCurl($url, json_encode($data));

        return $existing;

    }


    // General purpose HS API interrgogation function.
    public static function triggerHubspotCurl($url, $fields_string) {
      	// Stupid, convoluted way to get a basic fucking option....
      	$global_opts = get_option('wporg_options');
        $hubspot_token = $global_opts['hubspot_api_key'];
      
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'authorization: Bearer ' . $hubspot_token
        ));
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);

        $data = curl_exec($curl);
        curl_close($curl);
        return json_decode($data);
    } 


}