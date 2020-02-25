<?php
/**
 * 色管理 クラス
 *
 * @package ystandard
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

/**
 * Class YS_Color
 */
class YS_Color {

	/**
	 * サイト背景色デフォルト値取得
	 *
	 * @return string
	 */
	public static function get_site_bg_default() {
		return YS_Option::get_default( 'ys_color_site_bg', '#ffffff' );
	}

	/**
	 * サイト背景色取得
	 *
	 * @return string
	 */
	public static function get_site_bg() {
		return ys_get_option( 'ys_color_site_bg', self::get_site_bg_default() );
	}

	/**
	 * 色設定の定義
	 *
	 * @param bool $all ユーザー定義追加.
	 *
	 * @return array
	 */
	public static function get_color_palette( $all = true ) {
		$color = array(
			array(
				'name'        => '青',
				'slug'        => 'ys-blue',
				'color'       => ys_get_option( 'ys-color-palette-ys-blue', '#82B9E3' ),
				'default'     => '#82B9E3',
				'description' => '',
			),
			array(
				'name'        => '赤',
				'slug'        => 'ys-red',
				'color'       => ys_get_option( 'ys-color-palette-ys-red', '#D53939' ),
				'default'     => '#D53939',
				'description' => '',
			),
			array(
				'name'        => '緑',
				'slug'        => 'ys-green',
				'color'       => ys_get_option( 'ys-color-palette-ys-green', '#92C892' ),
				'default'     => '#92C892',
				'description' => '',
			),
			array(
				'name'        => '黄',
				'slug'        => 'ys-yellow',
				'color'       => ys_get_option( 'ys-color-palette-ys-yellow', '#F5EC84' ),
				'default'     => '#F5EC84',
				'description' => '',
			),
			array(
				'name'        => 'オレンジ',
				'slug'        => 'ys-orange',
				'color'       => ys_get_option( 'ys-color-palette-ys-orange', '#EB962D' ),
				'default'     => '#EB962D',
				'description' => '',
			),
			array(
				'name'        => '紫',
				'slug'        => 'ys-purple',
				'color'       => ys_get_option( 'ys-color-palette-ys-purple', '#B67AC2' ),
				'default'     => '#B67AC2',
				'description' => '',
			),
			array(
				'name'        => '灰色',
				'slug'        => 'ys-gray',
				'color'       => ys_get_option( 'ys-color-palette-ys-gray', '#757575' ),
				'default'     => '#757575',
				'description' => '',
			),
			array(
				'name'        => '薄灰色',
				'slug'        => 'ys-light-gray',
				'color'       => ys_get_option( 'ys-color-palette-ys-light-gray', '#F1F1F3' ),
				'default'     => '#F1F1F3',
				'description' => '',
			),
			array(
				'name'        => '黒',
				'slug'        => 'ys-black',
				'color'       => ys_get_option( 'ys-color-palette-ys-black', '#000000' ),
				'default'     => '#000000',
				'description' => '',
			),
			array(
				'name'        => '白',
				'slug'        => 'ys-white',
				'color'       => ys_get_option( 'ys-color-palette-ys-white', '#ffffff' ),
				'default'     => '#ffffff',
				'description' => '',
			),
		);

		/**
		 * ユーザー定義情報の追加
		 */
		for ( $i = 1; $i <= 3; $i ++ ) {
			$option_name = 'ys-color-palette-ys-user-' . $i;
			if ( $all || ys_get_option( $option_name, '#ffffff' ) !== YS_Option::get_default( $option_name, '#ffffff' ) ) {
				$color[] = array(
					'name'        => 'ユーザー定義' . $i,
					'slug'        => 'ys-user-' . $i,
					'color'       => ys_get_option( $option_name, '#ffffff' ),
					'default'     => '#ffffff',
					'description' => 'よく使う色を設定しておくと便利です。',
				);
			}
		}

		return apply_filters( 'ys_editor_color_palette', $color );
	}
}
