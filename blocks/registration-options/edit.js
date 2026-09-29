import {
    TextControl,
    SelectControl,
    Notice,
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
 * Mirrors render.php: the first box whose dates include today, unless one is picked manually.
 * Uses the editor's local date, so it can differ from the site's timezone around midnight.
 */
const getActiveItem = ( items, activeMode ) => {
    if ( activeMode === 'none' ) {
        return null;
    }
    if ( activeMode !== 'auto' ) {
        return items.find( i => String( i.id ) === activeMode ) || null;
    }
    const now = new Date();
    const today = [
        now.getFullYear(),
        String( now.getMonth() + 1 ).padStart( 2, '0' ),
        String( now.getDate() ).padStart( 2, '0' ),
    ].join( '-' );
    return items.find( i => ( ! i.start || today >= i.start ) && ( ! i.end || today <= i.end ) ) || null;
};

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
    const { title, activeMode, upcomingLabel, closedLabel, items } = attributes;

    const updateItem = ( id, changes ) => {
        const newItems = items.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ items: newItems });
    };

    const activeItem = getActiveItem( items, activeMode || 'auto' );

    const modeOptions = [
        { label: 'Automatic – by dates', value: 'auto' },
        ...items.map( i => ( { label: `Always: ${ i.label || 'Untitled' }`, value: String( i.id ) } ) ),
        { label: 'None – registration closed', value: 'none' },
    ];

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Registration Options">
                    <div className="gyc-registration-options-fields-wrapper">
                        <Notice status={ activeItem ? 'success' : 'warning' } isDismissible={ false }>
                            { activeItem
                                ? `Open for registration today: ${ activeItem.label || 'Untitled' }`
                                : 'No box is open for registration today.' }
                        </Notice>
                        <SelectControl
                            label="Which box is open"
                            help="Automatic opens the first box whose dates include today (site timezone). Only one box is ever open; the others show a status instead of a button."
                            value={ activeMode || 'auto' }
                            options={ modeOptions }
                            onChange={ ( newValue ) => setAttributes( { activeMode: newValue } ) }
                        />
                        <TextControl
                            label="Label for boxes not open yet"
                            value={ upcomingLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { upcomingLabel: newValue } ) }
                        />
                        <TextControl
                            label="Label for boxes that have ended"
                            value={ closedLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { closedLabel: newValue } ) }
                        />
                        <TextControl
                            label="Section title"
                            help="Read out by screen readers only."
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Boxes">
                                {items.map(item => (
                                    <PanelRow key={item.id}>
                                        <div className="gyc-registration-options-fields-wrapper">
                                            <TextControl
                                                label="Label"
                                                value={ item.label || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { label: newValue } ) }
                                            />
                                            <TextControl
                                                label="Price"
                                                value={ item.price || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { price: newValue } ) }
                                            />
                                            <TextControl
                                                label="Opens on"
                                                type="date"
                                                help="Leave empty to be open from now."
                                                value={ item.start || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { start: newValue } ) }
                                            />
                                            <TextControl
                                                label="Last day"
                                                type="date"
                                                help="Open until the end of this day. Leave empty for no end."
                                                value={ item.end || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { end: newValue } ) }
                                            />
                                            <TextControl
                                                label="Button label"
                                                value={ item.buttonLabel || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { buttonLabel: newValue } ) }
                                            />
                                            <TextControl
                                                label="Button link"
                                                help="The registration form or ticket page for this price."
                                                value={ item.buttonUrl || '' }
                                                onChange={ ( newValue ) => updateItem( item.id, { buttonUrl: newValue } ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newItems = items.filter(i => i.id !== item.id);
                                                        setAttributes({ items: newItems });
                                                        if ( activeMode === String( item.id ) ) {
                                                            setAttributes({ activeMode: 'auto' });
                                                        }
                                                    } }
                                                >
                                                    Remove box
                                                </Button>
                                            </div>
                                            <hr className="gyc-registration-options-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newItem = { id: Date.now(), label: '', price: '', start: '', end: '', buttonLabel: 'Register now', buttonUrl: '' };
                                        setAttributes({ items: [...items, newItem] });
                                    } }
                                >
                                    Add box
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
