import {
    TextControl,
    TextareaControl,
    Panel,
    PanelBody,
    PanelRow,
    Button,
    ToggleControl
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
/**
 * Talks or workshops of one speaker, each with a title and an optional day and time.
 * Both are shown as labels at the bottom of the speaker's pop-up.
 */
function SessionsFields({ items = [], titleLabel, titleHelp, addLabel, onChange }) {
    const updateItem = ( id, changes ) => onChange( items.map(i => i.id === id ? { ...i, ...changes } : i) );

    return (
        <>
            {items.map(item => (
                <div key={item.id} className="gyc-people-workshop-row">
                    <TextControl
                        label={ titleLabel }
                        help={ titleHelp }
                        value={ item.title || '' }
                        onChange={ ( newValue ) => updateItem( item.id, { title: newValue } ) }
                    />
                    <TextControl
                        label="Day and time (optional)"
                        help="For example: Thursday · 10:00"
                        value={ item.time || '' }
                        onChange={ ( newValue ) => updateItem( item.id, { time: newValue } ) }
                    />
                    <div>
                        <Button
                            size="small"
                            variant="outline"
                            className="is-secondary is-destructive"
                            onClick={ () => onChange( items.filter(i => i.id !== item.id) ) }
                        >
                            Remove
                        </Button>
                    </div>
                </div>
            ))}
            <div>
                <Button
                    size="small"
                    variant="secondary"
                    onClick={ () => onChange( [ ...items, { id: Date.now(), title: '', time: '' } ] ) }
                >
                    { addLabel }
                </Button>
            </div>
        </>
    );
}

export default function Edit({ attributes, setAttributes }) {
    const { showMain = true, showStaff = true, title, text, staffTitle, main = [], staff = [] } = attributes;

    const updateSessions = ( listName, person, key, items ) => {
        const list = listName === 'main' ? main : staff;
        setAttributes({ [ listName ]: list.map(i => i.id === person.id ? { ...i, [ key ]: items } : i) });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title={ !showMain && !showStaff ? 'People (hidden)' : 'People' }>
                    <div className="gyc-people-fields-wrapper">
                        <ToggleControl
                            label="Show main speakers"
                            help={ showMain ? 'Shown: the title, text and speaker cards appear on the page.' : 'Hidden: visitors do not see the title, text or speaker cards. Their content is kept.' }
                            checked={ !!showMain }
                            onChange={ ( newValue ) => setAttributes( { showMain: newValue } ) }
                        />
                        <ToggleControl
                            label="Show workshop speakers"
                            help={ showStaff ? 'Shown: the workshop speakers box appears on the page.' : 'Hidden: visitors do not see the workshop speakers box. Its content is kept.' }
                            checked={ !!showStaff }
                            onChange={ ( newValue ) => setAttributes( { showStaff: newValue } ) }
                        />
                        <TextControl
                            label="Title"
                            help="Type it in normal case; it is shown in small capitals."
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
                        <TextControl
                            label="Workshop speakers title"
                            value={ staffTitle || '' }
                            onChange={ ( newValue ) => setAttributes( { staffTitle: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Main speakers">
                                <p>Role is shown under the name. The description and talks appear in the pop-up when a speaker is clicked.</p>
                                {main.map(person => (
                                    <PanelRow key={person.id}>
                                        <div className="gyc-people-fields-wrapper">
                                            <TextControl
                                                label="Photo"
                                                value={ person.photo || '' }
                                                onChange={ ( newValue ) => {
                                                    const newMain = main.map(i => i.id === person.id ? { ...i, photo: newValue } : i);
                                                    setAttributes({ main: newMain });
                                                } }
                                            />
                                            <TextControl
                                                label="Name"
                                                value={ person.name || '' }
                                                onChange={ ( newValue ) => {
                                                    const newMain = main.map(i => i.id === person.id ? { ...i, name: newValue } : i);
                                                    setAttributes({ main: newMain });
                                                } }
                                            />
                                            <TextControl
                                                label="Role"
                                                help="For example: Role · Church or ministry"
                                                value={ person.role || '' }
                                                onChange={ ( newValue ) => {
                                                    const newMain = main.map(i => i.id === person.id ? { ...i, role: newValue } : i);
                                                    setAttributes({ main: newMain });
                                                } }
                                            />
                                            <TextControl
                                                label="Country (optional)"
                                                help="Shown on its own line with a location pin."
                                                value={ person.country || '' }
                                                onChange={ ( newValue ) => {
                                                    const newMain = main.map(i => i.id === person.id ? { ...i, country: newValue } : i);
                                                    setAttributes({ main: newMain });
                                                } }
                                            />
                                            { person.headline && (
                                                <TextControl
                                                    label="Headline (old field)"
                                                    help="Shown in the pop-up until a talk is added below. Clear it once you have moved the text there."
                                                    value={ person.headline }
                                                    onChange={ ( newValue ) => {
                                                        const newMain = main.map(i => i.id === person.id ? { ...i, headline: newValue } : i);
                                                        setAttributes({ main: newMain });
                                                    } }
                                                />
                                            ) }
                                            <TextareaControl
                                                label="Description"
                                                rows={6}
                                                value={ person.description || '' }
                                                onChange={ ( newValue ) => {
                                                    const newMain = main.map(i => i.id === person.id ? { ...i, description: newValue } : i);
                                                    setAttributes({ main: newMain });
                                                } }
                                            />

                                            <p>Talks this speaker gives, shown in the pop-up.</p>
                                            <SessionsFields
                                                items={ person.sessions }
                                                titleLabel="Talk title"
                                                titleHelp="Shown exactly as typed, e.g. Speaking on: [message title] or just [message title]"
                                                addLabel="Add talk"
                                                onChange={ ( items ) => updateSessions( 'main', person, 'sessions', items ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newMain = main.filter(i => i.id !== person.id);
                                                        setAttributes({ main: newMain });
                                                    } }
                                                >
                                                    Remove person
                                                </Button>
                                            </div>
                                            <hr className="gyc-pricing-table-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newPerson = {
                                            id: Date.now(),
                                            photo: '',
                                            name: '',
                                            role: '',
                                            country: '',
                                            description: '',
                                            sessions: []
                                        };

                                        setAttributes({ main: [ ...main, newPerson ] });
                                    } }
                                >
                                    Add person
                                </Button>
                            </PanelBody>
                        </Panel>

                        <Panel>
                            <PanelBody initialOpen={false} title="Workshop speakers">
                                <p>Without a photo, the speaker's initials are shown. A speaker with a description or at least one workshop can be clicked to open their bio.</p>
                                {staff.map(person => (
                                    <PanelRow key={person.id}>
                                        <div className="gyc-people-fields-wrapper">
                                            <TextControl
                                                label="Photo"
                                                value={ person.photo || '' }
                                                onChange={ ( newValue ) => {
                                                    const newStaff = staff.map(i => i.id === person.id ? { ...i, photo: newValue } : i);
                                                    setAttributes({ staff: newStaff });
                                                } }
                                            />
                                            <TextControl
                                                label="Name"
                                                value={ person.name || '' }
                                                onChange={ ( newValue ) => {
                                                    const newStaff = staff.map(i => i.id === person.id ? { ...i, name: newValue } : i);
                                                    setAttributes({ staff: newStaff });
                                                } }
                                            />
                                            <TextControl
                                                label="Role"
                                                help="Topic or ministry."
                                                value={ person.role || '' }
                                                onChange={ ( newValue ) => {
                                                    const newStaff = staff.map(i => i.id === person.id ? { ...i, role: newValue } : i);
                                                    setAttributes({ staff: newStaff });
                                                } }
                                            />
                                            <TextControl
                                                label="Country (optional)"
                                                help="Shown only in the speaker's pop-up, with a location pin."
                                                value={ person.country || '' }
                                                onChange={ ( newValue ) => {
                                                    const newStaff = staff.map(i => i.id === person.id ? { ...i, country: newValue } : i);
                                                    setAttributes({ staff: newStaff });
                                                } }
                                            />
                                            { person.headline && (
                                                <TextControl
                                                    label="Headline (old field)"
                                                    help="Shown in the pop-up until a workshop is added below. Clear it once you have moved the text there."
                                                    value={ person.headline }
                                                    onChange={ ( newValue ) => {
                                                        const newStaff = staff.map(i => i.id === person.id ? { ...i, headline: newValue } : i);
                                                        setAttributes({ staff: newStaff });
                                                    } }
                                                />
                                            ) }
                                            <TextareaControl
                                                label="Description"
                                                value={ person.description || '' }
                                                onChange={ ( newValue ) => {
                                                    const newStaff = staff.map(i => i.id === person.id ? { ...i, description: newValue } : i);
                                                    setAttributes({ staff: newStaff });
                                                } }
                                            />

                                            <p>Workshops this speaker leads, shown in the pop-up.</p>
                                            <SessionsFields
                                                items={ person.workshops }
                                                titleLabel="Workshop title"
                                                titleHelp="Shown exactly as typed, e.g. Workshop: [workshop title] or just [workshop title]"
                                                addLabel="Add workshop"
                                                onChange={ ( items ) => updateSessions( 'staff', person, 'workshops', items ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newStaff = staff.filter(i => i.id !== person.id);
                                                        setAttributes({ staff: newStaff });
                                                    } }
                                                >
                                                    Remove staff
                                                </Button>
                                            </div>
                                            <hr className="gyc-pricing-table-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newPerson = {
                                            id: Date.now(),
                                            photo: '',
                                            name: '',
                                            role: '',
                                            country: '',
                                            description: '',
                                            workshops: []
                                        };

                                        setAttributes({ staff: [ ...staff, newPerson ] });
                                    } }
                                >
                                    Add staff
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
