import VanillaTilt from 'vanilla-tilt'

// 3D tilt that follows the pointer on elements marked with data-gyc-tilt (the event price boxes).
// Skipped on touch screens, where there is no hover, and for visitors who ask for reduced motion.
export default function initTilt() {
    const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
    if (!canHover || reducedMotion) {
        return
    }

    VanillaTilt.init(document.querySelectorAll('[data-gyc-tilt]'), {
        max: 5,
        perspective: 1000,
        scale: 1.03,
        speed: 500,
        easing: 'cubic-bezier(.03,.98,.52,.99)',
        glare: true,
        'max-glare': 0.1,
    })
}
