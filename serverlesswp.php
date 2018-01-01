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

add_filter( 'aws_get_client_args', 'serverlesswp_filter_aws_args' );

function serverlesswp_filter_aws_args($args) {
	if (defined('AWS_SESSION_TOKEN')) {
		$args['token'] = AWS_SESSION_TOKEN;
	}
	return $args;
}
