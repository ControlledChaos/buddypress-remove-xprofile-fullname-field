<?php
/**
* This plugin removes the default BuddyPress xprofile fullname field
*
* @author Daan Kortenbach
*
* Plugin Name: BuddyPress remove xprofile fullname field
* Plugin URI: http://daan.kortenba.ch/
* Description: This plugin removes the default BuddyPress xprofile fullname field
* Author: Daan Kortenbach
* Version: 0.2
* Author URI: http://daan.kortenba.ch/
* License: GPLv2
*/

add_filter( 'xprofile_group_fields', 'dk_bp_remove_xprofile_fullname_field', 10, 2 );
/**
 * Removes the default BuddyPress xprofile fullname field
 *
 * @param  array $fields   Array with field names
 * @return array           Array with filtered fields
 *
 * @author Daan Kortenbach
 */
function dk_bp_remove_xprofile_fullname_field( $fields ){

	if( ! bp_is_register_page() )
		return $fields;

	// Remove item from array.
	foreach ($fields as $key => $value ) {
		if ( $value->name == BP_XPROFILE_FULLNAME_FIELD_NAME )
			unset( $fields[ $key ] );
	}

	// Return the fields
	return $fields;
}

add_action( 'bp_core_activated_user', 'dk_bp_set_user_nicename', 9999 );
/**
 * Resets user because it got the wrong user meta (WTF BuddyPress, why?).
 * See xprofile_sync_wp_profile() in BuddyPress.
 *
 * @param  integer $user_id
 * @return void
 *
 * @author Daan Kortenbach
 */
function dk_bp_set_user_nicename( $user_id ){

	// Get user data
	$user = get_userdata( $user_id );

	// Set new user data
	$userdata = array(
		'ID' => $user_id,
		'user_nicename' => $user->user_login,
		'display_name' => $user->user_login,
		'nickname' => $user->user_login,
		'first_name' => $user->user_login
	);
	// Update user
	wp_update_user( $userdata );

	// Update xprofile
	xprofile_set_field_data( BP_XPROFILE_FULLNAME_FIELD_NAME, $user_id, $user->user_login );
}