<?php

if(!defined('ABSPATH')){ 
    exit; 
}    

/**
 * Controller class to govern the series of processes that occur when a user submits an order form.
 * 
 * Tries to:
 * - Validate form
 * - Determine if payment required
 * - If payment required, process payment
 * - Store order in database
 * 
 * If any of these steps fail, the process is halted and the user is redirected to the checkout page with an error message.
 * 
 * - If all OK, user is provided with a success message and then downloadable content is delivered to them by email (separate process).
 *  
 */

class OrderFormSubmission {




}