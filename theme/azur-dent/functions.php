<?php
/**
 * Theme bootstrap.
 *
 * @package Azur_Dent
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AZUR_DENT_VERSION', '2.2.1' );

require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/site-content.php';
require_once get_template_directory() . '/inc/admin-settings.php';
require_once get_template_directory() . '/inc/contact-form.php';
require_once get_template_directory() . '/inc/seo.php';
