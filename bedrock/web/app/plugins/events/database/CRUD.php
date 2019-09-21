<?php

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'CRUD' ) ):
    class CRUD
    {
        public static function createEvent( $post_id, $post, $update )
        {

            $post_type = get_post_type($post_id);

            if ( $post_type != 'event' || ! isset( $_POST['post_ID'] ) )
                return;

            if ( isset( $_POST['post_ID'] ) )
                $wp_id = sanitize_text_field($_POST['post_ID']);

            if (isset($_POST['post_title']))
                $title = sanitize_text_field($_POST['post_title']);

            if (isset($_POST['post_content']))
                $description = sanitize_text_field($_POST['post_content']);

            if (isset($_POST['event_date']))
                $date = sanitize_text_field($_POST['event_date']);

            if (isset($_POST['start_time']))
                $start_time = sanitize_text_field($_POST['start_time']);

            if (isset($_POST['end_time']))
                $end_time = sanitize_text_field($_POST['end_time']);

            if (isset($_POST['tax_input']['post_tag']))
                $tags = sanitize_text_field($_POST['tax_input']['post_tag']);

            global $wpdb;
            $table_name = $wpdb->prefix . 'events';

            if ( $update )
            {
                $wpdb->update( $table_name, array(
                    'wp_id'       => $wp_id,
                    'title'       => $title,
                    'description' => $description,
                    'date'        => $date,
                    'start_at'    => $start_time,
                    'end_at'      => $end_time,
                    'tags'        => $tags
                ), array( 'wp_id' => $post_id ) );
            }

        }

        public static function trashEvent( $post_id )
        {

            $post_type = get_post_type($post_id);

            if ( $post_type != 'event' )
                return;

            global $wpdb;
            $table_name = $wpdb->prefix . 'events';

            $wpdb->update( $table_name, array( 'trashed' => true ), array( 'wp_id' => $post_id ) );

        }

        public static function untrashEvent( $post_id )
        {

            $post_type = get_post_type($post_id);

            if ( $post_type != 'event' )
                return;

            global $wpdb;
            $table_name = $wpdb->prefix . 'events';

            $wpdb->update( $table_name, array( 'trashed' => false ), array( 'wp_id' => $post_id ) );

        }
    }
endif;