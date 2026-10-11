<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl']);
$map = empty($attributes['map']) ? null : $attributes['map'];
$map_alt = empty($attributes['mapAlt']) ? '' : $attributes['mapAlt'];
$collage = empty($attributes['collage']) ? null : $attributes['collage'];
$collage_alt = empty($attributes['collageAlt']) ? '' : $attributes['collageAlt'];
?>
<section
    id="community"
    class="bg-gyc-sand text-gyc-ink py-16 md:py-20 overflow-hidden"
    <?php if ($title): ?>aria-labelledby="gyc-community-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
        <div class="lg:col-span-4 space-y-5">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/65"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-community-title" class="font-display text-4xl md:text-5xl uppercase leading-none text-gyc-ink whitespace-pre-line"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-base leading-relaxed text-gyc-ink/85 max-w-sm"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if ($button_label && $button_url): ?>
                <a
                    href="<?php echo esc_url($button_url); ?>"
                    class="inline-flex items-center gap-3 rounded-full border-2 border-gyc-teal px-6 py-3 font-jakarta text-xs font-bold uppercase tracking-[0.2em] text-gyc-teal motion-safe:transition-colors hover:bg-gyc-teal hover:text-white focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                    <?php echo esc_html($button_label); ?>
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <?php if ($map): ?>
            <div class="lg:col-span-3">
                <img
                    class="mx-auto w-full max-w-sm h-auto"
                    src="<?php echo esc_url($map); ?>"
                    alt="<?php echo esc_attr($map_alt); ?>"
                    loading="lazy"
                    decoding="async"
                    draggable="false" />
            </div>
        <?php endif; ?>

        <?php if ($collage): ?>
            <div class="<?php echo $map ? 'lg:col-span-5' : 'lg:col-span-8'; ?>">
                <img
                    class="mx-auto w-full h-auto"
                    src="<?php echo esc_url($collage); ?>"
                    alt="<?php echo esc_attr($collage_alt); ?>"
                    loading="lazy"
                    decoding="async"
                    draggable="false" />
            </div>
        <?php endif; ?>
    </div>
</section>
