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
    const { title, headline, items } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Pricing table">
                    <div className="gyc-pricing-table-fields-wrapper">
                        <TextControl
                            label="Title"
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />
                        <TextareaControl
                            label="Headline"
                            rows={4}
                            value={ headline || '' }
                            onChange={ ( newValue ) => setAttributes( { headline: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title={"Items"}>
                                {items.map(item => (
                                    <PanelRow key={item.id}>
                                        <div className="gyc-pricing-table-fields-wrapper">
                                            <TextControl
                                                label="Title"
                                                value={ item.title || '' }
                                                onChange={ ( newValue ) => {
                                                    const newItems = items.map(i => i.id === item.id ? { ...i, title: newValue } : i);
                                                    setAttributes({ items: newItems });
                                                } }
                                            />
                                            <TextControl
                                                label="Badge"
                                                value={ item.badge || '' }
                                                onChange={ ( newValue ) => {
                                                    const newItems = items.map(i => i.id === item.id ? { ...i, badge: newValue } : i);
                                                    setAttributes({ items: newItems });
                                                } }
                                            />
                                            <TextControl
                                                label="Price"
                                                value={ item.price || 0 }
                                                onChange={ ( newValue ) => {
                                                    const newItems = items.map(i => i.id === item.id ? { ...i, price: newValue } : i);
                                                    setAttributes({ items: newItems });
                                                } }
                                            />
                                            <TextControl
                                                label="Date"
                                                value={ item.date || '' }
                                                onChange={ ( newValue ) => {
                                                    const newItems = items.map(i => i.id === item.id ? { ...i, date: newValue } : i);
                                                    setAttributes({ items: newItems });
                                                } }
                                            />
                                            <TextControl
                                                label="Link"
                                                value={ item.link || '' }
                                                onChange={ ( newValue ) => {
                                                    const newItems = items.map(i => i.id === item.id ? { ...i, link: newValue } : i);
                                                    setAttributes({ items: newItems });
                                                } }
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
                                                    Remove price
                                                </Button>
                                            </div>
                                            <hr className="gyc-pricing-table-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newItem = { id: Date.now(), title: '', badge: '', price: 0, date: '', link: '' };
                                        setAttributes({ items: [...items, newItem] });
                                    } }
                                >
                                    Add price
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
