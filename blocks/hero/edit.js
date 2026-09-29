import {
    TextControl,
    TextareaControl,
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
    const { eyebrow, title, text, buttonLabel, buttonUrl, image, imageAlt, tagline } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Hero">
                    <div className="gyc-hero-fields-wrapper">
                        <TextControl
                            label="Eyebrow"
                            value={ eyebrow || '' }
                            onChange={ ( newValue ) => setAttributes( { eyebrow: newValue } ) }
                        />
                        <TextControl
                            label="Title"
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />
                        <TextareaControl
                            label="Text"
                            rows={4}
                            value={ text || '' }
                            onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                        />
                        <TextControl
                            label="Button label"
                            value={ buttonLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { buttonLabel: newValue } ) }
                        />
                        <TextControl
                            label="Button link"
                            help="Full URL, site path like /register/, a section like #community, or an email address."
                            value={ buttonUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { buttonUrl: newValue } ) }
                        />
                        <TextControl
                            label="Image URL"
                            value={ image || '' }
                            onChange={ ( newValue ) => setAttributes( { image: newValue } ) }
                        />
                        <TextControl
                            label="Image alt text"
                            help="Describe the photo for screen readers. Leave empty if it is purely decorative."
                            value={ imageAlt || '' }
                            onChange={ ( newValue ) => setAttributes( { imageAlt: newValue } ) }
                        />
                        <TextareaControl
                            label="Handwritten tagline"
                            help="One phrase per line."
                            rows={3}
                            value={ tagline || '' }
                            onChange={ ( newValue ) => setAttributes( { tagline: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
