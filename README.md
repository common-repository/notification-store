# Notification : Store

This is public repository for Notification : Store - the WordPress plugin.

This plugin allows to store notification in database sent by Notification plugin.

## Features

* Store notification with custom post type `notification_stored`
* Can store an alternative message in custom post content
* Option to disable sending notification and only store them
* Use `WP_Query` to display notifications
* Mark them read with set `post_status` pending -> publish

## Requirements

* THIS PLUGIN REQUIRE [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/)

## Usage

```
<?php $notifications = new WP_Query(array(
  'post_type' => 'notification_stored',
  'post_status' => array('pending', 'publish'), // For displaying unread
and read notifications
  'author' => get_current_user_id(),
  'posts_per_page' => -1
)); ?>
<?php while($notifications->have_posts()): $notifications->the_post(); ?>
<?php if(get_post_status() === 'pending') wp_publish_post(get_the_id()); // Mark notification read when displayed ?>
<div class="Dashboard-activity">
  <div class="Dashboard-activity-thumb"><?php echo get_avatar(get_field('author_email')); ?></div>
  <div class="Dashboard-activity-desc">
    <h3 class="Dashboard-activity-title"><?php the_title(); ?></h3>
    <?php the_content(); ?>
  </div>
  <div class="Dashboard-activity-time"><?php the_time(get_option( 'date_format' )); ?> <?php the_time(); ?></div>
</div>
<?php endwhile; wp_reset_postdata(); ?>
```

---

* [Notification plugin](https://github.com/Kubitomakita/Notification)
* [WordPress readme](https://github.com/HugoPoi/wp-notification-store/blob/master/readme.txt)
