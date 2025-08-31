<?php
/**
 * Auto-generated blocks index
 *
 * This file automatically loads all adapted WooCommerce blocks
 */

namespace Jankx\WooCommerce\Blocks;

defined('ABSPATH') || exit;

// Load abstract classes first
require_once __DIR__ . '/AbstractBlock.php';
require_once __DIR__ . '/AbstractDynamicBlock.php';
require_once __DIR__ . '/AbstractInnerBlock.php';
require_once __DIR__ . '/AbstractProductGrid.php';

// Load only the specified blocks
$block_files = [
    // All Reviews
    'AllReviews.php',

    // Product Search
    'ProductSearch.php',

    // Store Breadcrumbs
    'Breadcrumbs.php',

    // Cart Link (Cart button)
    'CartButton.php',

    // Catalog Sorting
    'CatalogSorting.php',

    // Classic Checkout
    'ClassicCheckout.php',

    // Classic Cart
    'ClassicCart.php',

    // Customer account
    'CustomerAccount.php',

                // Featured Products (FeaturedItem) - must be loaded first
    'FeaturedItem.php',

    // Featured Product
    'FeaturedProduct.php',

    // Featured Category
    'FeaturedCategory.php',

    // Mini-Cart
    'MiniCart.php',

    // Store Notices
    'StoreNotices.php',

    // Payment Method Icons (CartAcceptedPaymentMethodsBlock)
    'CartAcceptedPaymentMethodsBlock.php',

    // Product Categories List
    'ProductCategories.php',

    // Product Collection
    'ProductCollection.php',

    // Featured Products (FeaturedItem)
    'FeaturedItem.php',

    // New Arrivals (ProductNew)
    'ProductNew.php',

    // On Sale Products (ProductOnSale)
    'ProductOnSale.php',

    // Best Sellers (ProductBestSellers)
    'ProductBestSellers.php',

    // Top Rated Products (ProductTopRated)
    'ProductTopRated.php',

    // Hand-Picked Products
    'HandpickedProducts.php',

    // Products by Category (ProductCategory)
    'ProductCategory.php',

    // Products by Tag (ProductTag)
    'ProductTag.php',

    // Related Products
    'RelatedProducts.php',

    // Upsells (CartCrossSellsBlock)
    'CartCrossSellsBlock.php',

    // Cross-Sells (CartCrossSellsProductsBlock)
    'CartCrossSellsProductsBlock.php',

    // Product Filters (CollectionFilters)
    'CollectionFilters.php',

    // Product Results Count
    'ProductResultsCount.php',

    // Reviews by Category
    'ReviewsByCategory.php',

    // Reviews by Product
    'ReviewsByProduct.php',

    // Product (SingleProduct)
    'SingleProduct.php',

    // Order Status (CheckoutOrderSummaryBlock)
    'CheckoutOrderSummaryBlock.php',

    // Order Summary (CheckoutOrderSummaryCartItemsBlock)
    'CheckoutOrderSummaryCartItemsBlock.php',

    // Order Totals (CheckoutTotalsBlock)
    'CheckoutTotalsBlock.php',

    // Order Totals Section (CartTotalsBlock)
    'CartTotalsBlock.php',

    // Order Downloads (CheckoutOrderSummaryBlock)
    'CheckoutOrderSummaryBlock.php',

    // Downloads Section (CheckoutOrderSummaryBlock)
    'CheckoutOrderSummaryBlock.php',

    // Billing Address Section (CheckoutBillingAddressBlock)
    'CheckoutBillingAddressBlock.php',

    // Shipping (CheckoutShippingAddressBlock)
    'CheckoutShippingAddressBlock.php',

    // Additional Information (CheckoutFieldsBlock)
    'CheckoutFieldsBlock.php',

    // Additional Fields (CheckoutFieldsBlock)
    'CheckoutFieldsBlock.php',

    // Additional Field List (CheckoutFieldsBlock)
    'CheckoutFieldsBlock.php',

    // Accordion Group (CheckoutFieldsBlock)
    'CheckoutFieldsBlock.php',

    // Reviews Form (ProductReviews)
    'ProductReviews.php',

    // Cart (Cart.php)
    'Cart.php',

    // Checkout
    'Checkout.php',
];

// Load only files that exist
foreach ($block_files as $file) {
    $file_path = __DIR__ . '/' . $file;
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}
