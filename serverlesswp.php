<?php

/*
Plugin Name: ServerlessWP
Description: Tweaks to enhance running WP on AWS Serverless technology.
Version: 0.1.0
Author: Mitch MacKenzie
Author URI: https://www.serverlesswp.com
License: GPLv2 or later
Text Domain: serverlesswp
*/

add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'feed_links_show_comments_feed', '__return_false' );

add_action( 'init', 'serverlesswp_cleanup' );

function serverlesswp_cleanup() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10);
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10);
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rel_canonical' );
}

add_filter( 'aws_get_client_args', 'serverlesswp_filter_aws_args' );

function serverlesswp_filter_aws_args($args) {
	if (defined('AWS_SESSION_TOKEN')) {
		$args['token'] = AWS_SESSION_TOKEN;
	}
	return $args;
}

add_action('admin_bar_menu', 'serverlesswp_admin_menu', 100);

function serverlesswp_admin_menu($admin_bar) {
	$args = array(
		'id'    => 'serverlesswp-crawl',
		'title' => '<span class="ab-icon dashicons dashicons-media-code"></span>' . _( 'Launch ServerlessWP Static Update' ),
		'href'  => get_site_url( null, 'serverlesswp-crawl'),
		'meta'  => array(
			'title' => __( 'Launch ServerlessWP Static Update' ),
			'target' => '_blank',
		),
	);
	$admin_bar->add_node( $args );
}
