<?php
/*
Plugin Name: CW RSS Feed Widget
Description: Displays RSS Feed
Version: 1.0
Author: Camilla Westin
Author URI: http://www.camillawestin.se
*/

function cw_rss_widget_styles() {
    wp_enqueue_style( 'cw-rss-plugin-style', plugins_url('/cw-rss-feed-style.css', __FILE__), false, '1.0.0', 'all' );
  }

  add_action('wp_enqueue_scripts', 'cw_rss_widget_styles');

class cw_rss_widget extends WP_Widget {

	function __construct() {
      parent::__construct(
      // Base ID of your widget
      'cw_rss_widget', 

      // Widget name will appear in UI
      __('CW RSS Feed', 'wp_cw_rss_widget'), 

      // Widget description
      array( 'description' => __( 'Displays RSS Feed', 'wp_cw_rss_widget' ), ) 
      );
  }

	// widget form creation
function form($instance) {

// Check values
if( $instance) {
     $title = esc_attr($instance['title']);
     $rsspostcount = esc_attr($instance['rsspostcount']);
     $rssfeedurl = esc_attr($instance['rssfeedurl']);

} else {
     $title = '';
     $rsspostcount = '';
     $rssfeedurl = '';
  }
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp_cw_rss_widget'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('rsspostcount'); ?>"><?php _e('Number of posts:', 'wp_cw_rss_widget'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('rsspostcount'); ?>" name="<?php echo $this->get_field_name('rsspostcount'); ?>" type="text" value="<?php echo $rsspostcount; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('rssfeedurl'); ?>"><?php _e('RSS Feed URL:', 'wp_cw_rss_widget'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('rssfeedurl'); ?>" name="<?php echo $this->get_field_name('rssfeedurl'); ?>" type="text" value="<?php echo $rssfeedurl; ?>" />
</p>


<?php
}

	// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['rsspostcount'] = strip_tags($new_instance['rsspostcount']);
      $instance['rssfeedurl'] = strip_tags($new_instance['rssfeedurl']);

    return $instance;
}

	// display widget
function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $title = $instance['title'];
   $rsspostcount = $instance['rsspostcount'];
   $rssfeedurl = $instance['rssfeedurl'];
   echo $before_widget;

     // Display the widget

     // Check if title is set
         if ( $title ) {
            echo $before_title . $title . $after_title;
         }

     echo '<div class="cw-rss-widget">';
     echo '<ul class="rss-feed-list">';
        
      //Import and loop rss feed
      include('cw-rss-feed.php');

      echo '</ul></div>';
   
    echo $after_widget;
  }
}

// Register and load the widget
function wpb_load_widget() {
  register_widget( 'cw_rss_widget' );
}

add_action( 'widgets_init', 'wpb_load_widget' );