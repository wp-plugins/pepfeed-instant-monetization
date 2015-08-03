<?php

function pepfeed_widget_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=pepfeed') ) .'">Settings</a>';
   return $links;
}


class PepFeed_Widget extends WP_Widget {
	function __construct() {
		load_plugin_textdomain( 'pepfeed', false, dirname( plugin_basename( __FILE__ ) ) );
		$widget_ops = array('classname' => 'widget_pepfeed', 'description' => __("Get instant access to the most relevant content about the gadgets you're browsing", 'pepfeed'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('pepfeed', __('PepFeed Widget', 'pepfeed'), $widget_ops, $control_ops);	
	}


	function widget( $args, $instance ) {
		/*
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? "" : $instance['title'], $instance ); 
		$text = ( isset( $instance['text'] ) && $instance['text'] != "" ) ? apply_filters( 'widget_pepfeed', $instance['text'], $instance ) : pepfeed_getproducts_widget();
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
			ob_start();
			eval('?>'.$text);
			$text = ob_get_contents();
			ob_end_clean();
			?>
			<div class="pepfeedwidget"><?php echo $instance['filter'] ? wpautop($text) : $text; ?></div>
		<?php
		echo $after_widget;
		*/
		extract($args);
		echo $before_widget;
		if(get_option("pepfeed_agreement") == 1){
			if(get_option( 'pepfeed_display_format' ) == "widget_format") 
				echo pepfeed_getproducts_widget();
			else
				echo pepfeed_getproducts_button();
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
	}

	function form( $instance ) {
		echo '<p><a class="button-primary" href="' . esc_url( get_admin_url(null, 'options-general.php?page=pepfeed') ) . '" title="widgetconfiguration">Widget Configuration</a></p>';
	/*
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = format_to_edit($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'pepfeed'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs.', 'pepfeed'); ?></label></p>
<?php 
	*/
	}
}

add_action('widgets_init', create_function('', 'return register_widget("PepFeed_Widget");'));
?>