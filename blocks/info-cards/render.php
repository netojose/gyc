<?php
$items = empty($attributes['items']) ? array() : $attributes['items'];

$items = array_filter($items, function ($item) {
    return !empty($item['title']) || !empty($item['text']);
});

if (count($items) === 0) {
    return;
}
?>
<div class="bg-gyc-mist text-gyc-plum pt-4 pb-16 md:pb-20">
    <ul class="max-w-6xl mx-auto px-6 md:px-12 space-y-6" role="list">
        <?php foreach ($items as $item): ?>
            <?php $button_url = empty($item['buttonUrl']) ? null : GycUI::resolve_url($item['buttonUrl'], false); ?>
            <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 rounded-sm border border-gyc-plum/10 bg-gyc-ivory px-6 py-8 md:px-8">
                <div class="space-y-2">
                    <?php if (!empty($item['title'])): ?>
                        <h2 class="font-jakarta text-lg font-extrabold uppercase tracking-tight"><?php echo esc_html($item['title']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($item['text'])): ?>
                        <p class="font-jakarta text-sm text-gyc-plum/80"><?php echo esc_html($item['text']); ?></p>
                    <?php endif; ?>
                </div>

                <?php if (!empty($item['buttonLabel']) && $button_url): ?>
                    <a
                        href="<?php echo esc_url($button_url); ?>"
                        class="group inline-flex shrink-0 items-center gap-2 self-start sm:self-auto rounded-sm bg-gyc-plum px-6 py-3 font-jakarta text-xs font-bold uppercase tracking-[0.18em] text-white hover:bg-gyc-plum-light motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-plum">
                        <?php echo esc_html($item['buttonLabel']); ?>
                        <svg class="h-3.5 w-3.5 motion-safe:transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
