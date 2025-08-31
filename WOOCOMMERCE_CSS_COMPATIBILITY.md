# 🎨 Tương thích với WooCommerce CSS

## 📋 Tổng quan

Package này được thiết kế để **tương thích hoàn toàn với WooCommerce CSS** thay vì phải build lại JavaScript phức tạp. Điều này cho phép:

- ✅ **Sử dụng ngay** mà không cần build
- ✅ **Tương thích 100%** với WooCommerce CSS classes
- ✅ **Dễ dàng customize** và extend
- ✅ **Hiệu suất cao** vì không cần JavaScript phức tạp

## 🏗️ Kiến trúc

### PHP Blocks
- **Render HTML** với WooCommerce CSS classes
- **Tự động register** khi load
- **Tương thích** với Gutenberg editor

### CSS Classes
- **Sử dụng** `wc-block-grid`, `wc-block-grid__product`, etc.
- **Tương thích** với WooCommerce theme
- **Responsive** và accessible

## 📁 Cấu trúc Block

```
src/Blocks/
├── ProductOnSale/
│   ├── ProductOnSale.php      # Logic render
│   └── editor.css            # CSS cho editor
├── ProductBestSellers/
│   ├── ProductBestSellers.php
│   └── editor.css
└── ...
```

## 🔧 Cách sử dụng

### 1. Blocks có sẵn

Các blocks đã được tạo sẵn:

- `jankx/product-on-sale` - Sản phẩm giảm giá
- `jankx/product-best-sellers` - Sản phẩm bán chạy
- `jankx/product-new` - Sản phẩm mới
- `jankx/product-top-rated` - Sản phẩm đánh giá cao
- `jankx/product-categories` - Danh mục sản phẩm
- `jankx/product-search` - Tìm kiếm sản phẩm
- `jankx/mini-cart` - Giỏ hàng mini
- `jankx/breadcrumbs` - Breadcrumbs
- `jankx/catalog-sorting` - Sắp xếp catalog

### 2. Sử dụng trong Gutenberg

```php
// Trong Gutenberg editor
<!-- wp:jankx/product-on-sale {
    "columns": 3,
    "rows": 2,
    "align": "wide"
} /-->
```

### 3. Sử dụng trong PHP

```php
// Render block trong PHP
echo do_blocks('<!-- wp:jankx/product-on-sale {"columns": 4} /-->');
```

## 🎨 CSS Classes

### Grid Layout
```css
.jankx-block-product-on-sale {
    /* Tương thích với WooCommerce */
}

.wc-block-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.wc-block-grid__product {
    /* Product item styling */
}
```

### Responsive
```css
/* Tự động responsive với WooCommerce */
.has-3-columns {
    grid-template-columns: repeat(3, 1fr);
}

@media (max-width: 768px) {
    .has-3-columns {
        grid-template-columns: repeat(2, 1fr);
    }
}
```

## 🚀 Tạo Block mới

### 1. Sử dụng script tự động

```bash
# Chỉnh sửa script và chạy
php scripts/create-woocommerce-compatible-blocks.php
```

### 2. Tạo thủ công

```php
<?php
namespace Jankx\WooCommerce\Blocks;

class MyCustomBlock extends AbstractBlock {
    protected $block_name = 'jankx/my-custom-block';

    public function render($attributes, $content) {
        // CSS classes tương thích với WooCommerce
        $wrapper_classes = [
            'jankx-block-my-custom-block',
            'wc-block-grid',
            'has-' . $attributes['columns'] . '-columns',
        ];

        ob_start();
        ?>
        <div class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>">
            <!-- Content here -->
        </div>
        <?php
        return ob_get_clean();
    }
}

new MyCustomBlock();
```

## 🔄 So sánh với JavaScript Blocks

| Tính năng | PHP Blocks | JavaScript Blocks |
|-----------|------------|-------------------|
| **Setup** | ✅ Đơn giản | ❌ Phức tạp |
| **Build** | ✅ Không cần | ❌ Cần webpack |
| **CSS** | ✅ Tương thích 100% | ❌ Cần build riêng |
| **Performance** | ✅ Nhanh | ❌ Chậm hơn |
| **Customize** | ✅ Dễ dàng | ❌ Phức tạp |
| **Dependencies** | ✅ Ít | ❌ Nhiều |

## 🎯 Lợi ích

### 1. **Đơn giản**
- Không cần build JavaScript
- Không cần webpack config
- Không cần npm dependencies

### 2. **Tương thích**
- Sử dụng CSS classes của WooCommerce
- Responsive tự động
- Accessible theo chuẩn WCAG

### 3. **Hiệu suất**
- Load nhanh hơn
- Ít JavaScript
- SEO friendly

### 4. **Dễ customize**
- Chỉ cần edit PHP
- CSS dễ override
- Logic đơn giản

## 🔧 Customization

### Override CSS
```css
/* Trong theme CSS */
.jankx-block-product-on-sale .wc-block-grid__product {
    border: 2px solid #ff4444;
    border-radius: 8px;
}
```

### Extend Block
```php
class CustomProductOnSale extends ProductOnSale {
    public function render($attributes, $content) {
        // Custom logic here
        return parent::render($attributes, $content);
    }
}
```

## 📚 Ví dụ thực tế

### Product Grid với Sale Badge
```php
<div class="jankx-block-product-on-sale wc-block-grid has-3-columns">
    <ul class="wc-block-grid__products">
        <li class="wc-block-grid__product">
            <div class="wc-block-grid__product-image">
                <a href="/product/example">
                    <img src="product-image.jpg" alt="Product">
                </a>
                <span class="onsale">Giảm giá!</span>
            </div>
            <div class="wc-block-grid__product-title">
                <a href="/product/example">Product Name</a>
            </div>
            <div class="wc-block-grid__product-price">
                <span class="price">$99.00</span>
            </div>
        </li>
    </ul>
</div>
```

## 🎉 Kết luận

Approach này cho phép bạn:

1. **Sử dụng ngay** WooCommerce Blocks mà không cần build
2. **Tương thích 100%** với WooCommerce CSS
3. **Dễ dàng customize** và extend
4. **Hiệu suất cao** và SEO friendly

Đây là cách tiếp cận **thông minh và hiệu quả** để sử dụng WooCommerce Blocks trong Jankx Framework! 🚀
