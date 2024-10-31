<?php

namespace HugoPoi\Notification\Store;

class RegisterAcf {

  public function __construct() {

    if(function_exists("register_field_group"))
    {
      register_field_group(array (
        'id' => 'acf_notification-store',
        'title' => 'Notification Store',
        'fields' => array (
          array (
            'key' => 'field_595e36fe2681f',
            'label' => 'Notification Alternate Message',
            'name' => 'notification_alternate_message',
            'type' => 'wysiwyg',
            'default_value' => '',
            'toolbar' => 'full',
            'media_upload' => 'yes',
          ),
          array (
            'key' => 'field_595e385cb18f6',
            'label' => 'Disable email',
            'name' => 'disable_email',
            'type' => 'true_false',
            'message' => 'Disable sending email for this notification',
            'default_value' => 0,
          ),
        ),
        'location' => array (
          array (
            array (
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'notification',
              'order_no' => 0,
              'group_no' => 0,
            ),
          ),
        ),
        'options' => array (
          'position' => 'normal',
          'layout' => 'no_box',
          'hide_on_screen' => array (
          ),
        ),
        'menu_order' => 0,
      ));
    }
  }
}
