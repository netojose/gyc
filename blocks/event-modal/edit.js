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
    const { active, image, eyebrow, title, titleHighlight, notice, whereLabel, whereValue, whenLabel, whenValue, text, primaryLabel, primaryUrl, closeLabel } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title={ active ? 'Event Modal (active)' : 'Event Modal (disabled)' }>
                    <div className="gyc-event-modal-fields-wrapper">
                        <ToggleControl
                            label="Show the modal"
                            help={ active ? 'Active: the modal opens every time someone visits this page.' : 'Disabled: visitors do not see the modal. Its content is kept.' }
                            checked={ !!active }
                            onChange={ ( newValue ) => setAttributes( { active: newValue } ) }
                        />
                        <TextControl
                            label="Background illustration URL"
                            help="Shown behind the title, as decoration, so it needs no alt text. Leave empty for plain purple with hills."
                            value={ image || '' }
                            onChange={ ( newValue ) => setAttributes( { image: newValue } ) }
                        />
                        <TextControl
                            label="Eyebrow"
                            value={ eyebrow || '' }
                            onChange={ ( newValue ) => setAttributes( { eyebrow: newValue } ) }
                        />
                        <TextControl
                            label="Title – first line"
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />
                        <TextControl
                            label="Title – second line in mint (optional)"
                            help="For example: Stand / Fast."
                            value={ titleHighlight || '' }
                            onChange={ ( newValue ) => setAttributes( { titleHighlight: newValue } ) }
                        />
                        <TextControl
                            label="Notice"
                            help="The mint line under the illustration. Put **two stars** around words to make them bold."
                            value={ notice || '' }
                            onChange={ ( newValue ) => setAttributes( { notice: newValue } ) }
                        />

                        <p>The two boxes: each one appears when its value is filled in.</p>
                        <TextControl
                            label="First box label"
                            value={ whereLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { whereLabel: newValue } ) }
                        />
                        <TextControl
                            label="First box value"
                            value={ whereValue || '' }
                            onChange={ ( newValue ) => setAttributes( { whereValue: newValue } ) }
                        />
                        <TextControl
                            label="Second box label"
                            value={ whenLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { whenLabel: newValue } ) }
                        />
                        <TextControl
                            label="Second box value"
                            value={ whenValue || '' }
                            onChange={ ( newValue ) => setAttributes( { whenValue: newValue } ) }
                        />

                        <TextareaControl
                            label="Text"
                            rows={3}
                            value={ text || '' }
                            onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                        />
                        <TextControl
                            label="Mint button label"
                            value={ primaryLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { primaryLabel: newValue } ) }
                        />
                        <TextControl
                            label="Mint button link"
                            help="Full URL or a site path like /event/demo-2027/. The button is hidden when the label or the link is empty."
                            value={ primaryUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { primaryUrl: newValue } ) }
                        />
                        <TextControl
                            label="Close button label"
                            help="The outlined button. It closes the modal and leaves the visitor on this page."
                            value={ closeLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { closeLabel: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
