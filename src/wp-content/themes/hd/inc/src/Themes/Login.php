<?php

namespace Themes;

use Cores\Helper;
use Libs\CSS;

/**
 * Custom Login Class
 *
 * @author HD
 */

\defined( 'ABSPATH' ) || die;

final class Login {
	public function __construct() {

		add_action( 'login_enqueue_scripts', [ &$this, 'login_enqueue_script' ], 31 );

		// Changing the alt text on the logo to show your site name
		add_filter( 'login_headertext', function () {
			$headertext = Helper::getThemeMod( 'login_page_headertext_setting' );

			return $headertext ?: get_bloginfo( 'name' );
		} );

		// Changing the logo link from wordpress.org to your site
		add_filter( 'login_headerurl', function () {
			$headerurl = Helper::getThemeMod( 'login_page_headerurl_setting' );

			return $headerurl ?: Helper::home();
		} );
	}

	/**
	 * @retun void
	 */
	public function login_enqueue_script(): void {
		wp_enqueue_style( "login-style", THEME_URL . "assets/css/admin.css", [], THEME_VERSION );
		wp_enqueue_script( "login", THEME_URL . "assets/js/login.js", [ "jquery" ], THEME_VERSION, true );

		//$default_logo    = THEME_URL . "storage/img/logo.png";
		//$default_logo_bg = THEME_URL . "storage/img/login-bg.jpg";

		$default_logo    = '';
		$default_logo_bg = '';

		// script/style
		$logo          = ! empty( $logo = Helper::getThemeMod( 'login_page_logo_setting' ) ) ? $logo : $default_logo;
		$logo_bg       = ! empty( $logo_bg = Helper::getThemeMod( 'login_page_bgimage_setting' ) ) ? $logo_bg : $default_logo_bg;
		$logo_bg_color = Helper::getThemeMod( 'login_page_bgcolor_setting' );

		$css = new CSS();

		if ( $logo_bg ) {
			$css->set_selector( 'body.login' );
			$css->add_property( 'background-image', 'url(' . $logo_bg . ')' );
		}

		if ( $logo_bg_color ) {
			$css->set_selector( 'body.login' );
			$css->add_property( 'background-color', $logo_bg_color );

			$css->set_selector( 'body.login:before' );
			$css->add_property( 'background', 'none' );
			$css->add_property( 'opacity', 1 );
		}

		$css->set_selector( 'body.login #login h1 a' );
		if ( $logo ) {
			$css->add_property( 'background-image', 'url(' . $logo . ')' );
		} //else {
			//$css->add_property( 'background-image', 'unset' );
		//}

		if ( $css->css_output() ) {
			wp_add_inline_style( 'login-style', $css->css_output() );
		}
	}
}