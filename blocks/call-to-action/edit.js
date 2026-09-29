import {
    TextControl,
    TextareaControl,
    SelectControl,
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
    const { titleTop, title, text, variant, buttonLabel, buttonUrl } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Call to Action">
                    <div className="gyc-call-to-action-fields-wrapper">
                        <TextControl
                            label="Title – first line"
                            value={ titleTop || '' }
                            onChange={ ( newValue ) => setAttributes( { titleTop: newValue } ) }
                        />
                        <TextControl
                            label="Title – second line"
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />
                        <TextareaControl
                            label="Text"
                            rows={2}
                            value={ text || '' }
                            onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                        />
                        <SelectControl
                            label="Style"
                            value={ variant || 'light' }
                            options={ [
                                { label: 'Light background, mint button', value: 'light' },
                                { label: 'Mint background, dark button', value: 'mint' },
                            ] }
                            onChange={ ( newValue ) => setAttributes( { variant: newValue } ) }
                        />
                        <TextControl
                            label="Button label"
                            value={ buttonLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { buttonLabel: newValue } ) }
                        />
                        <TextControl
                            label="Button link"
                            help="Full URL, site path like /about, or a section on this page like #give."
                            value={ buttonUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { buttonUrl: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
