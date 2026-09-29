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
    <div class="max-w-6xl mx-auto px-6 md:px-12">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-8">
            <div class="space-y-5">
                <?php if ($eyebrow): ?>
                    <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-mint"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 id="gyc-goals-title" class="font-jakarta font-extrabold text-4xl md:text-5xl uppercase tracking-tight text-gyc-ivory"><?php echo esc_html($title); ?></h2>
                    <span class="block h-1.5 w-12 bg-gyc-mint" aria-hidden="true"></span>
                <?php endif; ?>
            </div>

            <?php if ($text): ?>
                <p class="max-w-xs font-jakarta text-sm leading-relaxed text-white/70"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if (count($items) > 0): ?>
            <ol class="mt-12 md:mt-14 grid grid-cols-1 md:grid-cols-2 gap-px border border-white/10 bg-white/10" role="list">
                <?php foreach ($items as $index => $item): ?>
                    <li class="bg-gyc-night p-8 md:p-10">
                        <span class="inline-block rounded-sm bg-gyc-mint/15 px-2.5 py-1 font-jakarta text-xs font-bold tracking-[0.2em] text-gyc-mint" aria-hidden="true"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>

                        <?php if (!empty($item['title'])): ?>
                            <h3 class="font-jakarta font-extrabold mt-5 text-2xl uppercase tracking-tight text-gyc-ivory"><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($item['text'])): ?>
                            <p class="mt-3 font-jakarta text-sm md:text-base leading-relaxed text-white/70"><?php echo esc_html($item['text']); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>
</section>
