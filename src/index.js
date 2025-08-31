/**
 * Jankx WooCommerce Blocks - Main Entry Point
 */

import { registerBlockCollection } from '@wordpress/blocks';

import './assets/js/blocks/cart-checkout-shared';
import './assets/js/blocks/cart';
import './assets/js/blocks/product-on-sale';

// Register block collection
registerBlockCollection('jankx-woocommerce', {
    title: 'Jankx WooCommerce',
    icon: 'cart',
});
