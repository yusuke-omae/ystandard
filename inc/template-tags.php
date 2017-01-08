<?php
/* ***************************************************************************
 *
 *	テンプレート出力する類の関数
 *
 * ************************************************************************ */


//------------------------------------------------------------------------------
//
//	html~head関連
//
//------------------------------------------------------------------------------
//-----------------------------------------------
//	html-head要素の出力
//-----------------------------------------------
if(!function_exists( 'ys_template_head_tag')) {
	function ys_template_head_tag(){

		// ------------------------
		// html,head開始タグ,charset,viewport
		// ------------------------
		if(ys_is_amp()):
			// AMPページ用
			ys_template_head_amp();
		else :
			// 通常ページ
			ys_template_head_normal();
		endif;
		echo "</head>";
	}
}




//-----------------------------------------------
//	AMPページのHTML-head要素
//-----------------------------------------------
if(!function_exists( 'ys_template_head_amp')) {
	function ys_template_head_amp(){
		?>
<html ⚡>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="referrer" content="origin-when-crossorigin">
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<meta name="format-detection" content="telephone=no" />
<meta itemscope id="EntityOfPageid" itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php echo the_permalink(); ?>"/>
<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
 <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
<script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
<script async src="https://cdn.ampproject.org/v0.js"></script>
<style amp-custom>
<?php
	$inline = file_get_contents(TEMPLATEPATH.'/css/ys-inline.min.css');
	echo str_replace('@charset "UTF-8";','',$inline);
	$css = file_get_contents(TEMPLATEPATH.'/css/ys-style.min.css');
	echo str_replace('@charset "UTF-8";','',$css);
?>
</style>
<?php
	// noindex
	ys_extras_add_noindex();
	// canonical
	ys_extras_add_canonical();
	// next,prev
	ys_extras_adjacent_posts_rel_link_wp_head();
	// タイトル
	echo '<title>'.wp_get_document_title().'</title>';
?>
<?php
	}
}




//-----------------------------------------------
//	通常ページのHTML-head要素
//-----------------------------------------------
if(!function_exists( 'ys_template_head_normal')) {
	function ys_template_head_normal(){
		?>
<html <?php language_attributes(); ?>>
<?php if(ys_is_ogp_enable()): ?>
<?php 	if(is_single() || is_page()): ?>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<?php 	else: ?>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# blog: http://ogp.me/ns/blog#">
<?php 	endif; ?>
<?php else: ?>
<head>
<?php endif; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="referrer" content="origin-when-crossorigin">
<meta name="format-detection" content="telephone=no" />
<meta itemscope id="EntityOfPageid" itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php echo the_permalink(); ?>"/>
<style type="text/css">
<?php include(TEMPLATEPATH.'/css/ys-inline.min.css'); ?>
</style>
<?php
	if ( is_singular() && pings_open( get_queried_object() ) ) :
?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
	endif;
	// wp_head呼び出し
	wp_head();
	}
}







//------------------------------------------------------------------------------
//
//	投稿の表示関連
//
//------------------------------------------------------------------------------

//-----------------------------------------------
//	投稿・更新日取得
//-----------------------------------------------
if (!function_exists( 'ys_template_the_entry_date')) {
	function ys_template_the_entry_date($show_update = true) {

		$format = get_option( 'date_format' );
		$pubdate = 'pubdate="pubdate"';
		$updatecontent = 'content="'.get_the_modified_time('Y-m-d').'"';

		$entry_date_class = 'entry-date entry-published published';
		$update_date_class = 'entry-updated updated';

		$ico_calendar = '<svg width="32" height="32" viewBox="0 0 32 32" id="ico-calendar" ><path d="M10 12h4v4h-4zM16 12h4v4h-4zM22 12h4v4h-4zM4 24h4v4h-4zM10 24h4v4h-4zM16 24h4v4h-4zM10 18h4v4h-4zM16 18h4v4h-4zM22 18h4v4h-4zM4 18h4v4h-4zM26 0v2h-4v-2h-14v2h-4v-2h-4v32h30v-32h-4zM28 30h-26v-22h26v22z"></path></svg>';

		$ico_update = '<svg width="32" height="32" viewBox="0 0 32 32" id="ico-update"><path d="M32 12h-12l4.485-4.485c-2.267-2.266-5.28-3.515-8.485-3.515s-6.219 1.248-8.485 3.515c-2.266 2.267-3.515 5.28-3.515 8.485s1.248 6.219 3.515 8.485c2.267 2.266 5.28 3.515 8.485 3.515s6.219-1.248 8.485-3.515c0.189-0.189 0.371-0.384 0.546-0.583l3.010 2.634c-2.933 3.349-7.239 5.464-12.041 5.464-8.837 0-16-7.163-16-16s7.163-16 16-16c4.418 0 8.418 1.791 11.313 4.687l4.687-4.687v12z"></path></svg>';

		$ico_calendar = apply_filters('ys_ico_calendar',$ico_calendar);
		$ico_update = apply_filters('ys_ico_update',$ico_update);

		if(ys_is_amp()){
			$pubdate = '';
			$updatecontent = '';
		}


		//公開直後に微調整はよくあること。日付で判断
		if(get_the_time('Ymd') === get_the_modified_time('Ymd') || $show_update === false) {
			$entry_date_class .= ' updated';

			echo $ico_calendar.'<time class="'.$entry_date_class.'" itemprop="dateCreated datePublished dateModified" datetime="'.get_post_time('Y-m-d').'" '.$pubdate.'>'.get_the_time($format).'</time>';
		} else {
			echo $ico_calendar.'<time class="'.$entry_date_class.'" itemprop="dateCreated datePublished" datetime="'.get_post_time('Y-m-d').'" '.$pubdate.'>'.get_the_time($format).'</time>';
			echo $ico_update.'<span class="'.$update_date_class.'" itemprop="dateModified" '.$updatecontent.'>'.get_the_modified_time($format).'</span>';
		}
	}
}




//-----------------------------------------------
//	投稿者取得
//-----------------------------------------------
if (!function_exists( 'ys_template_the_entry_author')) {
	function ys_template_the_entry_author($link = true) {

		$author_name = get_the_author();
		$author_url = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );

		$stracture = '';
		if(!is_singular()){
			$stracture = ' itemprop="author editor creator" itemscope itemtype="http://schema.org/Person"';
		}

		if($link) {
			$author = '<span class="author vcard"'.$stracture.'><a class="url fn n" href="'.$author_url.'"><span itemprop="name">'.$author_name.'</span></a></span>';
		} else {
			$author = '<span class="author vcard"'.$stracture.'><span class="url fn n"><span itemprop="name">'.$author_name.'</span></span></span>';
		}

		echo $author;
	}
}




//-----------------------------------------------
//	この記事を読む
//-----------------------------------------------
if (!function_exists( 'ys_template_the_entry_more_text')) {
	function ys_template_the_entry_more_text() {

		$read_more = 'この記事を読む';

		echo apply_filters('ys_entry_more_text',$read_more);
	}
}




//-----------------------------------------------
//	筆者のSNSプロフィール
//-----------------------------------------------
if (!function_exists( 'ys_template_the_author_sns')) {
	function ys_template_the_author_sns() {

		if(ys_is_amp()) {
			return;
		}

		$sns_list ='';

		// キーがmeta key,valueがfontawesomeのクラス
		$sns_arr = array(
			'ys_twitter' => 'twitter',
			'ys_facebook' => 'facebook',
			'ys_googleplus' => 'google-plus',
			'ys_instagram' => 'instagram',
			'ys_tumblr' => 'tumblr',
			'ys_youtube' => 'youtube-play',
			'ys_vine' => 'vine',
			'ys_github' => 'github',
			'ys_pinterest' => 'pinterest',
			'ys_linkedin' => 'linkedin'
		);

		foreach ($sns_arr as $key => $val) {

			$author_sns = get_the_author_meta( $key );
			if($author_sns != '') {
				$sns_list .= '<li class="color-'.$val.'"><a href="'.esc_url( $author_sns ).'" target="_blank" rel="nofollow" ><i class="fa fa-fw fa-'.$val.'" aria-hidden="true"></i></a></li>'.PHP_EOL;
			}
		}

		if($sns_list !== ''){
			$sns_list = '<ul class="author-sns">'.$sns_list.'</ul>';
		}
		echo $sns_list;
	}
}




//-----------------------------------------------
//	ページング
//-----------------------------------------------
if (!function_exists( 'ys_template_the_link_pages')) {
	function ys_template_the_link_pages() {
		wp_link_pages( array(
					'before'      => '<div class="page-links">',
					'after'       => '</div>',
					'link_before' => '<span class="page-text">',
					'link_after'  => '</span>',
					'pagelink'    => '%',
					'separator'   => '',
				) );
	}
}




//-----------------------------------------------
//	投稿抜粋文を作成
//-----------------------------------------------
if( ! function_exists( 'ys_template_get_the_custom_excerpt' ) ) {
	function ys_template_get_the_custom_excerpt($content,$length,$sep=' ...'){
		//HTMLタグ削除
		$content = wp_strip_all_tags($content,true);
		//ショートコード削除
		$content = strip_shortcodes($content);
		if(mb_strlen($content) > $length) {
			$content =  mb_substr($content,0,$length - mb_strlen($sep)).$sep;
		}
		return $content;
	}
}




//-----------------------------------------------
//	シェアボタン
//-----------------------------------------------
if( ! function_exists( 'ys_template_the_sns_share' ) ) {
	function ys_template_the_sns_share(){

		echo '<div id="sns-share" class="sns-share">';
		echo '<p class="sns-share-title">\ みんなにシェアする /</p>';

		if(!ys_is_amp()){
			// AMP以外
			ys_template_the_sns_share_buttons();

		} else {
			// AMP記事
			$fb_app_id = '254325784911610';
			echo '<amp-social-share type="twitter" width="100" height="44"></amp-social-share>';
			echo '<amp-social-share type="facebook" width="100" height="44" data-param-app_id="'.$fb_app_id.'"></amp-social-share>';
			echo '<amp-social-share type="gplus" width="100" height="44"></amp-social-share>';
			echo '<p class="amp-view-info">その他の方法でシェアする場合は通常表示に切り替えて下さい。<a class="normal-view-link" href="'.get_the_permalink().'#sns-share">通常表示に切り替える »</a></p>';
		}
		echo '</div>';

	}
}




//-----------------------------------------------
//	通常のシェアボタン
//-----------------------------------------------
if( ! function_exists( 'ys_template_the_sns_share_buttons' ) ) {
	function ys_template_the_sns_share_buttons(){

		$share_url = urlencode(get_permalink());
		$share_title = urlencode(get_the_title());

		echo '<ul class="sns-share-button">';
		// Twitter
		$tweet_via = '';
		if(get_option('ys_sns_share_tweet_via',0) == 1 && get_option('ys_sns_share_tweet_via_account') != ''){
			$tweet_via = '&via='.get_option('ys_sns_share_tweet_via_account');
		}
		echo '<li class="twitter bg-twitter"><a href="http://twitter.com/share?text='.$share_title.'&url='.$share_url.$tweet_via.'">Twitter</a></li>';
		// Facebook
		echo '<li class="facebook bg-facebook"><a href="http://www.facebook.com/sharer.php?src=bm&u='.$share_url.'&t='.$share_title.'">Facebook</a></li>';
		// はてブ
		echo '<li class="hatenabookmark bg-hatenabookmark"><a href="http://b.hatena.ne.jp/add?mode=confirm&url='.$share_url.'">はてブ</a></li>';
		// Google +
		echo '<li class="google-plus bg-google-plus"><a href="https://plus.google.com/share?url='.$share_url.'">Google+</a></li>';
		// Pocket
		echo '<li class="pocket bg-pocket"><a href="http://getpocket.com/edit?url='.$share_url.'&title='.$share_title.'">Pocket</a></li>';
		// LINE
		echo '<li class="line bg-line"><a href="http://line.me/R/msg/text/?'.$share_title.'%0A'.$share_url.'" target="_blank">LINE</a></li>';

		echo '</ul>';
	}
}







//------------------------------------------------------------------------------
//
//	フッター関連
//
//------------------------------------------------------------------------------
if( ! function_exists( 'ys_template_the_copyright' ) ) {
	function ys_template_the_copyright() {

		$copyright = '<p class="copy">Copyright &copy; '.ys_get_settings('ys_copyright_year').' <a href="'. esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo('name') . '</a> All Rights Reserved.</p>';
		$powered = '<p id="powered">Powered by <a href="https://ja.wordpress.org/" target="_blank">WordPress</a> &amp; ';
		$poweredtheme = '<a href="https://ystandard.net" target="_blank">yStandard Theme</a> by <a href="https://yosiakatsuki.net" target="_blank">yosiakatsuki</a></p>';

		$copyright = apply_filters('ys_copyright',$copyright);
		$powered = apply_filters('ys_poweredby',$powered);
		$poweredtheme = apply_filters('ys_poweredby_theme',$poweredtheme);

		echo $copyright.$powered.$poweredtheme;
	}
}







//------------------------------------------------------------------------------
//
//	タクソノミー関連の関数
//
//------------------------------------------------------------------------------
//-----------------------------------------------
//	投稿のカテゴリー出力
//-----------------------------------------------
if( ! function_exists( 'ys_template_the_post_categorys' ) ) {
	function ys_template_the_post_categorys($number = null,$link=true,$separator=', ',$postid=0) {

		if($postid==0){
			$postid = get_the_ID();
		}

		$terms ='';
		$taxonomy = 'category';
		// 投稿に付けられたターム（カテゴリー）の ID を取得する。
		$post_terms = wp_get_object_terms( $postid, $taxonomy, array( 'fields' => 'ids' ) );

		if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {

			$term_ids = implode( ',' , $post_terms );

			$query = 'include=' . $term_ids;
			if($number != null ) {
				$query .= '&number='.$number;
			}

			$categories = get_categories( $query );
			foreach ( $categories as $category ) {

				if($link) {
					$terms = '<a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a>';
				} else {
					$terms = '<span class="cat-list <?php echo $category->slug; ?>">'.$category->name.'</span>';
				}
				$terms .= $separator;
			}
		}
		// 投稿のカテゴリーを表示
		echo rtrim($terms,$separator);
	}//ys_category_get_post_categorys
}








//------------------------------------------------------------------------------
//
//	画像関連の関数
//
//------------------------------------------------------------------------------

//-----------------------------------------------
//	記事一覧用画像タグの出力
//-----------------------------------------------
if (!function_exists( 'ys_template_the_post_thumbnail')) {
	function ys_template_the_post_thumbnail($thumbname='full',$outputmeta=true,$imgid='',$imgclass='',$postid=0) {

		if($postid == 0){
			$postid = get_the_ID();
		}
		// 画像を取得
		$image = ys_utilities_get_post_thumbnail($thumbname,'',$postid);

		// id確認
		if($imgid !== ''){
			$imgid = ' id="'.$imgid.'"';
		}
		// class確認
		if($imgclass !== ''){
			$imgclass = ' class="'.$imgclass.'"';
		}

		//imgタグを出力
		if(ys_is_amp()){
			$imgtag = '<amp-img layout="responsive" ';
		} else {
			$imgtag = '<img ';
		}
		echo $imgtag.$imgid.$imgclass.'src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" />';

		//metaタグを出力
		if($outputmeta && !ys_is_amp()){
			echo '<meta itemprop="url" content="'.$image[0].'" />';
			echo '<meta itemprop="width" content="'.$image[1].'" />';
			echo '<meta itemprop="height" content="'.$image[2].'" />';
		}
	}
}




//-----------------------------------------------
//	ユーザー画像出力
//-----------------------------------------------
if (!function_exists( 'ys_template_the_user_avatar')) {
	function ys_template_the_user_avatar($author_id = null,$size = 96){

		echo ys_utilities_get_the_user_avatar_img($author_id,$size);
	}
}

?>