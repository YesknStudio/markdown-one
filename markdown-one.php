<?php

/**
 * Plugin Name: markdown one
 * Plugin URI: https://yeskn.com
 * Description: markdown support for wordpress
 * Version: 1.0
 * Author: jaggle
 * License: GPL2
 * Email: jaggle@yeskn.com
 * Text Domain: markdown-one
 * Domain Path: /languages
*/

if (!class_exists('MarkdownOne')) {
    require_once 'src/MarkdownOne.php';
    require_once 'src/Parsedown.php';
}

$pluginPath  = __DIR__;
$pluginDir = plugin_dir_url(__FILE__);

$plugin = new MarkdownOne($pluginPath, $pluginDir);

$plugin->start();
