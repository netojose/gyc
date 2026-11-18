import { Panel, PanelBody, ToggleControl } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';
import { Field } from '../../editor/info-fields';
import OpensAtField from '../../editor/opens-at-field';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { active, buttonOpensAt } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={ false } title={ `Info Register Banner${ active ? '' : ' (hidden)' }` }>
                    <div className="gyc-info-fields-wrapper">
                        <ToggleControl
                            label="Show this section"
                            help={ active ? 'Shown: this section appears on the page.' : 'Hidden: visitors do not see this section. Its content is kept.' }
                            checked={ !! active }
                            onChange={ ( newValue ) => setAttributes( { active: newValue } ) }
                        />
                        <Field attributes={ attributes } setAttributes={ setAttributes } name="eyebrow" label="Label above the title" />
                        <Field attributes={ attributes } setAttributes={ setAttributes } name="title" label="Title" />
                        <Field attributes={ attributes } setAttributes={ setAttributes } name="text" label="Text" textarea rows={ 2 } />
                        <Field attributes={ attributes } setAttributes={ setAttributes } name="buttonLabel" label="Button label" help="Leave empty to hide the button." />
                        <Field attributes={ attributes } setAttributes={ setAttributes } name="buttonUrl" label="Button link" />
                        <OpensAtField
                            label="Button active from (CET, optional)"
                            value={ buttonOpensAt }
                            onChange={ ( newValue ) => setAttributes( { buttonOpensAt: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
