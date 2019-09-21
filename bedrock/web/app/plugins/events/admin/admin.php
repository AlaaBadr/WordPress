<?php
defined( 'ABSPATH' ) or die();

require_once( 'Menu.php' );
require_once( 'Event.php' );
require_once( dirname(__DIR__).'/frontend/CustomTheme.php' );

// register your custom settings
add_action( 'admin_init', array( 'Menu', 'registerSettings' ) );

// create the backend sidebar menu
add_action( 'admin_menu', array( 'Menu', 'createMenu' ) );

// register custom post type Event
add_action( 'init', array( 'Event', 'registerEventType' ) );

// save custom fields
add_action( 'save_post', array( 'Event', 'saveMetaBoxFields' ) );

// register menu Event
add_action( 'init', array( 'CustomTheme', 'registerNavMenu' ) );

// remove Uncategorized from my widgets in sidebar
add_filter( 'widget_categories_args', array( 'CustomTheme', 'removeUncategorized' ) );

// create categories needed by Events
add_action( 'admin_init', array( 'CustomTheme', 'createEventCategories' ) );

// attach each event to a category
add_filter( 'the_posts', array( 'Event', 'setPostCategory' ) );

//let events CPT appear in categories
add_filter( 'pre_get_posts', array( 'CustomTheme', 'appearEventsCategories' ) );