<?php
// Switched off in the block's settings: nothing is output
if (empty($attributes['active'])) {
    return;
}

$image = empty($attributes['image']) ? null : $attributes['image'];
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$title_highlight = empty($attributes['titleHighlight']) ? null : $attributes['titleHighlight'];
$notice = empty($attributes['notice']) ? null : $attributes['notice'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$primary_label = empty($attributes['primaryLabel']) ? null : $attributes['primaryLabel'];
$primary_url = empty($attributes['primaryUrl']) ? null : GycUI::resolve_url($attributes['primaryUrl']);
$close_label = empty($attributes['closeLabel']) ? null : $attributes['closeLabel'];

$facts = array(
    array(
        'label' => empty($attributes['whereLabel']) ? '' : $attributes['whereLabel'],
        'value' => empty($attributes['whereValue']) ? '' : $attributes['whereValue'],
    ),
    array(
        'label' => empty($attributes['whenLabel']) ? '' : $attributes['whenLabel'],
        'value' => empty($attributes['whenValue']) ? '' : $attributes['whenValue'],
    ),
);
$facts = array_filter($facts, function ($fact) {
    return $fact['value'] !== '';
});
$has_title = $title || $title_highlight;

// **text** is shown in bold
$format = function ($line) {
    return preg_replace('/\*\*(.+?)\*\*/s', '<strong class="font-bold">$1</strong>', esc_html($line));
};
?>
<div
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-data="gycEventModal"
    x-show="open"
    x-cloak
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @keydown.escape.window="close()"
    @keydown.tab="trapFocus($event)">
    <div class="absolute inset-0 bg-gyc-ink/80" @click="close()"></div>

    <div
        class="relative flex max-h-full w-full max-w-2xl flex-col overflow-y-auto rounded-3xl bg-gyc-plum-mid text-white shadow-2xl focus:outline-none"
        x-ref="dialog"
        tabindex="-1"
        role="dialog"
        aria-modal="true"
        <?php if ($has_title): ?>aria-labelledby="gyc-event-modal-title"<?php else: ?>aria-label="Event announcement"<?php endif; ?>>
        <div class="relative shrink-0 overflow-hidden bg-linear-to-b from-[#1e1024] to-gyc-plum px-6 pt-8 pb-10 md:px-10 md:min-h-64">
            <?php if ($image): ?>
                <!-- Decorative illustration: the text carries the meaning -->
                <img
                    class="absolute inset-0 h-full w-full object-cover object-right"
                    src="<?php echo esc_url($image); ?>"
                    alt=""
                    decoding="async"
                    draggable="false" />
            <?php else: ?>
                <!-- Without an illustration, layered hills keep the top from looking empty -->
                <svg class="absolute inset-x-0 bottom-0 h-24 w-full md:h-32" viewBox="0 0 1440 260" preserveAspectRatio="none" aria-hidden="true">
                    <path class="fill-white/5" d="M0 260V150l220-110 240 130 200-90 230 70 260-130 290 120v120z"/>
                    <path class="fill-gyc-plum-light/50" d="M0 260v-50l260-80 300 100 240-70 270 60 370-120v160z"/>
                </svg>
            <?php endif; ?>

            <div class="relative space-y-3 pr-10">
                <?php if ($eyebrow): ?>
                    <p class="font-jakarta text-sm font-semibold text-gyc-mint"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <?php if ($has_title): ?>
                    <h2 id="gyc-event-modal-title" class="font-display text-6xl md:text-7xl uppercase leading-[0.95] break-words">
                        <?php if ($title): ?>
                            <span class="block text-gyc-ivory"><?php echo esc_html($title); ?></span>
                        <?php endif; ?>
                        <?php if ($title_highlight): ?>
                            <span class="block text-gyc-mint"><?php echo esc_html($title_highlight); ?></span>
                        <?php endif; ?>
                    </h2>
                <?php endif; ?>
            </div>

            <button
                type="button"
                class="absolute top-4 right-4 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full bg-white/15 text-white motion-safe:transition-colors hover:bg-white/25 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-mint"
                @click="close()"
                aria-label="Close">
                <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <path d="M3 3l10 10M13 3L3 13"/>
                </svg>
            </button>
        </div>

        <div class="space-y-5 px-6 py-8 text-center md:px-10">
            <?php if ($notice): ?>
                <p class="font-jakarta text-sm font-medium text-gyc-mint"><?php echo $format($notice); ?></p>
            <?php endif; ?>

            <?php if (count($facts) > 0): ?>
                <dl class="mx-auto grid max-w-lg gap-3 <?php echo count($facts) > 1 ? 'sm:grid-cols-2' : ''; ?>">
                    <?php foreach ($facts as $fact): ?>
                        <div class="rounded-xl bg-white/10 px-4 py-3">
                            <?php if ($fact['label'] !== ''): ?>
                                <dt class="font-jakarta text-xs text-white/75"><?php echo esc_html($fact['label']); ?></dt>
                            <?php endif; ?>
                            <dd class="font-jakarta text-sm font-semibold md:text-base"><?php echo esc_html($fact['value']); ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="mx-auto max-w-md font-jakarta text-sm leading-relaxed text-white/90 whitespace-pre-line"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <div class="flex flex-col items-center gap-3 pt-2">
                <?php if ($primary_label && $primary_url): ?>
                    <a href="<?php echo esc_url($primary_url); ?>" class="inline-flex w-full max-w-xs items-center justify-center rounded-full bg-gyc-mint px-7 py-3.5 font-jakarta text-sm font-semibold text-gyc-plum motion-safe:transition-colors hover:bg-gyc-mint-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint">
                        <?php echo esc_html($primary_label); ?>
                    </a>
                <?php endif; ?>
                <?php if ($close_label): ?>
                    <button type="button" class="inline-flex w-full max-w-xs cursor-pointer items-center justify-center rounded-full border border-white/60 px-7 py-3.5 font-jakarta text-sm font-semibold text-white motion-safe:transition-colors hover:border-white hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint" @click="close()">
                        <?php echo esc_html($close_label); ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
