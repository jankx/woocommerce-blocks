<?php
/**
 * Bootstrap file for Jankx WooCommerce Blocks
 *
 * This file initializes the WooCommerce Blocks system within the Jankx framework
 */

namespace Jankx\WooCommerce\Blocks;

defined('ABSPATH') || exit;

class Bootstrap {
    /**
     * Plugin version
     */
    const VERSION = '1.0.0';

    /**
     * Plugin path
     */
    private static $plugin_path;

    /**
     * Plugin URL
     */
    private static $plugin_url;

    /**
     * Initialize the plugin
     */
    public static function init() {
        self::$plugin_path = dirname(dirname(__DIR__));
        self::$plugin_url = plugin_dir_url(self::$plugin_path . '/bootstrap.php');

        // Load dependencies
        self::load_dependencies();

        // Initialize blocks
        self::init_blocks();

        // Register assets
        self::register_assets();

        // Register hooks
        self::register_hooks();
    }

    /**
     * Load required dependencies
     */
    private static function load_dependencies() {
        // Load WooCommerce Blocks trunk
        $trunk_path = self::$plugin_path . '/woocommerce-blocks-trunk';

        if (file_exists($trunk_path . '/woocommerce-gutenberg-products-block.php')) {
            require_once $trunk_path . '/woocommerce-gutenberg-products-block.php';
        }

        // Load our custom blocks
        require_once self::$plugin_path . '/src/Blocks/BlockRegistry.php';
        require_once self::$plugin_path . '/src/Blocks/AbstractBlock.php';

        // Load all adapted blocks
        $blocks_index = self::$plugin_path . '/src/Blocks/index.php';
        if (file_exists($blocks_index)) {
            require_once $blocks_index;
        }
    }

    /**
     * Initialize blocks
     */
    private static function init_blocks() {
        // Initialize block registry
        BlockRegistry::init();

        // Register custom blocks
        self::register_custom_blocks();
    }

    /**
     * Register custom blocks
     */
    private static function register_custom_blocks() {
        // Register blocks from WooCommerce Blocks trunk
        $blocks_dir = self::$plugin_path . '/woocommerce-blocks-trunk/src/BlockTypes';

        if (is_dir($blocks_dir)) {
            $block_files = glob($blocks_dir . '/*.php');

            foreach ($block_files as $block_file) {
                $block_class = 'Automattic\\WooCommerce\\Blocks\\BlockTypes\\' . basename($block_file, '.php');

                if (class_exists($block_class)) {
                    BlockRegistry::register_block($block_class);
                }
            }
        }
    }

    /**
     * Register assets
     */
    private static function register_assets() {
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_frontend_assets']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_admin_assets']);
    }

    /**
     * Enqueue frontend assets
     */
    public static function enqueue_frontend_assets() {
        // Enqueue WooCommerce Blocks assets
        $assets_path = self::$plugin_path . '/woocommerce-blocks-trunk/assets';

        if (file_exists($assets_path . '/build/frontend.js')) {
            wp_enqueue_script(
                'jankx-woocommerce-blocks-frontend',
                self::$plugin_url . 'woocommerce-blocks-trunk/assets/build/frontend.js',
                ['wp-blocks', 'wp-element', 'wp-components'],
                self::VERSION,
                true
            );
        }

        if (file_exists($assets_path . '/build/frontend.css')) {
            wp_enqueue_style(
                'jankx-woocommerce-blocks-frontend',
                self::$plugin_url . 'woocommerce-blocks-trunk/assets/build/frontend.css',
                [],
                self::VERSION
            );
        }
    }

    /**
     * Enqueue admin assets
     */
    public static function enqueue_admin_assets() {
        $assets_path = self::$plugin_path . '/woocommerce-blocks-trunk/assets';

        if (file_exists($assets_path . '/build/editor.js')) {
            wp_enqueue_script(
                'jankx-woocommerce-blocks-editor',
                self::$plugin_url . 'woocommerce-blocks-trunk/assets/build/editor.js',
                ['wp-blocks', 'wp-element', 'wp-components', 'wp-editor'],
                self::VERSION,
                true
            );
        }

        if (file_exists($assets_path . '/build/editor.css')) {
            wp_enqueue_style(
                'jankx-woocommerce-blocks-editor',
                self::$plugin_url . 'woocommerce-blocks-trunk/assets/build/editor.css',
                [],
                self::VERSION
            );
        }
    }

    /**
     * Register WordPress hooks
     */
    private static function register_hooks() {
        // Register block categories
        add_filter('block_categories_all', [__CLASS__, 'register_block_categories'], 10, 2);

        // Register block patterns
        add_action('init', [__CLASS__, 'register_block_patterns']);
    }

    /**
     * Register block categories
     */
    public static function register_block_categories($categories, $post) {
        return array_merge($categories, [
            [
                'slug' => 'jankx-woocommerce',
                'title' => __('Jankx WooCommerce', 'jankx-woocommerce-blocks'),
                'icon' => 'cart',
            ],
        ]);
    }

    /**
     * Register block patterns
     */
    public static function register_block_patterns() {
        // Register custom block patterns here
    }

    /**
     * Get plugin path
     */
    public static function get_plugin_path() {
        return self::$plugin_path;
    }

    /**
     * Get plugin URL
     */
    public static function get_plugin_url() {
        return self::$plugin_url;
    }
}

// Initialize the plugin
Bootstrap::init();
