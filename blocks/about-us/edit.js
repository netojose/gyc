import {
    TextControl,
    TextareaControl,
    SelectControl,
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

const ICON_OPTIONS = [
    { label: 'None', value: '' },
    { label: 'Praying hands', value: 'pray' },
    { label: 'Friends', value: 'friends' },
    { label: 'Target', value: 'mission' },
    { label: 'Connected dots', value: 'movement' },
];

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
    const { eyebrow, title, text, linkLabel, linkUrl, items } = attributes;

    const updateItem = ( id, changes ) => {
        const newItems = items.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ items: newItems });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="About Us">
                    <div className="gyc-about-us-fields-wrapper">
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
                            label="Link"
                            help="Full URL, site path like /about-us/, a section like #community, or an email address."
                            value={ linkUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { linkUrl: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Items">
                                {items.map(item => (
                                    <PanelRow key={item.id}>
                                        <div className="gyc-about-us-fields-wrapper">
                                            <SelectControl
                                                label="Icon"
                                                value={ item.icon || '' }
                                                options={ ICON_OPTIONS }
                                                onChange={ ( newValue ) => updateItem( item.id, { icon: newValue } ) }
                                            />
                                            <TextControl
                                                label="Title"
                                                value={ item.title || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { title: newValue } ) }
                                            />
                                            <TextareaControl
                                                label="Text"
                                                rows={3}
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
                                            <hr className="gyc-about-us-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newItem = { id: Date.now(), icon: '', title: '', text: '' };
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
