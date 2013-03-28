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
* Version: 0.1
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

	// Get 'bp-xprofile-fullname-field-name', if not present the default is 'Name'.
	$name = get_option( 'bp-xprofile-fullname-field-name', 'Name' );

	// Remove 'bp-xprofile-fullname-field-name' from array.
	foreach ($fields as $key => $value ) {
		if ( $value->name == $name )
			unset( $fields[ $key ] );
	}

	// Reset array keys and return
	return array_values( $fields );
}