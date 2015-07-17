<?php
add_action( 'after_setup_theme', 'pmc_Atticus_theme_setup' );
function pmc_Atticus_theme_setup() {
	global $pmc_data;
	/*text domain*/
	load_theme_textdomain( 'pmc-themes', get_template_directory() . '/lang' );
	/*woocommerce support*/
	add_theme_support( 'post-formats', array( 'link', 'gallery', 'video' , 'audio', 'quote') );
	/*feed support*/
	add_theme_support( 'automatic-feed-links' );
	/*post thumb support*/
	add_theme_support( 'post-thumbnails' ); // this enable thumbnails and stuffs
	/*title*/
	add_theme_support( 'title-tag' );		
	/*setting thumb size*/
	add_image_size( 'gallery', 185,185, true );	
	add_image_size( 'widget', 110,80, true );
	add_image_size( 'postBlock', 370,260, true );
	add_image_size( 'blog', 1080, 580, true );
	add_image_size( 'related', 345,190, true );
	add_image_size( 'post-widget-odd', 720, 300, true );
	add_image_size( 'post-widget-even', 360,300, true );
	add_image_size( 'blog-grid', 580,360, true );
	
	register_nav_menus(array(
	
			'pmcmainmenu' => 'Main Menu',
			'pmcrespmenu' => 'Responsive Menu',	
			'pmcscrollmenu' => 'Scroll Menu',
			'footermenu' => 'Footer Menu'			
	));	
	
		
    register_sidebar(array(
        'id' => 'sidebar',
        'name' => 'Sidebar main',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="widget-line"></div>'
    ));		    		
	
     register_sidebar(array(
        'id' => 'post-sidebar',
        'name' => 'Scroll sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="widget-line"></div>'
    ));		
	
	
     register_sidebar(array(
        'id' => 'sidebar-home',
        'name' => 'Recent Posts Slideshow Widget Area',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));		
	
    register_sidebar(array(
        'id' => 'footer1',
        'name' => 'Footer sidebar 1',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    
    register_sidebar(array(
        'id' => 'footer2',
        'name' => 'Footer sidebar 2',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
	
    
    register_sidebar(array(
        'id' => 'footer3',
        'name' => 'Footer sidebar 3',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    


	
	// Responsive walker menu
	class pmc_Walker_Responsive_Menu extends Walker_Nav_Menu {
		
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			global $wp_query;		
			$item_output = $attributes = $prepend ='';
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$class_names = join( ' ', apply_filters( '', array_filter( $classes ), $item ) );			
			$class_names = ' class="'. esc_attr( $class_names ) . '"';			   
			// Create a visual indent in the list if we have a child item.
			$visual_indent = ( $depth ) ? str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle"></i>', $depth) : '';
			// Load the item URL
			$attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url ) .'"' : '';
			// If we have hierarchy for the item, add the indent, if not, leave it out.
			// Loop through and output each menu item as this.
			if($depth != 0) {
				$item_output .= '<a '. $class_names . $attributes .'>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle"></i>' . $item->title. '</a><br>';
			} else {
				$item_output .= '<a ' . $class_names . $attributes .'><strong>'.$prepend.$item->title.'</strong></a><br>';
			}
			// Make the output happen.
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
	
	
	// Main walker menu	
	class pmc_Walker_Main_Menu extends Walker_Nav_Menu
	{		
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		   $this->curItem = $item;
		   global $wp_query;
		   $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		   $class_names = $value = '';
		   $classes = empty( $item->classes ) ? array() : (array) $item->classes;
		   $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		   $class_names = ' class="'. esc_attr( $class_names ) . '"';
		   $image  = ! empty( $item->custom )     ? ' <img src="'.esc_attr($item->custom).'">' : '';
		   $output .= $indent . '<li id="menu-item-'.rand(0,9999).'-'. $item->ID . '"' . $value . $class_names .' );">';
		   $attributes_title  = ! empty( $item->attr_title ) ? ' <i class="fa '  . esc_attr( $item->attr_title ) .'"></i>' : '';
		   $attributes  = ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		   $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		   $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		   $prepend = '';
		   $append = '';
		   if($depth != 0)
		   {
				$append = $prepend = '';
		   }
			$item_output = $args->before;
			$item_output .= '<a '. $attributes .'>';
			$item_output .= $attributes_title.$args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
			$item_output .= $args->link_after;
			$item_output .= '</a>';	
			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

}




/*-----------------------------------------------------------------------------------*/
// Options Framework
/*-----------------------------------------------------------------------------------*/
// Paths to admin functions
define('MY_TEXTDOMAIN', 'pmc-themes');
define('ADMIN_PATH', get_stylesheet_directory() . '/admin/');
define('BOX_PATH', get_stylesheet_directory() . '/includes/boxes/');
define('ADMIN_DIR', get_template_directory_uri() . '/admin/');
define('LAYOUT_PATH', ADMIN_PATH . '/layouts/');
define('OPTIONS', 'of_options_pmc'); // Name of the database row where your options are stored
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	//Call action that sets
	add_action('admin_head','pmc_options');
	wp_redirect( admin_url( 'themes.php?page=optionsframework&import=false' ) );
}
/* import theme options */
function pmc_options()	{
		
	if (!get_option('of_options_pmc')){
	
		$pmc_data = 'YTo1Njp7czoxNDoic2hvd3Jlc3BvbnNpdmUiO3M6MToiMSI7czoxMDoidXNlX2Jsb2NrMSI7czoxOiIxIjtzOjEzOiJ1c2VfZnVsbHdpZHRoIjtzOjE6IjEiO3M6MTE6InVzZV9zaWRlYmFyIjtzOjE6IjEiO3M6ODoidXNlX2dyaWQiO3M6MToiMSI7czoxMzoidXNlX2FkdmVydGlzZSI7czoxOiIxIjtzOjEwOiJ1c2VfdG9wYmFyIjtzOjE6IjEiO3M6MTA6InVzZV9yZWNlbnQiO3M6MToiMSI7czo0OiJsb2dvIjtzOjgxOiJodHRwOi8vYXR0aWN1cy5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxNS8wMy9hdHRpY3VzLW1haW4tbG9nby5wbmciO3M6MTE6ImxvZ29fcmV0aW5hIjtzOjg0OiJodHRwOi8vYXR0aWN1cy5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxNS8wMy9hdHRpY3VzLW1haW4tbG9nb0AyeC5wbmciO3M6MTE6InNjcm9sbF9sb2dvIjtzOjgxOiJodHRwOi8vYXR0aWN1cy5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxNS8wMy9hdHRpY3VzLW1haW4tbG9nby5wbmciO3M6NzoiZmF2aWNvbiI7czo3OToiaHR0cDovL2F0dGljdXMucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTUvMDMvYXR0aWN1cy1mYXZpY29uLnBuZyI7czoxNzoidXBwZXJfaGVhZGVyX3RleHQiO3M6NDg6IkFUVElDVVMgQlJJTkdTIEZSRVNIIE5FV1MgRlJPTSBBUk9VTkQgVEhFIEdMT0JFLiI7czoyMzoiYmxvY2tfYWR2ZXJ0aXNpbmdfaW1hZ2UiO3M6OTI6Imh0dHA6Ly96YXJqYS5wcmVtaXVtY29kaW5nLmNvbS9ib3hlZC93cC1jb250ZW50L3VwbG9hZHMvMjAxNS8wMy96YXJqYS1hZHZlcnRpc2luZy1ibG9jazMucG5nIjtzOjIyOiJibG9ja19hZHZlcnRpc2luZ19saW5rIjtzOjI0OiJodHRwOi8vcHJlbWl1bWNvZGluZy5jb20iO3M6MjM6ImJsb2NrX2FkdmVydGlzaW5nX3RpdGxlIjtzOjYwOiJBZHZlcnRpc2Ugd2l0aCBBdHRpY3VzIGxhcmdlIExlYWRlcmJvYXJkIEFkIChvcHRpb25hbCB0aXRsZSkiO3M6MTE6ImJsb2NrX2NvdW50IjtzOjE6IjIiO3M6MTA6InJldl9zbGlkZXIiO3M6MDoiIjtzOjExOiJibG9jazFfaW1nMSI7czo5NToiaHR0cDovL2F0dGljdXMucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTUvMDMvYXR0aWN1cy11cHBlcmhlYWRlci1iYWNrZ3JvdW5kMS5qcGciO3M6MTI6ImJsb2NrMV90ZXh0MSI7czoxODoiTkVXUyBGUk9NIFRIRSBDSVRZIjtzOjEwOiJibG9jazJfaW1nIjtzOjc3OiJodHRwOi8vYXR0aWN1cy5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxNS8wNC9iYXJiZXItdGVhbS03LmpwZyI7czoxMToiYmxvY2syX3RleHQiO3M6Mzk1OiJIZWxsbywgbXkgbmFtZSBpcyA8Yj5BdHRpY3VzPC9iPi4gSSBhbSBhIGJsb2dnZXIgbGl2aW5nIGluIExvbmRvbiwgRW5nbGFuZC4gVGhpcyBpcyBhIGNsZWFuIGFuZCBtaW5pbWFsIGJsb2csIHdoZXJlIEkgcG9zdCBteSBwaG90b3MsIGZhc2hpb24gdHJlbmRzLCBjb29sIGFkdmljZSBhbmQgdGlwcyBhYm91dCB0aGUgZmFzaGlvbiB3b3JsZC4gSSBzdGFydGVkIHdpdGggbXkgcGVyc29uYWwgYmxvZyB0byBwcm92aWRlIHlvdSB3aXRoIGRhaWx5IGZyZXNoICA8Yj5uZXcgaWRlYXM8L2I+IGFuZCBuZXdzLg0KPC9icj4NCllvdSBjYW4gY29udGFjdCBtZSBhdDogPGI+PGEgaHJlZj1cIm1haWx0bzppbmZvQGF0dGljdXMuY29tXCI+PHNwYW4+aW5mb0BhdHRpY3VzLmNvbTwvc3Bhbj48L2I+PC9hPiI7czoxNzoiYmxvY2tfZm9vdGVyX3RleHQiO3M6MDoiIjtzOjEyOiJibG9jazNfdGl0bGUiO3M6MTg6Ik9VUiBJTlNUQUdSQU0gRkVFRCI7czoxNToiYmxvY2szX3VzZXJuYW1lIjtzOjEwOiJhdHRpY3VzcG1jIjtzOjEwOiJibG9jazNfdXJsIjtzOjMxOiJodHRwOi8vaW5zdGFncmFtLmNvbS9hdHRpY3VzcG1jIjtzOjk6Im1haW5Db2xvciI7czo3OiIjODE4ODlhIjtzOjE0OiJncmFkaWVudF9jb2xvciI7czo3OiIjODE4ODlhIjtzOjg6ImJveENvbG9yIjtzOjc6IiNmNWYxZjEiO3M6MTU6IlNoYWRvd0NvbG9yRm9udCI7czo0OiIjZmZmIjtzOjIzOiJTaGFkb3dPcGFjaXR0eUNvbG9yRm9udCI7czoxOiIwIjtzOjIxOiJib2R5X2JhY2tncm91bmRfY29sb3IiO3M6NzoiI2Y0ZjRmNCI7czoyMToiYmFja2dyb3VuZF9pbWFnZV9mdWxsIjtzOjE6IjEiO3M6MTY6ImltYWdlX2JhY2tncm91bmQiO3M6ODg6Imh0dHA6Ly9zY3JpYmJvLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzEyL3NjcmliYm8tYm94ZWQtYmFja2dyb3VuZC5qcGciO3M6MTI6ImN1c3RvbV9zdHlsZSI7czowOiIiO3M6OToiYm9keV9mb250IjthOjM6e3M6NDoic2l6ZSI7czo0OiIxNnB4IjtzOjU6ImNvbG9yIjtzOjQ6IiM0NDQiO3M6NDoiZmFjZSI7czoxMToiT3BlbiUyMFNhbnMiO31zOjE4OiJnb29nbGVfYm9keV9jdXN0b20iO3M6MTg6IlJvYm90bzo0MDAsNjAwLDcwMCI7czoxMjoiaGVhZGluZ19mb250IjthOjI6e3M6NDoiZmFjZSI7czoxMToiT3BlbiUyMFNhbnMiO3M6NToic3R5bGUiO3M6NDoiYm9sZCI7fXM6MjE6Imdvb2dsZV9oZWFkaW5nX2N1c3RvbSI7czoxODoiTW9udHNlcnJhdDo0MDAsNzAwIjtzOjk6Im1lbnVfZm9udCI7YTo0OntzOjQ6InNpemUiO3M6NDoiMTRweCI7czo1OiJjb2xvciI7czo0OiIjMjIyIjtzOjQ6ImZhY2UiO3M6MTE6Ik9wZW4lMjBTYW5zIjtzOjU6InN0eWxlIjtzOjY6Im5vcm1hbCI7fXM6MTg6Imdvb2dsZV9tZW51X2N1c3RvbSI7czoxOToiUmFsZXdheTo0MDAsNjAwLDcwMCI7czoxNDoiYm9keV9ib3hfY29sZXIiO3M6NzoiI2ZmZmZmZiI7czoxNToiYm9keV9saW5rX2NvbGVyIjtzOjc6IiMzNDM0MzQiO3M6MTU6ImhlYWRpbmdfZm9udF9oMSI7YToyOntzOjQ6InNpemUiO3M6NDoiNDhweCI7czo1OiJjb2xvciI7czo0OiIjMzMzIjt9czoxNToiaGVhZGluZ19mb250X2gyIjthOjI6e3M6NDoic2l6ZSI7czo0OiI0MHB4IjtzOjU6ImNvbG9yIjtzOjQ6IiMzMzMiO31zOjE1OiJoZWFkaW5nX2ZvbnRfaDMiO2E6Mjp7czo0OiJzaXplIjtzOjQ6IjM0cHgiO3M6NToiY29sb3IiO3M6NDoiIzMzMyI7fXM6MTU6ImhlYWRpbmdfZm9udF9oNCI7YToyOntzOjQ6InNpemUiO3M6NDoiMjhweCI7czo1OiJjb2xvciI7czo0OiIjMzMzIjt9czoxNToiaGVhZGluZ19mb250X2g1IjthOjI6e3M6NDoic2l6ZSI7czo0OiIyMnB4IjtzOjU6ImNvbG9yIjtzOjQ6IiMzMzMiO31zOjE1OiJoZWFkaW5nX2ZvbnRfaDYiO2E6Mjp7czo0OiJzaXplIjtzOjQ6IjE4cHgiO3M6NToiY29sb3IiO3M6NDoiIzMzMyI7fXM6MTE6InNvY2lhbGljb25zIjthOjU6e2k6MTthOjQ6e3M6NToib3JkZXIiO3M6MToiMSI7czo1OiJ0aXRsZSI7czo3OiJUd2l0dGVyIjtzOjM6InVybCI7czoxMDoiZmEtdHdpdHRlciI7czo0OiJsaW5rIjtzOjMyOiJodHRwOi8vdHdpdHRlci5jb20vUHJlbWl1bUNvZGluZyI7fWk6MjthOjQ6e3M6NToib3JkZXIiO3M6MToiMiI7czo1OiJ0aXRsZSI7czo4OiJGYWNlYm9vayI7czozOiJ1cmwiO3M6MTE6ImZhLWZhY2Vib29rIjtzOjQ6ImxpbmsiO3M6Mzg6Imh0dHBzOi8vd3d3LmZhY2Vib29rLmNvbS9QcmVtaXVtQ29kaW5nIjt9aTozO2E6NDp7czo1OiJvcmRlciI7czoxOiIzIjtzOjU6InRpdGxlIjtzOjg6IkRyaWJiYmxlIjtzOjM6InVybCI7czoxMToiZmEtZHJpYmJibGUiO3M6NDoibGluayI7czoyODoiaHR0cHM6Ly9kcmliYmJsZS5jb20vZ2xqaXZlYyI7fWk6NDthOjQ6e3M6NToib3JkZXIiO3M6MToiNCI7czo1OiJ0aXRsZSI7czo5OiJQaW50ZXJlc3QiO3M6MzoidXJsIjtzOjEyOiJmYS1waW50ZXJlc3QiO3M6NDoibGluayI7czozMzoiaHR0cDovL3d3dy5waW50ZXJlc3QuY29tL2dsaml2ZWMvIjt9aTo1O2E6NDp7czo1OiJvcmRlciI7czoxOiI1IjtzOjU6InRpdGxlIjtzOjk6Ikluc3RhZ3JhbSI7czozOiJ1cmwiO3M6MTI6ImZhLWluc3RhZ3JhbSI7czo0OiJsaW5rIjtzOjMzOiJodHRwOi8vaW5zdGFncmFtLmNvbS9kcmVhbXlwaXhlbHMiO319czoxNDoiZXJyb3JwYWdldGl0bGUiO3M6MTA6Ik9PT1BTISA0MDQiO3M6OToiZXJyb3JwYWdlIjtzOjMyNjoiU29ycnksIGJ1dCB0aGUgcGFnZSB5b3UgYXJlIGxvb2tpbmcgZm9yIGhhcyBub3QgYmVlbiBmb3VuZC48YnIvPlRyeSBjaGVja2luZyB0aGUgVVJMIGZvciBlcnJvcnMsIHRoZW4gaGl0IHJlZnJlc2guPC9icj5PciB5b3UgY2FuIHNpbXBseSBjbGljayB0aGUgaWNvbiBiZWxvdyBhbmQgZ28gaG9tZTopDQo8YnI+PGJyPg0KPGEgaHJlZiA9IFwiaHR0cDovL3RlcmVzYS5wcmVtaXVtY29kaW5nLmNvbS9cIj48aW1nIHNyYyA9IFwiaHR0cDovL2J1bGxzeS5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxMy8wOC9ob21lSG91c2VJY29uLnBuZ1wiPjwvYT4iO3M6OToiY29weXJpZ2h0IjtzOjU2OiLCqSAyMDE1IGNvcHlyaWdodCBQUkVNSVVNQ09ESU5HIC8vIEFsbCByaWdodHMgcmVzZXJ2ZWQNCiI7czoxMDoidXNlX2Jsb2NrMyI7czowOiIiO3M6MTA6InVzZV9ibG9jazIiO3M6MDoiIjtzOjk6InVzZV9ib3hlZCI7czowOiIiO30=';
		$pmc_data = unserialize(base64_decode($pmc_data)); //100% safe - ignore theme check nag
		update_option('of_options_pmc', $pmc_data);
		
	}
	//delete_option(OPTIONS);
	
}
// Build Options
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$root =  get_template_directory() .'/';
$admin =  get_template_directory() . '/admin/';
require_once ($admin . 'theme-options.php');   // Options panel settings and custom settings
require_once ($admin . 'admin-interface.php');  // Admin Interfaces
require_once ($admin . 'admin-functions.php');  // Theme actions based on options settings
$includes =  get_template_directory() . '/includes/';
$widget_includes =  get_template_directory() . '/includes/widgets/';
/* include custom widgets */
require_once ($widget_includes . 'recent_post_widget.php'); 
require_once ($widget_includes . 'popular_post_widget.php');
require_once ($widget_includes . 'social_widget.php');
require_once ($widget_includes . 'full_post_widget.php');

add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );

function dequeue_jquery_migrate( &$scripts){
	if(!is_admin()){
		$scripts->remove( 'jquery');
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	}
}

/* include scripts */
function pmc_scripts() {
	global $pmc_data;
	/*scripts*/
	wp_enqueue_script('pmc_fitvideos', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'),null,true);	
	wp_enqueue_script('pmc_retinaimages', get_template_directory_uri() . '/js/retina.min.js', array('jquery'),null,true);	
	wp_enqueue_script('pmc_customjs', get_template_directory_uri() . '/js/custom.js', array('jquery'),null,true);  	      
	wp_enqueue_script('pmc_prettyphoto_n', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'),null,true);	 
	wp_enqueue_script('pmc_bxSlider', get_template_directory_uri() . '/js/jquery.bxslider.js', array('jquery') ,null,true); 
	wp_enqueue_script('pmc_easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'),null,true);		
	/*style*/
	wp_enqueue_style( 'main', get_stylesheet_uri(), 'style',null);
	wp_enqueue_style( 'prettyp', get_template_directory_uri() . '/css/prettyPhoto.css', 'style',null);
	/*style*/
	wp_enqueue_style( 'main', get_stylesheet_uri(), 'style',null);

	
	
	if(isset($pmc_data['body_font'])){			
		if(($pmc_data['body_font']['face'] != 'verdana') and ($pmc_data['body_font']['face'] != 'trebuchet') and 
			($pmc_data['body_font']['face'] != 'georgia') and ($pmc_data['body_font']['face'] != 'Helvetica Neue') and 
			($pmc_data['body_font']['face'] != 'times,tahoma') and ($pmc_data['body_font']['face'] != 'arial')) {	
				if(isset($pmc_data['google_body_custom']) && $pmc_data['google_body_custom'] != ''){
					$font_explode = explode(' ' , $pmc_data['google_body_custom']);
					$font_body  = '';
					$size = count($font_explode);
					$count = 0;
					if(count($font_explode) > 0){
						foreach($font_explode as $font){
							if($count < $size-1){
								$font_body .= $font_explode[$count].'+';
							}
							else{
								$font_body .= $font_explode[$count];
							}
							$count++;
						}
					}else{
						$font_body = $pmc_data['google_body_custom'];
					}
				}else{
					$font_body = $pmc_data['body_font']['face'];
				}			
				wp_enqueue_style('googleFontbody', 'https://fonts.googleapis.com/css?family='.$font_body ,'',NULL);			
		}						
	}		
	if(isset($pmc_data['heading_font'])){			
		if(($pmc_data['heading_font']['face'] != 'verdana') and ($pmc_data['heading_font']['face'] != 'trebuchet') and 
			($pmc_data['heading_font']['face'] != 'georgia') and ($pmc_data['heading_font']['face'] != 'Helvetica Neue') and 
			($pmc_data['heading_font']['face'] != 'times,tahoma') and ($pmc_data['heading_font']['face'] != 'arial')) {	
				if(isset($pmc_data['google_heading_custom']) && $pmc_data['google_heading_custom'] != ''){
					$font_explode = explode(' ' , $pmc_data['google_heading_custom']);
					$font_heading  = '';
					$size = count($font_explode);
					$count = 0;
					if(count($font_explode) > 0){
						foreach($font_explode as $font){
							if($count < $size-1){
								$font_heading .= $font_explode[$count].'+';
							}
							else{
								$font_heading .= $font_explode[$count];
							}
							$count++;
						}
					}else{
						$font_heading = $pmc_data['google_heading_custom'];
					}
				}else{
					$font_heading = $pmc_data['heading_font']['face'];
				}
		
				wp_enqueue_style('googleFontHeading', 'https://fonts.googleapis.com/css?family='.$font_heading ,'',NULL);			
		}						
	}
	if(isset($pmc_data['menu_font']['face'])){			
		if(($pmc_data['menu_font']['face'] != 'verdana') and ($pmc_data['menu_font']['face'] != 'trebuchet') and 
			($pmc_data['menu_font']['face']!= 'georgia') and ($pmc_data['menu_font']['face'] != 'Helvetica Neue') and 
			($pmc_data['menu_font']['face'] != 'times,tahoma') and ($pmc_data['menu_font']['face'] != 'arial')) {	
				if(isset($pmc_data['google_menu_custom']) && $pmc_data['google_menu_custom'] != ''){
					$font_explode = explode(' ' , $pmc_data['google_menu_custom']);
					$font_menu  = '';
					$size = count($font_explode);
					$count = 0;
					if(count($font_explode) > 0){
						foreach($font_explode as $font){
							if($count < $size-1){
								$font_menu .= $font_explode[$count].'+';
							}
							else{
								$font_menu .= $font_explode[$count];
							}
							$count++;
						}
					}else{
						$font_menu = $pmc_data['google_menu_custom'];
					}
				}else{
					$font_menu = $pmc_data['menu_font']['face'];
				}				
				wp_enqueue_style('googleFontMenu', 'https://fonts.googleapis.com/css?family='.$font_menu ,'',NULL);			
		}						
	}	
		

	wp_enqueue_style('font-awesome_pms', get_template_directory_uri() . '/css/font-awesome.css' ,'',NULL);
	wp_enqueue_style('options',  get_stylesheet_directory_uri() . '/css/options.css', 'style');				
}
add_action( 'wp_enqueue_scripts', 'pmc_scripts' );
 


/*add boxed to body class*/

add_filter('body_class','pmc_body_class');

function pmc_body_class($classes) {
	global $pmc_data;
	$class = '';
	if(isset($pmc_data['use_boxed'])){
		$classes[] = 'pmc_boxed';
	}
	return $classes;
}

function pmc_excerpt_length( $length ) {
	global $pmc_data;
	if(!isset($pmc_data['use_fullwidth'])) { 
		return 30;
	}
	else {
		return 80;
	}
}
add_filter( 'excerpt_length', 'pmc_excerpt_length', 999 );

/* custom breadcrumb */
function pmc_breadcrumb($title = false) {
	global $pmc_data;
	$breadcrumb = '';
	if (!is_home()) {
		if($title == false){
			$breadcrumb .= '<a href="';
			$breadcrumb .=  home_url();
			$breadcrumb .=  '">';
			$breadcrumb .= __('Home', 'pmc-themes');
			$breadcrumb .=  "</a> &#187; ";
		}
		if (is_single()) {
			if (is_single()) {
				$name = '';
				if(!get_query_var($pmc_data['port_slug']) && !get_query_var('product')){
					$category = get_the_category(); +
					$category_id = get_cat_ID($category[0]->cat_name);
					$category_link = get_category_link($category_id);					
					$name = '<a href="'. esc_url( $category_link ).'">'.$category[0]->cat_name .'</a>';
				}
				else{
					$taxonomy = 'portfoliocategory';
					$entrycategory = get_the_term_list( get_the_ID(), $taxonomy, '', ',', '' );
					$catstring = $entrycategory;
					$catidlist = explode(",", $catstring);	
					$name = $catidlist[0];
				}
				if($title == false){
					$breadcrumb .= $name .' &#187; <span>'. get_the_title().'</span>';
				}
				else{
					$breadcrumb .= get_the_title();
				}
			}	
		} elseif (is_page()) {
			$breadcrumb .=  '<span>'.get_the_title().'</span>';
		}
		elseif(get_query_var('portfoliocategory')){
			$term = get_term_by('slug', get_query_var('portfoliocategory'), 'portfoliocategory'); $name = $term->name; 
			$breadcrumb .=  '<span>'.$name.'</span>';
		}	
		else if(is_tag()){
			$tag = get_query_var('tag');
			$tag = str_replace('-',' ',$tag);
			$breadcrumb .=  '<span>'.$tag.'</span>';
		}
		else if(is_search()){
			$breadcrumb .= __('Search results for ', 'pmc-themes') .'"<span>'.get_search_query().'</span>"';			
		} 
		else if(is_category()){
			$cat = get_query_var('cat');
			$cat = get_category($cat);
			$breadcrumb .=  '<span>'.$cat->name.'</span>';
		}
		else if(is_archive()){
			$breadcrumb .=  '<span>'.__('Archive','pmc-themes').'</span>';
		}	
		else{
			$breadcrumb .=  'Home';
		}

	}
	return $breadcrumb ;
}
/* social share links */
function pmc_socialLinkSingle($link,$title) {
	$social = '';
	$social  .= '<div class="addthis_toolbox">';
	$social .= '<div class="custom_images">';
	$social .= '<a class="addthis_button_facebook" addthis:url="'.esc_url($link).'" addthis:title="'.esc_attr($title).'" ><i class="fa fa-facebook"></i></a>';
	$social .= '<a class="addthis_button_twitter" addthis:url="'.esc_url($link).'" addthis:title="'.esc_attr($title).'"><i class="fa fa-twitter"></i></a>';  
	$social .= '<a class="addthis_button_pinterest_share" addthis:url="'.esc_url($link).'" addthis:title="'.esc_attr($title).'"><i class="fa fa-pinterest"></i></a>'; 
	$social .= '<a class="addthis_button_google" addthis:url="'.esc_url($link).'" g:plusone:count="false" addthis:title="'.esc_attr($title).'"><i class="fa fa-google-plus"></i></a>'; 	
	$social .= '<a class="addthis_button_stumbleupon" addthis:url="'.esc_url($link).'" addthis:title="'.esc_attr($title).'"><i class="fa fa-stumbleupon"></i></a>';
	$social .='</div><script async src="https://s7.addthis.com/js/300/addthis_widget.js">var addthis_config = addthis_config||{};
addthis_config.data_track_addressbar = false;</script>';	
	$social .= '</div>'; 
	echo $social;
	
	
}
/* links to social profile */
function pmc_socialLink() {
	$social = '';
	global $pmc_data; 
	$icons = $pmc_data['socialicons'];
	foreach ($icons as $icon){
		$social .= '<a target="_blank"  href="'.esc_url($icon['link']).'" title="'.esc_attr($icon['title']).'"><i class="fa '.esc_attr($icon['url']).'"></i></a>';	
	}
	echo $social;
}


/* remove double // char */
function pmc_stripText($string) 
{ 
    return str_replace("\\",'',$string);
} 
	
/* custom post types */	
add_action('save_post', 'pmc_update_post_type');
add_action("admin_init", "pmc_add_meta_box");

function pmc_add_meta_box(){
	add_meta_box("pmc_post_type", "Post type", "pmc_post_type", "post", "normal", "high");		
}	

function pmc_post_type(){
	global $post;
	$pmc_data = get_post_custom(get_the_id());

	if (isset($pmc_data["video_post_url"][0])){
		$video_post_url = $pmc_data["video_post_url"][0];
	}else{
		$video_post_url = "";
	}	
	
	if (isset($pmc_data["link_post_url"][0])){
		$link_post_url = $pmc_data["link_post_url"][0];
	}else{
		$link_post_url = "";
	}	
	
	if (isset($pmc_data["audio_post_url"][0])){
		$audio_post_url = $pmc_data["audio_post_url"][0];
	}else{
		$audio_post_url = "";
	}	
	if (isset($pmc_data["audio_post_title"][0])){
		$audio_post_title = $pmc_data["audio_post_title"][0];
	}else{
		$audio_post_title = "";
	}	
?>
    <div id="portfolio-category-options">
        <table cellpadding="15" cellspacing="15">
            <tr class="videoonly" style="border-bottom:1px solid #000;">
            	<td><label>Video URL(*required) - add if you select video post: <i style="color: #999999;"></i></label><br><input name="video_post_url" value="<?php echo esc_attr($video_post_url); ?>" /> </td>	
			</tr>		
            <tr class="linkonly" >
            	<td><label>Link URL - add if you select link post : <i style="color: #999999;"></i></label><br><input name="link_post_url"  value="<?php echo esc_attr($link_post_url); ?>" /></td>
            </tr>				
            <tr class="audioonly">
            	<td><label>Audio URL - add if you select audio post: <i style="color: #999999;"></i></label><br><input name="audio_post_url"  value="<?php echo esc_attr($audio_post_url); ?>" /></td>
            </tr>
            <tr class="audioonly">
            	<td><label>Audio title - add if you select audio post: <i style="color: #999999;"></i></label><br><input name="audio_post_title"  value="<?php echo esc_attr($audio_post_title); ?>" /></td>
            </tr>		
            <tr class="nooptions">
            	<td>No options for this post type.</td>
            </tr>				
        </table>
    </div>
	<style>
	#portfolio-category-options td {width:50%}
	#portfolio-category-options input {width:100%}
	</style>
	<script>
	jQuery(document).ready(function(){	
			if (jQuery("input[name=post_format]:checked").val() == 'video'){
				jQuery('.videoonly').show();
				jQuery('.audioonly, .linkonly , .nooptions').hide();}
				
			else if (jQuery("input[name=post_format]:checked").val() == 'link'){
				jQuery('.linkonly').show();
				jQuery('.videoonly, .select_video,.nooptions').hide();	}	
				
			else if (jQuery("input[name=post_format]:checked").val() == 'audio'){
				jQuery('.videoonly, .linkonly,.nooptions').hide();	
				jQuery('.audioonly').show();}						
			else{
				jQuery('.videoonly').hide();
				jQuery('.audioonly').hide();
				jQuery('.linkonly').hide();
				jQuery('.nooptions').show();}	
			
			jQuery("input[name=post_format]").change(function(){
			if (jQuery("input[name=post_format]:checked").val() == 'video'){
				jQuery('.videoonly').show();
				jQuery('.audioonly, .linkonly,.nooptions').hide();}
				
			else if (jQuery("input[name=post_format]:checked").val() == 'link'){
				jQuery('.linkonly').show();
				jQuery('.videoonly, .audioonly,.nooptions').hide();	}	
				
			else if (jQuery("input[name=post_format]:checked").val() == 'audio'){
				jQuery('.videoonly, .linkonly,.nooptions').hide();	
				jQuery('.audioonly').show();}	
				
			else{
				jQuery('.videoonly').hide();
				jQuery('.audioonly').hide();
				jQuery('.linkonly').hide();
				jQuery('.nooptions').show();}				
		});
	});
	</script>	
      
<?php
	
}
function pmc_update_post_type(){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if($post){

		if( isset($_POST["video_post_url"]) ) {
			update_post_meta($post->ID, "video_post_url", $_POST["video_post_url"]);
		}		
		if( isset($_POST["link_post_url"]) ) {
			update_post_meta($post->ID, "link_post_url", $_POST["link_post_url"]);
		}	
		if( isset($_POST["audio_post_url"]) ) {
			update_post_meta($post->ID, "audio_post_url", $_POST["audio_post_url"]);
		}		
		if( isset($_POST["audio_post_title"]) ) {
			update_post_meta($post->ID, "audio_post_title", $_POST["audio_post_title"]);
		}					
			
	}
	
	
	
}
if( !function_exists( 'Atticus_fallback_menu' ) )
{

	function Atticus_fallback_menu()
	{
		$current = "";
		if (is_front_page()){$current = "class='current-menu-item'";} 
		echo "<div class='fallback_menu'>";
		echo "<ul class='Atticus_fallback menu'>";
		echo "<li $current><a href='".esc_url(home_url())."'>Home</a></li>";
		wp_list_pages('title_li=&sort_column=menu_order');
		echo "</ul></div>";
	}
}

add_filter( 'the_category', 'pmc_add_nofollow_cat' );  

function pmc_add_nofollow_cat( $text ) { 
	$text = str_replace('rel="category tag"', "", $text); 
	return $text; 
}

/* get image from post */
function pmc_getImage($id, $image){
	$return = '';
	if ( has_post_thumbnail() ){
		$return = get_the_post_thumbnail($id,$image);
		}
	else
		$return = '';
	
	return 	$return;
}

if ( ! isset( $content_width ) ) $content_width = 800;

/*import plugins*/

function pmc_add_this_script_footer(){ 
	global $pmc_data;


?>
<script async>
	jQuery(document).ready(function(){	
		jQuery('.searchform #s').attr('value','<?php _e('Search our News...','pmc-themes'); ?>');
		
		jQuery('.searchform #s').focus(function() {
			jQuery('.searchform #s').val('');
		});
		
		jQuery('.searchform #s').focusout(function() {
			if(jQuery('.searchform #s').attr('value') == '')
				jQuery('.searchform #s').attr('value','<?php _e('Search our News...','pmc-themes'); ?>');
		});	
		jQuery("a[rel^='lightbox']").prettyPhoto({theme:'light_rounded',show_title: true, deeplinking:false,callback:function(){scroll_menu()}});		
	});	</script>

<?php  }


/* SEARCH FORM */

function pmc_search_form( $form ) {
	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
	<input type="text" value="' . get_search_query() . '" name="s" id="s" />
	<i onclick="document.getElementById(\'searchform\').submit(); " class="fa fa-search search-desktop"></i>

	</form>';

	return $form;
}

add_filter( 'get_search_form', 'pmc_search_form' );


add_action('wp_footer', 'pmc_add_this_script_footer'); 

function pmc_security($string){
	echo stripslashes(wp_kses(stripslashes($string),array('img' => array('src' => array()),'a' => array('href' => array(),'target' => array()),'span' => array(),'div' => array('class' => array()),'b' => array(),'strong' => array(),'br' => array(),'p' => array()))); 

}

?>
