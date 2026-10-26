import {
    TextControl,
    TextareaControl,
    SelectControl,
    ToggleControl,
    Button,
    Panel,
    PanelBody,
    PanelRow
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

const EMPTY_EVENT = {
    organizer: 'europe',
    featured: false,
    image: '',
    imageAlt: '',
    badgeTop: '',
    badgeMain: '',
    label: '',
    online: false,
    title: '',
    date: '',
    location: '',
    text: '',
    linkLabel: '',
    linkUrl: '',
    secondLabel: '',
    secondUrl: '',
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
    const { allLabel, europeLabel, focusLabel, emptyText, events, pastEyebrow, pastTitle, past } = attributes;

    const updateEvent = ( id, changes ) => {
        setAttributes({ events: events.map(e => e.id === id ? { ...e, ...changes } : e) });
    };
    const moveEvent = ( index, step ) => {
        const newEvents = [ ...events ];
        const [ moved ] = newEvents.splice( index, 1 );
        newEvents.splice( index + step, 0, moved );
        setAttributes({ events: newEvents });
    };
    const updatePast = ( id, changes ) => {
        setAttributes({ past: past.map(p => p.id === id ? { ...p, ...changes } : p) });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Events Overview">
                    <div className="gyc-events-overview-fields-wrapper">
                        <TextControl
                            label="Filter – all events"
                            value={ allLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { allLabel: newValue } ) }
                        />
                        <TextControl
                            label="Filter – GYC Europe"
                            value={ europeLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { europeLabel: newValue } ) }
                        />
                        <TextControl
                            label="Filter – GYC Focus"
                            value={ focusLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { focusLabel: newValue } ) }
                        />
                        <TextareaControl
                            label="Text when there are no events"
                            rows={2}
                            value={ emptyText || '' }
                            onChange={ ( newValue ) => setAttributes( { emptyText: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Upcoming events">
                                {events.map((event, index) => (
                                    <PanelRow key={event.id}>
                                        <div className="gyc-events-overview-fields-wrapper">
                                            <TextControl
                                                label="Title"
                                                value={ event.title || '' }
                                                onChange={ ( newValue ) => updateEvent( event.id, { title: newValue } ) }
                                            />
                                            <SelectControl
                                                label="Organizer"
                                                help="Used by the filter and the coloured tag."
                                                value={ event.organizer || 'europe' }
                                                options={ [
                                                    { label: 'GYC Europe', value: 'europe' },
                                                    { label: 'GYC Focus', value: 'focus' },
                                                ] }
                                                onChange={ ( newValue ) => updateEvent( event.id, { organizer: newValue } ) }
                                            />
                                            <ToggleControl
                                                label="Featured (large card across the full width)"
                                                checked={ !! event.featured }
                                                onChange={ ( newValue ) => updateEvent( event.id, { featured: newValue } ) }
                                            />
                                            { event.featured ? (
                                                <TextControl
                                                    label="Label above the title"
                                                    help="Leave empty to show the organizer."
                                                    value={ event.label || '' }
                                                    onChange={ ( newValue ) => updateEvent( event.id, { label: newValue } ) }
                                                />
                                            ) : (
                                                <>
                                                    <ToggleControl
                                                        label="Online event"
                                                        checked={ !! event.online }
                                                        onChange={ ( newValue ) => updateEvent( event.id, { online: newValue } ) }
                                                    />
                                                    <TextControl
                                                        label="Date badge – small line"
                                                        help="For example Mon, Aug or Daily. Leave both badge lines empty to hide the badge."
                                                        value={ event.badgeTop || '' }
                                                        onChange={ ( newValue ) => updateEvent( event.id, { badgeTop: newValue } ) }
                                                    />
                                                    <TextControl
                                                        label="Date badge – big line"
                                                        help="For example 18 or 7:00."
                                                        value={ event.badgeMain || '' }
                                                        onChange={ ( newValue ) => updateEvent( event.id, { badgeMain: newValue } ) }
                                                    />
                                                </>
                                            ) }
                                            <TextControl
                                                label="Date"
                                                value={ event.date || '' }
                                                onChange={ ( newValue ) => updateEvent( event.id, { date: newValue } ) }
                                            />
                                            <TextControl
                                                label="Place"
                                                value={ event.location || '' }
                                                onChange={ ( newValue ) => updateEvent( event.id, { location: newValue } ) }
                                            />
                                            <TextareaControl
                                                label="Text (optional)"
                                                rows={3}
                                                value={ event.text || '' }
                                                onChange={ ( newValue ) => updateEvent( event.id, { text: newValue } ) }
                                            />
                                            <TextControl
                                                label="Image URL"
                                                value={ event.image || '' }
                                                onChange={ ( newValue ) => updateEvent( event.id, { image: newValue } ) }
                                            />
                                            <TextControl
                                                label="Image alt text"
                                                value={ event.imageAlt || '' }
                                                onChange={ ( newValue ) => updateEvent( event.id, { imageAlt: newValue } ) }
                                            />
                                            <TextControl
                                                label={ event.featured ? 'Main button label' : 'Link label' }
                                                value={ event.linkLabel || '' }
                                                onChange={ ( newValue ) => updateEvent( event.id, { linkLabel: newValue } ) }
                                            />
                                            <TextControl
                                                label={ event.featured ? 'Main button link' : 'Link' }
                                                help="Full URL or site path like /register/. Links to other websites open in a new tab."
                                                value={ event.linkUrl || '' }
                                                onChange={ ( newValue ) => updateEvent( event.id, { linkUrl: newValue } ) }
                                            />
                                            { event.featured && (
                                                <>
                                                    <TextControl
                                                        label="Second button label"
                                                        value={ event.secondLabel || '' }
                                                        onChange={ ( newValue ) => updateEvent( event.id, { secondLabel: newValue } ) }
                                                    />
                                                    <TextControl
                                                        label="Second button link"
                                                        value={ event.secondUrl || '' }
                                                        onChange={ ( newValue ) => updateEvent( event.id, { secondUrl: newValue } ) }
                                                    />
                                                </>
                                            ) }
                                            <div className="gyc-events-overview-actions">
                                                <Button size="small" variant="secondary" disabled={ index === 0 } onClick={ () => moveEvent( index, -1 ) }>Move up</Button>
                                                <Button size="small" variant="secondary" disabled={ index === events.length - 1 } onClick={ () => moveEvent( index, 1 ) }>Move down</Button>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => setAttributes({ events: events.filter(e => e.id !== event.id) }) }
                                                >
                                                    Remove event
                                                </Button>
                                            </div>
                                            <hr className="gyc-events-overview-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => setAttributes({ events: [ ...events, { ...EMPTY_EVENT, id: Date.now() } ] }) }
                                >
                                    Add event
                                </Button>
                            </PanelBody>
                        </Panel>

                        <TextControl
                            label="Past events – eyebrow"
                            value={ pastEyebrow || '' }
                            onChange={ ( newValue ) => setAttributes( { pastEyebrow: newValue } ) }
                        />
                        <TextControl
                            label="Past events – title"
                            value={ pastTitle || '' }
                            onChange={ ( newValue ) => setAttributes( { pastTitle: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Past events">
                                {past.map(item => (
                                    <PanelRow key={item.id}>
                                        <div className="gyc-events-overview-fields-wrapper">
                                            <TextControl
                                                label="Title"
                                                value={ item.title || '' }
                                                onChange={ ( newValue ) => updatePast( item.id, { title: newValue } ) }
                                            />
                                            <TextControl
                                                label="Text"
                                                value={ item.text || '' }
                                                onChange={ ( newValue ) => updatePast( item.id, { text: newValue } ) }
                                            />
                                            <TextControl
                                                label="Link"
                                                help="For example the YouTube playlist with the sessions."
                                                value={ item.url || '' }
                                                onChange={ ( newValue ) => updatePast( item.id, { url: newValue } ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => setAttributes({ past: past.filter(p => p.id !== item.id) }) }
                                                >
                                                    Remove past event
                                                </Button>
                                            </div>
                                            <hr className="gyc-events-overview-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => setAttributes({ past: [ { id: Date.now(), title: '', text: 'Watch the sessions', url: '' }, ...past ] }) }
                                >
                                    Add past event
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
