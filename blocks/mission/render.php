<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$items = empty($attributes['items']) ? array() : $attributes['items'];

$items = array_filter($items, function ($item) {
    return !empty($item['title']) || !empty($item['text']);
});
?>
<section
    class="bg-gyc-mist text-gyc-ink py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-mission-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12">
        <div class="max-w-2xl mx-auto text-center flex flex-col items-center gap-6">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-mission-title" class="font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-sm md:text-base leading-relaxed text-gyc-ink/80"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if (count($items) > 0): ?>
            <ul class="mt-12 md:mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" role="list">
                <?php foreach ($items as $item): ?>
                    <li class="overflow-hidden rounded-2xl border border-gyc-ink/10 bg-white">
                        <div class="relative aspect-[4/3] bg-gyc-ink/10">
                            <?php if (!empty($item['image'])): ?>
                                <img
                                    class="absolute inset-0 h-full w-full object-cover"
                                    src="<?php echo esc_url($item['image']); ?>"
                                    alt="<?php echo esc_attr(empty($item['imageAlt']) ? '' : $item['imageAlt']); ?>"
                                    loading="lazy"
                                    decoding="async"
                                    draggable="false" />
                            <?php endif; ?>
                        </div>

                        <div class="p-5 md:p-6 space-y-2">
                            <?php if (!empty($item['title'])): ?>
                                <h3 class="font-display small-caps text-xl leading-tight"><?php echo esc_html($item['title']); ?></h3>
                            <?php endif; ?>

                            <?php if (!empty($item['text'])): ?>
                                <p class="font-jakarta text-sm leading-relaxed text-gyc-ink/80"><?php echo esc_html($item['text']); ?></p>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
