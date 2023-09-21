<?php
/**
 * FL Gravity Forms send notification as text
 *
 * @package   fl-gf-send-notif-as-text
 * @author    FutureLab Digital <contact@futurelab.co.nz>
 * @copyright 2009-2023 FutureLab Digital
 * @license   GPL v2 or later
 *
 * Plugin Name:  FL Gravity Forms send notifications as text
 * Description:  Adds an option to force send notification as text instead of HTML
 * Version:      1.0.0
 * Author:       FutureLab Digital & Contributors
 * Author URI:   https://futurelab.digital
 * Text Domain:  fl-send-notif
 * Domain Path:  /languages/
 * Network:      false
 * Requires PHP: 7.2
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'GFCommon' ) ) {
	exit;
}

/**
 * Set notification to text only if flSendNotificationAsText is set.
 * 
 * @see https://docs.gravityforms.com/gform_notification/ for filter documentation.
 * 
 */
function fl_change_notification_format( $notification, $form, $entry ) {
	if ( $notification) {
	    if ( ! empty( $notification['flSendNotificationAsText'] ) ) {
        	$notification['message_format'] = 'text';
    	}
	}

    return $notification;
}
add_filter( 'gform_notification', 'fl_change_notification_format', 10, 3 );


/**
 * Add GF notification setting
 * 
 * @see https://docs.gravityforms.com/gform_notification_settings_fields/ for filter documentation.
 */
function fl_add_notification_setting( $fields, $notification, $form ) {
	$fields[0]['fields'][] = array(
        'name' => 'flSendNotificationAsText',
		'type' => 'checkbox',
        'label' => esc_html__( 'Email format', 'fl-send-notif' ),
        'choices' => array(
			array(
				'name'  => 'flSendNotificationAsText',
				'label' => esc_html__( 'Send notification email as text (leave unchecked to send as HTML, or default)', 'fl-send-notif' ),
			),
        )
    );

    return $fields;
}
add_filter('gform_notification_settings_fields', 'fl_add_notification_setting', 10, 3);
