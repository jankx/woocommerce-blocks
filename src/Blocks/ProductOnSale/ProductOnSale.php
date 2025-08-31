<?php
/**
 * ProductOnSale Block - Tương thích với WooCommerce CSS
 *
 * @package Jankx\WooCommerce\Blocks
 */

namespace Jankx\WooCommerce\Blocks;

defined('ABSPATH') || exit;

class ProductOnSale extends AbstractBlock {
    protected $block_name = 'jankx/product-on-sale';
    protected $description = 'Hiển thị sản phẩm đang giảm giá';
    protected $keywords = ['products', 'sale', 'on-sale', 'jankx', 'woocommerce'];

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

        // Lấy sản phẩm đang giảm giá
        $product_ids_on_sale = wc_get_product_ids_on_sale();

        if (empty($product_ids_on_sale)) {
            return '<div class="jankx-block-product-on-sale-no-products">Không có sản phẩm nào đang giảm giá.</div>';
        }

        $args = [
            'post_type' => 'product',
            'posts_per_page' => $attributes['columns'] * $attributes['rows'],
            'post_status' => 'publish',
            'post__in' => $product_ids_on_sale,
            'orderby' => $attributes['orderBy'],
            'order' => $attributes['order'],
        ];

        // Filter theo categories nếu có
        if (!empty($attributes['categories'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $attributes['categories'],
                ],
            ];
        }

        $products = get_posts($args);
        $products = array_filter(array_map('wc_get_product', wp_list_pluck($products, 'ID')));

        if (empty($products)) {
            return '<div class="jankx-block-product-on-sale-no-products">Không có sản phẩm nào đang giảm giá.</div>';
        }

        // CSS classes tương thích với WooCommerce
        $wrapper_classes = [
            'jankx-block-product-on-sale',
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
            <ul class="wc-block-grid__products">
                <?php foreach ($products as $product): ?>
                    <li class="wc-block-grid__product">
                        <div class="wc-block-grid__product-image">
                            <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>">
                                <?php echo $product->get_image('woocommerce_thumbnail'); ?>
                            </a>
                            <?php if ($product->is_on_sale()): ?>
                                <span class="onsale">Giảm giá!</span>
                            <?php endif; ?>
                        </div>

                        <div class="wc-block-grid__product-title">
                            <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>">
                                <?php echo esc_html($product->get_name()); ?>
                            </a>
                        </div>

                        <div class="wc-block-grid__product-price">
                            <?php echo $product->get_price_html(); ?>
                        </div>

                        <div class="wc-block-grid__product-add-to-cart">
                            <?php
                            woocommerce_template_loop_add_to_cart([
                                'product' => $product,
                            ]);
                            ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }

    public function enqueue_editor_assets() {
        // Không cần enqueue JavaScript phức tạp
        // Chỉ cần CSS cơ bản cho editor
        wp_enqueue_style(
            'jankx-product-on-sale-editor',
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
new ProductOnSale();
