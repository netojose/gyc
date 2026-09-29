<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl']);
$map = empty($attributes['map']) ? null : $attributes['map'];
$map_alt = empty($attributes['mapAlt']) ? '' : $attributes['mapAlt'];
$note = empty($attributes['note']) ? null : $attributes['note'];
$photos = empty($attributes['photos']) ? array() : array_filter($attributes['photos'], function ($photo) {
    return !empty($photo['url']);
});

// Alternating tilt for the collage, kept as literal classes so Tailwind picks them up.
$tilts = array('-rotate-3', 'rotate-2', '-rotate-1', 'rotate-3', '-rotate-2', 'rotate-1');
?>
<section
    id="community"
    class="bg-gyc-sand text-gyc-ink py-16 md:py-20 overflow-hidden"
    <?php if ($title): ?>aria-labelledby="gyc-community-title"<?php endif; ?>>
    <div class="max-w-6xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
        <div class="lg:col-span-4 space-y-5">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-community-title" class="font-jakarta text-4xl md:text-5xl font-extrabold uppercase leading-none tracking-tight text-gyc-ink whitespace-pre-line"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-base leading-relaxed text-gyc-ink/85 max-w-sm"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if ($button_label && $button_url): ?>
                <a
                    href="<?php echo esc_url($button_url); ?>"
                    class="inline-flex items-center gap-3 rounded-sm border-2 border-gyc-teal px-6 py-3 font-jakarta text-xs font-bold uppercase tracking-[0.2em] text-gyc-teal motion-safe:transition-colors hover:bg-gyc-teal hover:text-white focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                    <?php echo esc_html($button_label); ?>
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <?php if ($map): ?>
            <div class="lg:col-span-4">
                <img
                    class="mx-auto w-full max-w-md h-auto"
                    src="<?php echo esc_url($map); ?>"
                    alt="<?php echo esc_attr($map_alt); ?>"
                    loading="lazy"
                    decoding="async"
                    draggable="false" />
            </div>
        <?php endif; ?>

        <?php if (count($photos) > 0 || $note): ?>
            <div class="relative <?php echo $map ? 'lg:col-span-4' : 'lg:col-span-8'; ?>">
                <?php if (count($photos) > 0): ?>
                    <ul class="grid grid-cols-2 sm:grid-cols-3 gap-3" role="list">
                        <?php foreach (array_values($photos) as $index => $photo): ?>
                            <li class="bg-white p-1.5 shadow-md <?php echo $tilts[$index % count($tilts)]; ?> motion-safe:transition-transform motion-safe:hover:rotate-0 motion-safe:hover:scale-105">
                                <img
                                    class="aspect-4/3 w-full object-cover"
                                    src="<?php echo esc_url($photo['url']); ?>"
                                    alt="<?php echo esc_attr(empty($photo['alt']) ? '' : $photo['alt']); ?>"
                                    loading="lazy"
                                    decoding="async"
                                    draggable="false" />
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ($note): ?>
                    <p class="relative mt-6 ml-auto w-fit max-w-[16rem] rotate-2 bg-gyc-note px-5 py-4 font-script text-xl md:text-2xl leading-tight text-gyc-ink shadow-lg whitespace-pre-line <?php echo count($photos) > 0 ? 'lg:absolute lg:-bottom-6 lg:right-0 lg:mt-0' : ''; ?>"><span class="absolute -top-2.5 left-1/2 h-5 w-16 -translate-x-1/2 -rotate-3 bg-gyc-mint/70" aria-hidden="true"></span><?php echo esc_html($note); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
