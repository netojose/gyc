import {
    TextControl,
    TextareaControl,
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

const ICON_OPTIONS = [
    { label: 'Email', value: 'mail' },
    { label: 'Chat bubble', value: 'chat' },
    { label: 'Location pin', value: 'location' },
    { label: 'Phone', value: 'phone' },
];

const NETWORK_OPTIONS = [
    { label: 'Instagram', value: 'instagram' },
    { label: 'YouTube', value: 'youtube' },
    { label: 'Facebook', value: 'facebook' },
    { label: 'TikTok', value: 'tiktok' },
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
    const { title, cards, socials, formTitle, formText, topics, recipient, buttonLabel, note, successMessage } = attributes;

    const updateCard = ( id, changes ) => {
        setAttributes({ cards: cards.map(i => i.id === id ? { ...i, ...changes } : i) });
    };

    const updateSocial = ( id, changes ) => {
        setAttributes({ socials: socials.map(i => i.id === id ? { ...i, ...changes } : i) });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Contact">
                    <div className="gyc-contact-fields-wrapper">
                        <TextControl
                            label="Title"
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Contact cards">
                                <p>Links can be full URLs, email addresses, site paths like /faq/, or #contact-form to jump to the form.</p>
                                {cards.map(card => (
                                    <PanelRow key={card.id}>
                                        <div className="gyc-contact-fields-wrapper">
                                            <SelectControl
                                                label="Icon"
                                                value={ card.icon || 'mail' }
                                                options={ ICON_OPTIONS }
                                                onChange={ ( newValue ) => updateCard( card.id, { icon: newValue } ) }
                                            />
                                            <TextControl
                                                label="Title"
                                                value={ card.title || '' }
                                                onChange={ ( newValue ) => updateCard( card.id, { title: newValue } ) }
                                            />
                                            <TextareaControl
                                                label="Text"
                                                rows={2}
                                                value={ card.text || '' }
                                                onChange={ ( newValue ) => updateCard( card.id, { text: newValue } ) }
                                            />
                                            <TextControl
                                                label="Link label"
                                                value={ card.linkLabel || '' }
                                                onChange={ ( newValue ) => updateCard( card.id, { linkLabel: newValue } ) }
                                            />
                                            <TextControl
                                                label="Link"
                                                value={ card.linkUrl || '' }
                                                onChange={ ( newValue ) => updateCard( card.id, { linkUrl: newValue } ) }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => setAttributes({ cards: cards.filter(i => i.id !== card.id) }) }
                                                >
                                                    Remove card
                                                </Button>
                                            </div>
                                            <hr className="gyc-contact-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newCard = { id: Date.now(), icon: 'mail', title: '', text: '', linkLabel: '', linkUrl: '' };
                                        setAttributes({ cards: [...cards, newCard] });
                                    } }
                                >
                                    Add card
                                </Button>
                            </PanelBody>
                        </Panel>

                        <Panel>
                            <PanelBody initialOpen={false} title="Social links">
                                {socials.map(social => (
                                    <PanelRow key={social.id}>
                                        <div className="gyc-contact-fields-wrapper">
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
                                                    onClick={ () => setAttributes({ socials: socials.filter(i => i.id !== social.id) }) }
                                                >
                                                    Remove social link
                                                </Button>
                                            </div>
                                            <hr className="gyc-contact-separator" />
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

                        <Panel>
                            <PanelBody initialOpen={false} title="Message form">
                                <div className="gyc-contact-fields-wrapper">
                                    <TextControl
                                        label="Send messages to"
                                        help="Email address that receives the messages. Visitors never see it. Leave empty to hide the form."
                                        type="email"
                                        value={ recipient || '' }
                                        onChange={ ( newValue ) => setAttributes( { recipient: newValue } ) }
                                    />
                                    <TextControl
                                        label="Form title"
                                        value={ formTitle || '' }
                                        onChange={ ( newValue ) => setAttributes( { formTitle: newValue } ) }
                                    />
                                    <TextareaControl
                                        label="Form text"
                                        rows={2}
                                        value={ formText || '' }
                                        onChange={ ( newValue ) => setAttributes( { formText: newValue } ) }
                                    />
                                    <TextareaControl
                                        label="Topics"
                                        help="One per line. The first one is selected by default and the chosen topic is added to the email subject."
                                        rows={5}
                                        value={ topics || '' }
                                        onChange={ ( newValue ) => setAttributes( { topics: newValue } ) }
                                    />
                                    <TextControl
                                        label="Button label"
                                        value={ buttonLabel || '' }
                                        onChange={ ( newValue ) => setAttributes( { buttonLabel: newValue } ) }
                                    />
                                    <TextControl
                                        label="Note under the button"
                                        value={ note || '' }
                                        onChange={ ( newValue ) => setAttributes( { note: newValue } ) }
                                    />
                                    <TextareaControl
                                        label="Message after sending"
                                        rows={2}
                                        value={ successMessage || '' }
                                        onChange={ ( newValue ) => setAttributes( { successMessage: newValue } ) }
                                    />
                                </div>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
