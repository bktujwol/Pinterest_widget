<?php
 /*
Plugin Name: Pinterest Widget
Plugin URI: 
Description: Pinterest RSS Widget
Version: 2.0.0
Author: Ujwol Bastakoti
Author URI: 
License: GPLv2
*/


class pinterest_widget extends WP_Widget{
		
		public function __construct() {
			parent::__construct(
					'pinterest_widget', // Base ID
					'Pinterest  Widget', // Name
					array( 'description' => __( 'Pinterest Fedd Widget', 'text_domain' ), ) // Args
			);
		}
		
		//function to detemine default number of pin to display
		public function default_pin_count($pinCount,$currentPinCount){
		    if(isset($currentPinCount))
		    {
		        if($pinCount == $currentPinCount)
		        {
		            echo 'selected="selected"';
		        }
		    }
		}
		
		
		public function form( $instance ) {
			if ( isset( $instance[ 'title' ] ) ) {
			
					$title = $instance[ 'title' ];
				}
			else {
					$title = __( 'Pinterest Feed Widget', 'text_domain' );
				}
		?>
		    <p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		    </p>
		    <p>
				<label for="<?php echo $this->get_field_id( 'pinterest_username' ); ?>"><?php _e( 'Pinterest Username:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest_username' ); ?>" name="<?php echo $this->get_field_name( 'pinterest_username' ); ?>" type="text" value="<?php echo esc_attr( $instance['pinterest_username' ] ); ?>" />
		    </p>
		    <p>
				<label for="<?php echo $this->get_field_id( 'pinterest_pin_board' ); ?>"><?php _e( 'Pin Board:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest_pin_board' ); ?>" name="<?php echo $this->get_field_name( 'pinterest_pin_board' ); ?>" type="text" value="<?php echo esc_attr( $instance['pinterest_pin_board' ] ); ?>" />
		    </p>
		    <p>
				<label for="<?php echo $this->get_field_id( 'pinterest_pin_count' ); ?>"><?php _e( 'No of pins to be displayed:' ); ?></label> 
        		    <select class="widefat"  id="<?php echo $this->get_field_id('pinterest_pin_count'); ?>" name="<?php echo $this->get_field_name( 'pinterest_pin_count' ); ?> "   style="width:120px !important;">
					  <option <?php $this->default_pin_count("1",$instance['pinterest_pin_count'] ); ?>  value="1">1</option>
					  <option <?php $this->default_pin_count("3", $instance['pinterest_pin_count'] ); ?>  value="3" >3</option>
					  <option <?php $this->default_pin_count("6", $instance['pinterest_pin_count'] ); ?>  value="6">6</option>
					</select> 
		    </p>
		     <p>
        		    <ol>
        		    <b>
        			<li>In User name enter your username.</li>
        			<li>In board enter pin board as it is.</li>
        			<li>If you leave board empty it will display pin based on you username.</li>
        			<li>Do not forget to make your account public, private pin won't display.</li>
        			</ol>
        			</b>
		    </p>
		    
		<?php 
		}
		
		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['pinterest_username'] = strip_tags($new_instance['pinterest_username']);
			$instance['pinterest_pin_board'] =  strip_tags($new_instance['pinterest_pin_board']);
			$instance['pinterest_pin_count'] = strip_tags($new_instance['pinterest_pin_count']);
			return $instance;
		}
		
		
		//function to get contents from pinterest css
		public function process_pinterest_feed($username,$pinboard){
			include_once( ABSPATH . WPINC . '/feed.php' );
			// Get a SimplePie feed object from the specified feed source.
			if(isset($pinboard)&& !empty($pinboard)){
			    
			    $feedurl = 'http://pinterest.com/'.$username.'/'.str_replace(' ','-',trim ($pinboard)).'.rss';
			    //echo($feedurl);
			}
			else{
		    $feedurl = 'http://pinterest.com/'.$username.'/feed.rss';
			}
            $rss = fetch_feed($feedurl);
			return $rss;
		}
		
		//function to resgister css and javascript file
		public function pinterest_widget_register_custom_js_css()
		{
		    wp_enqueue_script('jquery');
		    wp_enqueue_style('pinterestCss', plugins_url('css/pinterest_rss.css',__FILE__ ));
		    wp_enqueue_script('pinterestJs', plugins_url('js/pinterest-widget.js',__FILE__ ));
		}
		
		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
		  
		    $this->pinterest_widget_register_custom_js_css();
		    add_action( 'wp_enqueue_scripts','pinterest_widget_register_custom_js_css');
			
			extract( $args );
			$title = apply_filters( 'widget_title', $instance['title'] );
		
			
			echo $before_widget;
			if ( ! empty( $title ) )
			    echo $before_title . $title . $after_title;
			
			    //function to fetch feeds from site based oon user input
			    $feed = $this->process_pinterest_feed($instance['pinterest_username'],$instance['pinterest_pin_board']);
			    
			   
			         $i = abs(rand(0, $feed->get_item_quantity()));
			    
        			    if($i>= $feed->get_item_quantity()-6)
        			    {
        			        $i= 3;
        			    }
        			    
			         $a=0;
			    
			   
			     $pinCount = $instance['pinterest_pin_count']-1;
			 
			
			
			
			     echo "<ol  class='pinterest_feeds'  pinCount ='".$instance['pinterest_pin_count']."'  style='list-style-type:circle !important;'>";
				foreach($feed->get_items($i) as $item)
				{
					 	
					 echo "<li  class='feed_item'  style='list-style-type:none!important;'>".$item->get_content()."<span id='pin_feed_pic_".$pinCount."'>".$item->get_title()."</span></li>";
			         if(++$a > $pinCount) break;
					
				}
			echo "</ol>";
		
		    echo "<div class='pinterest__follow_icon'><a class='pinterest_link' href='http://pinterest.com/".$instance['pinterest_username']."' target='_blank'><img class='item-6' src='". plugins_url('images/pinterest.png', __FILE__)."' title='pinterest'/></a></div>";
			echo $after_widget;
		  
		}//end of function widget
		
		
}

/*function resgiter widget as plguin*/
function register_pinterest_widget(){
    register_widget( "pinterest_widget" );
}

add_action( 'widgets_init', 'register_pinterest_widget' );		
?>