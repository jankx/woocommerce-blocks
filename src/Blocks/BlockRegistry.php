<?php

namespace Jankx\WooCommerce\Blocks;

/**
 * BlockRegistry class for managing WooCommerce blocks
 */
class BlockRegistry {
    /**
     * Registered blocks
     *
     * @var array
     */
    private static $blocks = [];

    /**
     * Initialize the block registry
     */
    public static function init() {
        // Initialize the registry
        self::$blocks = [];
    }

    /**
     * Register a block class
     *
     * @param string $block_class The block class name
     */
    public static function register_block($block_class) {
        if (class_exists($block_class)) {
            self::$blocks[] = $block_class;
        }
    }

    /**
     * Get all registered blocks
     *
     * @return array
     */
    public static function get_blocks() {
        return self::$blocks;
    }

    /**
     * Register all blocks with WordPress
     */
    public static function register_all_blocks() {
        foreach (self::$blocks as $block_class) {
            if (class_exists($block_class)) {
                // Create an instance and register the block
                try {
                    $block = new $block_class();
                    if (method_exists($block, 'register_block_type')) {
                        $block->register_block_type();
                    }
                } catch (\Exception $e) {
                    // Log error or handle gracefully
                    error_log("Failed to register block: " . $block_class . " - " . $e->getMessage());
                }
            }
        }
    }
}
