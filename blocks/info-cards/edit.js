import { Panel, PanelBody, SelectControl } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';
import { SectionFields, ItemsPanel } from '../../editor/info-fields';
import './editor.scss';

const CARD_FIELDS = [
    { key: 'style', label: 'Colour', type: 'select', options: [
        { label: 'White', value: 'white' },
        { label: 'Purple', value: 'plum' },
        { label: 'Mint', value: 'mint' },
    ] },
    { key: 'icon', type: 'icon' },
    { key: 'title', label: 'Title' },
    { key: 'items', label: 'Bullet points', type: 'textarea', help: 'One per line. Optional.' },
    { key: 'text', label: 'Text', type: 'textarea', help: 'Optional, shown under the bullet points.' },
    { key: 'linkLabel', label: 'Link label (optional)' },
    { key: 'linkUrl', label: 'Link', help: 'Full URL, a site path like /volunteer/, or a section like #venue.' },
];

const NEW_CARD = { style: 'white', icon: '', title: '', items: '', text: '', linkLabel: '', linkUrl: '' };

export default function Edit({ attributes, setAttributes }) {
    const { active, title, background, iconColor, cards, wideCards } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={ false } title={ `Info Cards${ title ? `: ${ title }` : '' }${ active ? '' : ' (hidden)' }` }>
                    <div className="gyc-info-fields-wrapper">
                        <SectionFields attributes={ attributes } setAttributes={ setAttributes } />

                        <SelectControl
                            label="Background"
                            value={ background || 'lilac' }
                            options={ [
                                { label: 'Lilac', value: 'lilac' },
                                { label: 'Cream', value: 'cream' },
                                { label: 'White', value: 'white' },
                            ] }
                            onChange={ ( newValue ) => setAttributes( { background: newValue } ) }
                        />
                        <SelectControl
                            label="Icons on white cards"
                            value={ iconColor || 'mint' }
                            options={ [
                                { label: 'Mint square, purple icon', value: 'mint' },
                                { label: 'Purple square, mint icon', value: 'plum' },
                            ] }
                            onChange={ ( newValue ) => setAttributes( { iconColor: newValue } ) }
                        />

                        <ItemsPanel
                            title="Cards (three per row)"
                            items={ cards }
                            onChange={ ( newValue ) => setAttributes( { cards: newValue } ) }
                            fields={ CARD_FIELDS }
                            newItem={ NEW_CARD }
                        />

                        <ItemsPanel
                            title="Wide cards (two per row, optional)"
                            items={ wideCards }
                            onChange={ ( newValue ) => setAttributes( { wideCards: newValue } ) }
                            fields={ CARD_FIELDS }
                            newItem={ NEW_CARD }
                            addLabel="Add wide card"
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
