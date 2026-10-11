<?php
$layout = in_array($attributes['layout'] ?? '', ['split', 'text', 'image'], true) ? $attributes['layout'] : 'split';
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl']);
$image = empty($attributes['image']) ? null : $attributes['image'];
$image_alt = empty($attributes['imageAlt']) ? '' : $attributes['imageAlt'];
?>
<section
    class="relative overflow-hidden bg-gyc-cream text-gyc-ink"
    <?php if ($title): ?>aria-labelledby="gyc-hero-title"<?php endif; ?>>

    <?php if ($layout === 'image'): ?>
        <!-- Photo only: the title stays as a hidden heading so the page still has an h1 -->
        <?php if ($title): ?>
            <h1 id="gyc-hero-title" class="sr-only"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>

        <div class="relative aspect-[4/3] sm:aspect-[16/9] lg:aspect-[21/9] w-full">
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
        </div>
    <?php else: ?>
        <?php if ($layout === 'split'): ?>
            <div class="relative h-72 sm:h-96 lg:absolute lg:inset-y-0 lg:right-0 lg:h-auto lg:w-[68%]">
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
            </div>
        <?php endif; ?>

        <div class="relative max-w-content mx-auto px-6 md:px-12 <?php echo $layout === 'split' ? 'pb-16 lg:py-32' : 'py-20 md:py-28'; ?>">
            <div class="<?php echo $layout === 'split' ? 'max-w-md lg:max-w-lg' : ''; ?> space-y-6">
                <?php if ($eyebrow): ?>
                    <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/80"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h1 id="gyc-hero-title" class="font-display text-6xl sm:text-7xl lg:text-[5.5rem] uppercase leading-[0.95] text-gyc-ink break-words">
                        <?php echo esc_html($title); ?>
                    </h1>
                <?php endif; ?>

                <?php if ($text): ?>
                    <p class="font-jakarta text-base md:text-lg leading-relaxed text-gyc-ink/85 <?php echo $layout === 'text' ? 'max-w-3xl' : ''; ?>"><?php echo esc_html($text); ?></p>
                <?php endif; ?>

                <?php if ($button_label && $button_url): ?>
                    <a
                        href="<?php echo esc_url($button_url); ?>"
                        class="inline-flex items-center gap-4 rounded-full bg-linear-to-r from-gyc-teal-dark to-gyc-teal px-8 py-4 font-jakarta text-xs font-bold uppercase tracking-[0.2em] text-white shadow-md motion-safe:transition-colors hover:from-gyc-teal-dark hover:to-gyc-teal-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                        <?php echo esc_html($button_label); ?>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
