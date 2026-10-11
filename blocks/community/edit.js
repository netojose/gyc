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
    const { eyebrow, title, text, buttonLabel, buttonUrl, map, mapAlt, collage, collageAlt } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Community">
                    <div className="gyc-community-fields-wrapper">
                        <TextControl
                            label="Eyebrow"
                            value={ eyebrow || '' }
                            onChange={ ( newValue ) => setAttributes( { eyebrow: newValue } ) }
                        />
                        <TextareaControl
                            label="Title"
                            help="Use a new line to break the title."
                            rows={2}
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
                            label="Map image URL"
                            value={ map || '' }
                            onChange={ ( newValue ) => setAttributes( { map: newValue } ) }
                        />
                        <TextControl
                            label="Map alt text"
                            help="For example: Map of Europe highlighting the countries GYC is present in."
                            value={ mapAlt || '' }
                            onChange={ ( newValue ) => setAttributes( { mapAlt: newValue } ) }
                        />
                        <TextControl
                            label="Photo collage image URL"
                            help="One image with the photos and the handwritten note already in it."
                            value={ collage || '' }
                            onChange={ ( newValue ) => setAttributes( { collage: newValue } ) }
                        />
                        <TextControl
                            label="Photo collage alt text"
                            help="Describe the photos and include the handwritten words, e.g. Young people from GYC events. Note: Different languages. Different cultures. One faith."
                            value={ collageAlt || '' }
                            onChange={ ( newValue ) => setAttributes( { collageAlt: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
