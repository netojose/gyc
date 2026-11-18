/**
 * Alpine component for the floating "Back to top" button (rendered by blocks/footer).
 * Shows the button once the visitor has scrolled past the first screen and,
 * on click, scrolls up and moves keyboard focus to the first link on the page.
 * While the footer scrolls into view the button grows a white border
 * (0 → MAX_BORDER px), so it stays visible against the footer.
 * Logic lives here rather than in x-data because WordPress texturizes
 * block markup and breaks ">" and "&&" inside attributes.
 */
const MAX_BORDER = 3

export default function gycBackToTop() {
    return {
        visible: false,
        border: 0,

        init() {
            this.update()
            window.addEventListener('scroll', () => this.update(), { passive: true })
            window.addEventListener('resize', () => this.update(), { passive: true })
        },

        update() {
            this.visible = window.scrollY > window.innerHeight * 0.8

            // How far the page bottom is below the viewport, measured against the footer height
            const footer = document.querySelector('footer')
            const zone = footer ? footer.offsetHeight : window.innerHeight
            const distance = document.documentElement.scrollHeight - (window.scrollY + window.innerHeight)
            const progress = Math.min(1, Math.max(0, 1 - distance / zone))

            this.border = Math.round(progress * MAX_BORDER * 10) / 10
        },

        get borderStyle() {
            return { borderWidth: this.border + 'px' }
        },

        scrollUp() {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
            window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' })

            const first = document.querySelector('a[href], button:not([disabled])')
            if (first && first !== this.$el) {
                first.focus({ preventScroll: true })
            }
        },
    }
}
