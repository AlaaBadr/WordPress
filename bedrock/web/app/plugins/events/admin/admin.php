<?php
defined( 'ABSPATH' ) or die();

require_once( 'Menu.php' );
require_once( 'Event.php' );
require_once( dirname(__DIR__).'/frontend/CustomTheme.php' );
require_once( dirname( __DIR__ ).'/database/CRUD.php' );

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

// remove Un-categorized from my widgets in sidebar
add_filter( 'widget_categories_args', array( 'CustomTheme', 'removeUnCategorized' ) );

// create categories needed by Events
add_action( 'admin_init', array( 'CustomTheme', 'createEventCategories' ) );

// attach each event to a category
add_filter( 'the_posts', array( 'Event', 'setPostCategory' ) );

// let events CPT appear in categories
add_filter( 'pre_get_posts', array( 'CustomTheme', 'appearEventsCategories' ) );

// check to show past events to frontend user
add_filter( 'pre_get_posts', array( 'CustomTheme', 'checkShowingPastEvents' ) );

// paginate events
add_filter( 'pre_get_posts', array( 'CustomTheme', 'getEventsLimitPerPage' ) );

// save/update event to custom table
add_action( 'save_post', array( 'CRUD', 'createEvent' ) );

// retrieve event from custom table
add_filter( 'the_posts', array( 'CRUD', 'retrieveEvent' ) );

// soft delete event in custom table
add_action( 'trashed_post', array( 'CRUD', 'trashEvent' ) );

// restore event in custom table
add_action( 'untrash_post', array( 'CRUD', 'untrashEvent' ) );

// delete event from custom table
add_action( 'delete_post', array( 'CRUD', 'deleteEvent' ) );