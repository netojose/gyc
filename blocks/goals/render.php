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
    class="bg-gyc-night text-white py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-goals-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div class="space-y-5">
                <?php if ($eyebrow): ?>
                    <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-aqua"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 id="gyc-goals-title" class="font-display small-caps text-4xl md:text-5xl leading-none text-white"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
            </div>

            <?php if ($text): ?>
                <p class="max-w-xs font-jakarta text-sm leading-relaxed text-white/70"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if (count($items) > 0): ?>
            <ul class="mt-10 md:mt-12 grid grid-cols-1 md:grid-cols-2 border-t border-l border-white/15" role="list">
                <?php foreach ($items as $item): ?>
                    <li class="border-r border-b border-white/15 px-6 py-8 md:p-10">
                        <?php if (!empty($item['title'])): ?>
                            <h3 class="font-display small-caps text-xl leading-tight text-white"><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($item['text'])): ?>
                            <p class="mt-3 max-w-md font-jakarta text-sm md:text-base leading-relaxed text-white/70"><?php echo esc_html($item['text']); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
