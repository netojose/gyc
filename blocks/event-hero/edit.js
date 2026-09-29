import {
    TextControl,
    Panel,
    PanelBody,
    PanelRow,
    Button
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
    const { eyebrow, title, primaryLabel, primaryUrl, secondaryLabel, secondaryUrl, stats } = attributes;

    const updateStat = ( id, changes ) => {
        const newStats = stats.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ stats: newStats });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Event Hero">
                    <div className="gyc-event-hero-fields-wrapper">
                        <TextControl
                            label="Eyebrow"
                            value={ eyebrow || '' }
                            onChange={ ( newValue ) => setAttributes( { eyebrow: newValue } ) }
                        />
                        <TextControl
                            label="Title"
                            help="Leave empty to use the event title."
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />

                        <p>Links can be full URLs, site paths like /about, sections like #schedule, or an email address.</p>
                        <TextControl
                            label="First link label"
                            value={ primaryLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { primaryLabel: newValue } ) }
                        />
                        <TextControl
                            label="First link"
                            value={ primaryUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { primaryUrl: newValue } ) }
                        />
                        <TextControl
                            label="Second link label"
                            value={ secondaryLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { secondaryLabel: newValue } ) }
                        />
                        <TextControl
                            label="Second link"
                            value={ secondaryUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { secondaryUrl: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Numbers">
                                {stats.map(stat => (
                                    <PanelRow key={stat.id}>
                                        <div className="gyc-event-hero-fields-wrapper">
                                            <TextControl
                                                label="Number"
                                                value={ stat.value || '' }
                                                onChange={ ( newValue ) => updateStat( stat.id, { value: newValue } ) }
                                            />
                                            <TextControl
                                                label="Label"
                                                value={ stat.label || '' }
                                                onChange={ ( newValue ) => updateStat( stat.id, { label: newValue } ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newStats = stats.filter(i => i.id !== stat.id);
                                                        setAttributes({ stats: newStats });
                                                    } }
                                                >
                                                    Remove
                                                </Button>
                                            </div>
                                            <hr className="gyc-event-hero-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newStat = { id: Date.now(), value: '', label: '' };
                                        setAttributes({ stats: [...stats, newStat] });
                                    } }
                                >
                                    Add number
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
