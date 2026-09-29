<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$link_label = empty($attributes['linkLabel']) ? null : $attributes['linkLabel'];
$link_url = empty($attributes['linkUrl']) ? null : GycUI::resolve_url($attributes['linkUrl']);
$items = empty($attributes['items']) ? array() : $attributes['items'];

$icons = array(
    'pray' => '<path d="M12 21V11.5c0-1.2-.6-2.3-1.6-3L8.5 7.2M12 21v-9.5c0-1.2.6-2.3 1.6-3l1.9-1.3M8.5 7.2 6 3.5M15.5 7.2 18 3.5M7 21l-2.2-5.3c-.4-1-.2-2.1.5-2.9L8.5 9.5M17 21l2.2-5.3c.4-1 .2-2.1-.5-2.9L15.5 9.5"/><path d="M12 1.5v1.5M9 2.5l.6 1.2M15 2.5l-.6 1.2"/>',
    'friends' => '<circle cx="12" cy="7" r="3.2"/><circle cx="7.5" cy="12.5" r="3.2"/><circle cx="16.5" cy="12.5" r="3.2"/><path d="M12 15.5V21M9.5 21h5"/>',
    'mission' => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5.5"/><circle cx="12" cy="12" r="2"/>',
    'movement' => '<circle cx="12" cy="12" r="2.2"/><circle cx="12" cy="4" r="2.2"/><circle cx="12" cy="20" r="2.2"/><circle cx="4" cy="12" r="2.2"/><circle cx="20" cy="12" r="2.2"/><path d="M12 6.2v3.6M12 14.2v3.6M6.2 12h3.6M14.2 12h3.6"/>',
);
?>
<section
    id="about-us"
    class="bg-gyc-cream text-gyc-ink py-16 md:py-20 border-t border-gyc-ink/10"
    <?php if ($title): ?>aria-labelledby="gyc-about-us-title"<?php endif; ?>>
    <div class="max-w-6xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-10 items-start">
        <div class="lg:col-span-5 space-y-5">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-about-us-title" class="font-jakarta text-4xl md:text-5xl font-extrabold uppercase leading-none tracking-tight text-gyc-ink">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-base leading-relaxed text-gyc-ink/85 max-w-md"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if ($link_label && $link_url): ?>
                <a
                    href="<?php echo esc_url($link_url); ?>"
                    class="inline-flex items-center gap-3 border-b-2 border-gyc-teal pb-1.5 font-jakarta text-xs font-bold uppercase tracking-[0.2em] text-gyc-teal motion-safe:transition-colors hover:text-gyc-teal-dark hover:border-gyc-teal-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                    <?php echo esc_html($link_label); ?>
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <?php if (count($items) > 0): ?>
            <ul class="lg:col-span-7 grid grid-cols-2 sm:grid-cols-4 gap-y-10 sm:divide-x sm:divide-gyc-ink/15" role="list">
                <?php foreach ($items as $item): ?>
                    <li class="flex flex-col items-center text-center px-4 lg:px-5">
                        <?php if (!empty($item['icon']) && isset($icons[$item['icon']])): ?>
                            <svg class="h-10 w-10 mb-4 text-gyc-teal" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <?php echo $icons[$item['icon']]; ?>
                            </svg>
                        <?php endif; ?>
                        <h3 class="font-jakarta text-xs font-extrabold uppercase tracking-[0.18em] leading-snug text-gyc-ink mb-3">
                            <?php echo esc_html($item['title']); ?>
                        </h3>
                        <p class="font-jakarta text-sm leading-relaxed text-gyc-ink/80">
                            <?php echo esc_html($item['text']); ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
