<?php
/**
 * Settings class
 */

namespace HugoPoi\Notification\Store;
use underDEV\Utils\Settings\CoreFields;

class Settings {

	public function __construct() {

		add_action( 'notification/settings', array( $this, 'register_settings' ) );

	}

	public function register_settings( $settings_api ) {

		$storing = $settings_api->add_section( __( 'Storing', 'notification-store' ), 'storing' );

		$storing->add_group( __( 'Storing', 'notification-store' ), 'general' )
			->add_field( array(
				'name'     => __( 'Enable', 'notification-store' ),
				'slug'     => 'enable',
				'default'  => '',
				'addons'   => array(
					'label' => __( 'Store all notifications in database for futher display.', 'notification-store' )
				),
				'render'   => array( new CoreFields\Checkbox(), 'input' ),
				'sanitize' => array( new CoreFields\Checkbox(), 'sanitize' ),
      ) )
			->add_field( array(
				'name'     => __( 'Use alternate message', 'notification-store' ),
				'slug'     => 'use_alternate_message',
				'default'  => '',
				'addons'   => array(
					'label' => __( 'Use alternate message for saving the notification in database.', 'notification-store' )
				),
				'render'   => array( new CoreFields\Checkbox(), 'input' ),
				'sanitize' => array( new CoreFields\Checkbox(), 'sanitize' ),
			) )
			->description( __( 'Store notification settings.', 'notification' ) );

	}

}
