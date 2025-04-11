module.exports = {
	plugins: [
		require( 'postcss-import' ),
		require( 'postcss-mixins' )( {
			mixins: {
				'a11y-padding': (
					mixin,
					top,
					right,
					bottom = '',
					left = ''
				) => {
					const topVal = top / 16;
					const bottomVal = bottom ? bottom / 16 : topVal;
					const leftVal = left || right;
					return {
						'&': {
							padding: `${ topVal }rem ${ right }px ${ bottomVal }rem ${ leftVal }px`,
						},
					};
				},
				'a11y-margin': (
					mixin,
					top,
					right,
					bottom = '',
					left = ''
				) => {
					const topVal = top / 16;
					const bottomVal = bottom ? bottom / 16 : topVal;
					const leftVal = left || right;
					return {
						'&': {
							marginTop: `${ topVal }rem`,
							marginRight: isNaN( right )
								? right
								: `${ right }px`,
							marginBottom: `${ bottomVal }rem`,
							marginLeft: isNaN( leftVal )
								? leftVal
								: `${ leftVal }px`,
						},
					};
				},
			},
		} ),
		require( 'postcss-nested' ),
		require( 'postcss-preset-env' )( {
			autoprefixer: true,
			stage: 2,
			features: {
				'nesting-rules': true,
				'custom-media-queries': true,
				'custom-selectors': true,
			},
		} ),
		require( 'autoprefixer' ),
		require( 'cssnano' )( {
			preset: 'default',
		} ),
	],
};
