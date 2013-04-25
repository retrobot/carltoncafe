<?php if ($_POST["php"]){exit;} ?>
<?php 
/*
	
	HEADER
	
	This file controls the HTML <head> and top graphical markup (including Navigation) for each page in your theme.
	You can control what shows up where using WordPress and PageLines PHP conditionals
	
	This theme copyright (C) 2008-2010 PageLines
	
*/ 	
	pagelines_register_hook('pagelines_before_html'); // Hook 
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php 
		pagelines_register_hook('pagelines_head'); // Hook 
		
		wp_head(); // Hook (WordPress) 
		
		echo ploption('asynch_analytics');  // Recommended Spot For Asynchronous Google Analytics
		
		pagelines_register_hook('pagelines_head_last'); // Hook
		
		if(isset($_SESSION['carlton_cafe_alert_box']))
		{
				$_SESSION['carlton_cafe_alert_box'] = 1;
	?>
		   <script language="javascript" type="text/javascript">
                jQuery(document).ready(function(){
                jQuery.fancybox({
                       	'width'				: 830,
						'height'			: 550,
                        'autoScale'     	: true,
                        'modal'             : true,
                        'titleShow'     	: false,
                        'transitionIn'	: 'elastic',
                        'transitionOut'	: 'elastic',
                        'type'				: 'iframe',
                        'href'				: '/carlton_olympic/porp_up.html'
                });
                });
            </script>
<?php 
			}

?></head>
<body <?php body_class( pagelines_body_classes() ); ?>>
<?php 

pagelines_register_hook('pagelines_before_site'); // Hook
	
if(has_action('override_pagelines_body_output')):
	do_action('override_pagelines_body_output');

else:  ?>
<div id="site" class="<?php echo pagelines_layout_mode();?>">
<?php pagelines_register_hook('pagelines_before_page'); // Hook ?>
	<div id="page" class="thepage">
		<div class="page-canvas">
			<?php pagelines_register_hook('pagelines_before_header');?>
			<header id="header" class="container-group">
				<div class="outline">
					<?php pagelines_template_area('pagelines_header', 'header'); // Hook ?>
				</div>
			</header>
			<?php pagelines_register_hook('pagelines_before_main'); // Hook ?>
			<div id="page-main" class="container-group">
				<div id="dynamic-content" class="outline">
					
<?php endif;?>
