<?php
// Turned off in the block settings: nothing is shown, but the content is kept
if (!GycInfo::is_active($attributes)) {
    return;
}

$icon_color = (isset($attributes['iconColor']) && $attributes['iconColor'] === 'plum') ? 'plum' : 'mint';
$has_content = function ($card) {
    return !empty($card['title']) || !empty($card['items']) || !empty($card['text']);
};
$cards = array_filter(empty($attributes['cards']) ? array() : $attributes['cards'], $has_content);
$wide_cards = array_filter(empty($attributes['wideCards']) ? array() : $attributes['wideCards'], $has_content);

$render_card = function ($card) use ($icon_color) {
    $style = isset($card['style']) && in_array($card['style'], array('plum', 'mint'), true) ? $card['style'] : 'white';
    $is_dark = $style === 'plum';
    $badge = $style === 'plum' ? 'mint' : ($style === 'mint' ? 'plum' : $icon_color);
    $link_url = empty($card['linkUrl']) ? null : GycUI::resolve_url($card['linkUrl'], false);
    $is_external = $link_url && strpos($link_url, home_url()) !== 0 && preg_match('#^https?://#', $link_url);
    $classes = array(
        'white' => 'border border-gyc-plum/10 bg-white text-gyc-plum',
        'plum' => 'bg-gyc-plum-mid text-white',
        'mint' => 'bg-gyc-mint/25 text-gyc-plum',
    );
    ?>
    <li class="flex flex-col rounded-3xl p-6 md:p-7 <?php echo esc_attr($classes[$style]); ?>">
        <?php $icon = GycInfo::icon_badge(empty($card['icon']) ? '' : $card['icon'], $badge); ?>
        <?php if ($icon): ?>
            <div class="mb-5"><?php echo $icon; ?></div>
        <?php endif; ?>

        <?php if (!empty($card['title'])): ?>
            <h3 class="font-display small-caps text-2xl leading-tight <?php echo $is_dark ? 'text-gyc-ivory' : ''; ?>"><?php echo esc_html($card['title']); ?></h3>
        <?php endif; ?>

        <?php echo GycInfo::bullets(empty($card['items']) ? '' : $card['items'], $is_dark); ?>

        <?php if (!empty($card['text'])): ?>
            <p class="mt-4 max-w-md font-jakarta text-sm leading-relaxed whitespace-pre-line <?php echo $is_dark ? 'text-white/85' : 'text-gyc-plum/80'; ?>"><?php echo esc_html($card['text']); ?></p>
        <?php endif; ?>

        <?php if (!empty($card['linkLabel']) && $link_url): ?>
            <a
                href="<?php echo esc_url($link_url); ?>"
                <?php if ($is_external): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
                class="mt-5 inline-flex items-center gap-2 self-start font-jakarta text-sm font-semibold underline decoration-transparent underline-offset-4 hover:decoration-current motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 <?php echo $is_dark ? 'text-gyc-mint focus-visible:outline-gyc-mint' : 'text-gyc-teal focus-visible:outline-gyc-teal'; ?>">
                <?php echo esc_html($card['linkLabel']); ?>
                <?php if ($is_external): ?>
                    <span class="sr-only"><?php esc_html_e('(opens in a new tab)', 'gyc'); ?></span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17L17 7M9 7h8v8"/></svg>
                <?php else: ?>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                <?php endif; ?>
            </a>
        <?php endif; ?>
    </li>
    <?php
};

echo GycInfo::open($attributes, 'meals', 'lilac');
?>
<?php if (count($cards) > 0): ?>
    <ul class="mt-10 md:mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" role="list">
        <?php foreach ($cards as $card) { $render_card($card); } ?>
    </ul>
<?php endif; ?>

<?php if (count($wide_cards) > 0): ?>
    <ul class="mt-4 md:mt-5 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" role="list">
        <?php foreach ($wide_cards as $card) { $render_card($card); } ?>
    </ul>
<?php endif; ?>
<?php
echo GycInfo::close();
