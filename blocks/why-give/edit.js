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
    const { image, imageAlt, eyebrow, title, text, items } = attributes;

    const updateItem = ( id, changes ) => {
        const newItems = items.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ items: newItems });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Why Give">
                    <div className="gyc-why-give-fields-wrapper">
                        <TextControl
                            label="Image URL"
                            help="Leave empty to show the GYC placeholder."
                            value={ image || '' }
                            onChange={ ( newValue ) => setAttributes( { image: newValue } ) }
                        />
                        <TextControl
                            label="Image alt text"
                            value={ imageAlt || '' }
                            onChange={ ( newValue ) => setAttributes( { imageAlt: newValue } ) }
                        />
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

                        <Panel>
                            <PanelBody initialOpen={false} title="Checklist">
                                {items.map(item => (
                                    <PanelRow key={item.id}>
                                        <div className="gyc-why-give-fields-wrapper">
                                            <TextControl
                                                label="Text"
                                                value={ item.text || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { text: newValue } ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newItems = items.filter(i => i.id !== item.id);
                                                        setAttributes({ items: newItems });
                                                    } }
                                                >
                                                    Remove item
                                                </Button>
                                            </div>
                                            <hr className="gyc-why-give-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newItem = { id: Date.now(), text: '' };
                                        setAttributes({ items: [...items, newItem] });
                                    } }
                                >
                                    Add item
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
