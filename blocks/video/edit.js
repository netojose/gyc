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
    const { eyebrow, title, text, linkLabel, videoUrl, poster, posterAlt, overlayText } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Video">
                    <div className="gyc-video-fields-wrapper">
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
                            label="Link label"
                            value={ linkLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { linkLabel: newValue } ) }
                        />
                        <TextControl
                            label="Video URL"
                            help="YouTube or Vimeo link, or a direct link to a video file."
                            value={ videoUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { videoUrl: newValue } ) }
                        />
                        <TextControl
                            label="Poster image URL"
                            value={ poster || '' }
                            onChange={ ( newValue ) => setAttributes( { poster: newValue } ) }
                        />
                        <TextControl
                            label="Poster alt text"
                            help="Only used when there is no video URL; otherwise the poster is labelled as the play button."
                            value={ posterAlt || '' }
                            onChange={ ( newValue ) => setAttributes( { posterAlt: newValue } ) }
                        />
                        <TextareaControl
                            label="Handwritten overlay text"
                            rows={2}
                            value={ overlayText || '' }
                            onChange={ ( newValue ) => setAttributes( { overlayText: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
