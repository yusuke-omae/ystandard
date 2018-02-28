<?php
/**
 * アーカイブタイトル
 */
if( ! function_exists( 'ys_get_the_archive_title' )){
	function ys_get_the_archive_title( $title ) {
		/**
		 * 標準フォーマット
		 */
		$title_format = '「%s」の記事一覧';

		if ( is_category() ) {
			$title = sprintf( $title_format, single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( $title_format, single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( $title_format, get_the_author() );
		} elseif ( is_search() ) {
			$title_format = '「%s」に関連する記事一覧';
			$title = sprintf( $title_format, esc_html( get_search_query( false ) ) );
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( $title_format, post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$object = get_queried_object();
			$tax = get_taxonomy( $object->taxonomy );
			/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf( '%1$s「%2$s」の投稿一覧' , $tax->labels->singular_name, single_term_title( '', false ) );
		} elseif ( is_home() ) {
			$title = '記事一覧';
		}
		/**
		 * ページング
		 */
		if( get_query_var( 'paged' ) ) {
			$title .= ' ' . get_query_var( 'paged' ) . 'ページ';
		}

		return apply_filters( 'ys_get_the_archive_title', $title );
	}
}
add_filter( 'get_the_archive_title', 'ys_get_the_archive_title' );

/**
 * アーカイブURL
 */
if( ! function_exists( 'ys_get_the_archive_url' ) ){
	function ys_get_the_archive_url() {
		$url = '';
		$queried_object = get_queried_object();
		if ( is_category() ) {
			$url = get_category_link( $queried_object->term_id );
		} elseif ( is_tag() ) {
			$url = get_tag_link( $queried_object->term_id );
		} elseif ( is_author() ) {
			$author_id = get_query_var( 'author' );
			$url = esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) );
		} elseif ( is_search() ) {
			$url = home_url( '/?s=' . urlencode( get_search_query( false ) ) );
			$url = get_post_type_archive_link( esc_url_raw( $url ) );
		} elseif ( is_post_type_archive() ) {
			$post_type = ys_get_post_type();
			$url = get_post_type_archive_link( $post_type );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( $queried_object->taxonomy );
			$url = get_term_link( $tax->name, $queried_object->term_id );
		}
		return apply_filters( 'ys_get_the_archive_url', $url );
	}
}
/**
 * cardタイプ表示の場合のカラム数取得
 */
if( ! function_exists( 'ys_get_archive_card_col' ) ){
	function ys_get_archive_card_col() {
		if( ys_is_one_column() ) {
			return 'entry-list--card-3';
		}
		return 'entry-list--card-2';
	}
}
