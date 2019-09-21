<?php

defined('ABSPATH') or die();

if ( ! class_exists( 'Deactivation' ) ):
    class Deactivation
    {
        function deactivatePlugin()
        {

            remove_meta_box('event_meta', 'events', 'normal');
            unregister_post_type('events');

            wp_delete_nav_menu('main-menu');

        }
    }
endif;