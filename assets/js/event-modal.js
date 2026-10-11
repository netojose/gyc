/**
 * Alpine component for the Event Modal block (blocks/event-modal).
 * The modal opens on every page load, keeps keyboard focus inside while open
 * and stops the page behind it from scrolling.
 * Logic lives here rather than in x-data because WordPress texturizes
 * block markup and breaks ">" and "&&" inside attributes.
 */
export default function gycEventModal() {
    return {
        open: true,

        init() {
            document.documentElement.style.overflow = 'hidden';
            this.$nextTick(() => this.$refs.dialog.focus({ preventScroll: true }));
        },

        close() {
            this.open = false;
            document.documentElement.style.overflow = '';
        },

        trapFocus(event) {
            const dialog = this.$refs.dialog;
            const focusable = dialog.querySelectorAll('a[href], button:not([disabled])');

            if (focusable.length === 0) {
                event.preventDefault();
                return;
            }

            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            const current = document.activeElement;

            if (event.shiftKey && (current === first || current === dialog)) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && current === last) {
                event.preventDefault();
                first.focus();
            }
        },
    };
}
