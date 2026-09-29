import {
    TextControl,
    TextareaControl,
    Panel,
    PanelBody,
    PanelRow,
    Button
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
    const { eyebrow, title, text, buttonLabel, buttonUrl, map, mapAlt, note, photos } = attributes;

    const updatePhoto = ( id, changes ) => {
        const newPhotos = photos.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ photos: newPhotos });
    };

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
                        <TextareaControl
                            label="Handwritten note"
                            rows={3}
                            value={ note || '' }
                            onChange={ ( newValue ) => setAttributes( { note: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Photos">
                                {photos.map(photo => (
                                    <PanelRow key={photo.id}>
                                        <div className="gyc-community-fields-wrapper">
                                            <TextControl
                                                label="Photo URL"
                                                value={ photo.url || '' }
                                                onChange={ ( newValue ) => updatePhoto( photo.id, { url: newValue } ) }
                                            />
                                            <TextControl
                                                label="Alt text"
                                                value={ photo.alt || '' }
                                                onChange={ ( newValue ) => updatePhoto( photo.id, { alt: newValue } ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newPhotos = photos.filter(i => i.id !== photo.id);
                                                        setAttributes({ photos: newPhotos });
                                                    } }
                                                >
                                                    Remove photo
                                                </Button>
                                            </div>
                                            <hr className="gyc-community-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newPhoto = { id: Date.now(), url: '', alt: '' };
                                        setAttributes({ photos: [...photos, newPhoto] });
                                    } }
                                >
                                    Add photo
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
