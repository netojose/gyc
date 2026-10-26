<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$items = empty($attributes['items']) ? array() : $attributes['items'];

$icons = array(
    'gift' => '<rect x="3.5" y="8.5" width="17" height="4" rx="1"/><path d="M5 12.5V20h14v-7.5M12 8.5V20M12 8.5c-1.5-3-5-3.5-5-1.2 0 1.2 1.5 1.2 5 1.2zM12 8.5c1.5-3 5-3.5 5-1.2 0 1.2-1.5 1.2-5 1.2z"/>',
    'calendar' => '<rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4M9.5 15l2 2 3.5-3.5"/>',
    'person' => '<circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/>',
    'heart' => '<path d="M12 20s-7.5-4.6-7.5-10A4.3 4.3 0 0 1 12 7.2 4.3 4.3 0 0 1 19.5 10c0 5.4-7.5 10-7.5 10z"/>',
);

$items = array_filter($items, function ($item) {
    return !empty($item['title']) || !empty($item['text']);
});
?>
<section
    class="bg-gyc-mist text-gyc-ink py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-gift-options-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12">
        <?php if ($title || $text): ?>
            <div class="max-w-2xl space-y-5">
                <?php if ($title): ?>
                    <h2 id="gyc-gift-options-title" class="font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($text): ?>
                    <p class="font-jakarta text-sm md:text-base leading-relaxed text-gyc-ink/80"><?php echo esc_html($text); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (count($items) > 0): ?>
            <ul class="mt-10 md:mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" role="list">
                <?php foreach (array_values($items) as $index => $item): ?>
                    <?php
                    $item_title_id = 'gyc-gift-options-item-' . $index;
                    $button_url = empty($item['buttonUrl']) ? null : GycUI::resolve_url($item['buttonUrl'], false);
                    ?>
                    <li class="flex flex-col rounded-2xl border border-gyc-ink/10 bg-white p-6 md:p-8">
                        <?php if (!empty($item['icon']) && isset($icons[$item['icon']])): ?>
                            <span class="mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-gyc-aqua/20 text-gyc-teal" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <?php echo $icons[$item['icon']]; ?>
                                </svg>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($item['title'])): ?>
                            <h3 id="<?php echo esc_attr($item_title_id); ?>" class="font-display small-caps text-xl leading-tight"><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($item['text'])): ?>
                            <p class="mt-2 font-jakarta text-sm leading-relaxed text-gyc-ink/80"><?php echo esc_html($item['text']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($item['buttonLabel']) && $button_url): ?>
                            <a
                                href="<?php echo esc_url($button_url); ?>"
                                <?php if (!empty($item['title'])): ?>aria-describedby="<?php echo esc_attr($item_title_id); ?>"<?php endif; ?>
                                class="mt-4 self-start font-jakarta text-sm font-semibold text-gyc-teal underline decoration-transparent hover:decoration-current motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal">
                                <?php echo esc_html($item['buttonLabel']); ?>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
