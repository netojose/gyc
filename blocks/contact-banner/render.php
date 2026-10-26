<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl'], false);
// Mint with violet is reserved for event pages; everywhere else the strip is aqua with deep blue.
$is_mint = !empty($attributes['variant']) && $attributes['variant'] === 'mint';
?>
<section
    class="<?php echo $is_mint ? 'bg-gyc-mint text-gyc-plum' : 'bg-gyc-aqua text-gyc-ink'; ?> py-12 md:py-16"
    <?php if ($title): ?>aria-labelledby="gyc-contact-banner-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="space-y-2">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase <?php echo $is_mint ? 'text-gyc-plum/80' : 'text-gyc-ink/80'; ?>"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-contact-banner-title" class="font-display small-caps text-3xl md:text-4xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-sm md:text-base leading-relaxed <?php echo $is_mint ? 'text-gyc-plum/85' : 'text-gyc-ink/85'; ?>"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($button_label && $button_url): ?>
            <a
                href="<?php echo esc_url($button_url); ?>"
                class="inline-flex shrink-0 items-center self-start md:self-auto rounded-full px-7 py-3.5 font-jakarta text-sm font-semibold text-white motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 <?php echo $is_mint ? 'bg-gyc-plum hover:bg-gyc-plum-light focus-visible:outline-gyc-plum' : 'bg-gyc-ink hover:bg-gyc-night focus-visible:outline-gyc-ink'; ?>">
                <?php echo esc_html($button_label); ?>
            </a>
        <?php endif; ?>
    </div>
</section>
