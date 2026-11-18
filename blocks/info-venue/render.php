<?php
// Turned off in the block settings: nothing is shown, but the content is kept
if (!GycInfo::is_active($attributes)) {
    return;
}

$venue_label = empty($attributes['venueLabel']) ? null : $attributes['venueLabel'];
$venue_name = empty($attributes['venueName']) ? null : $attributes['venueName'];
$address = empty($attributes['address']) ? null : $attributes['address'];
$map_url = GycInfo::map_embed_url(empty($attributes['mapEmbed']) ? '' : $attributes['mapEmbed']);
$map_note = empty($attributes['mapNote']) ? null : $attributes['mapNote'];
$cards = empty($attributes['cards']) ? array() : $attributes['cards'];

// Without their own links, the buttons search for the venue in Google Maps or route to it
$place = trim(implode(', ', array_filter(array($venue_name, $address))));
$maps_label = empty($attributes['mapsLabel']) ? null : $attributes['mapsLabel'];
$maps_url = !empty($attributes['mapsUrl'])
    ? GycUI::resolve_url($attributes['mapsUrl'], false)
    : ($place === '' ? null : 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($place));
$directions_label = empty($attributes['directionsLabel']) ? null : $attributes['directionsLabel'];
$directions_url = !empty($attributes['directionsUrl'])
    ? GycUI::resolve_url($attributes['directionsUrl'], false)
    : ($place === '' ? null : 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($place));

$cards = array_filter($cards, function ($card) {
    return !empty($card['title']) || !empty($card['text']);
});

$has_venue = $venue_name || $address || $map_url;
$new_tab = '<span class="sr-only">' . esc_html__('(opens in a new tab)', 'gyc') . '</span>';

echo GycInfo::open($attributes, 'venue', 'plum');
?>
<div class="mt-10 md:mt-12 grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-5 items-start">
    <?php if ($has_venue): ?>
        <div class="rounded-3xl border border-white/15 bg-white/5 p-6 md:p-7">
            <?php echo GycInfo::icon_badge('pin', 'mint', 'lg'); ?>
            <?php if ($venue_label): ?>
                <p class="mt-5 font-jakarta text-xs font-bold tracking-[0.2em] uppercase text-gyc-mint"><?php echo esc_html($venue_label); ?></p>
            <?php endif; ?>
            <?php if ($venue_name): ?>
                <h3 class="mt-3 font-display small-caps text-3xl md:text-4xl leading-none text-gyc-ivory"><?php echo esc_html($venue_name); ?></h3>
            <?php endif; ?>
            <?php if ($address): ?>
                <p class="mt-4 font-jakarta text-sm text-white/85"><?php echo esc_html($address); ?></p>
            <?php endif; ?>

            <?php if ($map_url): ?>
                <div class="mt-6 overflow-hidden rounded-2xl bg-gyc-mist">
                    <iframe
                        src="<?php echo esc_url($map_url); ?>"
                        title="<?php echo esc_attr(sprintf(/* translators: %s: venue name */ __('Map: %s', 'gyc'), $venue_name ? $venue_name : __('Venue', 'gyc'))); ?>"
                        class="block aspect-[4/3] sm:aspect-[16/9] w-full border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen></iframe>
                </div>
            <?php endif; ?>

            <?php if (($maps_label && $maps_url) || ($directions_label && $directions_url)): ?>
                <div class="mt-5 flex flex-wrap gap-3">
                    <?php if ($maps_label && $maps_url): ?>
                        <a
                            href="<?php echo esc_url($maps_url); ?>"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 rounded-full bg-gyc-mint px-5 py-2.5 font-jakarta text-sm font-semibold text-gyc-plum hover:bg-gyc-mint-dark motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-mint">
                            <?php echo GycInfo::svg('pin', 'h-4 w-4'); ?>
                            <?php echo esc_html($maps_label); ?><?php echo $new_tab; ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($directions_label && $directions_url): ?>
                        <a
                            href="<?php echo esc_url($directions_url); ?>"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 rounded-full border border-gyc-mint px-5 py-2.5 font-jakarta text-sm font-semibold text-gyc-mint hover:bg-gyc-mint hover:text-gyc-plum motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-mint">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5l-17 7 7 2.5 2.5 7z"/></svg>
                            <?php echo esc_html($directions_label); ?><?php echo $new_tab; ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($map_note): ?>
                <p class="mt-4 font-jakarta text-xs leading-relaxed text-white/70"><?php echo esc_html($map_note); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (count($cards) > 0): ?>
        <ul class="grid grid-cols-1 gap-4 md:gap-5" role="list">
            <?php foreach ($cards as $card): ?>
                <?php
                $link_url = empty($card['linkUrl']) ? null : GycUI::resolve_url($card['linkUrl'], false);
                $is_external = $link_url && strpos($link_url, home_url()) !== 0 && preg_match('#^https?://#', $link_url);
                ?>
                <li class="rounded-3xl border border-white/15 bg-white/5 p-6 md:p-7">
                    <div class="flex items-center gap-4">
                        <?php echo GycInfo::icon_badge(empty($card['icon']) ? '' : $card['icon'], 'mint'); ?>
                        <?php if (!empty($card['title'])): ?>
                            <h3 class="font-display small-caps text-3xl leading-none text-gyc-ivory"><?php echo esc_html($card['title']); ?></h3>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($card['text'])): ?>
                        <p class="mt-4 max-w-md font-jakarta text-sm leading-relaxed text-white/85"><?php echo esc_html($card['text']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($card['linkLabel']) && $link_url): ?>
                        <a
                            href="<?php echo esc_url($link_url); ?>"
                            <?php if ($is_external): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
                            class="mt-5 inline-flex items-center gap-2 rounded-full border border-gyc-mint px-5 py-2.5 font-jakarta text-sm font-semibold text-gyc-mint hover:bg-gyc-mint hover:text-gyc-plum motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-mint">
                            <?php echo esc_html($card['linkLabel']); ?>
                            <?php if ($is_external): ?>
                                <?php echo $new_tab; ?>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17L17 7M9 7h8v8"/></svg>
                            <?php else: ?>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<?php
echo GycInfo::close();
