/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { ToggleControl, SelectControl } from '@wordpress/components';

export const getSharedContentControls = ( attributes, setAttributes ) => {
	const { contentVisibility } = attributes;
	return (
		<ToggleControl
			label={ __(
				'Show Sorting Dropdown',
				'jankx-woocommerce-blocks'
			) }
			checked={ contentVisibility.orderBy }
			onChange={ () =>
				setAttributes( {
					contentVisibility: {
						...contentVisibility,
						orderBy: ! contentVisibility.orderBy,
					},
				} )
			}
		/>
	);
};

export const getSharedListControls = ( attributes, setAttributes ) => {
	return (
		<SelectControl
			label={ __( 'Order Products By', 'jankx-woocommerce-blocks' ) }
			value={ attributes.orderby }
			options={ [
				{
					label: __(
						'Default sorting (menu order)',
						'jankx-woocommerce-blocks'
					),
					value: 'menu_order',
				},
				{
					label: __( 'Popularity', 'jankx-woocommerce-blocks' ),
					value: 'popularity',
				},
				{
					label: __(
						'Average rating',
						'jankx-woocommerce-blocks'
					),
					value: 'rating',
				},
				{
					label: __( 'Latest', 'jankx-woocommerce-blocks' ),
					value: 'date',
				},
				{
					label: __(
						'Price: low to high',
						'jankx-woocommerce-blocks'
					),
					value: 'price',
				},
				{
					label: __(
						'Price: high to low',
						'jankx-woocommerce-blocks'
					),
					value: 'price-desc',
				},
			] }
			onChange={ ( orderby ) => setAttributes( { orderby } ) }
		/>
	);
};
