/**
 * Alpine component for the Events Overview block (blocks/events-overview).
 * Shows the upcoming events of one organizer ("europe" or "focus") or all of them.
 * The choice is kept in the address (?organizer=focus) so a filtered view can be shared.
 * Logic lives here rather than in x-data because WordPress texturizes
 * block markup and breaks ">" and "&&" inside attributes.
 */
const FILTERS = ['all', 'europe', 'focus']

export default function gycEventsFilter() {
    return {
        filter: 'all',
        visible: 0,
        status: '',

        init() {
            const fromUrl = new URLSearchParams(window.location.search).get('organizer')
            this.filter = FILTERS.includes(fromUrl) ? fromUrl : 'all'
            this.$nextTick(() => this.update())
        },

        setFilter(filter) {
            this.filter = FILTERS.includes(filter) ? filter : 'all'

            const url = new URL(window.location.href)
            if (this.filter === 'all') {
                url.searchParams.delete('organizer')
            } else {
                url.searchParams.set('organizer', this.filter)
            }
            window.history.replaceState(null, '', url)

            this.$nextTick(() => this.update())
        },

        shows(organizer) {
            return this.filter === 'all' || this.filter === organizer
        },

        update() {
            const cards = this.$root.querySelectorAll('[data-organizer]')
            this.visible = Array.from(cards).filter((card) => this.shows(card.dataset.organizer)).length

            const labels = this.$root.dataset
            this.status = this.filter === 'all'
                ? 'Showing all upcoming events'
                : 'Showing ' + (this.filter === 'europe' ? labels.europeLabel : labels.focusLabel) + ' events'
        },
    }
}
