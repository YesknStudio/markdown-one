<?php

/**
 * This file is part of project markdown one.
 *
 * Author: jaggle
 * Create: 2018-12-10 21:05:37
 */

class MarkdownOne {

    private $pluginPath;

    private $pluginUrl;

    public function __construct($pluginPath, $pluginUrl)
    {
        $this->pluginPath = $pluginPath;
        $this->pluginUrl = $pluginUrl;
    }

    public function start()
    {
        $this->register_parser();
        $this->register_admin_menu();
        $this->register_setting_link();

        add_action( 'wp_enqueue_scripts', array( $this, 'highlight_scripts_styles' ) );
    }

    public function register_parser()
    {
        add_filter('the_content', function ($content) {
            $parser = new \Parsedown();
            return $parser->parse($content);
        }, 1);
    }

    public function register_admin_menu()
    {
        add_action('admin_menu', function () {
            add_options_page(
                'Markdown One设置',
                'Markdown One设置',
                'manage_options',
                'markdown-one',
                array($this, 'show_settings_page')
            );
        });
    }

    public function register_setting_link()
    {
        add_filter("plugin_action_links", [$this, 'show_settings_link'], 10, 2);
    }

    public function show_settings_page()
    {
        include $this->pluginPath . '/settings.php';
    }

    public function show_settings_link($links, $file)
    {
        if ($file == plugin_basename($this->pluginPath . '/markdown-one.php')) {
            $settings_title = __('Settings for this Plugin', 'markdown-one');
            $settings = __('Settings', 'markdown-one');
            $settings_link = '<a href="options-general.php?page=markdown-one" title="' . $settings_title . '">' . $settings . '</a>';
            array_unshift($links, $settings_link);
        }

        return $links;
    }

    public function highlight_scripts_styles() {
        wp_enqueue_style( 'highlight', $this->pluginUrl . 'assets/styles/frontend.min.css');
        wp_enqueue_script( 'highlight', $this->pluginUrl . 'assets/scripts/highlight.pack.js', '', '9.12.0', true );
        wp_add_inline_script( 'highlight', 'hljs.initHighlightingOnLoad();' );
        wp_enqueue_script( 'clipboard', $this->pluginUrl . 'assets/scripts/clipboard.min.js', '', '2.0.0', true );
        wp_enqueue_script( 'frontend', $this->pluginUrl . 'assets/scripts/frontend.min.js', '', '', true );
    }
}
