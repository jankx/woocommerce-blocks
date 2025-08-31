/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import classnames from 'classnames';
import { InnerBlocks } from '@wordpress/block-editor';
import { cart } from '@jankx/icons';
import { Icon } from '@wordpress/icons';
import { registerBlockType, createBlock } from '@wordpress/blocks';
/**
 * Internal dependencies
 */
import { Edit, Save } from './edit';
import './style.scss';
import { blockName, blockAttributes } from './attributes';
import './inner-blocks';

/**
 * Register and run the Cart block.
 */
const settings = {
	title: __( 'Cart', 'jankx-woocommerce-blocks' ),
	icon: {
		src: (
			<Icon
				icon={ cart }
				className="jankx-block-editor-components-block-icon"
			/>
		),
	},
	category: 'jankx-woocommerce',
	keywords: [ __( 'WooCommerce', 'jankx-woocommerce-blocks' ) ],
	description: __( 'Shopping cart.', 'jankx-woocommerce-blocks' ),
	supports: {
		align: [ 'wide' ],
		html: false,
		multiple: false,
	},
	example: {
		attributes: {
			isPreview: true,
		},
		viewportWidth: 800,
	},
	attributes: blockAttributes,
	edit: Edit,
	save: Save,
	transforms: {
		to: [
			{
				type: 'block',
				blocks: [ 'jankx/classic-shortcode' ],
				transform: ( attributes ) => {
					return createBlock(
						'jankx/classic-shortcode',
						{
							shortcode: 'cart',
							align: attributes.align,
						},
						[]
					);
				},
			},
		],
	},
	// Migrates v1 to v2 checkout.
	deprecated: [
		{
			attributes: blockAttributes,
			save: ( { attributes } ) => {
				return (
					<div
						className={ classnames(
							'is-loading',
							attributes.className
						) }
					>
						<InnerBlocks.Content />
					</div>
				);
			},
			migrate: ( attributes, innerBlocks ) => {
				const { checkoutPageId, align } = attributes;
				return [
					attributes,
					[
						createBlock(
							'jankx/filled-cart-block',
							{ align },
							[
								createBlock( 'jankx/cart-items-block' ),
								createBlock(
									'jankx/cart-totals-block',
									{},
									[
										createBlock(
											'jankx/cart-order-summary-block',
											{}
										),
										createBlock(
											'jankx/cart-express-payment-block'
										),
										createBlock(
											'jankx/proceed-to-checkout-block',
											{ checkoutPageId }
										),
										createBlock(
											'jankx/cart-accepted-payment-methods-block'
										),
									]
								),
							]
						),
						createBlock(
							'jankx/empty-cart-block',
							{ align },
							innerBlocks
						),
					],
				];
			},
			isEligible: ( _, innerBlocks ) => {
				return ! innerBlocks.find(
					( block ) => block.name === 'jankx/filled-cart-block'
				);
			},
		},
	],
};

registerBlockType( blockName, settings );
