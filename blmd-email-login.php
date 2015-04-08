<?php
/*
Plugin Name: BLMD Email Login
Plugin URI: http://github.com/blmd/blmd-email-login
Description: Allow login using either username or email address
Author: blmd
Author URI: http://github.com/blmd
Version: 0.1
*/

add_filter( 'authenticate', function ( $user, $username, $password ) {
	if ( ! get_user_by( 'login', $username ) && is_email( $username ) ) {
		if ( $user = get_user_by( 'email', $username ) ) {
			$username = $user->user_login;
		}
	}
	return wp_authenticate_username_password( null, $username, $password );
}, 20, 3 );

 
add_filter( 'gettext', function ( $translated_text, $text, $domain ) {
	global $pagenow;
	if ( $pagenow != 'wp-login.php' || !empty( $_GET['action'] ) ) { return $translated_text; }
	if ( $translated_text == 'Username' ) {
		$translated_text .= ' '.__( 'or Email', $domain );
	}
	// if ( $translated_text == '<strong>ERROR</strong>: Invalid username. <a href="%s">Lost your password</a>?' ) {
	// 	$translated_text = str_replace('username', __( 'username or email', $domain ), $translated_text);
	// }
	return $translated_text;
}, 20, 3 );
