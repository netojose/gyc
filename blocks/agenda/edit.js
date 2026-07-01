import {
    TextControl,
    TextareaControl,
    Panel,
    PanelBody,
    PanelRow,
    Button,
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
    const { title, headline, items = [] } = attributes;

    const agendaItems = Array.isArray(items) ? items : [];

    const updateDay = (dayId, field, value) => {
        const newItems = agendaItems.map((day) =>
            day.id === dayId ? { ...day, [field]: value } : day
        );
        setAttributes({ items: newItems });
    };

    const removeDay = (dayId) => {
        const newItems = agendaItems.filter((day) => day.id !== dayId);
        setAttributes({ items: newItems });
    };

    const addDay = () => {
        const newDay = { id: Date.now(), date: '', items: [] };
        setAttributes({ items: [ ...agendaItems, newDay ] });
    };

    const updateScheduleItem = (dayId, itemId, field, value) => {
        const newItems = agendaItems.map((day) => {
            if (day.id !== dayId) {
                return day;
            }

            return {
                ...day,
                items: (day.items || []).map((entry) =>
                    entry.id === itemId ? { ...entry, [field]: value } : entry
                ),
            };
        });

        setAttributes({ items: newItems });
    };

    const addScheduleItem = (dayId) => {
        const newItems = agendaItems.map((day) => {
            if (day.id !== dayId) {
                return day;
            }

            const newEntry = {
                id: Date.now(),
                time: '',
                title: '',
                description: '',
                responsible: '',
                tags: '',
            };

            return {
                ...day,
                items: [ ...(day.items || []), newEntry ],
            };
        });

        setAttributes({ items: newItems });
    };

    const removeScheduleItem = (dayId, itemId) => {
        const newItems = agendaItems.map((day) => {
            if (day.id !== dayId) {
                return day;
            }

            return {
                ...day,
                items: (day.items || []).filter((entry) => entry.id !== itemId),
            };
        });

        setAttributes({ items: newItems });
    };

    return (
        <div { ...useBlockProps() }>
            <Panel>
                <PanelBody initialOpen={ false } title={ __('Agenda', 'gyc/agenda') }>
                    <div className="gyc-agenda-fields-wrapper">
                        <TextControl
                            label={ __('Title', 'gyc/agenda') }
                            value={ title || '' }
                            onChange={ (newValue) => setAttributes({ title: newValue }) }
                        />

                        <TextareaControl
                            label={ __('Headline', 'gyc/agenda') }
                            rows={3}
                            value={ headline || '' }
                            onChange={ (newValue) => setAttributes({ headline: newValue }) }
                        />

                        <Panel>
                            <PanelBody initialOpen={ false } title={ __('Days', 'gyc/agenda') }>
                                { agendaItems.map((day) => (
                                    <PanelRow key={ day.id }>
                                        <div className="gyc-agenda-fields-wrapper">
                                            <TextControl
                                                label={ __('Date', 'gyc/agenda') }
                                                value={ day.date || '' }
                                                onChange={ (newValue) => updateDay(day.id, 'date', newValue) }
                                            />

                                            <Panel>
                                                <PanelBody initialOpen={ false } title={ __('Schedule Items', 'gyc/agenda') }>
                                                    { (day.items || []).map((entry) => (
                                                        <PanelRow key={ entry.id }>
                                                            <div className="gyc-agenda-fields-wrapper">
                                                                <TextControl
                                                                    label={ __('Time', 'gyc/agenda') }
                                                                    value={ entry.time || '' }
                                                                    onChange={ (newValue) => updateScheduleItem(day.id, entry.id, 'time', newValue) }
                                                                />

                                                                <TextControl
                                                                    label={ __('Title', 'gyc/agenda') }
                                                                    value={ entry.title || '' }
                                                                    onChange={ (newValue) => updateScheduleItem(day.id, entry.id, 'title', newValue) }
                                                                />

                                                                <TextareaControl
                                                                    label={ __('Description', 'gyc/agenda') }
                                                                    rows={ 3 }
                                                                    value={ entry.description || '' }
                                                                    onChange={ (newValue) => updateScheduleItem(day.id, entry.id, 'description', newValue) }
                                                                />

                                                                <TextControl
                                                                    label={ __('Responsible', 'gyc/agenda') }
                                                                    value={ entry.responsible || '' }
                                                                    onChange={ (newValue) => updateScheduleItem(day.id, entry.id, 'responsible', newValue) }
                                                                />

                                                                <TextControl
                                                                    label={ __('Tags', 'gyc/agenda') }
                                                                    value={ entry.tags || '' }
                                                                    onChange={ (newValue) => updateScheduleItem(day.id, entry.id, 'tags', newValue) }
                                                                />

                                                                <div>
                                                                    <Button
                                                                        size="small"
                                                                        variant="outline"
                                                                        className="is-secondary is-destructive"
                                                                        onClick={ () => removeScheduleItem(day.id, entry.id) }
                                                                    >
                                                                        { __('Remove item', 'gyc/agenda') }
                                                                    </Button>
                                                                </div>

                                                                <hr className="gyc-topics-separator" />
                                                            </div>
                                                        </PanelRow>
                                                    ) ) }

                                                    <Button
                                                        isPrimary
                                                        onClick={ () => addScheduleItem(day.id) }
                                                    >
                                                        { __('Add item', 'gyc/agenda') }
                                                    </Button>
                                                </PanelBody>
                                            </Panel>

                                            <div>
                                                <Button
                                                    size="small"
                                                    variant="outline"
                                                    className="is-secondary is-destructive"
                                                    onClick={ () => removeDay(day.id) }
                                                >
                                                    { __('Remove day', 'gyc/agenda') }
                                                </Button>
                                            </div>

                                            <hr className="gyc-topics-separator" />
                                        </div>
                                    </PanelRow>
                                ) ) }

                                <Button
                                    isPrimary
                                    onClick={ addDay }
                                >
                                    { __('Add day', 'gyc/agenda') }
                                </Button>
                            </PanelBody>
                        </Panel>
                    </div>
                </PanelBody>
            </Panel>
        </div>
    );
}
