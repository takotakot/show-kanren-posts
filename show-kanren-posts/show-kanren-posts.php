<?php
/**
 * Show Kanren Posts
 *
 * @since             1.0.0
 * @package           Show_Kanren_Posts
 *
 * @wordpress-plugin
 * Plugin Name:       Show Kanren Posts
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       -
 * Version:           1.0.0
 * Author:            takotakot
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       show-kanren-posts
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'SHOW_KANREN_POSTS_VERSION', '1.0.0' );

define( 'SHOW_KANREN_POSTS_VERSION__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SHOW_KANREN_POSTS_VERSION__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once SHOW_KANREN_POSTS_VERSION__PLUGIN_DIR . 'class-show-kanren-posts.php';

$show_kanren_posts = new Show_Kanren_Posts();
