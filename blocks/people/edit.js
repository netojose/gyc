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
    const { title, text, staffTitle, main = [], staff = [] } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="People">
                    <div className="gyc-people-fields-wrapper">
                        <TextControl
                            label="Title"
                            help="Type it in normal case; it is shown in small capitals."
                            value={ title || '' }
                            onChange={ ( newValue ) => setAttributes( { title: newValue } ) }
                        />
                        <TextareaControl
                            label="Text"
                            help="Optional, shown under the title."
                            rows={2}
                            value={ text || '' }
                            onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                        />
                        <TextControl
                            label="Workshop speakers title"
                            value={ staffTitle || '' }
                            onChange={ ( newValue ) => setAttributes( { staffTitle: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Main speakers">
                                <p>Role is shown under the name. Headline and description appear in the pop-up when a speaker is clicked.</p>
                                {main.map(person => (
                                    <PanelRow key={person.id}>
                                        <div className="gyc-people-fields-wrapper">
                                            <TextControl
                                                label="Photo"
                                                value={ person.photo || '' }
                                                onChange={ ( newValue ) => {
                                                    const newMain = main.map(i => i.id === person.id ? { ...i, photo: newValue } : i);
                                                    setAttributes({ main: newMain });
                                                } }
                                            />
                                            <TextControl
                                                label="Name"
                                                value={ person.name || '' }
                                                onChange={ ( newValue ) => {
                                                    const newMain = main.map(i => i.id === person.id ? { ...i, name: newValue } : i);
                                                    setAttributes({ main: newMain });
                                                } }
                                            />
                                            <TextControl
                                                label="Role"
                                                help="Topic or ministry, e.g. Keynote speaker."
                                                value={ person.role || '' }
                                                onChange={ ( newValue ) => {
                                                    const newMain = main.map(i => i.id === person.id ? { ...i, role: newValue } : i);
                                                    setAttributes({ main: newMain });
                                                } }
                                            />
                                            <TextControl
                                                label="Headline"
                                                value={ person.headline || '' }
                                                onChange={ ( newValue ) => {
                                                    const newMain = main.map(i => i.id === person.id ? { ...i, headline: newValue } : i);
                                                    setAttributes({ main: newMain });
                                                } }
                                            />
                                            <TextareaControl
                                                label="Description"
                                                rows={6}
                                                value={ person.description || '' }
                                                onChange={ ( newValue ) => {
                                                    const newMain = main.map(i => i.id === person.id ? { ...i, description: newValue } : i);
                                                    setAttributes({ main: newMain });
                                                } }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newMain = main.filter(i => i.id !== person.id);
                                                        setAttributes({ main: newMain });
                                                    } }
                                                >
                                                    Remove person
                                                </Button>
                                            </div>
                                            <hr className="gyc-pricing-table-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newPerson = {
                                            id: Date.now(),
                                            photo: '',
                                            name: '',
                                            role: '',
                                            headline: '',
                                            description: ''
                                        };

                                        setAttributes({ main: [ ...main, newPerson ] });
                                    } }
                                >
                                    Add person
                                </Button>
                            </PanelBody>
                        </Panel>

                        <Panel>
                            <PanelBody initialOpen={false} title="Workshop speakers">
                                <p>Without a photo, the speaker's initials are shown.</p>
                                {staff.map(person => (
                                    <PanelRow key={person.id}>
                                        <div className="gyc-people-fields-wrapper">
                                            <TextControl
                                                label="Photo"
                                                value={ person.photo || '' }
                                                onChange={ ( newValue ) => {
                                                    const newStaff = staff.map(i => i.id === person.id ? { ...i, photo: newValue } : i);
                                                    setAttributes({ staff: newStaff });
                                                } }
                                            />
                                            <TextControl
                                                label="Name"
                                                value={ person.name || '' }
                                                onChange={ ( newValue ) => {
                                                    const newStaff = staff.map(i => i.id === person.id ? { ...i, name: newValue } : i);
                                                    setAttributes({ staff: newStaff });
                                                } }
                                            />
                                            <TextControl
                                                label="Role"
                                                help="Topic or ministry."
                                                value={ person.role || '' }
                                                onChange={ ( newValue ) => {
                                                    const newStaff = staff.map(i => i.id === person.id ? { ...i, role: newValue } : i);
                                                    setAttributes({ staff: newStaff });
                                                } }
                                            />
                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newStaff = staff.filter(i => i.id !== person.id);
                                                        setAttributes({ staff: newStaff });
                                                    } }
                                                >
                                                    Remove staff
                                                </Button>
                                            </div>
                                            <hr className="gyc-pricing-table-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newPerson = {
                                            id: Date.now(),
                                            photo: '',
                                            name: '',
                                            role: ''
                                        };

                                        setAttributes({ staff: [ ...staff, newPerson ] });
                                    } }
                                >
                                    Add staff
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
