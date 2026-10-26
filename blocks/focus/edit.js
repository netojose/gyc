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
    const { eyebrow, title, text, buttonLabel, buttonUrl, imageType, logo, logoAlt } = attributes;
    const isLogo = imageType === 'logo';

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Focus">
                    <div className="gyc-focus-fields-wrapper">
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
                            rows={3}
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
                            help="The GYC Focus website. Links to other websites open in a new tab."
                            value={ buttonUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { buttonUrl: newValue } ) }
                        />
                        <SelectControl
                            label="Image type"
                            value={ isLogo ? 'logo' : 'picture' }
                            options={ [
                                { label: 'Picture – fills the box', value: 'picture' },
                                { label: 'Logo – fitted on a white card', value: 'logo' },
                            ] }
                            onChange={ ( newValue ) => setAttributes( { imageType: newValue } ) }
                        />
                        <TextControl
                            label={ isLogo ? 'Logo URL' : 'Picture URL' }
                            help={ isLogo
                                ? 'The whole logo is shown, centred on a white card with space around it. The card only appears once this is filled in.'
                                : 'The picture fills a rounded box twice as wide as it is tall; edges are cropped if its shape differs. The box only appears once this is filled in.' }
                            value={ logo || '' }
                            onChange={ ( newValue ) => setAttributes( { logo: newValue } ) }
                        />
                        <TextControl
                            label={ isLogo ? 'Logo alt text' : 'Picture alt text' }
                            value={ logoAlt || '' }
                            onChange={ ( newValue ) => setAttributes( { logoAlt: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
