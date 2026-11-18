import { Panel, PanelBody } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';
import { SectionFields, Field, ItemsPanel } from '../../editor/info-fields';
import OpensAtField from '../../editor/opens-at-field';
import './editor.scss';

// An editor's own icon, for activities none of the built-in icons fit
const ICON_IMAGE_FIELD = {
    key: 'iconImage',
    label: 'Own icon image URL (optional)',
    help: 'Replaces the icon above. Upload a square PNG (transparent background, dark purple, at least 96 × 96 px) to the Media Library and paste its File URL.',
};

export default function Edit({ attributes, setAttributes }) {
    const { active, anchorId, events, projects } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={ false } title={ `Info Outreach${ active ? '' : ' (hidden)' }` }>
                    <div className="gyc-info-fields-wrapper">
                        <SectionFields attributes={ attributes } setAttributes={ setAttributes } />

                        <ItemsPanel
                            title="Outreach events"
                            help="Large cards, two per row (one fills the width). Every field is optional: empty ones are left out."
                            items={ events }
                            onChange={ ( newValue ) => setAttributes( { events: newValue } ) }
                            fields={ [
                                { key: 'style', label: 'Colour', type: 'select', options: [ { label: 'Purple', value: 'plum' }, { label: 'White', value: 'white' } ] },
                                { key: 'label', label: 'Small label', help: 'For example Before the conference.' },
                                { key: 'title', label: 'Title' },
                                { key: 'dates', label: 'Dates' },
                                { key: 'place', label: 'Place' },
                                { key: 'text', label: 'Text', type: 'textarea' },
                                { key: 'items', label: 'Bullet points', type: 'textarea', help: 'One per line.' },
                                { key: 'image', label: 'Photo URL (optional)', help: 'Shown at the top of the card. Upload to the Media Library and paste its File URL.' },
                                { key: 'imageAlt', label: 'Photo alt text' },
                                { key: 'buttonLabel', label: 'Button label', help: 'Leave empty to hide the button.' },
                                { key: 'buttonUrl', label: 'Button link', help: `Full URL, a site path, or #${ anchorId || 'outreach' }-projects for the projects below.` },
                                { key: 'buttonOpensAt', label: 'Button active from (CET, optional)', type: 'opensAt' },
                            ] }
                            newItem={ { style: 'white', label: '', title: '', dates: '', place: '', text: '', items: '', image: '', imageAlt: '', buttonLabel: '', buttonUrl: '', buttonOpensAt: '' } }
                            addLabel="Add event"
                            itemLabel="event"
                        />

                        <Panel>
                            <PanelBody initialOpen={ false } title="Projects">
                                <div className="gyc-info-fields-wrapper">
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="projectsTitle" label="Projects title" help={ `Optional. Links can jump here with #${ anchorId || 'outreach' }-projects.` } />
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="projectsText" label="Projects text" textarea rows={ 2 } />
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="projectsButtonLabel" label="Registration button label" help="Shown centred at the end of the section, after the note. Leave empty to hide the button." />
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="projectsButtonUrl" label="Registration button link" help="Full URL of the registration portal; it opens in a new tab." />
                                    <OpensAtField
                                        label="Button active from (CET, optional)"
                                        value={ attributes.projectsButtonOpensAt }
                                        onChange={ ( newValue ) => setAttributes( { projectsButtonOpensAt: newValue } ) }
                                    />
                                </div>
                            </PanelBody>
                        </Panel>

                        <ItemsPanel
                            title="Project cards"
                            help="Four per row on large screens, as many rows as needed. The tag is a small pill at the bottom, e.g. Bring: Your Bible."
                            items={ projects }
                            onChange={ ( newValue ) => setAttributes( { projects: newValue } ) }
                            fields={ [
                                { key: 'icon', type: 'icon' },
                                ICON_IMAGE_FIELD,
                                { key: 'title', label: 'Title' },
                                { key: 'text', label: 'Text', type: 'textarea', rows: 2 },
                                { key: 'tag', label: 'Tag (optional)' },
                            ] }
                            newItem={ { icon: 'heart', iconImage: '', title: '', text: '', tag: '' } }
                            addLabel="Add project"
                            itemLabel="project"
                        />

                        <Field attributes={ attributes } setAttributes={ setAttributes } name="note" label="Note at the bottom (mint)" help="Leave empty to hide it." textarea rows={ 2 } />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
