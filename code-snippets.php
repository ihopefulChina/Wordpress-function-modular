<?php

/**
 * Code Snippets - An easy, clean and simple way to add code snippets to your site.
 *
 * If you're interested in helping to develop Code Snippets, or perhaps contribute
 * to the localization, please see https://github.com/ihopefulChina/Wordpress-function-modular
 *
 * @package   Code_Snippets
 * @author    黄鹏飞 <784667332@qq.com>
 * @copyright 
 * @license   MIT
 * @version   1.0
 * @link      https://github.com/ihopefulChina/Wordpress-function-modular
 */

/*
Plugin Name: 函数代码模块化
Plugin URI:  https://github.com/ihopefulChina/Wordpress-function-modular
Description: 函数模块化，以简单、简洁、简约的方式添加代码片段到您的站点。再也没有必要去编辑主题的 functions.php 文件。
Author:      黄鹏飞
Author URI:  http://hopeful.tk/
Version:     1.0
License:     MIT
License URI: license.txt
Text Domain: code-snippets
Domain Path: /languages
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * The version number for this release of the plugin.
 * This will later be used for upgrades and enqueuing files
 *
 * This should be set to the 'Plugin Version' value,
 * as defined above in the plugin header
 *
 * @since 2.0
 * @var string A PHP-standardized version number string
 */
define( 'CODE_SNIPPETS_VERSION', '1.1' );

/**
 * The full path to the main file of this plugin
 *
 * This can later be passed to functions such as
 * plugin_dir_path(), plugins_url() and plugin_basename()
 * to retrieve information about plugin paths
 *
 * @since 2.0
 * @var string
 */
define( 'CODE_SNIPPETS_FILE', __FILE__ );

/**
 * Enable autoloading of plugin classes
 * @param $class_name
 */
function code_snippets_autoload( $class_name ) {

	/* Only autoload classes from this plugin */
	if ( 'Code_Snippet' !== $class_name && 'Code_Snippets' !== substr( $class_name, 0, 13 ) ) {
		return;
	}

	/* Remove namespace from class name */
	$class_file = str_replace( 'Code_Snippets_', '', $class_name );

	if ( 'Code_Snippet' === $class_name ) {
		$class_file = 'Snippet';
	}

	/* Convert class name format to file name format */
	$class_file = strtolower( $class_file );
	$class_file = str_replace( '_', '-', $class_file );

	$class_path = dirname( __FILE__ ) . '/php/';

	if ( 'Menu' === substr( $class_name, -4, 4 ) ) {
		$class_path .= 'admin-menus/';
	}

	/* Load the class */
	require_once $class_path . "class-{$class_file}.php";
}

try {
	spl_autoload_register( 'code_snippets_autoload' );
} catch ( Exception $e ) {
	new WP_Error( $e->getCode(), $e->getMessage() );
}

/**
 * Retrieve the instance of the main plugin class
 *
 * @since 2.6.0
 * @return Code_Snippets
 */
function code_snippets() {
	static $plugin;

	if ( is_null( $plugin ) ) {
		$plugin = new Code_Snippets( CODE_SNIPPETS_VERSION, __FILE__ );
	}

	return $plugin;
}

code_snippets()->load_plugin();

/* Execute the snippets once the plugins are loaded */
add_action( 'plugins_loaded', 'execute_active_snippets', 1 );
