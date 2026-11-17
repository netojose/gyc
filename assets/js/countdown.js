/**
 * Alpine component for the Countdown block (blocks/countdown).
 * Counts down to the Unix timestamp in data-target and hides the section once it is reached,
 * so a cached page or a tab left open stops showing it without a reload.
 */
const pad = (value) => String(value).padStart(2, '0');

export default function gycCountdown() {
    return {
        target: 0,
        days: '00',
        hours: '00',
        minutes: '00',
        seconds: '00',
        done: false,
        timer: null,

        init() {
            this.target = Number(this.$el.dataset.target) * 1000;
            this.tick();
            if (!this.done) {
                this.timer = setInterval(() => this.tick(), 1000);
            }
        },

        destroy() {
            clearInterval(this.timer);
        },

        tick() {
            const left = Math.floor((this.target - Date.now()) / 1000);

            if (left <= 0) {
                this.done = true;
                clearInterval(this.timer);
                return;
            }

            this.days = pad(Math.floor(left / 86400));
            this.hours = pad(Math.floor((left % 86400) / 3600));
            this.minutes = pad(Math.floor((left % 3600) / 60));
            this.seconds = pad(left % 60);
        },
    };
}
