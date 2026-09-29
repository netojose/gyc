import {
    TextControl,
    TextareaControl,
    ToggleControl,
    Panel,
    PanelBody
} from '@wordpress/components';

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
    const { eyebrow, title, text, showSearch, searchLabel, searchPlaceholder } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Page Hero">
                    <div className="gyc-page-hero-fields-wrapper">
                        <TextControl
                            label="Eyebrow"
                            value={ eyebrow || '' }
                            onChange={ ( newValue ) => setAttributes( { eyebrow: newValue } ) }
                        />
                        <TextControl
                            label="Title"
                            help="The page's main heading."
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />
                        <TextareaControl
                            label="Text"
                            rows={3}
                            value={ text || '' }
                            onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                        />
                        <ToggleControl
                            label="Show search"
                            help="Searches the FAQ block on the same page."
                            checked={ !! showSearch }
                            onChange={ ( newValue ) => setAttributes( { showSearch: newValue } ) }
                        />
                        { showSearch && (
                            <>
                                <TextControl
                                    label="Search placeholder"
                                    value={ searchPlaceholder || '' }
                                    onChange={ ( newValue ) => setAttributes( { searchPlaceholder: newValue } ) }
                                />
                                <TextControl
                                    label="Search label"
                                    help="Read out by screen readers."
                                    value={ searchLabel || '' }
                                    onChange={ ( newValue ) => setAttributes( { searchLabel: newValue } ) }
                                />
                            </>
                        ) }
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
