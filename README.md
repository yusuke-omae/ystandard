# ystandard

## 普通とは一味違ったテーマ

サイト高速化、Google PageSpeed Insightsでの高得点獲得に重点を置きながら、比較的カスタマイズしやすい形を目指したテーマ

テンプレートファイルと機能面をなるべく分離し、子テーマでの拡張を前提に作っています。


## 必要な動作環境

WordPress  :  4.5以上
PHP  :  5.6以上


## 主な機能

- Google Analyticsのタグ出力を管理画面から設定可
- OGPの出力（管理画面で設定を行う必要あり）
- カテゴリー、タグ、日別ページのnoindex設定
- AMPフォーマット出力（β版）
- 筆者のSNSリンク出力機能
- 筆者の画像変更機能
- 記事毎にnoindexの設定が可能
- PageSpeed Insightsの提案に沿ったCSSの配信最適化


## メニューについて

### メニュー位置

1. グローバルメニュー
2. フッターメニュー

上記2種類のメニューを用意

### メニュー階層

- グローバルメニュー
  - 子項目まで対応（孫項目については設定しても表示されません）
- フッターメニュー
  - 階層メニュー非対応。階層メニューを設定しても、親メニューしか表示されません。


## 絵文字やoEmbed関連のスクリプト・CSSの削除について

`inc/setup.php`内の`ys_setup_remove_emoji`、`ys_setup_remove_oembed`にて絵文字やEmbeds関連のスクリプト・CSSを削除しています。

必要な場合は該当箇所をコメントアウトするか、子テーマであれば中身のない同名関数を作成して下さい。


## スタイルについて

### sass

ystandard側で作成したスタイルは`/sass/ystandard/`以下で定義

`/sass/_ys_custom_variables.scss`で変数を上書き、`/sass/_ys_customize.scss`で作成するテーマ独自のスタイルを追加していく想定で作成しています。

## 設定項目

### 簡単設定

- SNSまとめて設定
  - Twitter
    - アカウント名
  - Facebook
    - app_id
    - admins

### 基本設定

- Copyright
  - 発行年
- アクセス解析設定
  - Google Analytics トラッキングID
- シェアボタン設定
  - Twitterシェアにviaを付加する（要Twitterアカウント名設定）
  - Twitterアカウント名:@
- OGP・Twitterカード設定
  - Facebook app_id
  - Facebook admins
  - Twitterアカウント名
  - OGPデフォルト画像
- SEO対策設定
  - アーカイブページのnoindex設定

### 高度な設定

- 投稿設定
  - 個別ページでアイキャッチ画像を表示しない
- css,javascript設定
  - 追加で読み込むスタイルシート
  - jQueryをCDNから読み込む（URLを設定）
- AMP有効化
  - AMPページを生成する（β）

### AMP設定（β）

- シェアボタン設定
  - Facebook app_id
- 通常ビューへのリンク表示
  - コンテンツ上部
  - シェアボタン下
- AMP記事作成条件設定
  - scriptタグの削除
  - styleタグの削除



## 履歴

- 2016年10月xx日：開発開始
- 2016年11月15日：とりあえずGithubにて公開…の予定をやっぱりやめてもう一度構想から練り直し
- 2016年12月xx日：「Google PageSpeed Insightsでの高得点を出しやすい」「速い」をコンセプトに再作成開始
