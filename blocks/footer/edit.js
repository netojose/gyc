import {
    TextControl,
    TextareaControl,
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
    const {
        logo,
        logoAlt,
        logoUrl,
        description,
        newsletterTitle,
        newsletterText,
        newsletterAction,
        newsletterFieldName,
        newsletterPlaceholder,
        newsletterButton,
        columns,
        copyright,
        tagline
    } = attributes;

    const updateColumn = ( id, changes ) => {
        const newColumns = columns.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ columns: newColumns });
    };

    const updateLink = ( column, linkId, changes ) => {
        const newLinks = (column.links || []).map(i => i.id === linkId ? { ...i, ...changes } : i);
        updateColumn( column.id, { links: newLinks } );
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Site Footer">
                    <div className="gyc-footer-fields-wrapper">
                        <TextControl
                            label="Logo image URL"
                            value={ logo || '' }
                            onChange={ ( newValue ) => setAttributes( { logo: newValue } ) }
                        />
                        <TextControl
                            label="Logo alt text"
                            value={ logoAlt || '' }
                            onChange={ ( newValue ) => setAttributes( { logoAlt: newValue } ) }
                        />
                        <TextControl
                            label="Logo link"
                            value={ logoUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { logoUrl: newValue } ) }
                        />
                        <TextareaControl
                            label="Description"
                            rows={3}
                            value={ description || '' }
                            onChange={ ( newValue ) => setAttributes( { description: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Newsletter">
                                <div className="gyc-footer-fields-wrapper">
                                    <TextControl
                                        label="Title"
                                        value={ newsletterTitle || '' }
                                        onChange={ ( newValue ) => setAttributes( { newsletterTitle: newValue } ) }
                                    />
                                    <TextControl
                                        label="Text"
                                        value={ newsletterText || '' }
                                        onChange={ ( newValue ) => setAttributes( { newsletterText: newValue } ) }
                                    />
                                    <TextControl
                                        label="Form action URL"
                                        help="The sign-up URL from your newsletter provider. The form is hidden until this is set."
                                        value={ newsletterAction || '' }
                                        onChange={ ( newValue ) => setAttributes( { newsletterAction: newValue } ) }
                                    />
                                    <TextControl
                                        label="Email field name"
                                        help="The field name your provider expects, e.g. EMAIL for Mailchimp."
                                        value={ newsletterFieldName || '' }
                                        onChange={ ( newValue ) => setAttributes( { newsletterFieldName: newValue } ) }
                                    />
                                    <TextControl
                                        label="Placeholder"
                                        value={ newsletterPlaceholder || '' }
                                        onChange={ ( newValue ) => setAttributes( { newsletterPlaceholder: newValue } ) }
                                    />
                                    <TextControl
                                        label="Button label"
                                        value={ newsletterButton || '' }
                                        onChange={ ( newValue ) => setAttributes( { newsletterButton: newValue } ) }
                                    />
                                </div>
                            </PanelBody>
                        </Panel>

                        <Panel>
                            <PanelBody initialOpen={false} title="Link columns">
                                <p>Links can be full URLs, site paths like /about, sections like #about-us, or an email address.</p>
                                {columns.map(column => (
                                    <PanelRow key={column.id}>
                                        <div className="gyc-footer-fields-wrapper">
                                            <TextControl
                                                label="Column title"
                                                value={ column.title || '' }
                                                onChange={ ( newValue ) => updateColumn( column.id, { title: newValue } ) }
                                            />
                                            {(column.links || []).map(link => (
                                                <div key={link.id} className="gyc-footer-fields-wrapper">
                                                    <TextControl
                                                        label="Link label"
                                                        value={ link.label || '' }
                                                        onChange={ ( newValue ) => updateLink( column, link.id, { label: newValue } ) }
                                                    />
                                                    <TextControl
                                                        label="Link"
                                                        value={ link.url || '' }
                                                        onChange={ ( newValue ) => updateLink( column, link.id, { url: newValue } ) }
                                                    />
                                                    <div>
                                                        <Button
                                                            size="small"
                                                            variant="outline"
                                                            className="is-secondary is-destructive"
                                                            onClick={ () => {
                                                                const newLinks = column.links.filter(i => i.id !== link.id);
                                                                updateColumn( column.id, { links: newLinks } );
                                                            } }
                                                        >
                                                            Remove link
                                                        </Button>
                                                    </div>
                                                </div>
                                            ))}
                                            <div>
                                                <Button
                                                    variant="secondary"
                                                    onClick={ () => {
                                                        const newLink = { id: Date.now(), label: '', url: '' };
                                                        updateColumn( column.id, { links: [...(column.links || []), newLink] } );
                                                    } }
                                                >
                                                    Add link
                                                </Button>
                                            </div>
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newColumns = columns.filter(i => i.id !== column.id);
                                                        setAttributes({ columns: newColumns });
                                                    } }
                                                >
                                                    Remove column
                                                </Button>
                                            </div>
                                            <hr className="gyc-footer-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newColumn = { id: Date.now(), title: '', links: [] };
                                        setAttributes({ columns: [...columns, newColumn] });
                                    } }
                                >
                                    Add column
                                </Button>
                            </PanelBody>
                        </Panel>

                        <TextControl
                            label="Copyright"
                            help="{year} is replaced with the current year."
                            value={ copyright || '' }
                            onChange={ ( newValue ) => setAttributes( { copyright: newValue } ) }
                        />
                        <TextControl
                            label="Tagline"
                            value={ tagline || '' }
                            onChange={ ( newValue ) => setAttributes( { tagline: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
