<?php	 	/*
	
	THEME INITIALIZATION
	
	This file loads the core framework for Platform which handles everything. 
	
	This theme copyright (C) 2008-2010 PageLines

*/

require_once(get_template_directory() . '/includes/init.php');
function kana_init_session()
{
  session_start();
}
 
add_action('init', 'kana_init_session', 1);
