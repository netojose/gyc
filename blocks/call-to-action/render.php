<?php
$title_top = empty($attributes['titleTop']) ? null : $attributes['titleTop'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl'], false);
$is_mint = !empty($attributes['variant']) && $attributes['variant'] === 'mint';
$has_title = $title_top || $title;
?>
<section
    class="<?php echo $is_mint ? 'bg-gyc-mint' : 'bg-gyc-mist'; ?> text-gyc-plum py-16 md:py-24"
    <?php if ($has_title): ?>aria-labelledby="gyc-call-to-action-title"<?php endif; ?>>
    <div class="max-w-4xl mx-auto px-6 md:px-12 flex flex-col items-center text-center gap-8">
        <?php if ($has_title || $text): ?>
            <div class="space-y-4">
                <?php if ($has_title): ?>
                    <h2 id="gyc-call-to-action-title" class="font-jakarta font-extrabold uppercase leading-tight tracking-tight">
                        <?php if ($title_top): ?>
                            <span class="block text-2xl md:text-3xl mb-3"><?php echo esc_html($title_top); ?></span>
                        <?php endif; ?>
                        <?php if ($title): ?>
                            <span class="block text-3xl md:text-5xl"><?php echo esc_html($title); ?></span>
                        <?php endif; ?>
                    </h2>
                <?php endif; ?>

                <?php if ($text): ?>
                    <p class="font-jakarta text-sm md:text-base text-gyc-plum/85"><?php echo esc_html($text); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($button_label && $button_url): ?>
            <a
                href="<?php echo esc_url($button_url); ?>"
                class="group inline-flex items-center gap-2 rounded-sm px-8 py-3.5 font-jakarta text-xs font-bold uppercase tracking-[0.18em] motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-plum <?php echo $is_mint ? 'bg-gyc-plum text-white hover:bg-gyc-plum-light' : 'bg-gyc-mint text-gyc-plum hover:bg-gyc-mint-dark'; ?>">
                <?php echo esc_html($button_label); ?>
                <svg class="h-3.5 w-3.5 motion-safe:transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>
                </svg>
            </a>
        <?php endif; ?>
    </div>
</section>
