<?php
/**
 *
 *	sns設定
 *
 */
function ys_customizer_sns( $wp_customize ){
	/**
	 * パネルの追加
	 */
	$wp_customize->add_panel(
										'ys_customizer_panel_sns',
										array(
											'priority'       => 1100,
											'title'          => '[ys]SNS設定'
										)
									);
	/**
	 * OGP設定
	 */
	ys_customizer_sns_add_ogp( $wp_customize );
	/**
	 * Twitter Cards
	 */
	ys_customizer_sns_add_twitter_cards( $wp_customize );
	/**
	 * SNS Share Button
	 */
	ys_customizer_sns_add_sns_share_button( $wp_customize );
	/**
	 * Twitter Share
	 */
	ys_customizer_sns_add_twitter_share( $wp_customize );
	/**
	 * 購読ボタン設定
	 */
	ys_customizer_sns_add_sns_follow( $wp_customize );
	/**
	 * フッターSNSフォローボタン設定
	 */
	ys_customizer_sns_add_footer_sns_follow( $wp_customize );
}

/**
 * OGP設定
 */
function ys_customizer_sns_add_ogp( $wp_customize ) {
	/**
	 * セクション追加
	 */
	$wp_customize->add_section(
										'ys_customizer_section_ogp',
										array(
											'title'    => 'OGP設定',
											'panel'    => 'ys_customizer_panel_sns',
										)
									);
	/**
	 * OGP metaタグを出力する
	 */
	ys_customizer_add_label(
		$wp_customize,
		array(
			'label'       => 'OGP metaタグ',
			'section'     => 'ys_customizer_section_ogp',
			'description' => '',
		)
	);
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_ogp_enable',
			'label'     => 'OGPのmetaタグを出力する',
			'section'   => 'ys_customizer_section_ogp',
			'transport' => 'postMessage',
		)
	);
	/**
	 * Facebook app_id
	 */
	ys_customizer_add_setting_text(
		$wp_customize,
		array(
			'id'        => 'ys_ogp_fb_app_id',
			'default'   => '',
			'label'     => 'Facebook app_id',
			'section'   => 'ys_customizer_section_ogp',
			'transport' => 'postMessage',
			'input_attrs' => array(
												'placeholder' => '000000000000000',
												'maxlength' => 15
											)
		)
	);
	/**
	 * Facebook app_id
	 */
	ys_customizer_add_setting_text(
		$wp_customize,
		array(
			'id'        => 'ys_ogp_fb_admins',
			'default'   => '',
			'label'     => 'Facebook admins',
			'section'   => 'ys_customizer_section_ogp',
			'transport' => 'postMessage',
			'input_attrs' => array(
												'placeholder' => '000000000000000',
												'maxlength' => 15
											)
		)
	);
	/**
	 * OGPデフォルト画像
	 */
	ys_customizer_add_setting_image(
		$wp_customize,
		array(
			'id'        => 'ys_ogp_default_image',
			'default'   => '',
			'label'     => 'OGPデフォルト画像',
			'description'  => 'トップページ・アーカイブページ・投稿にアイキャッチ画像が無かった場合のデフォルト画像を指定して下さい。おすすめサイズ：横1200px - 縦630px ',
			'section'   => 'ys_customizer_section_ogp',
			'transport' => 'postMessage',
		)
	);
}

/**
 * Twitter Cards
 */
function ys_customizer_sns_add_twitter_cards( $wp_customize ) {
	/**
	 * セクション追加
	 */
	$wp_customize->add_section(
										'ys_customizer_section_twitter_cards',
										array(
											'title'    => 'Twitterカード設定',
											'panel'    => 'ys_customizer_panel_sns',
										)
									);
	/**
	 * Twitterカードのmetaタグを出力する
	 */
	ys_customizer_add_label(
		$wp_customize,
		array(
			'label'       => 'Twitterカードmetaタグ',
			'section'     => 'ys_customizer_section_twitter_cards',
			'description' => '',
		)
	);
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_twittercard_enable',
			'label'     => 'Twitterカードのmetaタグを出力する',
			'default'   => 1,
			'section'   => 'ys_customizer_section_twitter_cards',
			'transport' => 'postMessage',
		)
	);
	/**
	 * ユーザー名
	 */
	ys_customizer_add_setting_text(
		$wp_customize,
		array(
			'id'        => 'ys_twittercard_user',
			'default'   => '',
			'label'     => 'Twitterカードのユーザー名',
			'section'   => 'ys_customizer_section_twitter_cards',
			'description'  => '「@」なしのTwitterユーザー名を入力して下さい。例：Twitterユーザー名…「@yosiakatsuki」→入力…「yosiakatsuki」',
			'transport' => 'postMessage',
			'input_attrs' => array(
												'placeholder' => 'username',
											)
		)
	);
	/**
	 * カードタイプ
	 */
	ys_customizer_add_setting_radio(
		$wp_customize,
		array(
			'id'        => 'ys_twittercard_type',
			'default'   => 'summary_large_image',
			'label'     => 'カードタイプ',
			'section'   => 'ys_customizer_section_twitter_cards',
			'transport' => 'postMessage',
			'choices' => array(
				'summary_large_image' => 'Summary Card with Large Image',
				'summary' => 'Summary Card'
			)
		)
	);
}

/**
 * SNS Share Button
 */
function ys_customizer_sns_add_sns_share_button( $wp_customize ) {
	/**
	 * セクション追加
	 */
	$wp_customize->add_section(
										'ys_customizer_section_sns_share_button',
										array(
											'title'    => 'SNSシェアボタン設定',
											'panel'    => 'ys_customizer_panel_sns',
										)
									);
	/**
	 * シェアボタン表示設定
	 */
	ys_customizer_add_label(
		$wp_customize,
		array(
			'label'       => '表示するSNSシェアボタン',
			'section'     => 'ys_customizer_section_sns_share_button',
			'description' => '',
		)
	);
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_button_twitter',
			'label'     => 'Twitter',
			'default'   => 1,
			'section'   => 'ys_customizer_section_sns_share_button',
		)
	);
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_button_facebook',
			'label'     => 'Facebook',
			'default'   => 1,
			'section'   => 'ys_customizer_section_sns_share_button',
		)
	);
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_button_hatenabookmark',
			'label'     => 'はてなブックマーク',
			'default'   => 1,
			'section'   => 'ys_customizer_section_sns_share_button',
		)
	);
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_button_googlepuls',
			'label'     => 'Google+',
			'default'   => 1,
			'section'   => 'ys_customizer_section_sns_share_button',
		)
	);
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_button_pocket',
			'label'     => 'Pocket',
			'default'   => 1,
			'section'   => 'ys_customizer_section_sns_share_button',
		)
	);
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_button_line',
			'label'     => 'LINE',
			'default'   => 1,
			'section'   => 'ys_customizer_section_sns_share_button',
		)
	);
	/**
	 * シェアボタン表示位置
	 */
	ys_customizer_add_label(
		$wp_customize,
		array(
			'label'       => 'シェアボタンの表示位置',
			'section'     => 'ys_customizer_section_sns_share_button',
			'description' => '',
		)
	);
	/**
	 * 記事上部に表示する
	 */
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_on_entry_header',
			'label'     => '記事上部にシェアボタンを表示する',
			'default'   => 1,
			'section'   => 'ys_customizer_section_sns_share_button',
		)
	);
	/**
	 * 記事下部に表示する
	 */
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_on_below_entry',
			'label'     => '記事下部にシェアボタンを表示する',
			'default'   => 1,
			'section'   => 'ys_customizer_section_sns_share_button',
		)
	);
}

/**
 * Twitter share
 */
function ys_customizer_sns_add_twitter_share( $wp_customize ) {
	/**
	 * セクション追加
	 */
	$wp_customize->add_section(
										'ys_customizer_section_twitter_share',
										array(
											'title'    => 'Twitterシェアボタン設定',
											'panel'    => 'ys_customizer_panel_sns',
										)
									);
	/**
	 * 投稿ユーザー（via）の設定
	 */
	ys_customizer_add_label(
		$wp_customize,
		array(
			'label'       => '投稿ユーザー（via）の設定',
			'section'     => 'ys_customizer_section_twitter_share',
			'description' => '',
		)
	);
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_tweet_via',
			'label'     => 'Twitterシェアにviaを付加する',
			'description' => '※合わせて「viaに設定するTwitterアカウント名」の設定が必要です',
			'default'   => 0,
			'section'   => 'ys_customizer_section_twitter_share',
			'transport' => 'postMessage',
		)
	);
	/**
	 * viaに設定するTwitterアカウント名
	 */
	ys_customizer_add_setting_text(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_tweet_via_account',
			'default'   => '',
			'label'     => 'viaに設定するTwitterアカウント名',
			'section'   => 'ys_customizer_section_twitter_share',
			'description'  => '「@」なしのTwitterユーザー名を入力して下さい。例：Twitterユーザー名…「@yosiakatsuki」→入力…「yosiakatsuki」',
			'transport' => 'postMessage',
			'input_attrs' => array(
												'placeholder' => 'username',
											)
		)
	);
	/**
	 * おすすめアカウントの設定
	 */
	ys_customizer_add_label(
		$wp_customize,
		array(
			'label'       => 'おすすめアカウントの設定',
			'section'     => 'ys_customizer_section_twitter_share',
			'description' => '',
		)
	);
	ys_customizer_add_setting_checkbox(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_tweet_related',
			'label'     => 'ツイート後におすすめアカウントを表示する',
			'description' => '※合わせて「ツイート後に表示するおすすめアカウント」の設定が必要です',
			'default'   => 0,
			'section'   => 'ys_customizer_section_twitter_share',
			'transport' => 'postMessage',
		)
	);
	/**
	 * ツイート後に表示するおすすめアカウント
	 */
	ys_customizer_add_setting_text(
		$wp_customize,
		array(
			'id'        => 'ys_sns_share_tweet_related_account',
			'default'   => '',
			'label'     => 'ツイート後に表示するおすすめアカウント',
			'section'   => 'ys_customizer_section_twitter_share',
			'description'  => '「@」なしのTwitterユーザー名を入力して下さい。例：Twitterユーザー名…「@yosiakatsuki」→入力…「yosiakatsuki」、複数のアカウントをおすすめ表示する場合はカンマで区切って下さい',
			'transport' => 'postMessage',
			'input_attrs' => array(
												'placeholder' => 'username',
											)
		)
	);
}

/**
 * 購読ボタン設定
 */
function ys_customizer_sns_add_sns_follow( $wp_customize ) {
	/**
	 * セクション追加
	 */
	$wp_customize->add_section(
										'ys_customizer_section_sns_follow',
										array(
											'title'    => '購読ボタン設定',
											'panel'    => 'ys_customizer_panel_sns',
										)
									);
	/**
	 * SNS購読ボタン設定
	 */
	ys_customizer_add_label(
		$wp_customize,
		array(
			'label'       => '購読ボタン設定',
			'section'     => 'ys_customizer_section_sns_follow',
			'description' => '※購読ボタンを表示しない場合は空白にしてください',
		)
	);
	/**
	 * Twitter
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_subscribe_url_twitter',
			'default'   => '',
			'label'     => 'Twitter',
			'section'   => 'ys_customizer_section_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * Facebookページ
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_subscribe_url_facebook',
			'default'   => '',
			'label'     => 'Facebookページ',
			'section'   => 'ys_customizer_section_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * Facebookページ
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_subscribe_url_googleplus',
			'default'   => '',
			'label'     => 'Google+',
			'section'   => 'ys_customizer_section_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * Feedly
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_subscribe_url_feedly',
			'default'   => '',
			'label'     => 'Feedly',
			'section'   => 'ys_customizer_section_sns_follow',
			'description'  => '<a href="https://feedly.com/factory.html" target="_blank">https://feedly.com/factory.html</a>で購読用URLを生成・取得してください。（出来上がったHTMLタグのhref部分）'
		)
	);
	/**
	 * 何列表示するか
	 */
	ys_customizer_add_label(
		$wp_customize,
		array(
			'label'       => '購読ボタンを何列表示するか',
			'section'     => 'ys_customizer_section_sns_follow',
			'description' => '',
		)
	);
	/**
	 * Sp表示列数
	 */
	ys_customizer_add_setting_radio(
		$wp_customize,
		array(
			'id'      => 'ys_subscribe_col_sp',
			'default' => 2,
			'label'   => 'SP表示列数',
			'section' => 'ys_customizer_section_sns_follow',
			'choices' => array(
				'1' => '1列',
				'2'  => '2列',
				'3'  => '3列',
				'4'  => '4列',
			)
		)
	);
	/**
	 * PC表示列数
	 */
	ys_customizer_add_setting_radio(
		$wp_customize,
		array(
			'id'      => 'ys_subscribe_col_pc',
			'default' => 4,
			'label'   => 'PC表示列数',
			'section' => 'ys_customizer_section_sns_follow',
			'choices' => array(
				'1' => '1列',
				'2'  => '2列',
				'3'  => '3列',
				'4'  => '4列',
			)
		)
	);
}

/**
 * フッターSNSフォローボタン設定
 */
function ys_customizer_sns_add_footer_sns_follow( $wp_customize ) {
	/**
	 * セクション追加
	 */
	$wp_customize->add_section(
										'ys_customizer_section_footer_sns_follow',
										array(
											'title'    => 'フッターSNSフォローリンク設定',
											'panel'    => 'ys_customizer_panel_sns',
											'description' => 'フッターに標示するSNSフォローボタンの設定'
										)
									);
	/**
	 * Twitter
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_follow_url_twitter',
			'default'   => '',
			'label'     => 'Twitter',
			'section'   => 'ys_customizer_section_footer_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * Facebook
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_follow_url_facebook',
			'default'   => '',
			'label'     => 'Facebook',
			'section'   => 'ys_customizer_section_footer_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * Google+
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_follow_url_googlepuls',
			'default'   => '',
			'label'     => 'Google+',
			'section'   => 'ys_customizer_section_footer_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * Instagram
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_follow_url_instagram',
			'default'   => '',
			'label'     => 'Instagram',
			'section'   => 'ys_customizer_section_footer_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * Tumblr
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_follow_url_tumblr',
			'default'   => '',
			'label'     => 'Tumblr',
			'section'   => 'ys_customizer_section_footer_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * Youtube
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_follow_url_youtube',
			'default'   => '',
			'label'     => 'Youtube',
			'section'   => 'ys_customizer_section_footer_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * GitHub
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_follow_url_github',
			'default'   => '',
			'label'     => 'GitHub',
			'section'   => 'ys_customizer_section_footer_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * Pinterest
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_follow_url_pinterest',
			'default'   => '',
			'label'     => 'Pinterest',
			'section'   => 'ys_customizer_section_footer_sns_follow',
			'description'  => ''
		)
	);
	/**
	 * LinkedIn
	 */
	ys_customizer_add_setting_url(
		$wp_customize,
		array(
			'id'        => 'ys_follow_url_linkedin',
			'default'   => '',
			'label'     => 'LinkedIn',
			'section'   => 'ys_customizer_section_footer_sns_follow',
			'description'  => ''
		)
	);
}