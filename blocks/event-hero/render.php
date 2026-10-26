<?php
$post_id = empty($block->context['postId']) ? get_the_ID() : $block->context['postId'];
$image = empty($attributes['image']) ? null : $attributes['image'];
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? get_the_title($post_id) : $attributes['title'];
$title_highlight = empty($attributes['titleHighlight']) ? null : $attributes['titleHighlight'];
$details = empty($attributes['details']) ? null : $attributes['details'];
$primary_label = empty($attributes['primaryLabel']) ? null : $attributes['primaryLabel'];
$primary_url = empty($attributes['primaryUrl']) ? null : GycUI::resolve_url($attributes['primaryUrl'], false);
$secondary_label = empty($attributes['secondaryLabel']) ? null : $attributes['secondaryLabel'];
$secondary_url = empty($attributes['secondaryUrl']) ? null : GycUI::resolve_url($attributes['secondaryUrl'], false);
$stats = empty($attributes['stats']) ? array() : $attributes['stats'];

$stats = array_filter($stats, function ($stat) {
    return !empty($stat['value']) && !empty($stat['label']);
});
$has_title = $title || $title_highlight;
?>
<header
    class="relative overflow-hidden bg-linear-to-b from-[#1e1024] to-gyc-plum text-white"
    <?php if ($has_title): ?>aria-labelledby="gyc-event-hero-title"<?php endif; ?>>
    <?php if ($image): ?>
        <!-- Decorative illustration: the text carries the meaning -->
        <img
            class="absolute inset-0 h-full w-full object-cover object-right"
            src="<?php echo esc_url($image); ?>"
            alt=""
            fetchpriority="high"
            decoding="async"
            draggable="false" />
        <div class="absolute inset-0 bg-linear-to-r from-[#1e1024] via-[#1e1024]/60 to-transparent" aria-hidden="true"></div>
    <?php else: ?>
        <!-- Without an illustration, layered hills keep the hero from looking empty -->
        <svg class="absolute inset-x-0 bottom-0 h-40 w-full md:h-64" viewBox="0 0 1440 260" preserveAspectRatio="none" aria-hidden="true">
            <path class="fill-white/5" d="M0 260V150l220-110 240 130 200-90 230 70 260-130 290 120v120z"/>
            <path class="fill-gyc-plum-light/50" d="M0 260v-50l260-80 300 100 240-70 270 60 370-120v160z"/>
        </svg>
    <?php endif; ?>

    <div class="relative max-w-content mx-auto px-6 md:px-12 py-24 md:py-32 lg:min-h-[40rem] lg:flex lg:flex-col lg:justify-center">
        <div class="max-w-xl space-y-6">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-mint"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($has_title): ?>
                <h1 id="gyc-event-hero-title" class="font-display small-caps text-6xl md:text-8xl leading-[0.95] break-words">
                    <?php if ($title): ?>
                        <span class="block text-gyc-ivory"><?php echo esc_html($title); ?></span>
                    <?php endif; ?>
                    <?php if ($title_highlight): ?>
                        <span class="block text-gyc-mint"><?php echo esc_html($title_highlight); ?></span>
                    <?php endif; ?>
                </h1>
            <?php endif; ?>

            <?php if ($details): ?>
                <p class="font-jakarta text-lg md:text-xl text-white/90"><?php echo esc_html($details); ?></p>
            <?php endif; ?>

            <?php if (($primary_label && $primary_url) || ($secondary_label && $secondary_url)): ?>
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <?php if ($primary_label && $primary_url): ?>
                        <a href="<?php echo esc_url($primary_url); ?>" class="inline-flex items-center rounded-full bg-gyc-mint px-7 py-3.5 font-jakarta text-sm font-semibold text-gyc-plum motion-safe:transition-colors hover:bg-gyc-mint-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint">
                            <?php echo esc_html($primary_label); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($secondary_label && $secondary_url): ?>
                        <a href="<?php echo esc_url($secondary_url); ?>" class="inline-flex items-center rounded-full border border-white/60 px-7 py-3.5 font-jakarta text-sm font-semibold text-white motion-safe:transition-colors hover:border-white hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint">
                            <?php echo esc_html($secondary_label); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (count($stats) > 0): ?>
            <ul class="mt-14 grid grid-cols-2 gap-8 border-t border-white/15 pt-10 md:grid-cols-4" role="list">
                <?php foreach ($stats as $stat): ?>
                    <li class="flex flex-col gap-1">
                        <span class="font-display text-4xl md:text-5xl text-gyc-mint"><?php echo esc_html($stat['value']); ?></span>
                        <span class="font-jakarta text-xs font-bold uppercase tracking-widest text-white/75"><?php echo esc_html($stat['label']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</header>
