import { TextControl, Button } from '@wordpress/components';

/**
 * "Registration opens on" date and time for a register button, typed in Central European Time.
 * Until then the button is greyed out on the site and shows when it opens (GycUI::closed_button).
 * Empty keeps the button active.
 */
export default function OpensAtField({ value, onChange, label = 'Registration opens on (CET, optional)' }) {
    return (
        <>
            <TextControl
                type="datetime-local"
                label={ label }
                help={ value
                    ? 'Until this date and time (Central European Time, CEST in summer), the button is greyed out and shows when registration opens. Clear it to make the button active now.'
                    : 'Leave empty to keep the button active. Set a date and time in Central European Time (CEST in summer) to disable the button until then.' }
                value={ value || '' }
                onChange={ onChange }
            />
            { value && (
                <div>
                    <Button size="small" variant="secondary" onClick={ () => onChange( '' ) }>
                        Clear opening time
                    </Button>
                </div>
            ) }
        </>
    );
}
