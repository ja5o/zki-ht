import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import { SelectControl, TextControl } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

const BlockAreaDocumentSettingPanel = () => {
	// Get post type.
	const postType = useSelect(
		( select ) => select( 'core/editor' ).getCurrentPostType(),
		[]
	);

	const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );

	// return early if post type is not Block Area.
	if ( postType !== 'block_area' ) {
		return null;
	}

	const getPostMeta = ( key ) => meta[ key ] || '';

	const setPostMeta = ( key, value ) => {
		setMeta( {
			...meta,
			[ key ]: value,
		} );
	};

	const availableHooks = [
		{ value: '', label: __( 'Select a Hook', 'zki-ht' ), disabled: true },
		{ value: 'tha_body_top', label: 'Body Top' },
		{ value: 'tha_header_before', label: 'Header Before' },
		{ value: 'tha_header_after', label: 'Header After' },
		{ value: 'tha_content_top', label: 'Content Top' },
		{ value: 'tha_content_bottom', label: 'Content Bottom' },
		{ value: 'tha_entry_top', label: 'Entry Top' },
		{ value: 'tha_entry_bottom', label: 'Entry Bottom' },
		{ value: 'tha_entry_content_before', label: 'Entry Content Before' },
		{ value: 'tha_entry_content_after', label: 'Entry Content After' },
		{ value: 'tha_footer_top', label: 'Footer Top' },
		{ value: 'tha_footer_bottom', label: 'Footer Bottom' },
	];

	return (
		<PluginDocumentSettingPanel
			name="block-area-location"
			title={ __( 'Block Area Location', 'zki-ht' ) }
			className="block-area-location"
		>
			<SelectControl
				__next40pxDefaultSize
				label={ __( 'Hook Name', 'zki-ht' ) }
				options={ availableHooks }
				onChange={ ( value ) =>
					setPostMeta( 'block_area_hook', value )
				}
				value={ getPostMeta( 'block_area_hook' ) }
			/>
			<TextControl
				__next40pxDefaultSize
				__nextHasNoMarginBottom
				label={ __( 'Priority', 'zki-ht' ) }
				type="number"
				onChange={ ( value ) =>
					setPostMeta( 'block_area_priority', value )
				}
				value={ getPostMeta( 'block_area_priority' ) || 10 }
			/>
		</PluginDocumentSettingPanel>
	);
};

registerPlugin( 'zki-ht-block-area-setting-panel', {
	render: BlockAreaDocumentSettingPanel,
} );
