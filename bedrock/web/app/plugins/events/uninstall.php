<?php

defined('ABSPATH') or die();


function deactivatePlugin() {

    remove_meta_box( 'event_meta', 'events', 'normal' );
    unregister_post_type( 'events' );

    global $wpdb;
    $table_name = $wpdb->prefix . 'events';
    $wpdb->query("DROP TABLE IF EXISTS $table_name");

    wp_delete_nav_menu( 'main-menu' );

}