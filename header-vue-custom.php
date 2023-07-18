<?php

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge; chrome=1"> <!-- Render Chrome if available or using latest version of Internet Explorer (Recommended). -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<title>Dagorà Reports Shop | <?php echo get_the_title(); ?></title>
		<base href="<?php echo site_url(); ?> ">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@700&family=Roboto:ital,wght@0,300;0,500;1,300&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/custom-styles.css'; ?>">
        <?php wp_head(); ?>
    </head>
    <body>
		
	<div id="app"></div>