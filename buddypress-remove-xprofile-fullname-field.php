<?php
/**
* This plugin removes the default BuddyPress xprofile fullname field on the register page and sets fullname to user_login
*
* @author Daan Kortenbach
*
* Plugin Name: BuddyPress remove xprofile fullname field
* Plugin URI: http://daan.kortenba.ch/
* Description: This plugin removes the default BuddyPress xprofile fullname field on the register page and sets fullname to user_login
* Author: Daan Kortenbach
* Version: 0.3
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

	$rekey = false;

	// Remove item from array.
	foreach ($fields as $key => $value ) {
		if ( $value->name == BP_XPROFILE_FULLNAME_FIELD_NAME ) {
			unset( $fields[ $key ] );

			$rekey = true;
		}
	}

	if ( $rekey ) {
		$fields = array_values( $fields );
	}

	// Return the fields
	return $fields;
}

add_action( 'bp_custom_profile_edit_fields', 'dk_bp_add_xprofile_fullname_field_hidden' );
/**
 * Adds the default BuddyPress xprofile fullname field as a hidden field
 *
 * @return string
 *
 * @author  Daan Kortenbach
 */
function dk_bp_add_xprofile_fullname_field_hidden(){

	if( ! bp_is_register_page() )
		return;

	echo '<input type="hidden" name="field_1" id="field_1" value="x">';
}




add_action( 'bp_core_signup_user', 'dk_bp_core_signup_user' );
/**
 * Sets the correct user values
 *
 * @param  integer $user_id
 * @return void
 *
 * @author  Daan Kortenbach
 */
function dk_bp_core_signup_user( $user_id ) {

	// Get user data
	$user = get_userdata( $user_id );

	// Update xprofile fullname
	xprofile_set_field_data( BP_XPROFILE_FULLNAME_FIELD_NAME, $user_id, $user->user_login );

	// Set new user data
	$userdata = array(
		'ID' => $user_id,
		'user_nicename' => $user->user_login,
		'display_name' => $user->user_login,
		'nickname' => $user->user_login
	);

	// Update user
	wp_update_user( $userdata );
}
