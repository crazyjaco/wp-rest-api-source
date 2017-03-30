<?php
/**
 * Plugin Name: WordPress REST API Proof of Concept - Source
 * Plugin URI: http://boston.com
 * Description: Proof of concept to show how the REST API works.
 * Author: Bradley Jacobs
 * Version: 0.1.0
 * License: MIT
 *
 * @package rest-api-plugin
 */

define( REST_POC_URL, trailingslashit( plugins_url( '', __FILE__ ) ) );

require_once( 'class-wp-rest-api-source.php' );
