<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$lead = empty($attributes['lead']) ? null : $attributes['lead'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$images = empty($attributes['images']) ? array() : array_slice(array_values($attributes['images']), 0, 3);

// On phones the photos stack at full width; from tablet the first is large and the next two sit side by side underneath
$slots = array('aspect-[16/9] md:col-span-2 md:aspect-[16/7]', 'aspect-[16/9] md:aspect-[4/3]', 'aspect-[16/9] md:aspect-[4/3]');
?>
<section
    class="bg-gyc-ivory text-gyc-plum py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-vision-title"<?php endif; ?>>
    <div class="max-w-6xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <div class="space-y-6">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-plum/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-vision-title" class="font-jakarta font-extrabold text-4xl md:text-5xl uppercase tracking-tight"><?php echo esc_html($title); ?></h2>
                <span class="block h-1.5 w-12 bg-gyc-mint" aria-hidden="true"></span>
            <?php endif; ?>

            <?php if ($lead): ?>
                <p class="font-jakarta text-base leading-relaxed text-gyc-plum/90"><?php echo esc_html($lead); ?></p>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-sm leading-relaxed text-gyc-plum/70"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if (count($images) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <?php foreach ($images as $index => $image): ?>
                    <div class="relative overflow-hidden bg-gyc-plum-light <?php echo esc_attr($slots[$index]); ?>">
                        <?php if (!empty($image['url'])): ?>
                            <img
                                class="absolute inset-0 h-full w-full object-cover"
                                src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr(empty($image['alt']) ? '' : $image['alt']); ?>"
                                loading="lazy"
                                decoding="async"
                                draggable="false" />
                        <?php else: ?>
                            <div class="absolute inset-0 bg-linear-to-br from-gyc-plum-light to-gyc-plum" aria-hidden="true"></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
