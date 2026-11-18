import { Panel, PanelBody } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';
import { SectionFields, Field, ItemsPanel } from '../../editor/info-fields';
import OpensAtField from '../../editor/opens-at-field';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { active, tiers, extras } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={ false } title={ `Info Registration${ active ? '' : ' (hidden)' }` }>
                    <div className="gyc-info-fields-wrapper">
                        <SectionFields attributes={ attributes } setAttributes={ setAttributes } />

                        <ItemsPanel
                            title="Prices"
                            help="A price with a badge (e.g. Best price) is shown in purple."
                            items={ tiers }
                            onChange={ ( newValue ) => setAttributes( { tiers: newValue } ) }
                            fields={ [
                                { key: 'badge', label: 'Badge (optional)' },
                                { key: 'label', label: 'Name', help: 'For example Early bird.' },
                                { key: 'price', label: 'Price', help: 'Shown as typed, for example €120.' },
                                { key: 'date', label: 'Date' },
                                { key: 'note', label: 'Small print', type: 'textarea', rows: 2 },
                            ] }
                            newItem={ { badge: '', label: '', price: '', date: '', note: '' } }
                            addLabel="Add price"
                            itemLabel="price"
                        />

                        <ItemsPanel
                            title="Extras and notes"
                            help="Smaller cards under the prices. The value (e.g. Free) is optional."
                            items={ extras }
                            onChange={ ( newValue ) => setAttributes( { extras: newValue } ) }
                            fields={ [
                                { key: 'style', label: 'Colour', type: 'select', options: [ { label: 'Lilac', value: 'lilac' }, { label: 'White', value: 'white' } ] },
                                { key: 'label', label: 'Name' },
                                { key: 'value', label: 'Value (optional)' },
                                { key: 'text', label: 'Text', type: 'textarea' },
                            ] }
                            newItem={ { style: 'lilac', label: '', value: '', text: '' } }
                        />

                        <Field attributes={ attributes } setAttributes={ setAttributes } name="buttonLabel" label="Button label" help="Leave empty to hide the button." />
                        <Field attributes={ attributes } setAttributes={ setAttributes } name="buttonUrl" label="Button link" />
                        <OpensAtField
                            label="Button active from (CET, optional)"
                            value={ attributes.buttonOpensAt }
                            onChange={ ( newValue ) => setAttributes( { buttonOpensAt: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
