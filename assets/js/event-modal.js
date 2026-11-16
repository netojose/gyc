/**
 * Alpine component for the Event Modal block (blocks/event-modal).
 * The modal opens once per browser session: after it is closed (or one of its
 * links is clicked) it stays hidden until the tab or browser is closed.
 * While open it keeps keyboard focus inside and stops the page behind it from scrolling.
 * Logic lives here rather than in x-data because WordPress texturizes
 * block markup and breaks ">" and "&&" inside attributes.
 */
const STORAGE_KEY = 'gycEventModalSeen';

// sessionStorage can throw in private mode or with blocked site data
function wasSeen() {
    try {
        return sessionStorage.getItem(STORAGE_KEY) === '1';
    } catch (e) {
        return false;
    }
}

function markSeen() {
    try {
        sessionStorage.setItem(STORAGE_KEY, '1');
    } catch (e) {
        // Without storage the modal simply shows again on the next load
    }
}

export default function gycEventModal() {
    return {
        open: false,

        init() {
            if (wasSeen()) {
                return;
            }

            this.open = true;
            document.documentElement.style.overflow = 'hidden';
            this.$nextTick(() => this.$refs.dialog.focus({ preventScroll: true }));
        },

        close() {
            if (!this.open) {
                return;
            }

            this.open = false;
            markSeen();
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
