/**
 * Register buttons that are disabled until registration opens (GycUI::closed_button).
 * When the opening time passes, the disabled button and its "Opens …" note are removed
 * and the real link is shown, so a cached page or a tab left open switches without a reload.
 */
export default function initRegistrationOpens() {
    function check() {
        let next = Infinity;

        document.querySelectorAll('[data-gyc-closed]').forEach((closed) => {
            const opensAt = Number(closed.dataset.gycClosed) * 1000;
            if (Date.now() < opensAt) {
                next = Math.min(next, opensAt);
                return;
            }
            const link = closed.previousElementSibling;
            if (link && link.hasAttribute('data-gyc-opens')) {
                link.hidden = false;
                link.removeAttribute('data-gyc-opens');
            }
            closed.remove();
        });

        // Check again at the next opening time; capped so long waits don't overflow setTimeout
        if (next !== Infinity) {
            setTimeout(check, Math.min(next - Date.now() + 500, 60 * 60 * 1000));
        }
    }

    check();
}
