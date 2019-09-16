<?php

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'Menu' ) ):
class Menu
{
    public static function createMenu() {
        add_menu_page(
            'Events Plugin',
            __( 'Events Settings', 'events' ),
            'administrator',
            'events_menu',
            array( 'Menu', 'menuCallback' ),
            'dashicons-calendar-alt'
        );
    }

    public static function menuCallback() {

        ?>

        <h1><?php _e( 'Events Settings', 'events' ) ?></h1>

        <br><br>

        <form action="options.php" method="post">

	        <?php
	        settings_fields( 'settings-group' );
	        ?>

            <input id="past-events" type="checkbox" name="show-past-events" value="yes"
                <?php checked( get_option( 'show-past-events' ), 'yes' ) ?>>
            <label for="past-events"><?php _e( 'Show Past Events', 'events' ) ?></label>

            <br><br>

            <label><?php _e( 'Number of Events in listing page', 'even,ts' ) ?></label>
            <input id="events-num" type="number" min=1 name="events-number" value="<?php echo get_option( 'events-number' ) ?>">

            <br><br>

            <?php
            submit_button( 'Save' );
            ?>

        </form>

        <?php
    }

	public static function registerSettings() {
		register_setting( 'settings-group', 'show-past-events' );
		register_setting( 'settings-group', 'events-number' );
	}
}
endif;