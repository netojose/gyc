<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$image = empty($attributes['image']) ? null : $attributes['image'];
$image_alt = empty($attributes['imageAlt']) ? '' : $attributes['imageAlt'];
?>
<section
    class="bg-gyc-ink text-white py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-vision-statement-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 items-center gap-12 lg:gap-16">
        <div class="space-y-6">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-aqua"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-vision-statement-title" class="font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="max-w-xl lg:max-w-none font-jakarta text-base md:text-lg leading-relaxed text-white/85"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <!-- The outline sits behind the photo, shifted down and right -->
        <div class="relative w-full max-w-md justify-self-center lg:max-w-none pr-5 pb-5 md:pr-6 md:pb-6 lg:pl-6">
            <span class="absolute inset-0 top-5 left-5 md:top-6 md:left-6 lg:left-12 rounded-2xl border-2 border-gyc-aqua" aria-hidden="true"></span>
            <!-- Same grey placeholder as the intro photos (ink at 10% on cream) until a photo is set -->
            <div class="relative aspect-[8/7] overflow-hidden rounded-2xl bg-gyc-cream">
                <div class="absolute inset-0 bg-gyc-ink/10"></div>
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
    </div>
</section>
