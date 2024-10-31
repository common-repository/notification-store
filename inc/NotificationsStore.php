<?php
/**
 * NotificationsStore class
 */

namespace HugoPoi\Notification\Store;

use underDEV\Utils\Singleton;

class NotificationsStore extends Singleton {

	public function __construct() {

    add_action( 'init', array( $this, 'register_cpt' ), 10 );

		if ( \underDEV\Notification\Settings::get()->get_setting( 'storing/general/enable' ) ) {
			add_action( 'notification/notify/submit', array( $this, 'store_notification' ) );
    }

    add_action( 'notification/notify/pre/submit', array( $this, 'disable_email_send') );
    add_action( 'notification/notify/submit', array( $this, 'clean_filter_email_disable' ) );

	}

	/**
	 * Register Notifications custom post type
	 * @return void
	 */
	public function register_cpt() {

		$labels = array(
			'name'                => __( 'Notifications', 'notification' ),
			'singular_name'       => __( 'Notification', 'notification' ),
			'add_new'             => _x( 'Add New Notification', 'notification', 'notification' ),
			'add_new_item'        => __( 'Add New Notification', 'notification' ),
			'edit_item'           => __( 'Edit Notification', 'notification' ),
			'new_item'            => __( 'New Notification', 'notification' ),
			'view_item'           => __( 'View Notification', 'notification' ),
			'search_items'        => __( 'Search Notifications', 'notification' ),
			'not_found'           => __( 'No Notifications found', 'notification' ),
			'not_found_in_trash'  => __( 'No Notifications found in Trash', 'notification' ),
			'parent_item_colon'   => __( 'Parent Notification:', 'notification' ),
			'menu_name'           => __( 'Notifications', 'notification' ),
		);

		register_post_type( 'notification_stored', array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => false,
			'show_in_menu'        => false,
			'show_in_admin_bar'   => false,
			'menu_icon'           => 'dashicons-megaphone',
			'menu_position'       => 103,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => false,
			'can_export'          => true,
			'rewrite'             => false,
			'capability_type'     => apply_filters( 'notification/cpt/capability_type', 'post' ),
			'supports'            => array( 'title', 'editor' )
		) );

  }

	/**
	 * Store notification on submit
	 * @return void
	 */
  public function store_notification( $notification ) {

    $alternate_message = get_post_meta($notification->notification_post_id, 'notification_alternate_message', true);
    if( \underDEV\Notification\Settings::get()->get_setting( 'storing/general/use_alternate_message' ) ){
      $notification->set_message($alternate_message);
    }

    foreach ( $notification->notification->recipients as $to ) {
      if($user = get_user_by('email', $to)){
        $notification_stored_id = wp_insert_post(array(
          'post_type' => 'notification_stored',
          'post_title' => $notification->notification->subject,
          'post_content' => $notification->notification->message,
          'post_status' => 'pending',
          'post_author' => $user->ID,
        ));

        if($notification_stored_id){
          foreach($notification->tags as $tag_name => $tag_value){
            add_post_meta($notification_stored_id, $tag_name, $tag_value);
          }
        }
      }
    }

	}

  public function disable_email_send( $notification ) {

    $disable_email = get_post_meta($notification->notification_post_id, 'disable_email', true);

    if($disable_email){
      add_filter( 'wp_mail', array( $this, 'filter_wp_mail_empty_to' ) );
    }

  }

  public function clean_filter_email_disable( $notification ) {

		remove_filter( 'wp_mail', array( $this, 'filter_wp_mail_empty_to' ) );

  }

  public function filter_wp_mail_empty_to( $args ) {
    $args['to'] = '';
    return $args;
  }

}
