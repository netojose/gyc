/**
 * Alpine component for the People block (blocks/people).
 * One bio pop-up is shared by every speaker: render.php prints the speakers as JSON
 * and the pop-up shows the one at `index`. Visitors can step through speakers with
 * the arrows, the arrow keys or a swipe, and each speaker has its own #speaker-<id>
 * link, so a bio can be shared and opens straight away.
 * While open it keeps keyboard focus inside and stops the page behind it from scrolling.
 */
const HASH_PREFIX = '#speaker-';
const SWIPE_MIN = 50;

export default function gycPeople() {
    return {
        people: [],
        index: null,
        lastFocus: null,
        touchX: null,

        init() {
            try {
                this.people = JSON.parse(this.$refs.data.textContent);
            } catch (e) {
                this.people = [];
            }

            this.openFromHash();
            window.addEventListener('hashchange', () => this.openFromHash());
        },

        get isOpen() {
            return this.index !== null;
        },

        get current() {
            return this.isOpen ? this.people[this.index] : {};
        },

        // Getters rather than inline expressions: WordPress texturizes block markup and breaks ">" inside attributes
        get hasMany() {
            return this.people.length > 1;
        },

        get hasLabels() {
            return this.isOpen && this.current.labels.length > 0;
        },

        get position() {
            return this.isOpen ? (this.index + 1) + ' / ' + this.people.length : '';
        },

        open(index, trigger) {
            if (!this.people[index]) {
                return;
            }

            if (!this.isOpen) {
                this.lastFocus = trigger || document.activeElement;
                document.documentElement.style.overflow = 'hidden';
            }

            this.index = index;
            this.setHash(HASH_PREFIX + this.people[index].id);
            this.$nextTick(() => this.$refs.close.focus({ preventScroll: true }));
        },

        close() {
            if (!this.isOpen) {
                return;
            }

            this.index = null;
            document.documentElement.style.overflow = '';
            this.setHash('');

            if (this.lastFocus) {
                this.lastFocus.focus({ preventScroll: true });
                this.lastFocus = null;
            }
        },

        step(direction) {
            if (!this.isOpen || this.people.length < 2) {
                return;
            }

            const count = this.people.length;
            this.open((this.index + direction + count) % count);
        },

        openFromHash() {
            if (!window.location.hash.startsWith(HASH_PREFIX)) {
                return;
            }

            const id = window.location.hash.slice(HASH_PREFIX.length);
            const index = this.people.findIndex((person) => person.id === id);

            if (index !== -1 && index !== this.index) {
                // Without a clicked card, focus goes back to the card itself on close
                this.open(index, this.$root.querySelector('[data-person="' + index + '"]'));
            }
        },

        // replaceState keeps the back button for leaving the page, not for closing bios
        setHash(hash) {
            const url = window.location.pathname + window.location.search + hash;
            window.history.replaceState(null, '', url);
        },

        swipeStart(event) {
            this.touchX = event.changedTouches[0].clientX;
        },

        swipeEnd(event) {
            if (this.touchX === null) {
                return;
            }

            const distance = event.changedTouches[0].clientX - this.touchX;
            this.touchX = null;

            if (Math.abs(distance) >= SWIPE_MIN) {
                this.step(distance < 0 ? 1 : -1);
            }
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
