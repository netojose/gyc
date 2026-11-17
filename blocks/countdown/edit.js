import {
    TextControl,
    TextareaControl,
    Panel,
    PanelBody,
    ToggleControl
} from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';

import OpensAtField from '../../editor/opens-at-field';

/**
 * Sidebar fields of the Countdown block. The section itself is rendered by render.php.
 */
export default function Edit({ attributes, setAttributes }) {
    const { active = true, opensAt, eyebrow, text, primaryLabel, primaryUrl, secondaryLabel, secondaryUrl, note } = attributes;

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={false} title={ active ? 'Countdown' : 'Countdown (hidden)' }>
                    <div className="gyc-countdown-fields-wrapper">
                        <ToggleControl
                            label="Show this section"
                            help={ active ? 'Shown: the countdown appears on the page until it reaches zero, then hides itself.' : 'Hidden: visitors do not see the countdown. Its content is kept.' }
                            checked={ !!active }
                            onChange={ ( newValue ) => setAttributes( { active: newValue } ) }
                        />
                        <p>The countdown runs to the date and time below. Leave it empty to use the Event Hero's "First link active from" time, so both switch at the same moment. Without a time in the future, the section is not shown.</p>
                        <OpensAtField
                            label="Counts down to (CET, optional)"
                            value={ opensAt }
                            onChange={ ( newValue ) => setAttributes( { opensAt: newValue } ) }
                        />
                        <TextControl
                            label="Label above the countdown"
                            value={ eyebrow || '' }
                            onChange={ ( newValue ) => setAttributes( { eyebrow: newValue } ) }
                        />
                        <TextareaControl
                            label="Text"
                            help="Optional, shown under the date."
                            rows={3}
                            value={ text || '' }
                            onChange={ ( newValue ) => setAttributes( { text: newValue } ) }
                        />

                        <p>Links can be full URLs, site paths like /about, sections like #schedule, or an email address. Leave the first link empty to let visitors download a calendar reminder for the opening time.</p>
                        <TextControl
                            label="First button label"
                            value={ primaryLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { primaryLabel: newValue } ) }
                        />
                        <TextControl
                            label="First button link (optional)"
                            help={ primaryUrl ? '' : 'Empty: the button downloads a calendar reminder.' }
                            value={ primaryUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { primaryUrl: newValue } ) }
                        />
                        <TextControl
                            label="Second button label"
                            value={ secondaryLabel || '' }
                            onChange={ ( newValue ) => setAttributes( { secondaryLabel: newValue } ) }
                        />
                        <TextControl
                            label="Second button link"
                            value={ secondaryUrl || '' }
                            onChange={ ( newValue ) => setAttributes( { secondaryUrl: newValue } ) }
                        />
                        <TextControl
                            label="Small note (optional)"
                            help="Shown under the buttons."
                            value={ note || '' }
                            onChange={ ( newValue ) => setAttributes( { note: newValue } ) }
                        />
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
