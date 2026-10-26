<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl'], false);
$logo = empty($attributes['logo']) ? null : $attributes['logo'];
$logo_alt = empty($attributes['logoAlt']) ? '' : $attributes['logoAlt'];
$is_logo = ($attributes['imageType'] ?? '') === 'logo';

// The GYC Focus website is a separate site, so it opens in a new tab.
$button_is_external = $button_url && preg_match('~^https?://~i', $button_url) && wp_parse_url($button_url, PHP_URL_HOST) !== wp_parse_url(home_url(), PHP_URL_HOST);
?>
<section
    class="bg-gyc-aqua text-gyc-ink py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-focus-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 items-center gap-10 lg:gap-20">
        <div class="space-y-5">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-focus-title" class="font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="max-w-md font-jakarta text-sm md:text-base leading-relaxed text-gyc-ink/80"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if ($button_label && $button_url): ?>
                <div class="pt-1">
                    <a
                        href="<?php echo esc_url($button_url); ?>"
                        <?php if ($button_is_external): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
                        class="group inline-flex items-center gap-3 rounded-full bg-gyc-ink px-6 py-3.5 font-jakarta text-sm font-semibold text-white motion-safe:transition-colors hover:bg-gyc-night focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-ink">
                        <?php echo esc_html($button_label); ?>
                        <svg class="h-3.5 w-3.5 motion-safe:transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M8 7h9v9"></path>
                        </svg>
                        <?php if ($button_is_external): ?><span class="sr-only">(opens in a new tab)</span><?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($logo): ?>
            <?php if ($is_logo): ?>
                <!-- Logo: shown whole, centred on a white card -->
                <div class="flex aspect-[2/1] items-center justify-center rounded-3xl bg-white p-10 md:p-14">
            <?php else: ?>
                <!-- Picture: fills the box; edges are cropped when its shape differs -->
                <div class="relative aspect-[2/1] overflow-hidden rounded-3xl bg-white">
            <?php endif; ?>
                <img
                    class="<?php echo $is_logo ? 'max-h-full max-w-full object-contain' : 'absolute inset-0 h-full w-full object-cover'; ?>"
                    src="<?php echo esc_url($logo); ?>"
                    alt="<?php echo esc_attr($logo_alt); ?>"
                    loading="lazy"
                    decoding="async"
                    draggable="false" />
            </div>
        <?php endif; ?>
    </div>
</section>
