<?php
// Turned off in the block settings: nothing is shown, but the content is kept
if (!GycInfo::is_active($attributes)) {
    return;
}

$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$button = GycInfo::button(
    empty($attributes['buttonLabel']) ? '' : $attributes['buttonLabel'],
    empty($attributes['buttonUrl']) ? '' : $attributes['buttonUrl'],
    empty($attributes['buttonOpensAt']) ? '' : $attributes['buttonOpensAt']
);

if (!$title && !$text && !$button) {
    return;
}
?>
<section
    class="bg-gyc-mint text-gyc-plum py-14 md:py-20"
    <?php if ($title): ?>aria-labelledby="gyc-info-register-banner-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 flex flex-col gap-8 md:flex-row md:items-center md:justify-between">
        <div class="max-w-2xl space-y-4">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-plum/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($title): ?>
                <h2 id="gyc-info-register-banner-title" class="font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php if ($text): ?>
                <p class="font-jakarta text-sm md:text-base leading-relaxed text-gyc-plum/80"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($button): ?>
            <div class="gyc-register-banner-action shrink-0"><?php echo $button; ?></div>
        <?php endif; ?>
    </div>
</section>
