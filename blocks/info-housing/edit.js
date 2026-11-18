import { Panel, PanelBody } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';
import { SectionFields, ItemsPanel } from '../../editor/info-fields';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { active, hotels, tips } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={ false } title={ `Info Housing${ active ? '' : ' (hidden)' }` }>
                    <div className="gyc-info-fields-wrapper">
                        <SectionFields attributes={ attributes } setAttributes={ setAttributes } />

                        <ItemsPanel
                            title="Hotels"
                            help="Until a photo is set, a grey box is shown. With a booking link, the hotel name links to it."
                            items={ hotels }
                            onChange={ ( newValue ) => setAttributes( { hotels: newValue } ) }
                            fields={ [
                                { key: 'image', label: 'Photo URL', help: 'Upload to the Media Library and paste its File URL.' },
                                { key: 'imageAlt', label: 'Photo alt text' },
                                { key: 'name', label: 'Name' },
                                { key: 'subtitle', label: 'Distance or short note' },
                                { key: 'price', label: 'Price', help: 'Shown as typed, for example €96.' },
                                { key: 'unit', label: 'Text after the price' },
                                { key: 'note', label: 'Small print', help: 'For example check-in and check-out times.' },
                                { key: 'url', label: 'Booking link (optional)' },
                            ] }
                            newItem={ { image: '', imageAlt: '', name: '', subtitle: '', price: '', unit: '/ room / night · up to 4 people', note: '', url: '' } }
                            addLabel="Add hotel"
                            itemLabel="hotel"
                        />

                        <ItemsPanel
                            title="Tips"
                            items={ tips }
                            onChange={ ( newValue ) => setAttributes( { tips: newValue } ) }
                            fields={ [
                                { key: 'title', label: 'Title' },
                                { key: 'text', label: 'Text', type: 'textarea', rows: 2 },
                            ] }
                            newItem={ { title: '', text: '' } }
                            addLabel="Add tip"
                            itemLabel="tip"
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
