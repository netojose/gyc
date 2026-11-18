import {
    TextControl,
    TextareaControl,
    ToggleControl,
    SelectControl,
    Button,
    Panel,
    PanelBody,
    PanelRow
} from '@wordpress/components';
import OpensAtField from './opens-at-field';

/**
 * Shared sidebar fields for the Participant Info blocks (gyc/info-*).
 */

// Icons drawn in GycIcons.php; keep the two lists in sync
export const ICON_OPTIONS = [
    { label: 'None', value: '' },
    { label: 'Ticket', value: 'ticket' },
    { label: 'People', value: 'people' },
    { label: 'Fork and knife', value: 'meal' },
    { label: 'Leaf', value: 'leaf' },
    { label: 'Bed', value: 'bed' },
    { label: 'Map pin', value: 'pin' },
    { label: 'Plane', value: 'plane' },
    { label: 'Train', value: 'train' },
    { label: 'Bus', value: 'bus' },
    { label: 'Calendar', value: 'calendar' },
    { label: 'Heart', value: 'heart' },
    { label: 'Music', value: 'music' },
    { label: 'Document', value: 'document' },
    { label: 'Euro', value: 'euro' },
    { label: 'Hands', value: 'hands' },
    { label: 'Speech bubble', value: 'chat' },
    { label: 'Video camera', value: 'video' },
    { label: 'Box', value: 'cube' },
    { label: 'Book', value: 'book' },
    { label: 'Sun', value: 'sun' },
    { label: 'Portrait', value: 'frame' },
    { label: 'Statue', value: 'statue' },
    { label: 'Praying hands', value: 'pray' },
    { label: 'House', value: 'house' },
    { label: 'Walking person', value: 'walk' },
    { label: 'Hand with heart', value: 'helping-hands' },
    { label: 'Dove', value: 'dove' },
];

/**
 * "Show this section", section ID, label, title and intro: the top of every section block.
 */
export function SectionFields({ attributes, setAttributes, showText = true }) {
    const { active, anchorId, eyebrow, title, text } = attributes;

    return (
        <>
            <ToggleControl
                label="Show this section"
                help={ active ? 'Shown: this section appears on the page.' : 'Hidden: visitors do not see this section. Its content is kept.' }
                checked={ !! active }
                onChange={ ( newValue ) => setAttributes( { active: newValue } ) }
            />
            <TextControl
                label="Section ID"
                help={ `The hero buttons jump here with #${ anchorId || '…' }. Letters, numbers and dashes only.` }
                value={ anchorId || '' }
                onChange={ ( newValue ) => setAttributes( { anchorId: newValue.toLowerCase().replace( /[^a-z0-9-]/g, '' ) } ) }
            />
            <TextControl
                label="Label above the title"
                value={ eyebrow || '' }
                onChange={ ( newValue ) => setAttributes( { eyebrow: newValue } ) }
            />
            <TextControl
                label="Title"
                value={ title || '' }
                onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
            />
            { showText && (
                <TextareaControl
                    label="Intro text"
                    rows={3}
                    value={ text || '' }
                    onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                />
            ) }
        </>
    );
}

/**
 * Editable list of cards. `fields` describes each card's fields:
 * { key, label, type: 'text' | 'textarea' | 'toggle' | 'icon' | 'select' | 'opensAt', help, options, rows }.
 */
export function ItemsPanel({ title, help, items = [], onChange, fields, newItem, addLabel = 'Add card', itemLabel = 'card' }) {
    const update = ( id, changes ) => onChange( items.map( ( i ) => ( i.id === id ? { ...i, ...changes } : i ) ) );
    const move = ( index, step ) => {
        const next = [ ...items ];
        const [ item ] = next.splice( index, 1 );
        next.splice( index + step, 0, item );
        onChange( next );
    };

    const renderField = ( item, field ) => {
        const value = item[ field.key ];
        const set = ( newValue ) => update( item.id, { [ field.key ]: newValue } );

        switch ( field.type ) {
            case 'textarea':
                return <TextareaControl key={ field.key } label={ field.label } help={ field.help } rows={ field.rows || 3 } value={ value || '' } onChange={ set } />;
            case 'toggle':
                return <ToggleControl key={ field.key } label={ field.label } help={ field.help } checked={ !! value } onChange={ set } />;
            case 'icon':
                return <SelectControl key={ field.key } label={ field.label || 'Icon' } help={ field.help } value={ value || '' } options={ ICON_OPTIONS } onChange={ set } />;
            case 'opensAt':
                return <OpensAtField key={ field.key } label={ field.label } value={ value } onChange={ set } />;
            case 'select':
                return <SelectControl key={ field.key } label={ field.label } help={ field.help } value={ value || field.options[ 0 ].value } options={ field.options } onChange={ set } />;
            default:
                return <TextControl key={ field.key } label={ field.label } help={ field.help } value={ value || '' } onChange={ set } />;
        }
    };

    return (
        <Panel>
            <PanelBody initialOpen={ false } title={ title }>
                { help && <p>{ help }</p> }
                { items.map( ( item, index ) => (
                    <PanelRow key={ item.id }>
                        <div className="gyc-info-fields-wrapper">
                            { fields.map( ( field ) => renderField( item, field ) ) }
                            <div className="gyc-info-buttons">
                                <Button size="small" variant="secondary" disabled={ index === 0 } onClick={ () => move( index, -1 ) }>Move up</Button>
                                <Button size="small" variant="secondary" disabled={ index === items.length - 1 } onClick={ () => move( index, 1 ) }>Move down</Button>
                                <Button
                                    size="small"
                                    variant="outline"
                                    className="is-secondary is-destructive"
                                    onClick={ () => onChange( items.filter( ( i ) => i.id !== item.id ) ) }
                                >
                                    { `Remove ${ itemLabel }` }
                                </Button>
                            </div>
                            <hr className="gyc-info-separator" />
                        </div>
                    </PanelRow>
                ) ) }
                <Button isPrimary onClick={ () => onChange( [ ...items, { ...newItem, id: Date.now() } ] ) }>
                    { addLabel }
                </Button>
            </PanelBody>
        </Panel>
    );
}

/**
 * Plain text field bound to one attribute.
 */
export function Field({ attributes, setAttributes, name, label, help, textarea = false, rows = 3 }) {
    const props = {
        label,
        help,
        value: attributes[ name ] || '',
        onChange: ( newValue ) => setAttributes( { [ name ]: newValue } ),
    };

    return textarea ? <TextareaControl rows={ rows } { ...props } /> : <TextControl { ...props } />;
}
