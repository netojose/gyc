import { Panel, PanelBody, TextareaControl, Notice } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';
import { SectionFields, Field, ItemsPanel } from '../../editor/info-fields';
import './editor.scss';

// Same rule as GycInfo::map_embed_url(): only maps served by Google Maps are embedded
const isGoogleMapsEmbed = ( value ) => {
    const src = ( value.match( /src\s*=\s*["']([^"']+)["']/i ) || [ null, value ] )[ 1 ].trim();
    return /^https:\/\/(www\.|maps\.)?google\.com\/maps/i.test( src );
};

export default function Edit({ attributes, setAttributes }) {
    const { active, mapEmbed, cards } = attributes;
    const hasInvalidMap = !! mapEmbed && ! isGoogleMapsEmbed( mapEmbed );

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={ false } title={ `Info Venue${ active ? '' : ' (hidden)' }` }>
                    <div className="gyc-info-fields-wrapper">
                        <SectionFields attributes={ attributes } setAttributes={ setAttributes } />

                        <Panel>
                            <PanelBody initialOpen={ false } title="Venue and map">
                                <div className="gyc-info-fields-wrapper">
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="venueLabel" label="Small label" />
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="venueName" label="Venue name" />
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="address" label="Address" help="Also used for the Google Maps buttons when their links are empty." />

                                    <TextareaControl
                                        label="Google Maps embed"
                                        help="In Google Maps, find the venue, click Share → Embed a map → Copy HTML, and paste the code here (the <iframe> code or only its src address). Leave empty to hide the map."
                                        rows={ 4 }
                                        value={ mapEmbed || '' }
                                        onChange={ ( newValue ) => setAttributes( { mapEmbed: newValue } ) }
                                    />
                                    { hasInvalidMap && (
                                        <Notice status="warning" isDismissible={ false }>
                                            This is not a Google Maps embed, so no map is shown. Copy the code from Share → Embed a map.
                                        </Notice>
                                    ) }

                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="mapsLabel" label="First button label" help="Leave empty to hide the button." />
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="mapsUrl" label="First button link (optional)" help="Leave empty to search the venue name and address in Google Maps." />
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="directionsLabel" label="Second button label" help="Leave empty to hide the button." />
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="directionsUrl" label="Second button link (optional)" help="Leave empty to open Google Maps directions to the venue name and address." />
                                    <Field attributes={ attributes } setAttributes={ setAttributes } name="mapNote" label="Note under the buttons" textarea rows={ 2 } />
                                </div>
                            </PanelBody>
                        </Panel>

                        <ItemsPanel
                            title="Cards next to the venue"
                            items={ cards }
                            onChange={ ( newValue ) => setAttributes( { cards: newValue } ) }
                            fields={ [
                                { key: 'icon', type: 'icon' },
                                { key: 'title', label: 'Title' },
                                { key: 'text', label: 'Text', type: 'textarea' },
                                { key: 'linkLabel', label: 'Button label (optional)' },
                                { key: 'linkUrl', label: 'Button link' },
                            ] }
                            newItem={ { icon: '', title: '', text: '', linkLabel: '', linkUrl: '' } }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
