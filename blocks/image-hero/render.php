<?php
$image = empty($attributes['image']) ? null : $attributes['image'];
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$title_highlight = empty($attributes['titleHighlight']) ? null : $attributes['titleHighlight'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$has_title = $title || $title_highlight;
?>
<section
    class="relative overflow-hidden bg-gyc-ink text-white"
    <?php if ($has_title): ?>aria-labelledby="gyc-image-hero-title"<?php endif; ?>>
    <?php if ($image): ?>
        <!-- Decorative background photo: the text carries the meaning -->
        <img
            class="absolute inset-0 h-full w-full object-cover"
            src="<?php echo esc_url($image); ?>"
            alt=""
            fetchpriority="high"
            decoding="async"
            draggable="false" />
        <div class="absolute inset-0 bg-gyc-ink/80 bg-linear-to-r from-gyc-ink/60 to-transparent" aria-hidden="true"></div>
    <?php endif; ?>

    <div class="relative max-w-content mx-auto px-6 md:px-12 py-24 md:py-36">
        <div class="max-w-2xl space-y-6">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-mint"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($has_title): ?>
                <h1 id="gyc-image-hero-title" class="font-display small-caps text-5xl md:text-7xl leading-none break-words">
                    <?php if ($title): ?>
                        <span class="block text-white"><?php echo esc_html($title); ?></span>
                    <?php endif; ?>
                    <?php if ($title_highlight): ?>
                        <span class="block text-gyc-mint"><?php echo esc_html($title_highlight); ?></span>
                    <?php endif; ?>
                </h1>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="max-w-xl font-jakarta text-base md:text-lg leading-relaxed text-white/85"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
