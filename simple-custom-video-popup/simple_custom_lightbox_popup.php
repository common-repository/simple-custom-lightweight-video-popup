<?php
/*
Plugin Name: Simple Custom Lightweight Video Popup
Version: 1.0
Plugin URI: http:://themefantasy.com
Author: Sabir Abdul Gafoor
Author URI: http:://themefantasy.com
Description: Simple Custom Lightweight Popup plugin to display videos in a nice overlay popup. 
It It supports YouTube and Vimeo. It's doesn't required any external pluign. It is also responsive.
Tags:Custom video popup, popup, video, sabir
Domain Path: /languages
*/
if (!defined('ABSPATH')) exit;

if (!class_exists('WP_Simple_Video_Popup'))
{
    class WP_Simple_Video_Popup
    {
        var $version = '1.0';
        var $plugin_url;
        var $plugin_path;
        var $settings_obj;

        function __construct() 
        {
            add_shortcode('videopopup', array($this, 'shortcode'));
            add_action( 'wp_enqueue_scripts', array( $this, 'plugin_scripts' ), 20 );
            
        }

      
        function plugin_scripts()
        {
             wp_register_script( 'simple-custom-video-script', plugins_url( 'js/video-popup.js', __FILE__ ), '', '', true );
			 wp_enqueue_script('simple-custom-video-script');
			 
			 wp_register_style( 'simple-custom-video-css', plugins_url( 'css/simple_custom_video.css', __FILE__ ) );
			 wp_enqueue_style('simple-custom-video-css');
        }
		
		public function shortcode($atts)
		{
			
			$atts = shortcode_atts( array(
					'video_id' => 'video_id',
					 'type'=>'type',
                                        'imagewidth'=>'500',	),
					 $atts ,'videopopup');
				
			$type = $atts['type'];
			$imagewidth = $atts['imagewidth'];
			$imgid = $atts['video_id'];
			$videoid = $imgid;
			if($type=='vimeo') {
			$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
			return "<a class='mycustombtn' href='javascript:;'><img width='".$imagewidth."' src='".$hash[0]['thumbnail_large']."'></a><div id='myBtn' class='modal'> <div class='modal-content'>   <span class='close-simple-video'>X</span>    <iframe src='//player.vimeo.com/video/".$videoid."' width='560' height='315'></iframe> </div> </div> 	";  
			
			}else if($type=='youtube') {
			return "<a class='mycustombtn' href='javascript:;'><img width='".$imagewidth."' src='http://i1.ytimg.com/vi/".$imgid."/0.jpg'></a><div id='myBtn' class='modal'> <div class='modal-content'>   <span class='close-simple-video'>X</span>    <iframe width='560' height='315' src='https://www.youtube.com/embed/".$videoid."' frameborder='0' allowfullscreen></iframe> </div> </div> 	";  
			
			} else {
			return "This video is not supported. Contact theme developer at info@themesfantasy.com";
			}
		}
      
        function plugin_url(){ 
            if ( $this->plugin_url ) return $this->plugin_url;
            return $this->plugin_url = plugins_url( basename( plugin_dir_path(__FILE__) ), basename( __FILE__ ) );
        }

        function plugin_path(){ 	
            if ( $this->plugin_path ) return $this->plugin_path;		
            return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
        }

    }

}//End of class not exists check

$GLOBALS['WP_Simple_Video_Popup'] = new WP_Simple_Video_Popup();
?>