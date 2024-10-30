<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @version       1.0.0
 * @package       JLE_Elementor_Mega_Menu
 * @license       Copyright JLE_Elementor_Mega_Menu
 */

if ( ! function_exists( 'jltelmm_option' ) ) {
	/**
	 * Get setting database option
	 *
	 * @param string $section default section name jltelmm_general .
	 * @param string $key .
	 * @param string $default .
	 *
	 * @return string
	 */
	function jltelmm_option( $section = 'jltelmm_general', $key = '', $default = '' ) {
		$settings = get_option( $section );

		return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
	}
}

if ( ! function_exists( 'jltelmm_exclude_pages' ) ) {
	/**
	 * Get exclude pages setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltelmm_exclude_pages() {
		return jltelmm_option( 'jltelmm_triggers', 'exclude_pages', array() );
	}
}

if ( ! function_exists( 'jltelmm_exclude_pages_except' ) ) {
	/**
	 * Get exclude pages except setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltelmm_exclude_pages_except() {
		return jltelmm_option( 'jltelmm_triggers', 'exclude_pages_except', array() );
	}
}