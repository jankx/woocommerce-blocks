# Jankx WooCommerce Blocks

WooCommerce Blocks for Jankx Framework - Fork và extension của WooCommerce Blocks plugin.

## 🚀 Giới thiệu

Package này fork toàn bộ WooCommerce Blocks plugin và tạo ra một hệ thống blocks hoàn chỉnh có thể hoạt động độc lập trong Jankx Framework. Điều này cho phép:

- **Sử dụng WooCommerce Blocks** mà không cần cài đặt plugin gốc
- **Customize và extend** các blocks theo nhu cầu
- **Tạo thêm blocks mới** dựa trên codebase sẵn có
- **Tối ưu performance** bằng cách chỉ load những blocks cần thiết

## 📦 Cấu trúc

```
jankx/woocommerce-blocks/
├── woocommerce-blocks-trunk/     # Plugin WooCommerce Blocks gốc
│   ├── src/                      # PHP classes gốc
│   ├── assets/js/blocks/         # JavaScript blocks gốc
│   └── assets/css/               # Styles gốc
├── src/                          # Custom implementation
│   ├── bootstrap/                # Bootstrap system
│   ├── Blocks/                   # Custom blocks
│   │   ├── AbstractBlock.php     # Base class cho blocks
│   │   ├── BlockRegistry.php     # Registry để quản lý blocks
│   │   └── ProductGrid/          # Example: Product Grid block
│   └── styles/                   # Shared styles
├── assets/js/blocks/             # Forked JavaScript blocks
├── build/                        # Built assets
├── composer.json                 # PHP dependencies
├── package.json                  # Node dependencies
└── webpack.config.js             # Build configuration
```

## 🛠️ Cài đặt

### 1. Via Composer
```bash
composer require jankx/woocommerce-blocks
```

### 2. Manual Installation
1. Download package
2. Đặt vào thư mục `vendor/jankx/woocommerce-blocks`
3. Include autoloader:

```php
require_once 'vendor/autoload.php';
```

## 📖 Sử dụng

### Auto-loading
Package tự động load khi được include qua composer autoloader:

```php
// Automatically loaded via composer.json files autoload
use Jankx\WooCommerce\Blocks\Bootstrap;
```

### Manual Bootstrap
```php
use Jankx\WooCommerce\Blocks\Bootstrap;

// Initialize the blocks system
Bootstrap::init();
```

### Tạo Custom Block
```php
use Jankx\WooCommerce\Blocks\AbstractBlock;

class MyCustomBlock extends AbstractBlock {
    protected $block_name = 'my-custom-block';
    protected $description = 'My custom WooCommerce block';

    public function render($attributes, $content) {
        return '<div class="my-custom-block">Custom content</div>';
    }
}

// Register the block
new MyCustomBlock();
```

## 🎨 Available Blocks

### Core Blocks (từ WooCommerce Blocks trunk)
- Product Grid
- Product Carousel
- Product Categories
- Cart & Checkout
- Mini Cart
- Product Search
- Product Filters
- và 80+ blocks khác...

### Custom Blocks (Jankx Extensions)
- **Product Grid** - Grid layout cho sản phẩm với nhiều options
- More blocks coming soon...

## 🔧 Development

### Build Assets
```bash
# Install dependencies
npm install

# Development build with watch
npm run dev

# Production build
npm run build

# Lint code
npm run lint:js
npm run lint:css
```

### Adding New Blocks

1. **Tạo PHP class**:
```php
// src/Blocks/MyBlock.php
class MyBlock extends AbstractBlock {
    protected $block_name = 'my-block';
    // Implementation...
}
```

2. **Tạo JavaScript**:
```javascript
// src/Blocks/MyBlock/index.js
import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import Save from './save';

registerBlockType('jankx/my-block', {
    edit: Edit,
    save: Save,
});
```

3. **Update webpack config**:
```javascript
// webpack.config.js
entry: {
    'my-block': './src/Blocks/MyBlock/index.js',
}
```

## 🎯 Features

### ✅ Đã implement
- [x] Bootstrap system để load blocks
- [x] Block registry để quản lý blocks
- [x] Abstract base class cho custom blocks
- [x] Product Grid block với full customization
- [x] Build system với webpack
- [x] SCSS styling system
- [x] Auto-loading via composer

### 🔄 Đang phát triển
- [ ] Copy toàn bộ blocks từ trunk
- [ ] Custom admin interface
- [ ] Block patterns library
- [ ] Theme integration helpers
- [ ] Advanced filtering system

### 🚀 Kế hoạch tương lai
- [ ] Block variations system
- [ ] Custom post type blocks
- [ ] Advanced WooCommerce integrations
- [ ] Performance optimizations
- [ ] Multi-language support

## 🔗 Dependencies

### PHP Requirements
- PHP >= 7.4
- WordPress >= 5.8
- WooCommerce >= 6.0

### JavaScript Dependencies
- @wordpress/blocks
- @wordpress/block-editor
- @wordpress/components
- @wordpress/element
- @wordpress/i18n

## 📝 Documentation

- [Block Development Guide](docs/block-development.md)
- [Customization Guide](docs/customization.md)
- [API Reference](docs/api-reference.md)
- [Examples](docs/examples.md)

## 🤝 Contributing

1. Fork repository
2. Tạo feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📄 License

GPL-3.0-or-later - tương thích với WooCommerce Blocks gốc

## 👥 Authors

- **Puleeno Nguyen** - *Initial work* - [puleeno@gmail.com](mailto:puleeno@gmail.com)

## 🙏 Acknowledgments

- WooCommerce team cho WooCommerce Blocks plugin gốc
- WordPress Gutenberg team cho block editor framework
- Jankx Framework community
