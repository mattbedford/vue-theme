<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_action('after_switch_theme', 'create_dagora_reports_database_table');

function create_dagora_reports_database_table() {
    
	//Badges & registrations table
	global $wpdb;

	$table_name = $wpdb->prefix . 'orders';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name text NOT NULL,
		surname text NOT NULL,
		email text NOT NULL,
		company text NOT NULL,
		job_title text,
		my_company_is text,
		t_and_c tinyint(1) DEFAULT '1' NOT NULL,
		payment_amount int(9),
		payment_status text,
		coupon_code text,
		order_date DATE NOT NULL,
		report_ids text,
        report_names text,
		reports_delivered tinyint(1) DEFAULT '0' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}