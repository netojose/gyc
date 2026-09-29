import {
    TextControl,
    SelectControl,
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

const NETWORK_OPTIONS = [
    { label: 'Instagram', value: 'instagram' },
    { label: 'TikTok', value: 'tiktok' },
    { label: 'YouTube', value: 'youtube' },
    { label: 'Facebook', value: 'facebook' },
];

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
    const { logo, logoAlt, logoUrl, menu, socials, buttonLabel, buttonUrl } = attributes;

    const updateMenuItem = ( id, changes ) => {
        const newMenu = menu.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ menu: newMenu });
    };

    const updateSocial = ( id, changes ) => {
        const newSocials = socials.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ socials: newSocials });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Site Header">
                    <div className="gyc-header-fields-wrapper">
                        <TextControl
                            label="Logo image URL"
                            value={ logo || '' }
                            onChange={ ( newValue ) => setAttributes( { logo: newValue } ) }
                        />
                        <TextControl
                            label="Logo alt text"
                            help="Describes where the logo link goes, e.g. GYC Europe home."
                            value={ logoAlt || '' }
                            onChange={ ( newValue ) => setAttributes( { logoAlt: newValue } ) }
                        />
                        <TextControl
                            label="Logo link"
                            value={ logoUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { logoUrl: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Menu">
                                <p>Links can be full URLs, site paths like /about, or sections like #about-us.</p>
                                {menu.map(item => (
                                    <PanelRow key={item.id}>
                                        <div className="gyc-header-fields-wrapper">
                                            <TextControl
                                                label="Label"
                                                value={ item.label || '' }
                                                onChange={ ( newValue ) => updateMenuItem( item.id, { label: newValue } ) }
                                            />
                                            <TextControl
                                                label="Link"
                                                value={ item.url || '' }
                                                onChange={ ( newValue ) => updateMenuItem( item.id, { url: newValue } ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newMenu = menu.filter(i => i.id !== item.id);
                                                        setAttributes({ menu: newMenu });
                                                    } }
                                                >
                                                    Remove menu item
                                                </Button>
                                            </div>
                                            <hr className="gyc-header-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newItem = { id: Date.now(), label: '', url: '' };
                                        setAttributes({ menu: [...menu, newItem] });
                                    } }
                                >
                                    Add menu item
                                </Button>
                            </PanelBody>
                        </Panel>

                        <Panel>
                            <PanelBody initialOpen={false} title="Social links">
                                {socials.map(social => (
                                    <PanelRow key={social.id}>
                                        <div className="gyc-header-fields-wrapper">
                                            <SelectControl
                                                label="Network"
                                                value={ social.network || 'instagram' }
                                                options={ NETWORK_OPTIONS }
                                                onChange={ ( newValue ) => updateSocial( social.id, { network: newValue } ) }
                                            />
                                            <TextControl
                                                label="Link"
                                                value={ social.url || '' }
                                                onChange={ ( newValue ) => updateSocial( social.id, { url: newValue } ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newSocials = socials.filter(i => i.id !== social.id);
                                                        setAttributes({ socials: newSocials });
                                                    } }
                                                >
                                                    Remove social link
                                                </Button>
                                            </div>
                                            <hr className="gyc-header-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newSocial = { id: Date.now(), network: 'instagram', url: '' };
                                        setAttributes({ socials: [...socials, newSocial] });
                                    } }
                                >
                                    Add social link
                                </Button>
                            </PanelBody>
                        </Panel>

                        <TextControl
                            label="Button label"
                            value={ buttonLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { buttonLabel: newValue } ) }
                        />
                        <TextControl
                            label="Button link"
                            value={ buttonUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { buttonUrl: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
