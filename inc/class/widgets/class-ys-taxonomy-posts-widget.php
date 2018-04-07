<?php
/**
 * 人気記事ランキング
 *
 * @package ystandard
 * @author yosiakatsuki
 * @license GPL-2.0+
 */

/**
 * 人気記事ランキングウィジェット
 */
class YS_Taxonomy_Posts_Widget extends YS_Widget_Base {
	/**
	 * タイトル
	 *
	 * @var string
	 */
	private $default_title = '記事一覧';
	/**
	 * 表示投稿数
	 *
	 * @var integer
	 */
	private $default_post_count = 5;
	/**
	 * 画像表示有無
	 *
	 * @var integer
	 */
	private $default_show_img = 1;
	/**
	 * 画像サイズ
	 *
	 * @var string
	 */
	private $default_thmbnail_size = 'thumbnail';
	/**
	 * タクソノミーとタームの区切り文字
	 *
	 * @var string
	 */
	private $delimiter = '__';
	/**
	 * ウィジェット名などを設定
	 */
	public function __construct() {
		parent::__construct(
			'ys_taxonomy_posts',
			'[ys]カテゴリー・タグの記事一覧',
			array(
				'description' => 'カテゴリー・タグが付いている記事一覧',
			)
		);
	}

	/**
	 * ウィジェットの内容を出力
	 *
	 * @param array $args args.
	 * @param array $instance instance.
	 */
	public function widget( $args, $instance ) {
		$title         = '';
		$post_count    = $this->default_post_count;
		$show_img      = $this->default_show_img;
		$thmbnail_size = $this->default_thmbnail_size;
		$taxonomy_name = '';
		$trem_id       = 0;
		$term_label    = '';
		if ( ! empty( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		if ( isset( $instance['post_count'] ) ) {
			$post_count = esc_attr( $instance['post_count'] );
		}
		if ( isset( $instance['show_img'] ) ) {
			$show_img = esc_attr( $instance['show_img'] );
		}
		if ( isset( $instance['thmbnail_size'] ) ) {
			$thmbnail_size = esc_attr( $instance['thmbnail_size'] );
		}
		if ( isset( $instance['taxonomy'] ) ) {
			$selected = $this->get_selected_taxonomy( $instance['taxonomy'] );
			if ( ! is_null( $selected ) ) {
				$trem_id       = $selected['term_id'];
				$taxonomy_name = $selected['taxonomy_name'];
				$term          = get_term( $trem_id, $taxonomy_name );
				if ( ! is_wp_error( $term ) && ! is_null( $term ) ) {
					$term_label = $term->name;
				}
				if ( empty( $title ) ) {
					$title = sprintf( '%sの記事一覧', $term_label );
				}
			}
		}
		/**
		 * 画像なしの場合
		 */
		if ( ! $show_img ) {
			$thmbnail_size = '';
		}

		echo $args['before_widget'];
		/**
		 * ウィジェットタイトル
		 */
		if ( empty( $title ) ) {
			$title = $this->default_title;
		}
		$title = sprintf( $title, $term_label );
		echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];
		/**
		 * パラメータの作成
		 */
		$post_args = array(
			'posts_per_page' => $post_count,
			'tax_query'      => array(
				array(
					'taxonomy' => $taxonomy_name,
					'field'    => 'term_id',
					'terms'    => $trem_id,
				),
			),
		);
		/**
		 * 投稿データ取得
		 */
		echo $this->get_ys_post_list( $post_args, '', $thmbnail_size );
		echo $args['after_widget'];
	}

	/**
	 * 管理用のオプションのフォームを出力
	 *
	 * @param array $instance ウィジェットオプション.
	 */
	public function form( $instance ) {
		/**
		 * 管理用のオプションのフォームを出力
		 */
		$title             = '';
		$post_count        = $this->default_post_count;
		$show_img          = $this->default_show_img;
		$thmbnail_size     = $this->default_thmbnail_size;
		$selected_taxonomy = '';
		if ( ! empty( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		if ( isset( $instance['post_count'] ) ) {
			$post_count = esc_attr( $instance['post_count'] );
		}
		if ( isset( $instance['show_img'] ) ) {
			$show_img = esc_attr( $instance['show_img'] );
		}
		if ( isset( $instance['thmbnail_size'] ) ) {
			$thmbnail_size = esc_attr( $instance['thmbnail_size'] );
		}
		if ( isset( $instance['taxonomy'] ) ) {
			$selected_taxonomy = esc_attr( $instance['taxonomy'] );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'タイトル:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_count' ); ?>">表示する投稿数:</label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="number" step="1" min="1" value="<?php echo $post_count; ?>" size="3" />
		</p>
		<div class="ys-admin-section">
			<h4>画像設定</h4>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_img' ); ?>">
					<input type="checkbox" id="<?php echo $this->get_field_id( 'show_img' ); ?>" name="<?php echo $this->get_field_name( 'show_img' ); ?>" value="1" <?php checked( $show_img, 1 ); ?> />アイキャッチ画像を表示する
				</label><br />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'thmbnail_size' ); ?>">表示する画像のサイズ</label><br />
				<select name="<?php echo $this->get_field_name( 'thmbnail_size' ); ?>">
					<?php foreach ( $this->get_image_sizes() as $key => $value ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $thmbnail_size ); ?>><?php echo $key; ?> (横:<?php echo esc_html( $value['width'] ); ?> x 縦:<?php echo esc_html( $value['height'] ); ?>)</option>
					<?php endforeach; ?>
				</select>
				<span style="color:#aaa;font-size:.9em;">※「thumbnail」の場合、75pxの正方形で表示されます<br>※それ以外の画像はウィジェットの横幅に対して16:9の比率で表示されます。<br>※横幅300px~480pxの画像がおすすめです</span>
			</p>
		</div>
		<div class="ys-admin-section">
			<h4>カテゴリー・タグの選択</h4>
			<?php
				$taxonomies = get_taxonomies(
					array(
						'object_type' => array( 'post' ),
						'public'      => true,
						'show_ui'     => true,
					),
					'objects'
				);
			if ( ! empty( $taxonomies ) ) :
			?>
				<p>
					<select name="<?php echo $this->get_field_name( 'taxonomy' ); ?>">
						<option value="">選択してください</option>
						<?php foreach ( $taxonomies as $taxonomy ) : ?>
							<optgroup label="<?php echo $taxonomy->label; ?>">
								<?php foreach ( get_terms( $taxonomy->name ) as $term ) : ?>
									<option value="<?php echo $this->get_select_taxonomy_value( $taxonomy, $term ); ?>" <?php selected( $this->get_select_taxonomy_value( $taxonomy, $term ), $selected_taxonomy ); ?>><?php echo $term->name; ?></option>
								<?php endforeach; ?>
							</optgroup>
						<?php endforeach; ?>
					</select>
				</p>
			<?php else : ?>
				<p>選択できるカテゴリー・タグがありません</p>
			<?php endif; ?>
		</div>
	<?php
	}

	/**
	 * ウィジェットオプションの保存処理
	 *
	 * @param array $new_instance 新しいオプション.
	 * @param array $old_instance 以前のオプション.
	 */
	public function update( $new_instance, $old_instance ) {
		/**
		 * 初期値のセット
		 */
		$instance                  = array();
		$instance['title']         = '';
		$instance['post_count']    = $this->default_post_count;
		$instance['show_img']      = $this->sanitize_checkbox( $new_instance['show_img'] );
		$instance['thmbnail_size'] = $this->default_thmbnail_size;
		$instance['taxonomy']      = '';
		/**
		 * 更新値のセット
		 */
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = strip_tags( $new_instance['title'] );
		}
		if ( ( is_numeric( $new_instance['post_count'] ) ) ) {
			$instance['post_count'] = (int) $new_instance['post_count'];
		}
		if ( ( ! empty( $new_instance['thmbnail_size'] ) ) ) {
			$instance['thmbnail_size'] = $new_instance['thmbnail_size'];
		}
		if ( ( ! empty( $new_instance['taxonomy'] ) ) ) {
			$instance['taxonomy'] = $new_instance['taxonomy'];
		}
		return $instance;
	}
	/**
	 * 保存用選択値の作成
	 *
	 * @param object $taxonomy タクソノミーオブジェクト.
	 * @param object $term タームオブジェクト.
	 * @return string
	 */
	private function get_select_taxonomy_value( $taxonomy, $term ) {
		return esc_attr( $taxonomy->name . $this->delimiter . $term->term_id );
	}
	/**
	 * 選択値をタクソノミーとタームに分割
	 *
	 * @param string $value 選択値.
	 * @return array
	 */
	private function get_selected_taxonomy( $value ) {
		$selected = explode( $this->delimiter, $value );
		if ( ! is_array( $selected ) ) {
			return null;
		}
		$term_id  = array_pop( $selected );
		$taxonomy = implode( $this->delimiter, $selected );
		return array(
			'term_id'       => $term_id,
			'taxonomy_name' => $taxonomy,
		);
	}
}