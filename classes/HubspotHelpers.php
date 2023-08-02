<?php


// A series of helpers to communicate with Hubspot.

class HubspotHelpers {


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