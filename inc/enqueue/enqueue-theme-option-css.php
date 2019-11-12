<?php
/**
 * カスタマイザー/設定で追加するCSS
 *
 * @package ystandard
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

/**
 * モバイルフッター設定によって追加するCSS
 */
function ys_get_inline_css_mobile_css() {
	if ( ! has_nav_menu( 'mobile-footer' ) ) {
		return '';
	}
	$css = <<<EOD
.footer-mobile-nav {
  width: 100%;
  position: fixed;
  bottom: 0;
  left: 0;
  background-color: rgba(255, 255, 255, 0.95);
  border-top: 1px solid #EEEEEE;
  text-align: center;
  z-index: 9; }
  @media screen and (min-width: 1025px) {
    .footer-mobile-nav {
      display: none; } }
  .footer-mobile-nav ul {
    padding: .75rem 0 .5rem; }
  .footer-mobile-nav a {
    display: block;
    color: inherit;
    text-decoration: none; }
  .footer-mobile-nav svg, .footer-mobile-nav i {
    font-size: 1.5em; }

.footer-mobile-nav__dscr {
  display: block;
  font-size: .7em;
  line-height: 1.2; }

.has-mobile-footer .site__footer {
  padding-bottom: 5rem; }
  @media screen and (min-width: 1025px) {
    .has-mobile-footer .site__footer {
      padding-bottom: 1rem; } }
EOD;

	return $css;
}