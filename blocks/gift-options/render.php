<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$items = empty($attributes['items']) ? array() : $attributes['items'];

$icons = array(
    'gift' => '<rect x="3.5" y="8.5" width="17" height="4" rx="1"/><path d="M5 12.5V20h14v-7.5M12 8.5V20M12 8.5c-1.5-3-5-3.5-5-1.2 0 1.2 1.5 1.2 5 1.2zM12 8.5c1.5-3 5-3.5 5-1.2 0 1.2-1.5 1.2-5 1.2z"/>',
    'calendar' => '<rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4M9.5 15l2 2 3.5-3.5"/>',
    'person' => '<circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.9 3.1-7 7-7s7 3.1 7 7"/>',
    'heart' => '<path d="M12 20s-7.5-4.6-7.5-10A4.3 4.3 0 0 1 12 7.2 4.3 4.3 0 0 1 19.5 10c0 5.4-7.5 10-7.5 10z"/>',
);
?>
<section
    id="give"
    class="bg-gyc-plum-mid text-white py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-gift-options-title"<?php endif; ?>>
    <div class="max-w-6xl mx-auto px-6 md:px-12">
        <div class="max-w-xl mx-auto text-center space-y-5">
            <?php if ($title): ?>
                <h2 id="gyc-gift-options-title" class="font-jakarta text-3xl md:text-4xl font-extrabold uppercase leading-tight tracking-tight"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-base leading-loose text-white/85"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if (count($items) > 0): ?>
            <ul class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" role="list">
                <?php foreach (array_values($items) as $index => $item): ?>
                    <?php
                    $item_title_id = 'gyc-gift-options-item-' . $index;
                    $button_url = empty($item['buttonUrl']) ? null : GycUI::resolve_url($item['buttonUrl'], false);
                    ?>
                    <li class="flex flex-col items-center rounded-sm bg-gyc-ivory px-6 py-8 text-center text-gyc-plum">
                        <?php if (!empty($item['icon']) && isset($icons[$item['icon']])): ?>
                            <span class="mb-5 flex h-12 w-12 items-center justify-center rounded-full border-2 border-gyc-plum" aria-hidden="true">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <?php echo $icons[$item['icon']]; ?>
                                </svg>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($item['title'])): ?>
                            <h3 id="<?php echo esc_attr($item_title_id); ?>" class="font-jakarta text-xs font-extrabold uppercase tracking-[0.18em] leading-snug mb-3"><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($item['text'])): ?>
                            <p class="font-jakarta text-sm leading-relaxed text-gyc-plum/80 mb-6"><?php echo esc_html($item['text']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($item['buttonLabel']) && $button_url): ?>
                            <a
                                href="<?php echo esc_url($button_url); ?>"
                                <?php if (!empty($item['title'])): ?>aria-describedby="<?php echo esc_attr($item_title_id); ?>"<?php endif; ?>
                                class="mt-auto inline-block w-full max-w-48 rounded-sm bg-gyc-plum px-6 py-3 font-jakarta text-xs font-bold uppercase tracking-[0.18em] text-gyc-mint hover:bg-gyc-plum-light motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-plum">
                                <?php echo esc_html($item['buttonLabel']); ?>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
