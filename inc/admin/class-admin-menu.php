<?php
/**
 * テーマオプションページ
 *
 * @package ystandard
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

namespace ystandard;

/**
 * Class Admin_Menu
 *
 * @package ystandard
 */
class Admin_Menu {

	/**
	 * Nonce Action.
	 */
	const NONCE_ACTION = 'ystandard_delete_cache';
	/**
	 * Nonce Name.
	 */
	const NONCE_NAME = 'ystandard_delete_cache_nonce';

	/**
	 * Admin_Menu constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ], 11 );
	}

	/**
	 * テーマオプションページの追加
	 */
	public function add_admin_menu() {
		if ( apply_filters( 'disable_ystandard_admin_menu', false ) ) {
			return;
		}
		/**
		 * [yStandardメニューの追加]
		 */
		add_menu_page(
			'yStandard',
			'yStandard',
			'manage_options',
			'ystandard-start-page',
			[ $this, 'start_page' ],
			'',
			3
		);

		add_submenu_page(
			'ystandard-start-page',
			'アイコン',
			'アイコン',
			'manage_options',
			'ystandard-icons',
			[ $this, 'icons_page' ]
		);

		if ( $this->is_enable_cache() ) {
			/**
			 * キャッシュメニューの追加
			 */
			add_submenu_page(
				'ystandard-start-page',
				'キャッシュ管理',
				'キャッシュ管理',
				'manage_options',
				'ystandard-cache',
				[ $this, 'cache_page' ]
			);
		}
	}

	/**
	 * 管理画面-JavaScriptの読み込み
	 *
	 * @param string $hook_suffix suffix.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {
		// アイコン検索用.
		if ( 'ystandard_page_ystandard-icons' === $hook_suffix ) {
			wp_enqueue_script(
				'search-icons',
				get_template_directory_uri() . '/js/search-icons.js',
				[],
				Utility::get_ystandard_version(),
				true
			);
			wp_localize_script(
				'search-icons',
				'searchIcons',
				$this->get_icon_search_data()
			);
		}
	}

	/**
	 * スタートページ
	 */
	public function start_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		?>
		<div class="wrap ys-option-page">
			<h2><span class="orbitron">yStandard</span>を始めよう！</h2>
			<div class="ys-option__section">
				<div class="ys-contents">
					<div class="ys-contents__item">
						<h4>テーマの設定</h4>
						<div class="ys-contents__icon">
							<?php echo Icon::get_icon( 'settings' ); ?>
						</div>
						<p class="ys-contents__text">
							テーマカスタマイザーを開いてテーマの設定を始めましょう！<br>
							<small>※「外観」→「カスタマイズ」からも設定画面を開けます。</small>
						</p>
						<p class="wp-block-button">
							<a class="wp-block-button__link" href="<?php echo esc_url_raw( add_query_arg( 'return', rawurlencode( Utility::get_page_url() ), wp_customize_url() ) ); ?>" rel="noopener noreferrer nofollow">設定を始める <?php echo Icon::get_icon( 'arrow-right-circle' ); ?></a>
						</p>
					</div>
					<div class="ys-contents__item">
						<h4>マニュアル</h4>
						<div class="ys-contents__icon">
							<?php echo Icon::get_icon( 'book' ); ?>
						</div>
						<p class="ys-contents__text">
							yStandardの設定や使い方のマニュアル<br>
							<small>※yStandard公式サイトのマニュアルページを開きます。</small>
						</p>
						<p class="wp-block-button">
							<a class="wp-block-button__link" href="https://wp-ystandard.com/category/manual/" target="_blank" rel="noopener noreferrer nofollow">マニュアルを見る <?php echo Icon::get_icon( 'arrow-right-circle' ); ?></a>
						</p>
					</div>

					<div class="ys-contents__item">
						<h4>拡張プラグイン</h4>
						<div class="ys-contents__icon">
							<?php echo Icon::get_icon( 'tool' ); ?>
						</div>
						<p class="ys-contents__text">
							yStandardでブログを書くことがもっと楽しくなる拡張プラグイン！<br>
							ブロック拡張プラグインやデザインスキンの配布・販売を予定しています！
						</p>
						<p class="wp-block-button">
							<a class="wp-block-button__link" href="https://wp-ystandard.com/plugins/" target="_blank" rel="noopener noreferrer nofollow">拡張プラグインを見る <?php echo Icon::get_icon( 'arrow-right-circle' ); ?></a>
						</p>
					</div>

					<div class="ys-contents__item">
						<h4><span class="orbitron">yStandard</span>を応援する</h4>
						<div class="ys-contents__icon">
							<?php echo Icon::get_icon( 'gift' ); ?>
						</div>
						<div class="ys-contents__text">
							<ul style="text-align: center;">
								<li>「知り合いにyStandardを紹介する」</li>
								<li>「ブログでyStandardを紹介する」</li>
							</ul>
							<p>
								…など、ちょっとしたことでもyStandadを応援する方法があります。
							</p>
						</div>
						<p class="wp-block-button">
							<a class="wp-block-button__link" href="https://wp-ystandard.com/contribute/" target="_blank" rel="noopener noreferrer nofollow"><span class="orbitron">yStandard</span>を応援する <?php echo Icon::get_icon( 'arrow-right-circle' ); ?></a>
						</p>
					</div>

					<div class="ys-contents__item">
						<h4>フォーラム</h4>
						<div class="ys-contents__icon">
							<?php echo Icon::get_icon( 'message-square' ); ?>
						</div>
						<p class="ys-contents__text">
							yStandardの使い方や機能要望、不具合かも？という内容はフォーラムにて質問・相談を受け付けております。
						</p>
						<p class="wp-block-button">
							<a class="wp-block-button__link" href="https://support.wp-ystandard.com/forums/" target="_blank" rel="noopener noreferrer nofollow">フォーラムを見る <?php echo Icon::get_icon( 'arrow-right-circle' ); ?></a>
						</p>
					</div>

					<div class="ys-contents__item">
						<h4>ユーザーコミュニティ</h4>
						<div class="ys-contents__icon">
							<?php echo Icon::get_icon( 'slack' ); ?>
						</div>
						<p class="ys-contents__text">
							yStandard利用者同士での交流を目的としたSlackチームです<br>
							コミュニティ参加者限定のオンラインもくもく会などを開催しています。
						</p>
						<p class="wp-block-button">
							<a class="wp-block-button__link" href="https://wp-ystandard.com/ystandard-user-community/" target="_blank" rel="noopener noreferrer nofollow">ユーザーコミュニティに参加する <?php echo Icon::get_icon( 'arrow-right-circle' ); ?></a>
						</p>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * アイコン コピーページ
	 */
	public function icons_page() {
		?>
		<div class="wrap ys-option-page">
			<h2>アイコン ショートコード一覧</h2>
			<?php echo Admin::manual_link( 'icon-search' ); ?>
			<div class="ys-option__section">
				<p>ショートコードをコピーしてサイト内でご使用ください。</p>
				<div id="ys-search-icons">
					<p class="ys-search-icons__search">
						検索：<input type="search" class="" v-model="keyword">
					</p>
					<div class="ys-icon-search__list">
						<div class="ys-icon-search__item" v-for="icon in filteredIcons">
							<div class="ys-icon-search__icon" v-html="icon.svg"></div>
							<p class="ys-icon-search__label">{{icon.label}}</p>
							<div class="copy-form">
								<input type="text" class="copy-form__target" v-bind:value="icon.short_code" readonly onfocus="this.select();" v-bind:ref="icon.name"/>
								<button class="copy-form__button is-without-event button action" v-on:click="copy(icon.name,`done_${icon.name}`)">
									<?php echo ys_get_icon( 'clipboard' ); ?>
								</button>
								<div class="copy-form__info" v-bind:ref="`done_${icon.name}`">コピーしました！</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * アイコンデータ取得
	 *
	 * @return array
	 */
	private function get_icon_search_data() {
		$icons = [];
		// feather.
		$icon_dir = get_template_directory() . '/library/feather';
		$files    = glob( $icon_dir . '/*.svg' );
		foreach ( $files as $file ) {
			$icon_name = str_replace(
				[
					$icon_dir . '/',
					'.svg',
				],
				'',
				$file
			);
			$icons[]   = [
				'name'       => $icon_name,
				'label'      => $icon_name,
				'short_code' => '[ys_icon name="' . $icon_name . '"]',
				'svg'        => Icon::get_icon( $icon_name ),
			];
		}
		// sns.
		$sns_icons = Icon::get_all_sns_icons();
		foreach ( $sns_icons as $key => $value ) {
			$icons[] = [
				'name'       => $key,
				'label'      => $value['title'],
				'short_code' => '[ys_sns_icon name="' . $key . '"]',
				'svg'        => Icon::get_sns_icon( $key ),
			];
		}

		return $icons;
	}

	/**
	 * キャッシュ管理ページ
	 */
	public function cache_page() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		$result = $this->delete_cache();
		?>
		<div class="wrap">
			<h2>キャッシュ管理</h2>
			<?php echo Admin::manual_link( 'cache-delete' ); ?>
			<?php if ( $result ) : ?>
				<div class="notice notice-success is-dismissible">
					<p><?php echo $result; ?></p>
				</div>
			<?php endif; ?>
			<div class="ys-option__section">
				<form method="post" action="" id="cache-clear">
					<?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME ); ?>
					<p>テーマ内で作成したキャッシュの件数確認・削除を行います。</p>
					<table class="ys-option__table">
						<thead>
						<tr>
							<th>種類</th>
							<td>件数</td>
							<td></td>
						</tr>
						</thead>
						<tbody>
						<tr>
							<th>新着記事一覧</th>
							<td><?php echo $this->get_cache_count( 'tax_posts' ); ?></td>
							<td><input type="submit" name="delete[tax_posts]" id="submit" class="button button-primary" value="キャッシュを削除"></td>
						</tr>
						<tr>
							<th>記事下エリア「関連記事」</th>
							<td><?php echo $this->get_cache_count( 'related_posts' ); ?></td>
							<td><input type="submit" name="delete[related_posts]" id="submit" class="button button-primary" value="キャッシュを削除"></td>
						</tr>
						<tr>
							<th>ブログカード</th>
							<td><?php echo $this->get_cache_count( Blog_Card::CACHE_KEY ); ?></td>
							<td><input type="submit" name="delete[<?php echo Blog_Card::CACHE_KEY; ?>]" id="submit" class="button button-primary" value="キャッシュを削除"></td>
						</tr>
						<?php do_action( 'ys_option_cache_table_row' ); ?>
						</tbody>
					</table>
					<p><input type="submit" name="delete_all" id="submit" class="button button-primary" value="すべてのキャッシュを削除"></p>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * キャッシュ設定が有効か
	 *
	 * @return bool
	 */
	private function is_enable_cache() {
		if ( 'none' !== Option::get_option( 'ys_query_cache_recent_posts', 'none' ) ) {
			return true;
		}
		if ( 'none' !== Option::get_option( 'ys_query_cache_related_posts', 'none' ) ) {
			return true;
		}

		return false;
	}


	/**
	 * キャッシュ削除処理
	 *
	 * @return string
	 */
	private function delete_cache() {

		if ( ! Admin::verify_nonce( self::NONCE_NAME, self::NONCE_ACTION ) ) {
			return '';
		}

		$result = '';
		/**
		 * 全削除
		 */
		if ( isset( $_POST['delete_all'] ) ) {
			$result = $this->get_cache_delete_message(
				$this->delete_cache_data( 'all' )
			);
		}
		/**
		 * 個別削除
		 */
		if ( isset( $_POST['delete'] ) ) {
			foreach ( $_POST['delete'] as $key => $value ) {
				$result = $this->get_cache_delete_message(
					$this->delete_cache_data( $key )
				);
			}
		}

	}


	/**
	 * キャッシュ件数のカウント
	 *
	 * @param string $cache_key キャッシュキー.
	 * @param string $prefix    プレフィックス.
	 *
	 * @return int
	 */
	private function get_cache_count( $cache_key, $prefix = Cache::PREFIX ) {
		/**
		 * Class wpdb
		 *
		 * @global \wpdb
		 */
		global $wpdb;
		$transient_key = $prefix . $cache_key;
		// クエリ実行.
		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT count(*) as 'count' FROM $wpdb->options WHERE option_name LIKE %s",
				'%_transient_' . $transient_key . '%'
			),
			OBJECT
		);
		if ( empty( $results ) ) {
			return 0;
		}

		return $results[0]->count;
	}

	/**
	 * キャッシュの削除
	 *
	 * @param string $cache_key キャッシュキー.
	 * @param string $prefix    プレフィックス.
	 *
	 * @return int;
	 */
	private function delete_cache_data( $cache_key, $prefix = Cache::PREFIX ) {
		/**
		 * Class wpdb
		 *
		 * @global \wpdb
		 */
		global $wpdb;
		$transient_key = $prefix . $cache_key;
		/**
		 * キャッシュの削除
		 */
		$delete = $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $wpdb->options WHERE option_name LIKE %s",
				'%_transient_' . $transient_key . '%'
			)
		);
		/**
		 * キャッシュ有効期限の削除
		 */
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $wpdb->options WHERE option_name LIKE %s",
				'%_transient_timeout_' . $transient_key . '%'
			)
		);
		if ( false === $delete ) {
			$delete = 0;
		}

		return $delete;
	}

	/**
	 * キャッシュ削除メッセージ
	 *
	 * @param string $type  タイプ.
	 * @param int    $count 件数.
	 *
	 * @return string
	 */
	private function get_cache_delete_message( $type, $count = 0 ) {
		if ( 0 >= $count ) {
			return '';
		}
		$cache_type = apply_filters(
			'ys_get_cache_delete_message_type',
			[
				'all'           => 'すべて',
				'tax_posts'     => 'カテゴリーに属する記事一覧',
				'related_posts' => '関連記事',
			],
			$type
		);
		/**
		 * メッセージの作成
		 */
		$message = '';
		if ( isset( $cache_type[ $type ] ) ) {
			$message = $cache_type[ $type ] . 'のキャッシュを' . $count . '件 削除しました。';
		}

		return apply_filters( 'ys_get_cache_delete_message', $message, $type );
	}

}

new Admin_Menu();