/**
 * Alpine component for the FAQ block (blocks/faq).
 * Filters the questions when the Page Hero search box dispatches
 * "gyc-faq-search" with { query, submit }.
 * Logic lives here rather than in x-data because WordPress texturizes
 * block markup and breaks ">" and "&&" inside attributes.
 */
export default function gycFaq() {
    return {
        query: '',
        matches: 0,
        noResults: false,
        status: '',

        search(event) {
            this.query = (event.detail.query || '').trim().toLowerCase();
            this.filter();

            if (event.detail.submit) {
                this.$root.scrollIntoView({ behavior: 'smooth' });
                this.$root.focus({ preventScroll: true });
            }
        },

        filter() {
            const query = this.query;
            let total = 0;

            this.$root.querySelectorAll('[data-faq-category]').forEach((category) => {
                let visible = 0;

                category.querySelectorAll('[data-faq-item]').forEach((item) => {
                    const match = query === '' || item.textContent.toLowerCase().includes(query);
                    item.hidden = !match;
                    if (match) {
                        visible++;
                    }
                });

                category.hidden = visible === 0;
                total += visible;
            });

            this.matches = total;
            this.noResults = query !== '' && total === 0;

            if (query === '') {
                this.status = '';
            } else if (total === 1) {
                this.status = '1 question found';
            } else {
                this.status = total + ' questions found';
            }
        },
    };
}
