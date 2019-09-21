<?php
defined( 'ABSPATH' ) or die();

/*
 * This file is only included when a backend page is loaded, e.g. if is_admin() returns true
 */

require_once( 'Menu.php' );
require_once( 'Event.php' );

// register your custom settings
add_action( 'admin_init', array( 'Menu', 'registerSettings' ) );

// create the backend sidebar menu
add_action( 'admin_menu', array( 'Menu', 'createMenu' ) );

// register custom post type Event
add_action( 'init', array( 'Event', 'registerEventType' ) );

// save custom fields
add_action( 'save_post', array( 'Event', 'saveMetaBoxFields' ) );