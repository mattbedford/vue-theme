<?php

// This script transforms any post into json (both post object and meta fields) for use in front end
// and calls the individual vue files for any given post, thereby relying on classic WP routing in our app.

function load_all_custom_scripts() {
	
	
	$post_id = get_the_ID();
	$post_obj = get_post($post_id);
	$post_meta = get_post_meta($post_id);

	
	wp_register_script( 'post_vars', false );
	$post_args = array(
		'post' => $post_obj,
		'meta' => $post_meta
	);
	wp_localize_script( 'post_vars', 'post_object', $post_args );
	wp_enqueue_script( 'post_vars' );
	
}
add_action( 'wp_enqueue_scripts', 'load_all_custom_scripts');


// Used to enable custom scripts on specific pages. Currently not in use (Vers. 1)
function do_single_page_loads() {
	
	if(is_front_page() || is_page('home') || is_home()) {

		wp_register_script( 
			'home_vue',
			get_stylesheet_directory_uri() . '/template_scripts/home.js',
			array(),
			false,
			true
		);
		wp_enqueue_script('home_vue');
		
	}
	
}


