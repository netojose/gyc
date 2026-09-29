<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl']);
$image = empty($attributes['image']) ? null : $attributes['image'];
$image_alt = empty($attributes['imageAlt']) ? '' : $attributes['imageAlt'];
$tagline = empty($attributes['tagline']) ? null : $attributes['tagline'];
?>
<section
    class="relative overflow-hidden bg-gyc-cream text-gyc-ink"
    <?php if ($title): ?>aria-labelledby="gyc-hero-title"<?php endif; ?>>

    <div class="relative h-72 sm:h-96 lg:absolute lg:inset-y-0 lg:right-0 lg:h-auto lg:w-[62%]">
        <?php if ($image): ?>
            <img
                class="absolute inset-0 h-full w-full object-cover"
                src="<?php echo esc_url($image); ?>"
                alt="<?php echo esc_attr($image_alt); ?>"
                fetchpriority="high"
                decoding="async"
                draggable="false" />
        <?php else: ?>
            <div class="absolute inset-0 bg-linear-to-br from-[#f6b26b] via-[#7a4b6e] to-[#1e2f4a]" aria-hidden="true"></div>
        <?php endif; ?>

        <div class="absolute inset-0 bg-linear-to-t from-gyc-cream via-transparent to-transparent lg:bg-linear-to-r lg:from-gyc-cream lg:via-gyc-cream/30 lg:via-25% lg:to-transparent lg:to-50%" aria-hidden="true"></div>

        <?php if ($tagline): ?>
            <p class="absolute right-6 top-8 sm:right-10 lg:right-12 lg:top-1/4 -rotate-6 font-script text-2xl sm:text-3xl lg:text-4xl leading-tight text-white text-right whitespace-pre-line drop-shadow-[0_2px_6px_rgba(0,0,0,0.55)]"><?php echo esc_html($tagline); ?><span class="block h-1 w-2/3 ml-auto mt-2 rounded-full bg-gyc-mint" aria-hidden="true"></span></p>
        <?php endif; ?>
    </div>

    <div class="relative max-w-6xl mx-auto px-6 md:px-12 pb-16 lg:py-32">
        <div class="max-w-md lg:max-w-lg space-y-6">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h1 id="gyc-hero-title" class="font-jakarta text-5xl sm:text-6xl lg:text-7xl font-extrabold uppercase leading-[0.95] tracking-tight text-gyc-ink">
                    <?php echo esc_html($title); ?>
                </h1>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-base md:text-lg leading-relaxed text-gyc-ink/85"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if ($button_label && $button_url): ?>
                <a
                    href="<?php echo esc_url($button_url); ?>"
                    class="inline-flex items-center gap-4 rounded-sm bg-gyc-teal px-7 py-4 font-jakarta text-xs font-bold uppercase tracking-[0.2em] text-white shadow-md motion-safe:transition-colors hover:bg-gyc-teal-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                    <?php echo esc_html($button_label); ?>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
