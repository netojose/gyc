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
    class="bg-white text-gyc-plum py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-mission-title"<?php endif; ?>>
    <div class="max-w-6xl mx-auto px-6 md:px-12">
        <div class="max-w-xl mx-auto text-center flex flex-col items-center gap-5">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-plum/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-mission-title" class="font-jakarta font-extrabold text-4xl md:text-5xl uppercase tracking-tight"><?php echo esc_html($title); ?></h2>
                <span class="block h-1.5 w-12 bg-gyc-mint" aria-hidden="true"></span>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-base leading-relaxed text-gyc-plum/75"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if (count($items) > 0): ?>
            <ul class="mt-12 md:mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-4" role="list">
                <?php foreach ($items as $item): ?>
                    <li>
                        <div class="relative aspect-[5/4] overflow-hidden bg-gyc-plum">
                            <?php if (!empty($item['image'])): ?>
                                <img
                                    class="absolute inset-0 h-full w-full object-cover"
                                    src="<?php echo esc_url($item['image']); ?>"
                                    alt="<?php echo esc_attr(empty($item['imageAlt']) ? '' : $item['imageAlt']); ?>"
                                    loading="lazy"
                                    decoding="async"
                                    draggable="false" />
                            <?php else: ?>
                                <div class="absolute inset-0 bg-linear-to-br from-gyc-plum-light to-gyc-plum" aria-hidden="true"></div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-linear-to-t from-gyc-plum/90 via-gyc-plum/20 to-transparent" aria-hidden="true"></div>

                            <?php if (!empty($item['title'])): ?>
                                <h3 class="absolute inset-x-0 bottom-0 px-4 pb-4 font-jakarta text-sm font-extrabold uppercase tracking-[0.18em] text-gyc-mint"><?php echo esc_html($item['title']); ?></h3>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($item['text'])): ?>
                            <p class="mt-4 font-jakarta text-sm leading-relaxed text-gyc-plum/75"><?php echo esc_html($item['text']); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
