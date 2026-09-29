<?php
$image = empty($attributes['image']) ? null : $attributes['image'];
$image_alt = empty($attributes['imageAlt']) ? '' : $attributes['imageAlt'];
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$items = empty($attributes['items']) ? array() : $attributes['items'];

$items = array_filter($items, function ($item) {
    return !empty($item['text']);
});
?>
<section
    class="bg-gyc-mist text-gyc-plum py-16 md:py-20"
    <?php if ($title): ?>aria-labelledby="gyc-why-give-title"<?php endif; ?>>
    <div class="max-w-6xl mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 items-center">
        <div class="relative aspect-[4/3] overflow-hidden rounded-sm bg-gyc-plum">
            <?php if ($image): ?>
                <img
                    class="absolute inset-0 h-full w-full object-cover"
                    src="<?php echo esc_url($image); ?>"
                    alt="<?php echo esc_attr($image_alt); ?>"
                    loading="lazy"
                    decoding="async"
                    draggable="false" />
            <?php else: ?>
                <div class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
                    <div class="flex h-1/2 aspect-square flex-col items-center justify-center rounded-full bg-gyc-plum-light text-white">
                        <span class="font-jakarta text-sm font-bold uppercase tracking-widest">GYC</span>
                        <span class="font-jakarta text-2xl md:text-3xl font-extrabold uppercase">Europe</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="space-y-5">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-plum/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-why-give-title" class="font-jakarta text-3xl md:text-4xl font-extrabold uppercase leading-tight tracking-tight"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-base leading-relaxed text-gyc-plum/85 max-w-md"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if (count($items) > 0): ?>
                <ul class="space-y-3 pt-2" role="list">
                    <?php foreach ($items as $item): ?>
                        <li class="flex items-start gap-3 font-jakarta text-sm md:text-base text-gyc-plum/90">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-gyc-teal" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="12" r="10" fill="currentColor" opacity="0.15"/>
                                <path d="M7.5 12.5l3 3 6-6.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span><?php echo esc_html($item['text']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
