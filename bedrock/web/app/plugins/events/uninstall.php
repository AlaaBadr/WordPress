<?php

defined('ABSPATH') or die();


function deactivatePlugin() {

    remove_meta_box( 'event_meta', 'events', 'normal' );
    unregister_post_type( 'events' );

    global $wpdb;
    $table_name = $wpdb->prefix . 'events';
    $wpdb->query("DROP TABLE IF EXISTS $table_name");

    $wpdb->delete('wp_posts', array( 'post_type' => 'event' ) );
    $wpdb->query( 'DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT ID FROM wp_posts)' );
    $wpdb->query( 'DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT ID FROM wp_posts)' );

    wp_delete_nav_menu( 'main-menu' );

}