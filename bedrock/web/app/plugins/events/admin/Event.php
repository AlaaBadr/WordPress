<?php

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'Event' ) ):
    class Event
    {

        public static function registerEventType()
        {
            $labels = array(
                'name' => 'Events',
                'singular_name' => 'Event',
                'add_new_item' => "New Event",
                'edit_item' => "Edit Event",
                'view_item' => "View Event",
                'view_items' => "View Events",
                'search_items' => "Search Events",
                'not_found' => "No event found",
                'not_found_in_trash' => "No event found in trash",
                'parent_item_colon' => "Parent Event",
                'all_items' => "All Events",
                'archives' => "Event Archives",
                'attributes' => "Event Attributes",
                'insert_into_item' => "Insert into event",
                'uploaded_to_this_item' => "Uploaded to this event"
            );

            $args = array(
                'register_meta_box_cb' => array('Event', 'registerEventFields'),
                'public' => true,
                'exclude_from_search' => false,
                'description' => 'Event Custom Post Type.',
                'labels' => $labels,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'show_in_admin_bar' => true,
                'query_var' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => 5,
                'supports' => array('title', 'editor', 'thumbnail'),
                'taxonomies' => array('category', 'post_tag')
            );

            register_post_type('event', $args);
        }

        public static function registerEventFields(WP_Post $post)
        {
            add_meta_box('event_meta', 'Event Details', function () use ($post) {

                $event_date = 'event_date';
                $event_date_value = get_post_meta($post->ID, $event_date, true);
                wp_nonce_field('event_date_nonce', 'event_date_nonce');

                $start_time = 'start_time';
                $start_time_value = get_post_meta($post->ID, $start_time, true);
                wp_nonce_field('start_time_nonce', 'start_time_nonce');

                $end_time = 'end_time';
                $end_time_value = get_post_meta($post->ID, $end_time, true);
                wp_nonce_field('end_time_nonce', 'end_time_nonce');

                ?>

                <table class="form-table">

                    <tr>
                        <th><label for="<?php echo $event_date; ?>">Event Date</label></th>
                        <td>
                            <input id="<?php echo $event_date; ?>"
                                   name="<?php echo $event_date; ?>"
                                   type="date"
                                   value="<?php echo esc_attr($event_date_value); ?>"
                                   required
                            />
                        </td>
                    </tr>

                    <tr>
                        <th><label for="<?php echo $start_time; ?>">Start Time</label></th>
                        <td>
                            <input id="<?php echo $start_time; ?>"
                                   name="<?php echo $start_time; ?>"
                                   type="time"
                                   value="<?php echo esc_attr($start_time_value); ?>"
                                   required
                            />
                        </td>
                    </tr>

                    <tr>
                        <th><label for="<?php echo $end_time; ?>">End Time</label></th>
                        <td>
                            <input id="<?php echo $end_time; ?>"
                                   name="<?php echo $end_time; ?>"
                                   type="time"
                                   value="<?php echo esc_attr($end_time_value); ?>"
                                   required
                            />
                        </td>
                    </tr>

                </table>

                <?php
            });
        }

        public static function saveMetaBoxFields($post_id)
        {
            if (isset($_POST['event_date'])) {
                $my_data = sanitize_text_field($_POST['event_date']);

                update_post_meta($post_id, 'event_date', $my_data);
            }

            if (isset($_POST['start_time'])) {
                $my_data = sanitize_text_field($_POST['start_time']);

                update_post_meta($post_id, 'start_time', $my_data);
            }

            if (isset($_POST['end_time'])) {
                $my_data = sanitize_text_field($_POST['end_time']);

                update_post_meta($post_id, 'end_time', $my_data);
            }
        }

        public static function setPostCategory( $posts )
        {
            foreach ( $posts as $post ) {

                $post_type = get_post_type($post->ID);

                if ( $post_type != 'event' )
                    continue;

                $date = get_post_field('event_date', $post->ID );

                if ( $date < current_time( 'Y-m-d' ) ) {
                    wp_set_post_categories( $post->ID, get_cat_ID( 'past' ), true );
                    wp_remove_object_terms( $post->ID, 'upcoming', 'category' );
                }
                elseif ( $date == current_time( 'Y-m-d' ) ) {
                    $start_time = get_post_field('start_time', $post->ID );
                    $date = new DateTime("now", new DateTimeZone('Africa/Cairo'));
                    $current_time = $date->format('H:i');
                    if ( $start_time <= $current_time ) {
                        wp_set_post_categories( $post->ID, get_cat_ID( 'past' ), true );
                        wp_remove_object_terms( $post->ID, 'upcoming', 'category' );
                    } else {
                        wp_set_post_categories( $post->ID, get_cat_ID( 'upcoming' ), true );
                        wp_remove_object_terms( $post->ID, 'past', 'category' );
                    }
                }
                else {
                    wp_set_post_categories( $post->ID, get_cat_ID( 'upcoming' ), true );
                    wp_remove_object_terms( $post->ID, 'past', 'category' );
                }

            }

            return $posts;
        }
    }
endif;