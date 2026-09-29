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
    const { noResultsText, categories } = attributes;

    const updateCategory = ( id, changes ) => {
        const newCategories = categories.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ categories: newCategories });
    };

    const updateItem = ( category, itemId, changes ) => {
        const newItems = (category.items || []).map(i => i.id === itemId ? { ...i, ...changes } : i);
        updateCategory( category.id, { items: newItems } );
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="FAQ">
                    <div className="gyc-faq-fields-wrapper">
                        <TextControl
                            label="No results message"
                            help="Shown when the search finds nothing."
                            value={ noResultsText || '' }
                            onChange={ ( newValue ) => setAttributes( { noResultsText: newValue } ) }
                        />

                        {categories.map(category => (
                            <Panel key={category.id}>
                                <PanelBody initialOpen={false} title={ category.title || 'Untitled category' }>
                                    <div className="gyc-faq-fields-wrapper">
                                        <TextControl
                                            label="Category title"
                                            value={ category.title || '' }
                                            onChange={ ( newValue ) => updateCategory( category.id, { title: newValue } ) }
                                        />
                                        {(category.items || []).map(item => (
                                            <PanelRow key={item.id}>
                                                <div className="gyc-faq-fields-wrapper">
                                                    <TextControl
                                                        label="Question"
                                                        value={ item.question || '' }
                                                        onChange={ ( newValue ) => updateItem( category, item.id, { question: newValue } ) }
                                                    />
                                                    <TextareaControl
                                                        label="Answer"
                                                        help="Blank lines start a new paragraph. Links can be added as HTML."
                                                        rows={4}
                                                        value={ item.answer || '' }
                                                        onChange={ ( newValue ) => updateItem( category, item.id, { answer: newValue } ) }
                                                    />
                                                    <div>
                                                        <Button
                                                            size="small"
                                                            variant="outline"
                                                            className="is-secondary is-destructive"
                                                            onClick={ () => {
                                                                const newItems = category.items.filter(i => i.id !== item.id);
                                                                updateCategory( category.id, { items: newItems } );
                                                            } }
                                                        >
                                                            Remove question
                                                        </Button>
                                                    </div>
                                                    <hr className="gyc-faq-separator" />
                                                </div>
                                            </PanelRow>
                                        ))}
                                        <div>
                                            <Button
                                                variant="secondary"
                                                onClick={ () => {
                                                    const newItem = { id: Date.now(), question: '', answer: '' };
                                                    updateCategory( category.id, { items: [...(category.items || []), newItem] } );
                                                } }
                                            >
                                                Add question
                                            </Button>
                                        </div>
                                        <div>
                                            <Button
                                                size="small"
                                                variant="outline"
                                                className="is-secondary is-destructive"
                                                onClick={ () => {
                                                    const newCategories = categories.filter(i => i.id !== category.id);
                                                    setAttributes({ categories: newCategories });
                                                } }
                                            >
                                                Remove category
                                            </Button>
                                        </div>
                                    </div>
                                </PanelBody>
                            </Panel>
                        ))}

                        <Button
                            isPrimary
                            onClick={ () => {
                                const newCategory = { id: Date.now(), title: '', items: [] };
                                setAttributes({ categories: [...categories, newCategory] });
                            } }
                        >
                            Add category
                        </Button>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
