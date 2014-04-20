<?php
/*
Plugin Name: SyntaxHighlighter Evolved Themes
Version: 1.0.1
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

class SyntaxHighlighter_Themes {
	/**
	 * @var SyntaxHighlighter_Themes
	 * @since 1.0.0
	*/
	private static $instance;

	/**
	 * Our new themes.
	 *
	 * @var $themes
	 * @since 1.0.0
	*/
	public $themes = array();

	/**
	 * Main SyntaxHighlighter Themes Instance
	 *
	 * @since 1.0.0
	 * @static
	*/
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * SyntaxHighlighter Themes Constructor
	 *
	 * @since 1.0.0
	*/
	public function __construct() {
		// If SyntaxHighlighter is not active, give a notice and bail.
		if ( ! class_exists( 'SyntaxHighlighter' ) ) {
			add_action( 'admin_notices', array( $this, 'notice' ) );
			return;
		}

		// Load localization domain
		load_plugin_textdomain( 'syntaxhighlighter-themes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Setup our new themes.
		$this->themes = array(
			'solarized-dark'  => __( 'Solarized Dark', 'syntaxhighlighter-theme' ),
			'solarized-light' => __( 'Solarized Light', 'syntaxhighlighter-theme' ),
			'tomorrow-night'  => __( 'Tomorrow Night', 'syntaxhighlighter-theme' ),
		);

		// Register our scripts on the frontend and admin.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_styles' ) );

		// Add our new themes.
		add_filter( 'syntaxhighlighter_themes', array( $this, 'filter_themes' ) );
	}

	/**
	 * Notice when SyntacHighlighter is not active.
	 *
	 * @since 1.0.0
	*/
	public function notice() {
		$notice = sprintf( __( 'SyntaxHighlighter Evolved Themes requires %sSyntaxHighlighter Evolved%s.', 'syntaxhighlighter-themes' ), '<a href="https://wordpress.org/plugins/syntaxhighlighter/">', '</a>' );

		echo '<div class="error"><p>' . $notice . '</p></div>';
	}

	/**
	 * Register our new styles for use in the plugin.
	 *
	 * @since 1.0.0
	*/
	public function register_styles() {
		foreach ( $this->themes as $slug => $name ) {
			wp_register_style( 'syntaxhighlighter-theme-' . $slug, plugins_url( 'themes/' . $slug . '.css', __FILE__ ), array( 'syntaxhighlighter-core' ), '20140330', 'all' );
		}
	}

	/**
	 * Hook into the syntaxhighlighter_themes filter
	 * to add our new themes.
	 *
	 * @since 1.0.0
	 * @param string Currently registered themes for SyntaxHighlighter.
	*/
	public function filter_themes( $themes ) {
		foreach ( $this->themes as $slug => $name ) {
			$themes[$slug] = $name;
		}

		return $themes;
	}
}

/**
 * Instantiate this plugin after plugins have loaded,
 * but before SyntaxHighlighter class is instantiated.
 *
 * We do this because we have a check for the class of
 * SyntaxHighlighter, but the need the code to load
 * before SyntaxHighlighter code.
 *
 * @since 1.0.0
*/
function syntaxhighlighter_themes() {
	return SyntaxHighlighter_Themes::instance();
}
add_action( 'plugins_loaded', 'syntaxhighlighter_themes' );