import { Panel, PanelBody } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';
import { SectionFields, Field, ItemsPanel } from '../../editor/info-fields';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { active, days } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={ false } title={ `Info Schedule${ active ? '' : ' (hidden)' }` }>
                    <div className="gyc-info-fields-wrapper">
                        <SectionFields attributes={ attributes } setAttributes={ setAttributes } />

                        <ItemsPanel
                            title="Days"
                            items={ days }
                            onChange={ ( newValue ) => setAttributes( { days: newValue } ) }
                            fields={ [
                                { key: 'weekday', label: 'Day', help: 'For example Wed.' },
                                { key: 'date', label: 'Date', help: 'For example 18 Aug.' },
                                { key: 'items', label: 'What happens', type: 'textarea', help: 'One line each.' },
                                { key: 'highlight', label: 'Highlight in purple', type: 'toggle' },
                            ] }
                            newItem={ { weekday: '', date: '', items: '', highlight: false } }
                            addLabel="Add day"
                            itemLabel="day"
                        />

                        <Field attributes={ attributes } setAttributes={ setAttributes } name="linkLabel" label="Text under the days" help="Leave empty to hide it." />
                        <Field attributes={ attributes } setAttributes={ setAttributes } name="linkUrl" label="Link (optional)" help="With a link, the text becomes a link with an arrow, e.g. to the event page." />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
