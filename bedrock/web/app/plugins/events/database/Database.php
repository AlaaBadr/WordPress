<?php

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'Database' ) ):
    class Database {

        private static function getTableName()
        {
            global $wpdb;

            return $wpdb->prefix . 'events';
        }

        public static function createDatabaseTable()
        {
            global $wpdb;
            $table_name      = self::getTableName();
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $table_name (
                `id` int(11) NOT NULL AUTO_INCREMENT,
				`wp_id` int(11) NOT NULL,
				`title` varchar(55) NULL,
				`description` text NULL,
                `image_path` text NULL,
				`date` datetime DEFAULT CURRENT_TIMESTAMP() NOT NULL,
				`start_at` TIME (0) NOT NULL,
                `end_at` TIME (0) NOT NULL,
                `categories` text DEFAULT 'upcoming' NOT NULL,
                `tags` text NULL,
                `trashed` boolean DEFAULT FALSE NOT NULL,
				PRIMARY KEY (`id`)
				) $charset_collate";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta( $sql );
        }

    }
endif;
