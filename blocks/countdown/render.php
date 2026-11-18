<?php
// Turned off in the block settings: nothing is shown, but the content is kept
if (isset($attributes['active']) && !$attributes['active']) {
    return;
}

$post_id = isset($block->context['postId']) ? (int) $block->context['postId'] : get_the_ID();

// Without its own date, the countdown runs to the Event Hero's "First link active from" time,
// so the countdown and the register button switch at the same moment
$opens_at_value = empty($attributes['opensAt']) ? '' : $attributes['opensAt'];
if ($opens_at_value === '' && $post_id) {
    foreach (parse_blocks((string) get_post_field('post_content', $post_id)) as $sibling) {
        if ($sibling['blockName'] === 'gyc/event-hero' && !empty($sibling['attrs']['primaryOpensAt'])) {
            $opens_at_value = $sibling['attrs']['primaryOpensAt'];
            break;
        }
    }
}

// No time set, an invalid one or one that has passed: there is nothing to count down to
$opens_at = GycUI::opens_at($opens_at_value);
if (!$opens_at) {
    return;
}

$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$primary_label = empty($attributes['primaryLabel']) ? null : $attributes['primaryLabel'];
$primary_url = empty($attributes['primaryUrl']) ? null : GycUI::resolve_url($attributes['primaryUrl']);
$secondary_label = empty($attributes['secondaryLabel']) ? null : $attributes['secondaryLabel'];
$secondary_url = empty($attributes['secondaryUrl']) ? null : GycUI::resolve_url($attributes['secondaryUrl']);
$note = empty($attributes['note']) ? null : $attributes['note'];

$timezone = new DateTimeZone('Europe/Berlin');
$date_label = wp_date('j F Y', $opens_at, $timezone);
$full_label = wp_date('j F Y, H:i T', $opens_at, $timezone);

// Starting values, so the numbers make sense before JavaScript runs; assets/js/countdown.js keeps them ticking
$left = max(0, $opens_at - time());
$units = array(
    'days' => array(__('Days', 'gyc'), floor($left / 86400)),
    'hours' => array(__('Hours', 'gyc'), floor($left % 86400 / 3600)),
    'minutes' => array(__('Minutes', 'gyc'), floor($left % 3600 / 60)),
    'seconds' => array(__('Seconds', 'gyc'), $left % 60),
);

// Without its own link, the first button downloads a calendar reminder for the opening time
$calendar_file = null;
if ($primary_label && !$primary_url) {
    $event_title = $post_id ? html_entity_decode(wp_strip_all_tags(get_the_title($post_id)), ENT_QUOTES, 'UTF-8') : get_bloginfo('name');
    /* translators: %s: event title */
    $summary = sprintf(__('Registration opens: %s', 'gyc'), $event_title);
    $ics_escape = function ($value) {
        return addcslashes($value, ",;\\");
    };
    $ics = implode("\r\n", array(
        'BEGIN:VCALENDAR',
        'VERSION:2.0',
        'PRODID:-//GYC Europe//Countdown//EN',
        'BEGIN:VEVENT',
        'UID:gyc-registration-' . $post_id . '-' . $opens_at . '@' . wp_parse_url(home_url(), PHP_URL_HOST),
        'DTSTAMP:' . gmdate('Ymd\THis\Z'),
        'DTSTART:' . gmdate('Ymd\THis\Z', $opens_at),
        'DTEND:' . gmdate('Ymd\THis\Z', $opens_at + 30 * 60),
        'SUMMARY:' . $ics_escape($summary),
        'URL:' . ($post_id ? get_permalink($post_id) : home_url('/')),
        'END:VEVENT',
        'END:VCALENDAR',
    )) . "\r\n";
    $primary_url = 'data:text/calendar;charset=utf-8,' . rawurlencode($ics);
    $calendar_file = sanitize_title($event_title ?: 'event') . '-registration.ics';
}

$button_classes = 'inline-flex items-center rounded-full px-6 py-3 lg:px-7 font-jakarta text-sm lg:text-[0.9375rem] font-semibold motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint';
?>
<section
    id="countdown"
    class="bg-linear-to-b from-[#1e1024] to-gyc-plum-mid py-16 md:py-24 text-gyc-ivory"
    x-data="gycCountdown"
    data-target="<?php echo esc_attr((string) $opens_at); ?>"
    x-show="!done"
    aria-labelledby="gyc-countdown-date">
    <div class="max-w-content mx-auto px-6 md:px-12 flex flex-col items-center text-center">
        <?php if ($eyebrow): ?>
            <p class="inline-flex items-center gap-2.5 rounded-full bg-white/10 px-4 py-1.5 font-jakarta text-xs font-bold tracking-[0.2em] uppercase text-gyc-mint">
                <span class="h-1.5 w-1.5 rounded-full bg-gyc-mint" aria-hidden="true"></span>
                <?php echo esc_html($eyebrow); ?>
            </p>
        <?php endif; ?>

        <!-- The ticking numbers are hidden from screen readers; the date below says when -->
        <div class="mt-6 grid w-full max-w-md grid-cols-4 gap-2 sm:flex sm:w-auto sm:max-w-none sm:items-center sm:gap-3 md:gap-5" aria-hidden="true">
            <?php $first = true; ?>
            <?php foreach ($units as $key => $unit): ?>
                <?php if (!$first): ?>
                    <span class="hidden sm:block font-display text-3xl md:text-4xl text-gyc-aqua/60">:</span>
                <?php endif; ?>
                <?php $first = false; ?>
                <div class="flex flex-col items-center justify-center rounded-2xl border border-gyc-aqua/35 bg-white/5 py-4 sm:w-28 sm:py-5 md:w-36 md:py-6">
                    <span class="font-display text-4xl sm:text-5xl md:text-7xl leading-none tabular-nums text-gyc-ivory" x-text="<?php echo esc_attr($key); ?>"><?php echo esc_html(str_pad((string) $unit[1], 2, '0', STR_PAD_LEFT)); ?></span>
                    <span class="mt-2 md:mt-3 font-jakarta text-[0.625rem] sm:text-xs font-bold tracking-[0.15em] uppercase text-gyc-mint"><?php echo esc_html($unit[0]); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <p id="gyc-countdown-date" class="mt-8 md:mt-10 font-display small-caps text-3xl md:text-4xl lg:text-5xl leading-none text-gyc-ivory">
            <?php echo esc_html($date_label); ?>
            <span class="sr-only">(<?php echo esc_html($full_label); ?>)</span>
        </p>

        <?php if ($text): ?>
            <p class="mt-6 max-w-xl font-jakarta text-base md:text-lg leading-relaxed text-gyc-ivory/85 whitespace-pre-line"><?php echo esc_html($text); ?></p>
        <?php endif; ?>

        <?php if (($primary_label && $primary_url) || ($secondary_label && $secondary_url)): ?>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <?php if ($primary_label && $primary_url): ?>
                    <a
                        href="<?php echo $calendar_file ? esc_attr($primary_url) : esc_url($primary_url); ?>"
                        <?php if ($calendar_file): ?>download="<?php echo esc_attr($calendar_file); ?>"<?php endif; ?>
                        class="<?php echo esc_attr($button_classes); ?> bg-gyc-mint text-gyc-plum hover:bg-gyc-mint-dark">
                        <?php echo esc_html($primary_label); ?>
                    </a>
                <?php endif; ?>
                <?php if ($secondary_label && $secondary_url): ?>
                    <a
                        href="<?php echo esc_url($secondary_url); ?>"
                        class="<?php echo esc_attr($button_classes); ?> border border-white/60 text-white hover:border-white hover:bg-white/10">
                        <?php echo esc_html($secondary_label); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($note): ?>
            <p class="mt-6 font-jakarta text-xs md:text-sm text-gyc-ivory/60"><?php echo esc_html($note); ?></p>
        <?php endif; ?>
    </div>
</section>
