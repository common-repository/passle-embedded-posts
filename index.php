<?php

if( !defined( 'WP_CONTENT_DIR' ) )
{
	exit( 'No direct script access allowed.' );
}

/*
Plugin Name: Passle Embedded Posts
Description: The Passle Embedded Posts Plugin allows you embed a chosen number of posts into any container in the page of your WordPress website using the signature Passle grid layout.
Author: Passle Limited
Version: 0.3
Author URI: http://www.passle.net/
*/

// CONSTANTS

define( 'PASSLE_EMBEDDED_POSTS_PLUGIN_VERSION', '0.3' );

define( 'PASSLE_EMBEDDED_POSTS_PLUGIN_PATH', dirname( __FILE__ ) );

define( 'PASSLE_EMBEDDED_POSTS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'PASSLE_EMBEDDED_POSTS_PLUGIN_PASSLE_SHORTCODE_DEFAULT_NUMBER_OF_POSTS', 6 );

define( 'PASSLE_EMBEDDED_POSTS_PLUGIN_SINGLE_POST_URL_BASE', 'blogpost' );

// include() or require() any necessary files here...

include_once( 'classes/PassleCore.php' );