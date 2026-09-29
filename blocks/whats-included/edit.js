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
    const { title, items, cardTitleTop, cardTitle, cardText, cardButtonLabel, cardButtonUrl } = attributes;

    const updateItem = ( id, changes ) => {
        const newItems = items.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ items: newItems });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="What's Included">
                    <div className="gyc-whats-included-fields-wrapper">
                        <TextControl
                            label="Title"
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Checklist">
                                {items.map(item => (
                                    <PanelRow key={item.id}>
                                        <div className="gyc-whats-included-fields-wrapper">
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
                                            <hr className="gyc-whats-included-separator" />
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

                        <Panel>
                            <PanelBody initialOpen={false} title="Highlighted card">
                                <div className="gyc-whats-included-fields-wrapper">
                                    <TextControl
                                        label="Title – first line"
                                        value={ cardTitleTop || '' }
                                        onChange={ ( newValue ) => setAttributes( { cardTitleTop: newValue } ) }
                                    />
                                    <TextControl
                                        label="Title – second line"
                                        value={ cardTitle || '' }
                                        onChange={ ( newValue ) => setAttributes( { cardTitle: newValue } ) }
                                    />
                                    <TextareaControl
                                        label="Text"
                                        rows={2}
                                        value={ cardText || '' }
                                        onChange={ ( newValue ) => setAttributes( { cardText: newValue } ) }
                                    />
                                    <TextControl
                                        label="Button label"
                                        value={ cardButtonLabel || '' }
                                        onChange={ ( newValue ) => setAttributes( { cardButtonLabel: newValue } ) }
                                    />
                                    <TextControl
                                        label="Button link"
                                        help="#pricing jumps to the price boxes on this page."
                                        value={ cardButtonUrl || '' }
                                        onChange={ ( newValue ) => setAttributes( { cardButtonUrl: newValue } ) }
                                    />
                                </div>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
