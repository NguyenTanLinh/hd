<?php

namespace Themes;

use Cores\Helper;
use PHPMailer\PHPMailer\Exception;

\defined( 'ABSPATH' ) || die;

/**
 * Options Class
 *
 * @author HD
 */
final class Options {
	public function __construct() {

		add_action( 'wp_enqueue_scripts', [ &$this, 'aspect_ratio_enqueue_scripts' ], 11 );

		/** SMTP Settings */
		if ( Helper::smtpConfigured() ) {
			//add_action( 'phpmailer_init', [ &$this, 'setup_phpmailer_init' ], 11 );
			add_filter( 'pre_wp_mail', [ &$this, 'smtp_mailer_pre_wp_mail' ], 10, 2 );
		}

		/** Contact info */

		/** Contact Button */

		/** Block editor */
		add_action( 'admin_init', [ &$this, 'editor_admin_init' ], 10 );
		add_action( 'wp_enqueue_scripts', [ &$this, 'editor_enqueue_scripts' ], 98 );

		/** Comments */
		add_action( 'comment_form_after_fields', [ &$this, 'add_simple_antispam_field' ] );
		add_filter( 'preprocess_comment', [ &$this, 'check_simple_antispam' ] );

		/** Custom Scripts */
		add_action( 'wp_head', [ &$this, 'header_scripts__hook' ], 99 ); // header scripts
		add_action( 'wp_body_open', [ &$this, 'body_scripts_top__hook' ], 99 ); // body scripts - TOP

		add_action( 'wp_footer', [ &$this, 'footer_scripts__hook' ], 1 ); // footer scripts
		add_action( 'wp_footer', [ &$this, 'body_scripts_bottom__hook' ], 998 ); // body scripts - BOTTOM

		/** Custom CSS */
		// add_action('wp_enqueue_scripts', [ &$this, 'header_custom_css' ], 99);
		add_action( 'wp_head', [ &$this, 'header_custom_css' ], 98 );
	}

	// ------------------------------------------------------

	/**
	 * @param $commentdata
	 *
	 * @return mixed
	 */
	public function check_simple_antispam( $commentdata ): mixed {
		if ( ! isset( $_POST['antispam_input'] ) || ! isset( $_POST['antispam_result'] ) ) {
			wp_die( esc_html__( 'Lỗi CAPTCHA. Vui lòng thử lại.', HD_TEXT_DOMAIN ) );
		}

		$input  = intval( $_POST['antispam_input'] );
		$result = intval( $_POST['antispam_result'] );

		if ( $input !== $result ) {
			wp_die( esc_html__( 'Câu trả lời chưa chính xác. Vui lòng thử lại.', HD_TEXT_DOMAIN ) );
		}

		return $commentdata;
	}

	// ------------------------------------------------------

	/**
	 * @return void
	 */
	public function add_simple_antispam_field(): void {
		$comment_options = Helper::getOption( 'comment__options', false, false );

		$simple_antispam = $comment_options['simple_antispam'] ?? '';
		if ( $simple_antispam ) {

			$num1     = rand( 1, 10 );
			$num2     = rand( 1, 10 );
			$operator = rand( 0, 1 ) ? '+' : '-';
			$result   = $operator === '+' ? $num1 + $num2 : $num1 - $num2;

			echo '<p class="comment-form-antispam">' . sprintf( esc_html__( 'Để xác minh bạn không phải là robot spam comment, Hãy tính: %1$d %2$s %3$d = ?', HD_TEXT_DOMAIN ), $num1, $operator, $num2 ) . '</p>';
			echo '<input type="hidden" name="antispam_result" value="' . $result . '" />';
			echo '<p class="comment-form-antispam-answer"><label for="antispam_input">' . esc_html__( 'Câu trả lời:', HD_TEXT_DOMAIN ) . '</label> <input type="text" name="antispam_input" id="antispam_input" required /></p>';
		}
	}

	// ------------------------------------------------------

	/**
	 * @return void
	 */
	public function header_custom_css(): void {
		/** Custom CSS */
		$css = Helper::getCustomPostContent( 'hd_css', false );

		if ( $css ) {
			$css = Helper::CSS_Minify( $css, true );

			echo "<style id='custom-style-inline-css'>" . $css . "</style>";
			// wp_add_inline_style( 'app-style', $css );
		}
	}

	// ------------------------------------------------------

	/**
	 * @return void
	 */
	public function editor_admin_init(): void {
		$block_editor_options = Helper::getOption( 'block_editor__options', false, false );

		$use_widgets_block_editor_off           = $block_editor_options['use_widgets_block_editor_off'] ?? '';
		$gutenberg_use_widgets_block_editor_off = $block_editor_options['gutenberg_use_widgets_block_editor_off'] ?? '';
		$use_block_editor_for_post_type_off     = $block_editor_options['use_block_editor_for_post_type_off'] ?? '';

		// Disables the block editor from managing widgets.
		if ( $use_widgets_block_editor_off ) {
			add_filter( 'use_widgets_block_editor', '__return_false' );
		}

		// Disables the block editor from managing widgets in the Gutenberg plugin.
		if ( $gutenberg_use_widgets_block_editor_off ) {
			add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
		}

		// Use Classic Editor - Disable Gutenberg Editor
		if ( $use_block_editor_for_post_type_off ) {
			add_filter( 'use_block_editor_for_post_type', '__return_false' );
		}
	}

	// ------------------------------------------------------

	/**
	 * @return void
	 */
	public function editor_enqueue_scripts(): void {

		$block_editor_options = Helper::getOption( 'block_editor__options', false, false );
		$block_style_off      = $block_editor_options['block_style_off'] ?? '';

		/** Remove block CSS */
		if ( $block_style_off ) {
			wp_dequeue_style( 'global-styles' );

			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );

			// Remove WooCommerce block CSS
			if ( Helper::is_woocommerce_active() ) {
				wp_deregister_style( 'wc-blocks-vendors-style' );
				wp_deregister_style( 'wc-block-style' );
			}
		}
	}

	// ------------------------------------------------------

	/**
	 * @return void
	 */
	public function aspect_ratio_enqueue_scripts(): void {
		$classes = [];
		$styles  = '';

		$ar_post_type_list = apply_filters( 'hd_aspect_ratio_post_type', [] );

		foreach ( $ar_post_type_list as $ar_post_type ) {
			$ratio_obj   = Helper::getAspectRatioClass( $ar_post_type, 'aspect_ratio__options' );
			$ratio_class = $ratio_obj->class ?? '';
			$ratio_style = $ratio_obj->style ?? '';

			if ( ! in_array( $ratio_class, $classes ) && $ratio_style ) {
				$classes[] = $ratio_class;
				$styles    .= $ratio_style;
			}
		}

		if ( $styles ) {
			wp_add_inline_style( 'hd-core-style', $styles );
		}
	}

	// ------------------------------------------------------

	/**
	 * @param $phpmailer
	 *
	 * @return void
	 * @throws Exception
	 */
//	public function setup_phpmailer_init( $phpmailer ): void {
//		Helper::PHPMailerInit( $phpmailer, 'smtp__options' );
//	}

	// ------------------------------------------------------

	/**
	 * @param $null
	 * @param $atts
	 *
	 * @return void
	 * @throws Exception
	 */
	public function smtp_mailer_pre_wp_mail( $null, $atts ): void {
		Helper::smtp_mailer_pre_wp_mail( $null, $atts, 'smtp__options' );
	}

	// ------------------------------------------------------

	/**
	 * Header scripts
	 *
	 * @return void
	 */
	public function header_scripts__hook(): void {
		$html_header = Helper::getCustomPostContent( 'html_header', true );
		if ( $html_header ) {
			echo $html_header;
		}
	}

	/**
	 * Body scripts - TOP
	 *
	 * @return void
	 */
	public function body_scripts_top__hook(): void {
		$html_body_top = Helper::getCustomPostContent( 'html_body_top', true );
		if ( $html_body_top ) {
			echo $html_body_top;
		}
	}

	/**
	 * Footer scripts
	 *
	 * @return void
	 */
	public function footer_scripts__hook(): void {
		$html_footer = Helper::getCustomPostContent( 'html_footer', true );
		if ( $html_footer ) {
			echo $html_footer;
		}
	}

	/**
	 * Body scripts - BOTTOM
	 *
	 * @return void
	 */
	public function body_scripts_bottom__hook(): void {
		$html_body_bottom = Helper::getCustomPostContent( 'html_body_bottom', true );
		if ( $html_body_bottom ) {
			echo $html_body_bottom;
		}
	}
}