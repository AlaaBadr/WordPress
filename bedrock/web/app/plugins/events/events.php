<?php
/*
Plugin Name: Events Plugin
Plugin URI: http://localhost/LinkDevTask/bedrock/web
Description: Events Plugin with custom database tables and CRUD system
Version: 1.0.0
Author: Alaa Badr
*/

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'Events' ) ):

	final class Events {

        private static $instance = null;

        /**
         * Events constructor.
         */
        private function __construct() {
            $this->initializeHooks();
            $this->setupDatabase();
            $this->deactivatePlugin();
            $this->uninstallPlugin();
        }

        public static function getInstance()
        {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        private function initializeHooks()
        {
            require_once( 'admin/admin.php' );
        }

        private function setupDatabase()
        {
            require_once( 'database/Database.php' );

            register_activation_hook( __FILE__, array( 'Database', 'createDatabaseTable' ) );
        }

        private function deactivatePlugin()
        {
            require_once( 'Deactivation.php' );

            register_deactivation_hook( __FILE__, array( 'Deactivation', 'deactivatePlugin' ) );
        }

        private function uninstallPlugin()
        {
            require_once( 'Uninstallation.php' );

            register_uninstall_hook( __FILE__, array( 'Uninstallation', 'uninstallPlugin' ) );
        }

	}
endif;

Events::getInstance();
