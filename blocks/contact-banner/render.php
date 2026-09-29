<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];$text = empty($attributes['text']) ? null : $attributes['text'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl'], false);
?>
<section
    class="bg-gyc-mint text-gyc-plum py-10 md:py-12"
    <?php if ($title): ?>aria-labelledby="gyc-contact-banner-title"<?php endif; ?>>
    <div class="max-w-6xl mx-auto px-6 md:px-12 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="space-y-2">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-plum/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-contact-banner-title" class="font-jakarta text-2xl md:text-3xl font-extrabold uppercase leading-tight tracking-tight"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-sm text-gyc-plum/85"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($button_label && $button_url): ?>
            <a
                href="<?php echo esc_url($button_url); ?>"
                class="group inline-flex shrink-0 items-center gap-2 self-start md:self-auto rounded-sm bg-gyc-plum px-7 py-3.5 font-jakarta text-xs font-bold uppercase tracking-[0.18em] text-white hover:bg-gyc-plum-light motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-plum">
                <?php echo esc_html($button_label); ?>
                <svg class="h-3.5 w-3.5 motion-safe:transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>
                </svg>
            </a>
        <?php endif; ?>
    </div>
</section>
