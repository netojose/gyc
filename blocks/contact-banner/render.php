<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl'], false);
?>
<section
    class="bg-gyc-mint text-gyc-ink py-12 md:py-16"
    <?php if ($title): ?>aria-labelledby="gyc-contact-banner-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="space-y-2">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-contact-banner-title" class="font-display small-caps text-3xl md:text-4xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-sm text-gyc-ink/85"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($button_label && $button_url): ?>
            <a
                href="<?php echo esc_url($button_url); ?>"
                class="inline-flex shrink-0 items-center self-start md:self-auto rounded-full bg-gyc-ink px-7 py-3.5 font-jakarta text-sm font-semibold text-white hover:bg-gyc-night motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-ink">
                <?php echo esc_html($button_label); ?>
            </a>
        <?php endif; ?>
    </div>
</section>
