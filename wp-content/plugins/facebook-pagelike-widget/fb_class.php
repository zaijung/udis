<?php
/**
 * Facebook Widget Class
 */
class facebook_widget extends WP_Widget {

    /** constructor */
    function facebook_widget() {
        parent::WP_Widget(false, $name = 'Facebook Widget');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
    	
    	global $app_id,$select_lng;
        extract( $args );
        
		$title 			=	apply_filters('widget_title', $instance['title']);
		$app_id                 =       $instance['app_id'];
		$fb_url 		=	$instance['fb_url'];
		$show_faces             =	isset($instance['show_faces']) ? $instance['show_faces'] : false;
		$show_stream            =	isset($instance['data_stream']) ? $instance['data_stream'] : false;
		$show_header            =	isset($instance['show_header']) ? $instance['show_header'] : false;
		$width			=	$instance['width'];
		$height			=	$instance['height'];
		$color_scheme           =	$instance['color_scheme'];
		$show_border            =	$instance['show_border'];
		$custom_css             =	$instance['custom_css'];
		$select_lng             =	$instance['select_lng'];
                
		echo $before_widget;
        if ( $title )
        echo $before_title . $title . $after_title;
        
        wp_register_script( 'myownscript', FB_WIDGET_PLUGIN_URL . 'fb.js' , array('jquery'));
        wp_enqueue_script( 'myownscript' );
        $local_variables = array('app_id' => $app_id,'select_lng'=>$select_lng);
        wp_localize_script( 'myownscript', 'vars', $local_variables );
        echo '<center><div class="loader"><img src="'.plugins_url().'/facebook-pagelike-widget/loader.gif" /></div></center>';
        echo '<div id="fb-root"></div>
        <div class="fb-like-box" data-href="'.$fb_url.'" data-width="'.$width.'" data-height="'.$height.'" data-colorscheme="'.$color_scheme.'" data-show-faces="'.$show_faces.'" data-header="'.$show_header.'" data-stream="'.$show_stream.'" data-show-border="'.$show_border.'" style="'.$custom_css.'"></div>';
        echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		
    	$instance	=	$old_instance;
		$instance	=	array('show_faces' => 0,'data_stream' => 0,'show_header' => 0,'show_border'=>0);
		foreach ( $instance as $field => $val ) {
			if ( isset($new_instance[$field]) )
				$instance[$field] = 1;
		}
                
		$instance['title']		=       strip_tags($new_instance['title']);
		$instance['app_id'] 		=       strip_tags($new_instance['app_id']);
		$instance['fb_url'] 		=	strip_tags($new_instance['fb_url']);
		$instance['width'] 		=	strip_tags($new_instance['width']);
		$instance['height'] 		=	strip_tags($new_instance['height']);
		$instance['color_scheme']	=	strip_tags($new_instance['color_scheme']);
		$instance['show_border']	=	strip_tags($new_instance['show_border']);
		$instance['custom_css']         =	strip_tags($new_instance['custom_css']);
		$instance['select_lng']         =	strip_tags($new_instance['select_lng']);

        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	

    	/**
    	 * Set Default Value for widget form
    	 */
    	
    	$default_value	=	array("width" => "250", "height" => "350", "show_faces" => 1, "show_header" => 1,"show_border"=>0,'select_lng'=>'en_US');
    	$instance		=	wp_parse_args((array)$instance,$default_value);
        $title			=	esc_attr($instance['title']);
        $app_id 		=   esc_attr($instance['app_id']);
        $fb_url			=	esc_attr($instance['fb_url']);
        $width			=	esc_attr($instance['width']);
        $height			=	esc_attr($instance['height']);
        $color_scheme	=	esc_attr($instance['color_scheme']);
        $show_border	=	esc_attr($instance['show_border']);
        $custom_css	=	esc_attr($instance['custom_css']);
        $select_lng	=	esc_attr($instance['select_lng']);
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo empty($title) ? 'Like Us On Facebook':$title; ?>" />
        </p>
		
        <p>
        	<label for="<?php echo $this->get_field_id('app_id'); ?>"><?php _e('Facebook Application Id:'); ?></label>
        	<input class="widefat" id="<?php echo $this->get_field_id('app_id'); ?>" name="<?php echo $this->get_field_name('app_id'); ?>" type="text" value="<?php echo empty($app_id) ? '503595753002055' : $app_id;?>" />
        </p>
        
        <p>
          	<label for="<?php echo $this->get_field_id('fb_url'); ?>"><?php _e('Facebook Page Url:'); ?></label>
          	<input class="widefat" id="<?php echo $this->get_field_id('fb_url'); ?>" name="<?php echo $this->get_field_name('fb_url'); ?>" type="text" value="<?php echo empty($fb_url) ? 'http://www.facebook.com/wordpress' : $fb_url; ?>" />
          	<small>
          		<?php _e('Works with only');?>
          		<a href="http://www.facebook.com/help/?faq=174987089221178" target="_blank">
          			<?php _e('Valid Facebook Pages'); ?>
          		</a>
          	</small>
        </p>
        
        <p>
        	<input class="checkbox" type="checkbox" <?php checked($instance['show_faces'], true) ?> id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" />
        	<label for="<?php echo $this->get_field_id('show_faces'); ?>"><?php _e('Show Friends\' Faces'); ?></label>
        </p>
        
        <p>
        	<input class="checkbox" type="checkbox" <?php checked($instance['data_stream'], true) ?> id="<?php echo $this->get_field_id('data_stream'); ?>" name="<?php echo $this->get_field_name('data_stream'); ?>" />
        	<label for="<?php echo $this->get_field_id('data_stream'); ?>"><?php _e('Show Posts'); ?></label>
        </p> 
        
        <p>
        	<input class="checkbox" type="checkbox" <?php checked($instance['show_header'], true) ?> id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" />
         	<label for="<?php echo $this->get_field_id('show_header'); ?>"><?php _e('Show Header'); ?></label>
        </p>
        
        <p>
        	<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Set Width:'); ?></label>
        	<input size="5" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
        </p>
        
        <p>
        	<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Set Height:'); ?></label>
        	<input size="5" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
        </p>
        
        <p>
        	<label for="<?php echo $this->get_field_id('color_scheme'); ?>"><?php _e('Color Scheme:'); ?></label>
    		<select name="<?php echo $this->get_field_name('color_scheme'); ?>" id="<?php echo $this->get_field_id('color_scheme'); ?>">
    			<option value="light"<?php selected( $instance['color_scheme'], 'light' ); ?>><?php _e('Light'); ?></option>
    			<option value="dark"<?php selected( $instance['color_scheme'], 'dark' ); ?>><?php _e('Dark'); ?></option>
        	</select>
        </p>
        
       <p>
        	<label for="<?php echo $this->get_field_id('show_border'); ?>"><?php _e('Show Border:'); ?></label>
    		<select name="<?php echo $this->get_field_name('show_border'); ?>" id="<?php echo $this->get_field_id('show_border'); ?>">
    			<option value="Yes"<?php selected( $instance['show_border'], 'Yes' ); ?>><?php _e('Yes'); ?></option>
    			<option value="No"<?php selected( $instance['show_border'], 'No' ); ?>><?php _e('No'); ?></option>
        	</select>
        </p>
        <?php
        $filename = "http://www.facebook.com/translations/FacebookLocales.xml";
        if(ini_get('allow_url_fopen')) {
            $langs = file_get_contents($filename);
            $xmlcont = new SimpleXMLElement($langs);
        ?>
        <p>
        	<label for="<?php echo $this->get_field_id('select_lng'); ?>"><?php _e('Select Language:'); ?></label>
                <select name="<?php echo $this->get_field_name('select_lng'); ?>" id="<?php echo $this->get_field_id('select_lng'); ?>">
                    <?php        
                    if(!empty($xmlcont)) {
                        foreach ($xmlcont as $languages) {
                            $representation = $languages[0]->codes->code->standard->representation[0];
                            ?>
                            <option value="<?php echo $representation;?>"<?php selected( $instance['select_lng'], $representation ); ?>><?php _e($title." => ".$representation); ?></option>
                            <?php
                        }
                    }
                    ?>
            </select>
        </p>
        <?php }
        elseif(function_exists('curl_version')) {
            if(!function_exists('file_get_contents_curl_mine')) {
                function file_get_contents_curl_mine($url) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $data = curl_exec($ch);
                    curl_close($ch);
                    return $data;
                }
            }
            if(!function_exists('xmlstring2array_mine')) {
                function xmlstring2array_mine($string)
                {
                    $xml   = simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA);
                    $array = json_decode(json_encode($xml), TRUE);
                    return $array;
                }
            }
            $langs      =   file_get_contents_curl_mine($filename);
            $xmlcont    =   xmlstring2array_mine($langs);
            $xmlcont    =   $xmlcont['locale'];
            ?>   
            <p>
        	<label for="<?php echo $this->get_field_id('select_lng'); ?>"><?php _e('Select Language:'); ?></label>
                <select name="<?php echo $this->get_field_name('select_lng'); ?>" id="<?php echo $this->get_field_id('select_lng'); ?>">
                    <?php
                    if(!empty($xmlcont)) {
                        foreach( $xmlcont as $languages ) {
                            $title          =   $languages['englishName'];
                            $representation =   $languages['codes']['code']['standard']['representation'];
                            ?>
                            <option value="<?php echo $representation;?>"<?php selected( $instance['select_lng'], $representation ); ?>><?php _e($title." => ".$representation); ?></option>
                            <?php
                            }
                    }
                    ?>
                </select>
        </p>    
            <?php
        } else {
           ?>
            <p>
        	<label for="<?php echo $this->get_field_id('select_lng'); ?>"><?php _e('Language : '); ?></label>
                <b>English</b> <br />(Your PHP configuration does not allow to read <a href="http://www.facebook.com/translations/FacebookLocales.xml" target="_blank">this</a> file.
                To unable language option, enable curl extension OR allow_url_fopen in your server configuration.)
        </p>       
            <?php
        }
        ?>
        <p>
        	<label for="<?php echo $this->get_field_id('custom_css'); ?>"><?php _e('Custom Css:'); ?></label>
                <textarea rows="4" cols="30" name="<?php echo $this->get_field_name('custom_css'); ?>"><?php if(!empty($custom_css)) { echo trim($custom_css); }?></textarea>
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("facebook_widget");'));
?>