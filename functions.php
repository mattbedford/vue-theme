<?php

include 'normalization/cleanup.php';
include 'normalization/routes.php';
include 'normalization/post_setup.php';
include 'normalization/external_scripts.php';
include 'classes/AdminOptions.php';
include 'normalization/db_setup.php';
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


// Remove standard WP description area on pages
function remove_desc_area() {
	remove_post_type_support( 'page', 'editor' );
}
add_action( 'init', 'remove_desc_area' );


// Disable rest API except for custom routes
class Filter_Rest_Api_Endpoints {

    private $my_routes;

    public function __construct( $routes ) {
        $this->my_routes = $routes;
        add_filter( 'rest_endpoints', array( $this, 'run_filter' ) );
    }

    public function run_filter( $endpoints ) {

        foreach ( $endpoints as $route => $endpoint ) {
            $keep_route = false;

            foreach ( $this->my_routes as $my_route ) {

                if ( strpos( $route, $my_route ) !== false ) {
                    $keep_route = true;
                    break;
                }
            }

            if ( !$keep_route ) {
                unset( $endpoints[ $route ] );
            }
        }

        return $endpoints;
    }
}

function hook_my_api_routes_filter() {
    $my_custom_routes = array(
        '/core-vue/',
    );
    new Filter_Rest_Api_Endpoints( $my_custom_routes );
}
add_action( 'rest_api_init', 'hook_my_api_routes_filter' );
