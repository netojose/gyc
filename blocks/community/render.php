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

        <!-- Until an image is set, a grey box with its name holds the slot, so the layout can be checked -->
        <!-- On desktop the collage overlaps the map by 24px and fills the rest of the row; the placeholder is 50px shorter than the map, the image keeps its own height -->
        <div class="lg:col-span-8 flex flex-col gap-12 lg:flex-row lg:gap-0">
        <div class="lg:w-[61%] lg:shrink-0">
            <?php if ($map): ?>
                <img
                    class="mx-auto w-full h-auto"
                    src="<?php echo esc_url($map); ?>"
                    alt="<?php echo esc_attr($map_alt); ?>"
                    loading="lazy"
                    decoding="async"
                    draggable="false" />
            <?php else: ?>
                <div class="flex aspect-[4/3] w-full items-center justify-center rounded-2xl bg-gyc-ink/10 font-jakarta text-sm text-gyc-ink/50" aria-hidden="true"><?php esc_html_e('Map', 'gyc'); ?></div>
            <?php endif; ?>
        </div>

        <div class="lg:relative lg:flex lg:flex-1 lg:items-center">
            <?php if ($collage): ?>
                <img
                    class="mx-auto w-full max-w-64 sm:max-w-xs h-auto lg:relative lg:z-10 lg:-ml-6 lg:w-[calc(100%+1.5rem)] lg:max-w-none"
                    src="<?php echo esc_url($collage); ?>"
                    alt="<?php echo esc_attr($collage_alt); ?>"
                    loading="lazy"
                    decoding="async"
                    draggable="false" />
            <?php else: ?>
                <div class="mx-auto flex aspect-square w-full max-w-64 sm:max-w-xs lg:absolute lg:inset-y-[25px] lg:-left-6 lg:z-10 lg:w-[calc(100%+1.5rem)] lg:max-w-none lg:aspect-auto items-center justify-center rounded-2xl bg-gyc-ink/10 font-jakarta text-sm text-gyc-ink/50" aria-hidden="true"><?php esc_html_e('Photo collage', 'gyc'); ?></div>
            <?php endif; ?>
        </div>
        </div>
    </div>
</section>
