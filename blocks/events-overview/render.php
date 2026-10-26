<?php
$all_label = empty($attributes['allLabel']) ? 'All events' : $attributes['allLabel'];
$europe_label = empty($attributes['europeLabel']) ? 'GYC Europe' : $attributes['europeLabel'];
$focus_label = empty($attributes['focusLabel']) ? 'GYC Focus' : $attributes['focusLabel'];
$empty_text = empty($attributes['emptyText']) ? null : $attributes['emptyText'];
$events = empty($attributes['events']) ? array() : $attributes['events'];
$past_eyebrow = empty($attributes['pastEyebrow']) ? null : $attributes['pastEyebrow'];
$past_title = empty($attributes['pastTitle']) ? null : $attributes['pastTitle'];
$past = empty($attributes['past']) ? array() : $attributes['past'];

$events = array_values(array_filter($events, function ($event) {
    return !empty($event['title']);
}));
$past = array_values(array_filter($past, function ($item) {
    return !empty($item['title']);
}));

$filters = array(
    'all' => $all_label,
    'europe' => $europe_label,
    'focus' => $focus_label,
);

// Links to other websites (such as GYC Focus) open in a new tab and get a diagonal arrow
$is_external = function ($url) {
    return (bool) preg_match('~^https?://~i', $url) && wp_parse_url($url, PHP_URL_HOST) !== wp_parse_url(home_url(), PHP_URL_HOST);
};
$arrow_right = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>';
$arrow_out = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M8 7h9v9"></path>';
$link_attrs = function ($url) use ($is_external) {
    $attrs = 'href="' . esc_url($url) . '"';
    if ($is_external($url)) {
        $attrs .= ' target="_blank" rel="noopener noreferrer"';
    }
    return $attrs;
};
$new_tab_note = '<span class="sr-only">(opens in a new tab)</span>';
?>
<div
    x-data="gycEventsFilter"
    data-europe-label="<?php echo esc_attr($europe_label); ?>"
    data-focus-label="<?php echo esc_attr($focus_label); ?>"
    class="bg-gyc-cream text-gyc-ink">
    <?php if (count($events) > 0): ?>
        <!-- The filter needs JavaScript; without it every event stays visible -->
        <div x-cloak class="border-b border-gyc-ink/10 bg-white">
            <div class="max-w-content mx-auto px-6 md:px-12 py-3 flex justify-center md:justify-end">
                <div class="flex max-w-full gap-1 overflow-x-auto rounded-full bg-gyc-mist p-1" role="group" aria-label="Filter events by organizer">
                    <?php foreach ($filters as $key => $label): ?>
                        <button
                            type="button"
                            data-filter="<?php echo esc_attr($key); ?>"
                            @click="setFilter($el.dataset.filter)"
                            :aria-pressed="filter === $el.dataset.filter ? 'true' : 'false'"
                            :class="filter === $el.dataset.filter ? 'bg-gyc-ink text-white' : 'text-gyc-ink hover:bg-white'"
                            class="shrink-0 cursor-pointer whitespace-nowrap rounded-full px-4 py-2 font-jakarta text-xs font-semibold motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal">
                            <?php echo esc_html($label); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <section class="py-12 md:py-16" aria-label="Upcoming events">
        <div class="max-w-content mx-auto px-6 md:px-12">
            <?php if (count($events) > 0): ?>
                <p x-cloak class="mb-6 font-jakarta text-xs text-gyc-ink/70" role="status" x-text="status"></p>

                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" role="list">
                    <?php foreach ($events as $event): ?>
                        <?php
                        $organizer = (isset($event['organizer']) && $event['organizer'] === 'focus') ? 'focus' : 'europe';
                        $organizer_label = $organizer === 'focus' ? $focus_label : $europe_label;
                        $featured = !empty($event['featured']);
                        $label = empty($event['label']) ? $organizer_label : $event['label'];
                        $link_url = empty($event['linkUrl']) ? null : GycUI::resolve_url($event['linkUrl'], false);
                        $second_url = empty($event['secondUrl']) ? null : GycUI::resolve_url($event['secondUrl'], false);
                        $has_link = $link_url && !empty($event['linkLabel']);
                        $has_second = $second_url && !empty($event['secondLabel']);
                        ?>
                        <?php if ($featured): ?>
                            <li
                                data-organizer="<?php echo esc_attr($organizer); ?>"
                                x-show="shows($el.dataset.organizer)"
                                class="md:col-span-2 lg:col-span-3 grid grid-cols-1 md:grid-cols-2 overflow-hidden rounded-3xl bg-gyc-night text-white">
                                <div class="relative min-h-56 md:min-h-80 bg-gyc-ink">
                                    <?php if (!empty($event['image'])): ?>
                                        <img class="absolute inset-0 h-full w-full object-cover" src="<?php echo esc_url($event['image']); ?>" alt="<?php echo esc_attr(empty($event['imageAlt']) ? '' : $event['imageAlt']); ?>" loading="lazy" decoding="async" draggable="false" />
                                    <?php endif; ?>
                                </div>

                                <div class="flex flex-col justify-center gap-5 p-6 md:p-10">
                                    <p><span class="inline-block rounded-full bg-white px-3 py-1 font-jakarta text-xs font-bold uppercase tracking-wider text-gyc-ink"><?php echo esc_html($label); ?></span></p>

                                    <h2 class="font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($event['title']); ?></h2>

                                    <?php if (!empty($event['date']) || !empty($event['location'])): ?>
                                        <ul class="space-y-2 font-jakarta text-sm text-white/90" role="list">
                                            <?php if (!empty($event['date'])): ?>
                                                <li class="flex items-center gap-3">
                                                    <svg class="h-4 w-4 shrink-0 text-gyc-aqua" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                                                    <span><span class="sr-only">Date: </span><?php echo esc_html($event['date']); ?></span>
                                                </li>
                                            <?php endif; ?>
                                            <?php if (!empty($event['location'])): ?>
                                                <li class="flex items-center gap-3">
                                                    <svg class="h-4 w-4 shrink-0 text-gyc-aqua" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7-6.1-7-11.5a7 7 0 0 1 14 0C19 14.9 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg>
                                                    <span><span class="sr-only">Place: </span><?php echo esc_html($event['location']); ?></span>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (!empty($event['text'])): ?>
                                        <p class="max-w-md font-jakarta text-sm leading-relaxed text-white/75"><?php echo esc_html($event['text']); ?></p>
                                    <?php endif; ?>

                                    <?php if ($has_link || $has_second): ?>
                                        <div class="flex flex-wrap gap-3 pt-1">
                                            <?php if ($has_link): ?>
                                                <a <?php echo $link_attrs($link_url); ?> class="inline-flex items-center gap-2 rounded-full bg-gyc-teal px-6 py-3 font-jakarta text-sm font-semibold text-white motion-safe:transition-colors hover:bg-gyc-teal-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-aqua">
                                                    <?php echo esc_html($event['linkLabel']); ?><?php if ($is_external($link_url)) echo $new_tab_note; ?>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($has_second): ?>
                                                <a <?php echo $link_attrs($second_url); ?> class="inline-flex items-center gap-2 rounded-full border border-white/80 px-6 py-3 font-jakarta text-sm font-semibold text-white motion-safe:transition-colors hover:bg-white hover:text-gyc-ink focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-aqua">
                                                    <?php echo esc_html($event['secondLabel']); ?><?php if ($is_external($second_url)) echo $new_tab_note; ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php else: ?>
                            <li
                                data-organizer="<?php echo esc_attr($organizer); ?>"
                                x-show="shows($el.dataset.organizer)"
                                class="flex flex-col overflow-hidden rounded-3xl border border-gyc-ink/10 bg-white">
                                <div class="relative aspect-[16/9] <?php echo $organizer === 'focus' ? 'bg-gyc-aqua/20' : 'bg-gyc-ink/10'; ?>">
                                    <?php if (!empty($event['image'])): ?>
                                        <img class="absolute inset-0 h-full w-full object-cover" src="<?php echo esc_url($event['image']); ?>" alt="<?php echo esc_attr(empty($event['imageAlt']) ? '' : $event['imageAlt']); ?>" loading="lazy" decoding="async" draggable="false" />
                                    <?php endif; ?>
                                    <?php if (!empty($event['badgeTop']) || !empty($event['badgeMain'])): ?>
                                        <span class="absolute left-3 top-3 flex min-w-12 flex-col items-center rounded-lg bg-white px-2.5 py-1.5 text-center shadow-sm" aria-hidden="true">
                                            <?php if (!empty($event['badgeTop'])): ?>
                                                <span class="font-jakarta text-xs font-bold uppercase tracking-wider text-gyc-teal"><?php echo esc_html($event['badgeTop']); ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($event['badgeMain'])): ?>
                                                <span class="font-display text-xl leading-none"><?php echo esc_html($event['badgeMain']); ?></span>
                                            <?php endif; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="flex flex-1 flex-col p-5 md:p-6">
                                    <p class="flex flex-wrap gap-1.5">
                                        <span class="rounded-full px-2.5 py-1 font-jakarta text-xs font-bold uppercase tracking-wider <?php echo $organizer === 'focus' ? 'bg-gyc-aqua text-gyc-ink' : 'bg-gyc-ink text-white'; ?>"><?php echo esc_html($organizer_label); ?></span>
                                        <?php if (!empty($event['online'])): ?>
                                            <span class="rounded-full border border-gyc-ink/20 px-2.5 py-1 font-jakarta text-xs font-bold uppercase tracking-wider">Online</span>
                                        <?php endif; ?>
                                    </p>

                                    <h2 class="mt-4 font-display small-caps text-2xl leading-tight"><?php echo esc_html($event['title']); ?></h2>

                                    <?php if (!empty($event['date']) || !empty($event['location'])): ?>
                                        <p class="mt-3 font-jakarta text-xs leading-relaxed text-gyc-ink/75">
                                            <?php if (!empty($event['date'])): ?><span class="block"><?php echo esc_html($event['date']); ?></span><?php endif; ?>
                                            <?php if (!empty($event['location'])): ?><span class="block"><?php echo esc_html($event['location']); ?></span><?php endif; ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if (!empty($event['text'])): ?>
                                        <p class="mt-3 font-jakarta text-sm leading-relaxed text-gyc-ink/80"><?php echo esc_html($event['text']); ?></p>
                                    <?php endif; ?>

                                    <?php if ($has_link): ?>
                                        <a <?php echo $link_attrs($link_url); ?> class="group mt-auto inline-flex items-center gap-2 self-start pt-4 font-jakarta text-sm font-semibold text-gyc-teal underline decoration-transparent underline-offset-4 motion-safe:transition-colors hover:decoration-current hover:text-gyc-teal-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal">
                                            <?php echo esc_html($event['linkLabel']); ?>
                                            <svg class="h-3.5 w-3.5 motion-safe:transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><?php echo $is_external($link_url) ? $arrow_out : $arrow_right; ?></svg>
                                            <?php if ($is_external($link_url)) echo $new_tab_note; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>

                <?php if ($empty_text): ?>
                    <p x-cloak x-show="visible === 0" class="rounded-3xl border border-dashed border-gyc-ink/20 px-6 py-12 text-center font-jakarta text-sm text-gyc-ink/70"><?php echo esc_html($empty_text); ?></p>
                <?php endif; ?>
            <?php elseif ($empty_text): ?>
                <p class="rounded-3xl border border-dashed border-gyc-ink/20 px-6 py-12 text-center font-jakarta text-sm text-gyc-ink/70"><?php echo esc_html($empty_text); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <?php if (count($past) > 0): ?>
        <section class="pb-16 md:pb-24" <?php if ($past_title): ?>aria-labelledby="gyc-events-past-title"<?php endif; ?>>
            <div class="max-w-content mx-auto px-6 md:px-12">
                <?php if ($past_eyebrow): ?>
                    <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-teal"><?php echo esc_html($past_eyebrow); ?></p>
                <?php endif; ?>
                <?php if ($past_title): ?>
                    <h2 id="gyc-events-past-title" class="mt-4 font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($past_title); ?></h2>
                <?php endif; ?>

                <ul class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" role="list">
                    <?php foreach ($past as $item): ?>
                        <?php $url = empty($item['url']) ? null : GycUI::resolve_url($item['url'], false); ?>
                        <li>
                            <<?php echo $url ? 'a ' . $link_attrs($url) : 'div'; ?> class="group flex h-full items-center justify-between gap-4 rounded-2xl border border-gyc-ink/10 bg-white px-6 py-5 motion-safe:transition-colors <?php echo $url ? 'hover:border-gyc-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal' : ''; ?>">
                                <span>
                                    <span class="block font-display small-caps text-xl leading-tight"><?php echo esc_html($item['title']); ?></span>
                                    <?php if (!empty($item['text'])): ?>
                                        <span class="mt-1 block font-jakarta text-xs text-gyc-ink/70"><?php echo esc_html($item['text']); ?></span>
                                    <?php endif; ?>
                                </span>
                                <?php if ($url): ?>
                                    <svg class="h-4 w-4 shrink-0 motion-safe:transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><?php echo $is_external($url) ? $arrow_out : $arrow_right; ?></svg>
                                    <?php if ($is_external($url)) echo $new_tab_note; ?>
                                <?php endif; ?>
                            </<?php echo $url ? 'a' : 'div'; ?>>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>
</div>
