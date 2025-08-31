<?php
/**
 * ProductTopRated Block - Tương thích với WooCommerce CSS
 * 
 * @package Jankx\WooCommerce\Blocks
 */

namespace Jankx\WooCommerce\Blocks;

defined('ABSPATH') || exit;

class ProductTopRated extends AbstractBlock {
    protected $block_name = 'jankx/product-top-rated';
    protected $description = 'Hiển thị sản phẩm được đánh giá cao nhất';
    protected $keywords = ['products', 'top-rated', 'reviews', 'jankx', 'woocommerce'];

    protected $attributes = [
        'columns' => [
            'type' => 'number',
            'default' => 3,
        ],
        'rows' => [
            'type' => 'number',
            'default' => 3,
        ],
        'categories' => [
            'type' => 'array',
            'default' => [],
        ],
        'orderBy' => [
            'type' => 'string',
            'default' => 'date',
        ],
        'order' => [
            'type' => 'string',
            'default' => 'desc',
        ],
        'align' => [
            'type' => 'string',
            'default' => '',
        ],
        'className' => [
            'type' => 'string',
            'default' => '',
        ],
    ];

    public function render($attributes, $content) {
        if (!class_exists('WooCommerce')) {
            return '<div class="jankx-block-error">WooCommerce is not active.</div>';
        }

        $attributes = wp_parse_args($attributes, [
            'columns' => 3,
            'rows' => 3,
            'categories' => [],
            'orderBy' => 'date',
            'order' => 'desc',
            'align' => '',
            'className' => '',
        ]);

        // CSS classes tương thích với WooCommerce
        $wrapper_classes = [
            'jankx-block-product-top-rated',
            'wc-block-grid',
            'has-' . $attributes['columns'] . '-columns',
        ];

        if ($attributes['align']) {
            $wrapper_classes[] = 'align' . $attributes['align'];
        }

        if ($attributes['className']) {
            $wrapper_classes[] = $attributes['className'];
        }

        ob_start();
        ?>
        <div class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>">
            <!-- ProductTopRated content here -->
            <div class="jankx-block-product-top-rated-content">
                <p>Jankx ProductTopRated Block - Tương thích với WooCommerce CSS</p>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function enqueue_editor_assets() {
        wp_enqueue_style(
            'jankx-product-top-rated-editor',
            $this->get_block_url() . '/editor.css',
            [],
            Bootstrap::VERSION
        );
    }

    public function enqueue_frontend_assets() {
        // Sử dụng CSS của WooCommerce
        // Không cần enqueue CSS riêng vì đã tương thích
    }
}

// Auto-register the block
new ProductTopRated();
