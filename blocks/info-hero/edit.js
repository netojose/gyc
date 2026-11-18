import { Panel, PanelBody } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';
import { Field, ItemsPanel } from '../../editor/info-fields';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { links } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={ false } title="Info Hero">
                    <div className="gyc-info-fields-wrapper">
                        <Field attributes={ attributes } setAttributes={ setAttributes } name="eyebrow" label="Label above the title" />
                        <Field attributes={ attributes } setAttributes={ setAttributes } name="title" label="Title" help="The page's main heading." />
                        <Field attributes={ attributes } setAttributes={ setAttributes } name="text" label="Text" textarea />

                        <ItemsPanel
                            title="Section buttons"
                            help="Each button jumps to a section on this page: use # and that section's Section ID (e.g. #meals). Site paths like /faq/ also work. A button without a label or link is hidden."
                            items={ links }
                            onChange={ ( newValue ) => setAttributes( { links: newValue } ) }
                            fields={ [
                                { key: 'icon', type: 'icon' },
                                { key: 'label', label: 'Label' },
                                { key: 'url', label: 'Link', help: 'For example #registration.' },
                            ] }
                            newItem={ { icon: '', label: '', url: '#' } }
                            addLabel="Add button"
                            itemLabel="button"
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
