import {
    TextControl,
    TextareaControl,
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

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
    const { eyebrow, title, text, areas, formTitle, skills, consent, recipient, buttonLabel, successMessage } = attributes;

    const updateArea = ( id, changes ) => {
        const newAreas = areas.map(a => a.id === id ? { ...a, ...changes } : a);
        setAttributes({ areas: newAreas });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Volunteer">
                    <div className="gyc-volunteer-fields-wrapper">
                        <TextControl
                            label="Eyebrow"
                            value={ eyebrow || '' }
                            onChange={ ( newValue ) => setAttributes( { eyebrow: newValue } ) }
                        />
                        <TextControl
                            label="Title"
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />
                        <TextareaControl
                            label="Text"
                            rows={3}
                            value={ text || '' }
                            onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Ways to volunteer">
                                {areas.map(area => (
                                    <PanelRow key={area.id}>
                                        <div className="gyc-volunteer-fields-wrapper">
                                            <TextControl
                                                label="Title"
                                                value={ area.title || '' }
                                                onChange={ ( newValue ) => updateArea( area.id, { title: newValue } ) }
                                            />
                                            <TextareaControl
                                                label="Text"
                                                rows={2}
                                                value={ area.text || '' }
                                                onChange={ ( newValue ) => updateArea( area.id, { text: newValue } ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newAreas = areas.filter(a => a.id !== area.id);
                                                        setAttributes({ areas: newAreas });
                                                    } }
                                                >
                                                    Remove item
                                                </Button>
                                            </div>
                                            <hr className="gyc-volunteer-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newArea = { id: Date.now(), title: '', text: '' };
                                        setAttributes({ areas: [...areas, newArea] });
                                    } }
                                >
                                    Add item
                                </Button>
                            </PanelBody>
                        </Panel>

                        <TextControl
                            label="Form title"
                            value={ formTitle || '' }
                            onChange={ ( newValue ) => setAttributes( { formTitle: newValue } ) }
                        />
                        <TextareaControl
                            label="Skills"
                            help="One skill per line. Applicants choose at least one."
                            rows={6}
                            value={ skills || '' }
                            onChange={ ( newValue ) => setAttributes( { skills: newValue } ) }
                        />
                        <TextareaControl
                            label="Agreement text"
                            help="Shown next to the checkbox applicants must tick."
                            rows={3}
                            value={ consent || '' }
                            onChange={ ( newValue ) => setAttributes( { consent: newValue } ) }
                        />
                        <TextControl
                            label="Button label"
                            value={ buttonLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { buttonLabel: newValue } ) }
                        />
                        <TextareaControl
                            label="Message after sending"
                            rows={2}
                            value={ successMessage || '' }
                            onChange={ ( newValue ) => setAttributes( { successMessage: newValue } ) }
                        />
                        <TextControl
                            label="Send applications to"
                            help="Visitors never see this address. Leave empty to use the site admin address (Settings → General)."
                            type="email"
                            value={ recipient || '' }
                            onChange={ ( newValue ) => setAttributes( { recipient: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
