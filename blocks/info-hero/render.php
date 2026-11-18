<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$links = empty($attributes['links']) ? array() : $attributes['links'];

$links = array_values(array_filter($links, function ($link) {
    return !empty($link['label']) && !empty($link['url']);
}));
?>
<section
    class="gyc-info-hero bg-gyc-plum-mid text-white"
    <?php if ($title): ?>aria-labelledby="gyc-info-hero-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 pt-16 pb-14 md:pt-28 md:pb-20">
        <div class="max-w-3xl space-y-5 md:space-y-6">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-mint"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h1 id="gyc-info-hero-title" class="font-display small-caps text-6xl md:text-7xl lg:text-[6.5rem] leading-[0.95] text-gyc-ivory break-words"><?php echo esc_html($title); ?></h1>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="max-w-xl font-jakarta text-base md:text-lg leading-relaxed text-white/85"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if (count($links) > 0): ?>
            <nav class="mt-12 md:mt-20 border-t border-white/15 pt-6 md:pt-8" aria-label="<?php echo esc_attr__('On this page', 'gyc'); ?>">
                <ul class="grid grid-cols-4 lg:grid-flow-col lg:auto-cols-fr lg:grid-cols-none gap-x-2 gap-y-6" role="list">
                    <?php foreach ($links as $link): ?>
                        <li>
                            <a
                                href="<?php echo esc_url(GycUI::resolve_url($link['url'], false)); ?>"
                                class="group flex flex-col items-center gap-3 rounded-xl py-1 text-center focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint">
                                <span class="flex h-12 w-12 items-center justify-center rounded-xl border border-white/25 bg-white/5 text-gyc-mint motion-safe:transition-colors group-hover:border-gyc-mint group-hover:bg-gyc-mint group-hover:text-gyc-plum" aria-hidden="true">
                                    <?php echo GycInfo::svg(empty($link['icon']) ? '' : $link['icon'], 'h-5 w-5'); ?>
                                </span>
                                <span class="font-jakarta text-xs sm:text-sm font-medium leading-tight text-white group-hover:text-gyc-mint motion-safe:transition-colors"><?php echo esc_html($link['label']); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>
