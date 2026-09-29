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

const IMAGE_LABELS = [ 'Large photo (top)', 'Small photo (bottom left)', 'Small photo (bottom right)' ];

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
    const { eyebrow, title, lead, text, images } = attributes;

    const updateImage = ( id, changes ) => {
        const newImages = images.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ images: newImages });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Vision">
                    <div className="gyc-vision-fields-wrapper">
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
                            label="Lead text"
                            rows={5}
                            value={ lead || '' }
                            onChange={ ( newValue ) => setAttributes( { lead: newValue } ) }
                        />
                        <TextareaControl
                            label="Text"
                            rows={4}
                            value={ text || '' }
                            onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Photos">
                                <div className="gyc-vision-fields-wrapper">
                                    {images.map((image, index) => (
                                        <div key={image.id} className="gyc-vision-fields-wrapper">
                                            <TextControl
                                                label={ `${ IMAGE_LABELS[ index ] || 'Photo' } – URL` }
                                                value={ image.url || '' }
                                                onChange={ ( newValue ) => updateImage( image.id, { url: newValue } ) }
                                            />
                                            <TextControl
                                                label="Alt text"
                                                value={ image.alt || '' }
                                                onChange={ ( newValue ) => updateImage( image.id, { alt: newValue } ) }
                                            />
                                            <hr className="gyc-vision-separator" />
                                        </div>
                                    ))}
                                </div>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
