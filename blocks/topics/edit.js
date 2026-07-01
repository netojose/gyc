import {
    TextControl,
    TextareaControl,
    Panel,
    PanelBody,
    PanelRow,
    Button
} from '@wordpress/components';
import { Text } from '@wordpress/ui';

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
    const { title, headline, text, items } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Topics">
                    <div className="gyc-topics-fields-wrapper">
                        <TextControl
                            label="Title"
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />
                        <TextControl
                            label="Headline"
                            value={ headline || '' }
                            onChange={ ( newValue ) => setAttributes( { headline: newValue } ) }
                        />
                        <TextareaControl
                            label="Text"
                            rows={8}
                            value={ text || '' }
                            onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Items">
                                {items.map(item => (
                                    <PanelRow key={item.id}>
                                        <div className="gyc-topics-fields-wrapper">
                                            <TextControl
                                                label="Title"
                                                value={ item.title || '' }
                                                onChange={ ( newValue ) => {
                                                    const newItems = items.map(i => i.id === item.id ? { ...i, title: newValue } : i);
                                                    setAttributes({ items: newItems });
                                                } }
                                            />
                                            <TextareaControl
                                                label="Text"
                                                rows={3}
                                                value={ item.text || '' }
                                                onChange={ ( newValue ) => {
                                                    const newItems = items.map(i => i.id === item.id ? { ...i, text: newValue } : i);
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
                                                    Remove topic
                                                </Button>
                                            </div>
                                            <hr className="gyc-topics-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newItem = { id: Date.now(), title: '', text: '' };
                                        setAttributes({ items: [...items, newItem] });
                                    } }
                                >
                                    Add topic
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
