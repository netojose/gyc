<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$items = empty($attributes['items']) ? array() : $attributes['items'];

$items = array_values(array_filter($items, function ($item) {
    return !empty($item['title']) || !empty($item['text']);
}));
?>
<section
    class="bg-gyc-mist text-gyc-ink py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-spirit-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12">
        <div class="space-y-5">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-teal"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-spirit-title" class="font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="max-w-xl font-jakarta text-sm md:text-base leading-relaxed text-gyc-ink/80"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if (count($items) > 0): ?>
            <!-- Each row starts with a top rule; the list's bottom rule closes the last row. Padding instead of a column gap keeps the rules unbroken across both columns -->
            <ol class="mt-10 md:mt-12 grid grid-cols-1 md:grid-cols-2 border-b border-gyc-ink/15" role="list">
                <?php foreach ($items as $index => $item): ?>
                    <li class="flex gap-6 md:gap-8 border-t border-gyc-ink/15 py-6 md:py-7 md:odd:pr-8 md:even:pl-8">
                        <span class="w-10 shrink-0 font-display text-3xl md:text-4xl leading-none text-gyc-teal" aria-hidden="true"><?php echo esc_html(str_pad($index + 1, 2, '0', STR_PAD_LEFT)); ?></span>
                        <p class="font-jakarta text-sm leading-relaxed text-gyc-ink/70">
                            <?php if (!empty($item['title'])): ?>
                                <strong class="font-bold text-gyc-ink"><?php echo esc_html($item['title']); ?></strong>
                            <?php endif; ?>
                            <?php if (!empty($item['text'])): ?>
                                <?php echo esc_html($item['text']); ?>
                            <?php endif; ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>
</section>
