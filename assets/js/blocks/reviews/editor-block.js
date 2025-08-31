/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { Component } from '@wordpress/element';
import PropTypes from 'prop-types';
import { Disabled } from '@wordpress/components';
import { getSetting } from '@jankx/settings';
import ErrorPlaceholder from '@jankx/editor-components/error-placeholder';
import LoadMoreButton from '@jankx/base-components/load-more-button';
import {
	ReviewList,
	ReviewSortSelect,
} from '@jankx/base-components/reviews';
import withReviews from '@jankx/base-hocs/with-reviews';

/**
 * Block rendered in the editor.
 */
class EditorBlock extends Component {
	static propTypes = {
		/**
		 * The attributes for this block.
		 */
		attributes: PropTypes.object.isRequired,
		// from withReviews
		reviews: PropTypes.array,
		totalReviews: PropTypes.number,
	};

	render() {
		const {
			attributes,
			error,
			isLoading,
			noReviewsPlaceholder: NoReviewsPlaceholder,
			reviews,
			totalReviews,
		} = this.props;

		if ( error ) {
			return (
				<ErrorPlaceholder
					className="jankx-block-featured-product-error"
					error={ error }
					isLoading={ isLoading }
				/>
			);
		}

		if ( reviews.length === 0 && ! isLoading ) {
			return <NoReviewsPlaceholder attributes={ attributes } />;
		}

		const reviewRatingsEnabled = getSetting( 'reviewRatingsEnabled', true );

		return (
			<Disabled>
				{ attributes.showOrderby && reviewRatingsEnabled && (
					<ReviewSortSelect
						readOnly
						value={ attributes.orderby }
						onChange={ () => null }
					/>
				) }
				<ReviewList attributes={ attributes } reviews={ reviews } />
				{ attributes.showLoadMore && totalReviews > reviews.length && (
					<LoadMoreButton
						screenReaderLabel={ __(
							'Load more reviews',
							'jankx-woocommerce-blocks'
						) }
					/>
				) }
			</Disabled>
		);
	}
}

export default withReviews( EditorBlock );
