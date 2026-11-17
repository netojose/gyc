<?php
$post_id = empty($block->context['postId']) ? get_the_ID() : $block->context['postId'];
$image = empty($attributes['image']) ? null : $attributes['image'];
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? get_the_title($post_id) : $attributes['title'];
$title_highlight = empty($attributes['titleHighlight']) ? null : $attributes['titleHighlight'];
$tagline = empty($attributes['tagline']) ? null : $attributes['tagline'];
$place = empty($attributes['place']) ? null : $attributes['place'];
$dates = empty($attributes['dates']) ? null : $attributes['dates'];
// Older heroes keep place and dates in one line; it is only shown when the new fields are empty
$details = ($place || $dates || empty($attributes['details'])) ? null : $attributes['details'];
$primary_label = empty($attributes['primaryLabel']) ? null : $attributes['primaryLabel'];
$primary_url = empty($attributes['primaryUrl']) ? null : GycUI::resolve_url($attributes['primaryUrl'], false);
$secondary_label = empty($attributes['secondaryLabel']) ? null : $attributes['secondaryLabel'];
$secondary_url = empty($attributes['secondaryUrl']) ? null : GycUI::resolve_url($attributes['secondaryUrl'], false);
$stats = empty($attributes['stats']) ? array() : $attributes['stats'];
// The first button stays disabled until this date and time (CET); null when not set or already passed.
// Without its own time it uses the Countdown block's, so the button and the countdown switch together
$primary_opens_value = empty($attributes['primaryOpensAt']) ? '' : $attributes['primaryOpensAt'];
if ($primary_opens_value === '' && $post_id) {
    foreach (parse_blocks((string) get_post_field('post_content', $post_id)) as $sibling) {
        $countdown_on = !isset($sibling['attrs']['active']) || $sibling['attrs']['active'];
        if ($sibling['blockName'] === 'gyc/countdown' && $countdown_on && !empty($sibling['attrs']['opensAt'])) {
            $primary_opens_value = $sibling['attrs']['opensAt'];
            break;
        }
    }
}
$primary_opens_at = $primary_opens_value === '' ? null : GycUI::opens_at($primary_opens_value);

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
        <div class="absolute inset-0 bg-linear-to-r from-[#1e1024]/80 via-[#1e1024]/30 via-40% to-transparent to-60%" aria-hidden="true"></div>
    <?php else: ?>
        <!-- Without an illustration, layered hills keep the hero from looking empty -->
        <svg class="absolute inset-x-0 bottom-0 h-40 w-full md:h-64" viewBox="0 0 1440 260" preserveAspectRatio="none" aria-hidden="true">
            <path class="fill-white/5" d="M0 260V150l220-110 240 130 200-90 230 70 260-130 290 120v120z"/>
            <path class="fill-gyc-plum-light/50" d="M0 260v-50l260-80 300 100 240-70 270 60 370-120v160z"/>
        </svg>
    <?php endif; ?>

    <div class="relative max-w-content mx-auto px-6 md:px-12 py-24 md:py-32 lg:min-h-[40rem] lg:flex lg:flex-col lg:justify-center">
        <div class="max-w-xl">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-sm lg:text-base font-bold tracking-[0.25em] uppercase text-gyc-mint"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($has_title): ?>
                <!-- Both words share one line: the first in mint, the second in ivory -->
                <h1 id="gyc-event-hero-title" class="mt-3 font-display small-caps text-6xl md:text-7xl lg:text-[6.5rem] leading-[0.95] break-words">
                    <?php if ($title): ?>
                        <span class="text-gyc-mint"><?php echo esc_html($title); ?></span>
                    <?php endif; ?>
                    <?php if ($title_highlight): ?>
                        <span class="text-gyc-ivory"><?php echo esc_html($title_highlight); ?></span>
                    <?php endif; ?>
                </h1>
            <?php endif; ?>

            <?php if ($tagline): ?>
                <p class="mt-6 lg:mt-8 inline-block font-jakarta text-lg md:text-xl lg:text-[1.625rem] italic text-gyc-ivory after:mt-1 after:block after:h-1 after:w-12 after:rounded-full after:bg-gyc-mint"><?php echo esc_html($tagline); ?></p>
            <?php endif; ?>

            <?php if ($place || $dates): ?>
                <p class="mt-6 flex flex-col gap-1 font-jakarta text-lg md:text-xl lg:text-[1.625rem] font-semibold leading-tight">
                    <?php if ($place): ?>
                        <span class="text-gyc-ivory"><?php echo esc_html($place); ?></span>
                    <?php endif; ?>
                    <?php if ($dates): ?>
                        <span class="text-gyc-mint"><?php echo esc_html($dates); ?></span>
                    <?php endif; ?>
                </p>
            <?php elseif ($details): ?>
                <p class="mt-6 font-jakarta text-lg md:text-xl lg:text-[1.625rem] text-white/90"><?php echo esc_html($details); ?></p>
            <?php endif; ?>

            <?php if (($primary_label && $primary_url) || ($secondary_label && $secondary_url)): ?>
                <div class="mt-8 flex flex-wrap items-start gap-4">
                    <?php if ($primary_label && $primary_url): ?>
                        <?php ob_start(); ?>
                        <a href="<?php echo esc_url($primary_url); ?>" class="inline-flex items-center rounded-full bg-gyc-mint px-6 py-3 lg:px-7 font-jakarta text-sm lg:text-[0.9375rem] font-medium text-gyc-plum motion-safe:transition-colors hover:bg-gyc-mint-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint">
                            <?php echo esc_html($primary_label); ?>
                        </a>
                        <?php $primary_link = ob_get_clean(); ?>
                        <?php if ($primary_opens_at): ?>
                            <!-- Greyed out until registration opens; the opening time goes under the whole row so it doesn't push the second button away -->
                            <?php echo GycUI::closed_button(
                                $primary_opens_at,
                                $primary_link,
                                $primary_label,
                                'inline-flex cursor-not-allowed items-center rounded-full bg-white/15 px-6 py-3 lg:px-7 font-jakarta text-sm lg:text-[0.9375rem] font-medium text-white/60',
                                null
                            ); ?>
                        <?php else: ?>
                            <?php echo $primary_link; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($secondary_label && $secondary_url): ?>
                        <a href="<?php echo esc_url($secondary_url); ?>" class="inline-flex items-center rounded-full border border-white/60 px-6 py-3 lg:px-7 font-jakarta text-sm lg:text-[0.9375rem] font-medium text-white motion-safe:transition-colors hover:border-white hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint">
                            <?php echo esc_html($secondary_label); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php if ($primary_label && $primary_url && $primary_opens_at): ?>
                    <p data-gyc-closed="<?php echo esc_attr((string) $primary_opens_at); ?>" class="mt-3 pl-1 font-jakarta text-xs lg:text-sm text-gyc-mint"><?php echo esc_html(GycUI::opens_note($primary_opens_at)); ?></p>
                <?php endif; ?>
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
