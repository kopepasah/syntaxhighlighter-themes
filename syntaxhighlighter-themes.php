<?php
/*
Plugin Name: Syntaxhighlighter Evolved Themes
Version: 1.0.0
Plugin URI: http://github.com/kopepasah/syntaxhighlighter-themes/
Description: Adds new themes for Syntaxhighlighter Evolved Plugin.
Author: Justin Kopepasah
Author URI: http://kopepasah.com

Copyright 2014  (email: justin@kopepasah.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * Register and enqueue the new theme stylesheets.
 * 
 * @since 1.0.0
**/
function kp_syntaxhighlighter_themes_enqueue_styles() {
	wp_register_style( 'syntaxhighlighter-theme-solarized-dark', plugins_url( 'themes/solarized-dark.css', __FILE__ ), array( 'syntaxhighlighter-core' ), '20140329', 'all' );
}
add_action( 'wp_enqueue_scripts', 'kp_syntaxhighlighter_themes_enqueue_styles' );
add_action( 'admin_enqueue_scripts', 'kp_syntaxhighlighter_themes_enqueue_styles' );

/**
 * Use syntaxhighlighter_themes filter to add new
 * themes.
 *
 * @since 1.0.0
*/
function kp_syntaxhighlighter_themes_filter_syntaxhighlighter_theme( $themes ) {
	$themes['solarized-dark'] = 'Solarized Dark';

	return $themes;
}
add_filter( 'syntaxhighlighter_themes', 'sxhet_add_syntaxhighlighter_theme' );