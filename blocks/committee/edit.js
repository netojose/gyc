import {
    TextControl,
    TextareaControl,
    RangeControl,
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
    const { eyebrow, title, text, featuredCount, members } = attributes;

    const updateMember = ( id, changes ) => {
        const newMembers = members.map(i => i.id === id ? { ...i, ...changes } : i);
        setAttributes({ members: newMembers });
    };

    const moveMember = ( index, direction ) => {
        const target = index + direction;
        if ( target < 0 || target >= members.length ) {
            return;
        }
        const newMembers = [ ...members ];
        [ newMembers[ index ], newMembers[ target ] ] = [ newMembers[ target ], newMembers[ index ] ];
        setAttributes({ members: newMembers });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title="Committee">
                    <div className="gyc-committee-fields-wrapper">
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
                        <RangeControl
                            label="Members shown larger (first row)"
                            help="The first members in the list get bigger photos; the rest are shown five per row."
                            min={ 0 }
                            max={ 6 }
                            value={ featuredCount ?? 3 }
                            onChange={ ( newValue ) => setAttributes( { featuredCount: newValue } ) }
                        />

                        <Panel>
                            <PanelBody initialOpen={false} title="Members">
                                {members.map((member, index) => (
                                    <PanelRow key={member.id}>
                                        <div className="gyc-committee-fields-wrapper">
                                            <TextControl
                                                label="Name"
                                                value={ member.name || '' }
                                                onChange={ ( newValue ) => updateMember( member.id, { name: newValue } ) }
                                            />
                                            <TextControl
                                                label="Role"
                                                value={ member.role || '' }
                                                onChange={ ( newValue ) => updateMember( member.id, { role: newValue } ) }
                                            />
                                            <TextControl
                                                label="Photo URL"
                                                value={ member.photo || '' }
                                                onChange={ ( newValue ) => updateMember( member.id, { photo: newValue } ) }
                                            />
                                            <TextControl
                                                label="Email"
                                                type="email"
                                                value={ member.email || '' }
                                                onChange={ ( newValue ) => updateMember( member.id, { email: newValue } ) }
                                            />
                                            <TextControl
                                                label="Instagram handle"
                                                help="For example @gyceurope"
                                                value={ member.instagram || '' }
                                                onChange={ ( newValue ) => updateMember( member.id, { instagram: newValue } ) }
                                            />
                                            <div style={ { display: 'flex', gap: '8px', flexWrap: 'wrap' } }>
                                                <Button size="small" variant="secondary" disabled={ index === 0 } onClick={ () => moveMember( index, -1 ) }>
                                                    Move up
                                                </Button>
                                                <Button size="small" variant="secondary" disabled={ index === members.length - 1 } onClick={ () => moveMember( index, 1 ) }>
                                                    Move down
                                                </Button>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => {
                                                        const newMembers = members.filter(i => i.id !== member.id);
                                                        setAttributes({ members: newMembers });
                                                    } }
                                                >
                                                    Remove member
                                                </Button>
                                            </div>
                                            <hr className="gyc-committee-separator" />
                                        </div>
                                    </PanelRow>
                                ))}
                                <Button
                                    isPrimary
                                    onClick={ () => {
                                        const newMember = { id: Date.now(), photo: '', name: '', role: '', email: '', instagram: '' };
                                        setAttributes({ members: [...members, newMember] });
                                    } }
                                >
                                    Add member
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
