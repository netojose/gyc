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
    const { title, text, items, cardTitle, cardText, buttonLabel, buttonUrl, note } = attributes;

    const updateItem = ( id, changes ) => {
        setAttributes({ items: items.map(i => i.id === id ? { ...i, ...changes } : i) });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Why Give">
                    <div className="gyc-why-give-fields-wrapper">
                        <TextControl
                            label="Title"
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />
                        <TextareaControl
                            label="Text"
                            help="Optional, shown under the title."
                            rows={2}
                            value={ text || '' }
                            onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Gift amounts">
                                {items.map(item => (
                                    <PanelRow key={item.id}>
                                        <div className="gyc-why-give-fields-wrapper">
                                            <TextControl
                                                label="Amount"
                                                help="For example €25"
                                                value={ item.amount || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { amount: newValue } ) }
                                            />
                                            <TextControl
                                                label="Title"
                                                value={ item.title || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { title: newValue } ) }
                                            />
                                            <TextareaControl
                                                label="Text"
                                                rows={2}
                                                value={ item.text || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { text: newValue } ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => setAttributes({ items: items.filter(i => i.id !== item.id) }) }
                                                >
                                                    Remove amount
                                                </Button>
                                            </div>
                                            <hr className="gyc-why-give-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newItem = { id: Date.now(), amount: '', title: '', text: '' };
                                        setAttributes({ items: [...items, newItem] });
                                    } }
                                >
                                    Add amount
                                </Button>
                            </PanelBody>
                        </Panel>

                        <Panel>
                            <PanelBody initialOpen={false} title="Donation card">
                                <div className="gyc-why-give-fields-wrapper">
                                    <TextControl
                                        label="Card title"
                                        value={ cardTitle || '' }
                                        onChange={ ( newValue ) => setAttributes( { cardTitle: newValue } ) }
                                    />
                                    <TextareaControl
                                        label="Card text"
                                        rows={2}
                                        value={ cardText || '' }
                                        onChange={ ( newValue ) => setAttributes( { cardText: newValue } ) }
                                    />
                                    <TextControl
                                        label="Button label"
                                        value={ buttonLabel || '' }
                                        onChange={ ( newValue ) => setAttributes( { buttonLabel: newValue } ) }
                                    />
                                    <TextControl
                                        label="Donation page link"
                                        help="Full URL of the external donation page, e.g. https://..."
                                        value={ buttonUrl || '' }
                                        onChange={ ( newValue ) => setAttributes( { buttonUrl: newValue } ) }
                                    />
                                    <TextControl
                                        label="Note under the button"
                                        value={ note || '' }
                                        onChange={ ( newValue ) => setAttributes( { note: newValue } ) }
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
