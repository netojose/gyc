<?php
$image = empty($attributes['image']) ? null : $attributes['image'];
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$title_highlight = empty($attributes['titleHighlight']) ? null : $attributes['titleHighlight'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$has_title = $title || $title_highlight;
?>
<section
    class="relative overflow-hidden bg-gyc-plum text-white border-b-4 border-gyc-mint"
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
    <?php endif; ?>
    <div class="absolute inset-0 bg-gyc-plum/80 bg-linear-to-r from-gyc-plum/60 to-transparent" aria-hidden="true"></div>

    <div class="relative max-w-6xl mx-auto px-6 md:px-12 py-20 md:py-28">
        <div class="max-w-xl space-y-6">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-mint"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($has_title): ?>
                <h1 id="gyc-image-hero-title" class="font-jakarta font-extrabold text-5xl md:text-7xl uppercase leading-none tracking-tight break-words">
                    <?php if ($title): ?>
                        <span class="block text-gyc-ivory"><?php echo esc_html($title); ?></span>
                    <?php endif; ?>
                    <?php if ($title_highlight): ?>
                        <span class="block text-gyc-mint"><?php echo esc_html($title_highlight); ?></span>
                    <?php endif; ?>
                </h1>
                <span class="block h-1.5 w-14 bg-gyc-mint" aria-hidden="true"></span>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-base leading-relaxed text-white/85"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
