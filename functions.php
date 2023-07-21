<?php

include 'normalization/cleanup.php';
include 'normalization/routes.php';
include 'normalization/post_setup.php';
include 'normalization/external_scripts.php';
require 'script_loader.php';


// Load custom template for web requests going anywhere aside from admin
//add_filter( 'template_include', 'only_show_vue_template' );
function only_show_vue_template( $original_template ) {
  global $wp;
  $request = explode( '/', $wp->request );
  if ( !is_admin()  ) {
    return 'index.php';
  }
  return $original_template;
}


// Disable 404 redirects unless pointed at admin. 
// It needs to return "false" on any request APART FROM those aimined at "admin".
add_filter('redirect_canonical', 'disable_404_redirection');
function disable_404_redirection( $redirect_url ) {

    global $wp;

    if ( !strpos( $wp->request, "wp-admin" ) !== false ) {
        return false;
    }
    
    return $redirect_url;

}
