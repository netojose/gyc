<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$active_mode = empty($attributes['activeMode']) ? 'auto' : (string) $attributes['activeMode'];
$upcoming_label = empty($attributes['upcomingLabel']) ? '' : $attributes['upcomingLabel'];
$closed_label = empty($attributes['closedLabel']) ? '' : $attributes['closedLabel'];
$items = empty($attributes['items']) ? array() : array_values($attributes['items']);

$items = array_values(array_filter($items, function ($item) {
    return !empty($item['label']) || !empty($item['price']);
}));

// Dates are "Y-m-d" strings compared against today in the site's timezone (Settings → General).
$today = wp_date('Y-m-d');

$date_range = function ($start, $end) {
    $start_ts = $start ? strtotime($start . ' 12:00:00') : null;
    $end_ts = $end ? strtotime($end . ' 12:00:00') : null;

    if ($start_ts && $end_ts) {
        $same_year = gmdate('Y', $start_ts) === gmdate('Y', $end_ts);
        return date_i18n($same_year ? 'M j' : 'M j, Y', $start_ts) . ' – ' . date_i18n('M j, Y', $end_ts);
    }
    if ($end_ts) {
        return sprintf('Until %s', date_i18n('M j, Y', $end_ts));
    }
    if ($start_ts) {
        return sprintf('From %s', date_i18n('M j, Y', $start_ts));
    }
    return '';
};

// Only one box can be active: the one picked in the editor, or the first whose dates include today.
$active_id = null;
if ($active_mode === 'auto') {
    foreach ($items as $item) {
        $starts_ok = empty($item['start']) || $today >= $item['start'];
        $ends_ok = empty($item['end']) || $today <= $item['end'];
        if ($starts_ok && $ends_ok) {
            $active_id = $item['id'];
            break;
        }
    }
} elseif ($active_mode !== 'none') {
    $active_id = $active_mode;
}
?>
<section
    id="pricing"
    class="bg-gyc-mist text-gyc-plum pt-16 md:pt-20 pb-6 scroll-mt-4"
    <?php if ($title): ?>aria-labelledby="gyc-registration-options-title"<?php endif; ?>>
    <div class="max-w-6xl mx-auto px-6 md:px-12">
        <?php if ($title): ?>
            <h2 id="gyc-registration-options-title" class="sr-only"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if (count($items) > 0): ?>
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" role="list">
                <?php foreach ($items as $item): ?>
                    <?php
                    $is_active = $active_id !== null && (string) $item['id'] === (string) $active_id;
                    $start = empty($item['start']) ? '' : $item['start'];
                    $end = empty($item['end']) ? '' : $item['end'];
                    $is_upcoming = !$is_active && $start && $today < $start;
                    $button_url = empty($item['buttonUrl']) ? null : GycUI::resolve_url($item['buttonUrl'], false);
                    $range = $date_range($start, $end);
                    ?>
                    <li class="flex flex-col items-center rounded-sm px-6 py-8 text-center <?php echo $is_active ? 'bg-gyc-mint shadow-lg' : 'bg-white border border-gyc-plum/10'; ?>">
                        <?php if (!empty($item['label'])): ?>
                            <h3 class="font-jakarta text-xs font-extrabold uppercase tracking-[0.18em] mb-4">
                                <?php echo esc_html($item['label']); ?>
                                <?php if ($is_active): ?><span class="sr-only">(available now)</span><?php endif; ?>
                            </h3>
                        <?php endif; ?>

                        <?php if (!empty($item['price'])): ?>
                            <p class="font-jakarta text-4xl md:text-5xl font-extrabold tracking-tight <?php echo $is_active ? '' : 'text-gyc-plum/85'; ?>"><?php echo esc_html($item['price']); ?></p>
                        <?php endif; ?>

                        <?php if ($range): ?>
                            <p class="mt-2 font-jakarta text-xs text-gyc-plum/75"><?php echo esc_html($range); ?></p>
                        <?php endif; ?>

                        <div class="mt-auto w-full pt-8">
                            <?php if ($is_active && $button_url && !empty($item['buttonLabel'])): ?>
                                <a
                                    href="<?php echo esc_url($button_url); ?>"
                                    class="group inline-flex w-full max-w-56 items-center justify-center gap-2 rounded-sm bg-gyc-plum px-6 py-3 font-jakarta text-xs font-bold uppercase tracking-[0.18em] text-white hover:bg-gyc-plum-light motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-plum">
                                    <?php echo esc_html($item['buttonLabel']); ?>
                                    <span class="sr-only">– <?php echo esc_html($item['label']); ?></span>
                                    <svg class="h-3.5 w-3.5 motion-safe:transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>
                                    </svg>
                                </a>
                            <?php elseif (!$is_active): ?>
                                <?php $status_label = $is_upcoming ? $upcoming_label : $closed_label; ?>
                                <?php if ($status_label): ?>
                                    <p class="inline-flex w-full max-w-56 items-center justify-center rounded-sm border border-dashed border-gyc-plum/30 px-6 py-3 font-jakarta text-xs font-bold uppercase tracking-[0.18em] text-gyc-plum/70">
                                        <?php echo esc_html($status_label); ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
