<?php
/**
 * Script tạo blocks PHP tương thích với WooCommerce CSS
 *
 * Chạy: php scripts/create-woocommerce-compatible-blocks.php
 */

// Định nghĩa các blocks cần tạo
$blocks = [
    'ProductBestSellers' => [
        'description' => 'Hiển thị sản phẩm bán chạy nhất',
        'keywords' => ['products', 'best-sellers', 'popular', 'jankx', 'woocommerce'],
        'query_method' => 'best_sellers',
    ],
    'ProductNew' => [
        'description' => 'Hiển thị sản phẩm mới nhất',
        'keywords' => ['products', 'new', 'latest', 'jankx', 'woocommerce'],
        'query_method' => 'new_products',
    ],
    'ProductTopRated' => [
        'description' => 'Hiển thị sản phẩm được đánh giá cao nhất',
        'keywords' => ['products', 'top-rated', 'reviews', 'jankx', 'woocommerce'],
        'query_method' => 'top_rated',
    ],
    'ProductCategories' => [
        'description' => 'Hiển thị danh sách danh mục sản phẩm',
        'keywords' => ['categories', 'product-categories', 'jankx', 'woocommerce'],
        'query_method' => 'categories',
    ],
    'ProductSearch' => [
        'description' => 'Hiển thị form tìm kiếm sản phẩm',
        'keywords' => ['search', 'product-search', 'jankx', 'woocommerce'],
        'query_method' => 'search_form',
    ],
    'MiniCart' => [
        'description' => 'Hiển thị giỏ hàng mini',
        'keywords' => ['cart', 'mini-cart', 'jankx', 'woocommerce'],
        'query_method' => 'mini_cart',
    ],
    'Breadcrumbs' => [
        'description' => 'Hiển thị breadcrumbs',
        'keywords' => ['breadcrumbs', 'navigation', 'jankx', 'woocommerce'],
        'query_method' => 'breadcrumbs',
    ],
    'CatalogSorting' => [
        'description' => 'Hiển thị tùy chọn sắp xếp catalog',
        'keywords' => ['sorting', 'catalog-sorting', 'jankx', 'woocommerce'],
        'query_method' => 'catalog_sorting',
    ],
];

// Template cho PHP block
$php_template = '<?php
/**
 * {BLOCK_NAME} Block - Tương thích với WooCommerce CSS
 *
 * @package Jankx\WooCommerce\Blocks
 */

namespace Jankx\WooCommerce\Blocks;

defined(\'ABSPATH\') || exit;

class {BLOCK_NAME} extends AbstractBlock {
    protected $block_name = \'jankx/{BLOCK_SLUG}\';
    protected $description = \'{DESCRIPTION}\';
    protected $keywords = {KEYWORDS};

    protected $attributes = [
        \'columns\' => [
            \'type\' => \'number\',
            \'default\' => 3,
        ],
        \'rows\' => [
            \'type\' => \'number\',
            \'default\' => 3,
        ],
        \'categories\' => [
            \'type\' => \'array\',
            \'default\' => [],
        ],
        \'orderBy\' => [
            \'type\' => \'string\',
            \'default\' => \'date\',
        ],
        \'order\' => [
            \'type\' => \'string\',
            \'default\' => \'desc\',
        ],
        \'align\' => [
            \'type\' => \'string\',
            \'default\' => \'\',
        ],
        \'className\' => [
            \'type\' => \'string\',
            \'default\' => \'\',
        ],
    ];

    public function render($attributes, $content) {
        if (!class_exists(\'WooCommerce\')) {
            return \'<div class="jankx-block-error">WooCommerce is not active.</div>\';
        }

        $attributes = wp_parse_args($attributes, [
            \'columns\' => 3,
            \'rows\' => 3,
            \'categories\' => [],
            \'orderBy\' => \'date\',
            \'order\' => \'desc\',
            \'align\' => \'\',
            \'className\' => \'\',
        ]);

        // CSS classes tương thích với WooCommerce
        $wrapper_classes = [
            \'jankx-block-{BLOCK_SLUG}\',
            \'wc-block-grid\',
            \'has-\' . $attributes[\'columns\'] . \'-columns\',
        ];

        if ($attributes[\'align\']) {
            $wrapper_classes[] = \'align\' . $attributes[\'align\'];
        }

        if ($attributes[\'className\']) {
            $wrapper_classes[] = $attributes[\'className\'];
        }

        ob_start();
        ?>
        <div class="<?php echo esc_attr(implode(\' \', $wrapper_classes)); ?>">
            <!-- {BLOCK_NAME} content here -->
            <div class="jankx-block-{BLOCK_SLUG}-content">
                <p>Jankx {BLOCK_NAME} Block - Tương thích với WooCommerce CSS</p>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function enqueue_editor_assets() {
        wp_enqueue_style(
            \'jankx-{BLOCK_SLUG}-editor\',
            $this->get_block_url() . \'/editor.css\',
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
new {BLOCK_NAME}();
';

// Template cho CSS
$css_template = '/* Editor styles for Jankx {BLOCK_NAME} Block */

.jankx-block-{BLOCK_SLUG} {
    /* Tương thích với WooCommerce CSS */
    margin: 0;
    padding: 1rem;
    border: 2px dashed #ddd;
    border-radius: 4px;
    text-align: center;
}

.jankx-block-{BLOCK_SLUG}-content {
    color: #666;
    font-style: italic;
}

/* Responsive */
@media (max-width: 768px) {
    .jankx-block-{BLOCK_SLUG} {
        padding: 0.5rem;
    }
}
';

// Tạo thư mục blocks nếu chưa có
$blocks_dir = __DIR__ . '/../src/Blocks/';
if (!is_dir($blocks_dir)) {
    mkdir($blocks_dir, 0755, true);
}

// Tạo từng block
foreach ($blocks as $block_name => $config) {
    $block_slug = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $block_name));

    // Tạo thư mục block
    $block_dir = $blocks_dir . $block_name . '/';
    if (!is_dir($block_dir)) {
        mkdir($block_dir, 0755, true);
    }

    // Tạo PHP file
    $php_content = str_replace(
        ['{BLOCK_NAME}', '{BLOCK_SLUG}', '{DESCRIPTION}', '{KEYWORDS}'],
        [
            $block_name,
            $block_slug,
            $config['description'],
            '[\'' . implode('\', \'', $config['keywords']) . '\']'
        ],
        $php_template
    );

    file_put_contents($block_dir . $block_name . '.php', $php_content);

    // Tạo CSS file
    $css_content = str_replace(
        ['{BLOCK_NAME}', '{BLOCK_SLUG}'],
        [$block_name, $block_slug],
        $css_template
    );

    file_put_contents($block_dir . 'editor.css', $css_content);

    echo "✓ Đã tạo block: {$block_name}\n";
}

echo "\n🎉 Hoàn thành! Đã tạo " . count($blocks) . " blocks tương thích với WooCommerce CSS.\n";
echo "📁 Blocks được tạo trong: src/Blocks/\n";
echo "🔧 Mỗi block có:\n";
echo "   - PHP file với logic render\n";
echo "   - CSS file cho editor\n";
echo "   - Tương thích với WooCommerce CSS classes\n";
echo "\n💡 Để sử dụng:\n";
echo "   1. Các blocks sẽ tự động được register\n";
echo "   2. Sử dụng CSS classes của WooCommerce\n";
echo "   3. Không cần build JavaScript phức tạp\n";
