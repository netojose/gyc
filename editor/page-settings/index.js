/**
 * Adds a "Header and footer" panel to the page and event sidebar with a toggle
 * that switches the site header and footer to dark on that page only.
 * The value is saved as the gyc_dark_header_footer post meta (see GycUI).
 */
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel, store as editorStore } from '@wordpress/editor';
import { ToggleControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';

const META_KEY = 'gyc_dark_header_footer';
const POST_TYPES = [ 'page', 'event' ];

function HeaderFooterPanel() {
    const postType = useSelect( ( select ) => select( editorStore ).getCurrentPostType(), [] );
    const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );

    if ( ! POST_TYPES.includes( postType ) || ! meta ) {
        return null;
    }

    return (
        <PluginDocumentSettingPanel name="gyc-header-footer" title="Header and footer">
            <ToggleControl
                label="Dark header and footer"
                help="Shows the site header and footer in dark purple on this page only."
                checked={ !! meta[ META_KEY ] }
                onChange={ ( value ) => setMeta( { ...meta, [ META_KEY ]: value } ) }
            />
        </PluginDocumentSettingPanel>
    );
}

registerPlugin( 'gyc-page-settings', { render: HeaderFooterPanel } );
