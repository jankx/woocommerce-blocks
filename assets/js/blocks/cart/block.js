/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { useStoreCart } from '@jankx/base-context/hooks';
import { useEffect } from '@wordpress/element';
import LoadingMask from '@jankx/base-components/loading-mask';
import { CURRENT_USER_IS_ADMIN } from '@jankx/settings';
import BlockErrorBoundary from '@jankx/base-components/block-error-boundary';
import { translateJQueryEventToNative } from '@jankx/base-utils';
import withScrollToTop from '@jankx/base-hocs/with-scroll-to-top';
import {
	CartEventsProvider,
	CartProvider,
	noticeContexts,
} from '@jankx/base-context';
import { SlotFillProvider } from '@jankx/blocks-checkout';
import { StoreNoticesContainer } from '@jankx/blocks-components';

/**
 * Internal dependencies
 */
import { CartBlockContext } from './context';
import './style.scss';

const reloadPage = () => void window.location.reload( true );

const Cart = ( { children, attributes = {} } ) => {
	const { cartIsLoading } = useStoreCart();
	const { hasDarkControls } = attributes;

	return (
		<LoadingMask showSpinner={ true } isLoading={ cartIsLoading }>
			<CartBlockContext.Provider
				value={ {
					hasDarkControls,
				} }
			>
				{ children }
			</CartBlockContext.Provider>
		</LoadingMask>
	);
};

const ScrollOnError = ( { scrollToTop } ) => {
	useEffect( () => {
		// Make it so we can read jQuery events triggered by WC Core elements.
		const removeJQueryAddedToCartEvent = translateJQueryEventToNative(
			'added_to_cart',
			'jankx-blocks_added_to_cart'
		);

		document.body.addEventListener(
			'jankx-blocks_added_to_cart',
			scrollToTop
		);

		return () => {
			removeJQueryAddedToCartEvent();

			document.body.removeEventListener(
				'jankx-blocks_added_to_cart',
				scrollToTop
			);
		};
	}, [ scrollToTop ] );

	return null;
};
const Block = ( { attributes, children, scrollToTop } ) => (
	<BlockErrorBoundary
		header={ __(
			'Something went wrong. Please contact us for assistance.',
			'jankx-woocommerce-blocks'
		) }
		text={ __(
			'The cart has encountered an unexpected error. If the error persists, please get in touch with us for help.',
			'jankx-woocommerce-blocks'
		) }
		button={
			<button className="jankx-block-button" onClick={ reloadPage }>
				{ __( 'Reload the page', 'jankx-woocommerce-blocks' ) }
			</button>
		}
		showErrorMessage={ CURRENT_USER_IS_ADMIN }
	>
		<StoreNoticesContainer context={ noticeContexts.CART } />
		<SlotFillProvider>
			<CartProvider>
				<CartEventsProvider>
					<Cart attributes={ attributes }>{ children }</Cart>
					<ScrollOnError scrollToTop={ scrollToTop } />
				</CartEventsProvider>
			</CartProvider>
		</SlotFillProvider>
	</BlockErrorBoundary>
);
export default withScrollToTop( Block );
