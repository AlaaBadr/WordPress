<?php
defined( 'ABSPATH' ) or die();

/*
 * This file is only included when a backend page is loaded, e.g. if is_admin() returns true
 */

require_once( 'Menu.php' );

// register your custom settings
add_action( 'admin_init', array( 'Menu', 'registerSettings' ) );
// create the backend sidebar menu
add_action( 'admin_menu', array( 'Menu', 'createMenu' ) );