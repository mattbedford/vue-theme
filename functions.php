<?php

include 'normalization/cleanup.php';
include 'normalization/routes.php';
include 'normalization/post_setup.php';
include 'normalization/external_scripts.php';
require 'script_loader.php';


// Disable 404 redirects unless pointed at admin
add_filter('redirect_canonical', 'disable_404_redirection');
function disable_404_redirection( $redirect_url ) {

    global $wp;
    
    if ( strpos( $wp->request, "wp-admin" ) !== false ) {
        return false;
    }
    
    return $redirect_url;

}

add_filter('redirect_canonical', 'disable_404');
function disable_404( $redirect_url ) {

    global $wp;
    
    if ( strpos( $wp->request, "account/" ) !== false ) {
        return false;
    }

    return $redirect_url;
    
}