import { Panel, PanelBody } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';
import { SectionFields, Field, ItemsPanel } from '../../editor/info-fields';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { active, groups } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={ false } title={ `Info Under 18${ active ? '' : ' (hidden)' }` }>
                    <div className="gyc-info-fields-wrapper">
                        <SectionFields attributes={ attributes } setAttributes={ setAttributes } />

                        <ItemsPanel
                            title="Age groups"
                            items={ groups }
                            onChange={ ( newValue ) => setAttributes( { groups: newValue } ) }
                            fields={ [
                                { key: 'ages', label: 'Ages', help: 'For example 7-13.' },
                                { key: 'unit', label: 'Small label under the ages', help: 'For example Years.' },
                                { key: 'title', label: 'Title' },
                                { key: 'text', label: 'Text', type: 'textarea', rows: 2 },
                            ] }
                            newItem={ { ages: '', unit: 'Years', title: '', text: '' } }
                            addLabel="Add age group"
                            itemLabel="age group"
                        />

                        <Field attributes={ attributes } setAttributes={ setAttributes } name="note" label="How it works (mint note)" help="Leave empty to hide it." textarea />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
