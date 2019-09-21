<?php

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'CRUD' ) ):
    class CRUD
    {
        public static function createEvent( $post_id )
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

            $image_path = get_the_post_thumbnail_url( $post_id );
            if (!$image_path) {
                $image_path = '';
            }

            $categories_array = wp_get_post_categories( $post_id, array( 'fields' => 'names' ) );
            $categories = implode( ',', array_values( $categories_array ) );

            global $wpdb;
            $table_name = $wpdb->prefix . 'events';

            $query = "SELECT * FROM $table_name WHERE wp_id = $post_id";
            $results = $wpdb->get_results( $query );

            $data = array(
                'wp_id'       => $wp_id,
                'title'       => $title,
                'description' => $description,
                'date'        => $date,
                'start_at'    => $start_time,
                'end_at'      => $end_time,
                'tags'        => $tags,
                'image_path'  => $image_path,
                'categories'  => $categories
            );

            if ( count( $results ) == 0 ) {
                $wpdb->insert( $table_name, $data);
            } else {
                $wpdb->update( $table_name,$data, array( 'wp_id' => $post_id ) );
            }
        }

        public static function retrieveEvent( $posts )
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'events';

            if ( ! count( $posts ) )
                return $posts;

            foreach ( $posts as $post ) {

                $post_type = get_post_type($post->ID);

                if ( $post_type != 'event' || $post->post_status != 'publish' )
                    continue;

                $query = "SELECT date,start_at,end_at FROM $table_name WHERE wp_id = $post->ID";

                $custom_fields    = $wpdb->get_results( $query )[0];
                $post->event_date = substr( $custom_fields->date, 0, 10);
                $post->start_time = substr( $custom_fields->start_at, 0, 5 );
                $post->end_time   = substr( $custom_fields->end_at, 0, 5 );
            }

            return $posts;
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

        public static function deleteEvent( $post_id )
        {
            $post_type = get_post_type($post_id);

            if ( $post_type != 'event' )
                return;

            global $wpdb;
            $table_name = $wpdb->prefix . 'events';

            $wpdb->delete( $table_name, array( 'wp_id' => $post_id ) );
        }

    }
endif;