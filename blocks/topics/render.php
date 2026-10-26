<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$headline = empty($attributes['headline']) ? null : $attributes['headline'];
$text = empty($attributes['text']) ? '' : $attributes['text'];
$image = empty($attributes['image']) ? null : $attributes['image'];
$image_alt = empty($attributes['imageAlt']) ? '' : $attributes['imageAlt'];
$items = empty($attributes['items']) ? array() : $attributes['items'];

// Blank lines start a new paragraph; **text** is shown in bold
$paragraphs = array_filter(array_map('trim', preg_split('/\n\s*\n/', $text)));
$format = function ($paragraph) {
    return nl2br(preg_replace('/\*\*(.+?)\*\*/s', '<strong class="font-bold text-gyc-plum">$1</strong>', esc_html($paragraph)), false);
};

$items = array_filter($items, function ($item) {
    return !empty($item['title']) || !empty($item['text']);
});
?>
<section
    class="bg-gyc-mist text-gyc-plum py-16 md:py-24"
    <?php if ($headline): ?>aria-labelledby="gyc-topics-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="space-y-5">
                <?php if ($title): ?>
                    <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-plum/80"><?php echo esc_html($title); ?></p>
                <?php endif; ?>

                <?php if ($headline): ?>
                    <h2 id="gyc-topics-title" class="max-w-md font-display small-caps text-4xl md:text-5xl leading-none whitespace-pre-line"><?php echo esc_html($headline); ?></h2>
                <?php endif; ?>

                <?php foreach ($paragraphs as $paragraph): ?>
                    <p class="max-w-lg font-jakarta text-sm md:text-base leading-relaxed text-gyc-plum/80"><?php echo $format($paragraph); ?></p>
                <?php endforeach; ?>
            </div>

            <div class="relative aspect-[4/3] overflow-hidden rounded-2xl bg-gyc-plum/10">
                <?php if ($image): ?>
                    <img
                        class="absolute inset-0 h-full w-full object-cover"
                        src="<?php echo esc_url($image); ?>"
                        alt="<?php echo esc_attr($image_alt); ?>"
                        loading="lazy"
                        decoding="async"
                        draggable="false" />
                <?php endif; ?>
            </div>
        </div>

        <?php if (count($items) > 0): ?>
            <ul class="mt-12 md:mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" role="list">
                <?php foreach ($items as $item): ?>
                    <li class="rounded-2xl border border-gyc-plum/10 bg-white p-6">
                        <?php if (!empty($item['title'])): ?>
                            <h3 class="font-display small-caps text-xl leading-tight"><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($item['text'])): ?>
                            <p class="mt-2 font-jakarta text-sm leading-relaxed text-gyc-plum/80"><?php echo esc_html($item['text']); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
