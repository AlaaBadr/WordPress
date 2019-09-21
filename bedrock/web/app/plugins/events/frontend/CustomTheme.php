<?php

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'CustomTheme' ) ):
    class CustomTheme
    {

        public static function registerNavMenu()
        {
            // switch the theme to be my custom theme
            switch_theme('childtheme', 'childtheme');

            // register menu location
            register_nav_menus(array('main-menu' => 'Main Menu'));

            $menu_name = 'Main Menu';
            $menu_exists = wp_get_nav_menu_object($menu_name);

            if (!$menu_exists) {
                $menu_id = wp_create_nav_menu($menu_name);

                // Set up default menu items
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => __('Home'),
                    'menu-item-classes' => 'home',
                    'menu-item-url' => home_url('/'),
                    'menu-item-status' => 'publish'));

                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => __('Sample Page'),
                    'menu-item-url' => home_url('/sample-page/'),
                    'menu-item-status' => 'publish'));

                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => __('Events'),
                    'menu-item-url' => home_url('/event/'),
                    'menu-item-status' => 'publish'));

                // Assign created menu to menu location
                $locations = get_theme_mod('nav_menu_locations');
                $locations['main-menu'] = $menu_id;
                set_theme_mod('nav_menu_locations', $locations);
            }
        }

        public static function removeUncategorized ( $args )
        {
            $args["exclude"] = get_cat_ID( 'Uncategorized' );
            return $args;
        }

        public static function createEventCategories()
        {
            wp_create_categories( array( 'past', 'upcoming' ) );
        }

        public static function appearEventsCategories()
        {
            if ( is_category() || is_tag() ) {

                set_query_var( 'post_type', array( 'post', 'event' ) );

            }
        }

    }
endif;