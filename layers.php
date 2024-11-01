<?php
/*
Plugin Name: WP Layers For Publishers
Plugin URI: http://www.xtremenews.info/wordpress-plugins/wp-layers-for-publishers
Description: Add Layers for publisher into your wordpress blog
Version: 0.1
Author: Moyo
Author URI: http://xtremenews.info
License: GPL2

Copyright 2011 Moyo

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ('layers.php' == basename($_SERVER['SCRIPT_FILENAME'])){
	die ('Please do not access this file directly. Thanks!');
}
 
add_action('admin_menu', 'layers_for_publishers_menu');

function layers_for_publishers_menu() {
	add_menu_page(__('Layers','menu'), __('Layers','menu'), 'manage_options', 'wp-layers-for-publishers','layers_for_publishers', get_option('siteurl').'/wp-content/plugins/wp-layers-for-publishers/images/lp.jpg ' );

}

  
function layers_for_publishers() {
    if( !current_user_can( 'manage_options' ) ) {
        wp_die( 'You do not have sufficient permissions to access this page' );
    }
    
    $code = get_option('layers_code');
    
   
     
   if( isset( $_POST['update_option'] ) ) {                   
                	
                   $code = sanitize_string($_POST['layers_code']);                    
				   update_option( 'layers_code', $code );               
            
    }
    
    createForm($code, $location);
	
            
 }
       
        
            
function sanitize_string( $str ) {
    if ( !function_exists( 'wp_kses' ) ) {
        require_once( ABSPATH . 'wp-includes/kses.php' );
    }
    global $allowedposttags;
    global $allowedprotocols;
    
    if ( is_string( $str ) ) {
        $str = htmlentities( stripslashes( $str ), ENT_QUOTES, 'UTF-8' );
    }
    
    $str = wp_kses( $str, $allowedposttags, $allowedprotocols );
    
    return $str;
}



function createForm($code, $location){	
	echo '
	
		<form action="" method="post" >
   
				    <div class="wrap">
				        <h2>Layers for Publishers Settings</h2>
				        <div class="tool-box">
				            <h3 class="title">Your Layer Code</h3>
							<p>Get your Layer for publishers code from <a href="http://publishers.layers.com/">www.publishers.layers.com</a> and paste it below.</p>	
							<p><textarea rows="10" cols="70" name="layers_code">'.$code.'</textarea></p>
															
				        </div> 
				        <div>       
				            <input type="submit" name="update_option" class="button-primary" value="Save"/>
				        </div>
				    </div>
				</form>
				
				<div id="donations"> 
<br />
<hr style="height:1px;color:#666;">
</p>
<p><a href="http://xtremenews.info/wordpress-plugins/wp-layers-for-publishers">Plugin Home Page</a></p>
</div>

	
	'	;
}
    

function print_layers(){

	$code = html_entity_decode(get_option('layers_code'));
	
	echo $code;
    
}


function wp_layers_for_publishers(){

    	add_action( 'wp_head', 'print_layers' ) ;

}
    
add_action( 'init', 'wp_layers_for_publishers' );

?>