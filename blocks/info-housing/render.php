<?php
// Turned off in the block settings: nothing is shown, but the content is kept
if (!GycInfo::is_active($attributes)) {
    return;
}

$hotels = empty($attributes['hotels']) ? array() : $attributes['hotels'];
$tips = empty($attributes['tips']) ? array() : $attributes['tips'];

$hotels = array_filter($hotels, function ($hotel) {
    return !empty($hotel['name']) || !empty($hotel['price']);
});
$tips = array_filter($tips, function ($tip) {
    return !empty($tip['title']) || !empty($tip['text']);
});

echo GycInfo::open($attributes, 'housing', 'white');
?>
<?php if (count($hotels) > 0): ?>
    <ul class="mt-10 md:mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" role="list">
        <?php foreach ($hotels as $hotel): ?>
            <?php
            $url = empty($hotel['url']) ? null : GycUI::resolve_url($hotel['url'], false);
            $is_external = $url && strpos($url, home_url()) !== 0 && preg_match('#^https?://#', $url);
            ?>
            <li class="flex flex-col overflow-hidden rounded-3xl bg-gyc-cream">
                <?php if (!empty($hotel['image'])): ?>
                    <img src="<?php echo esc_url($hotel['image']); ?>" alt="<?php echo esc_attr(empty($hotel['imageAlt']) ? '' : $hotel['imageAlt']); ?>" loading="lazy" class="aspect-[16/7] w-full object-cover" />
                <?php else: ?>
                    <div class="flex aspect-[16/7] w-full items-center justify-center bg-gyc-sand text-gyc-plum/25" aria-hidden="true">
                        <?php echo GycInfo::svg('bed', 'h-10 w-10'); ?>
                    </div>
                <?php endif; ?>

                <div class="flex flex-1 flex-col p-6 md:p-7">
                    <?php if (!empty($hotel['name'])): ?>
                        <h3 class="font-display small-caps text-2xl leading-tight">
                            <?php if ($url): ?>
                                <a
                                    href="<?php echo esc_url($url); ?>"
                                    <?php if ($is_external): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
                                    class="underline decoration-transparent underline-offset-4 hover:decoration-current motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-plum">
                                    <?php echo esc_html($hotel['name']); ?>
                                    <?php if ($is_external): ?><span class="sr-only"><?php esc_html_e('(opens in a new tab)', 'gyc'); ?></span><?php endif; ?>
                                </a>
                            <?php else: ?>
                                <?php echo esc_html($hotel['name']); ?>
                            <?php endif; ?>
                        </h3>
                    <?php endif; ?>
                    <?php if (!empty($hotel['subtitle'])): ?>
                        <p class="mt-2 font-jakarta text-sm text-gyc-teal"><?php echo esc_html($hotel['subtitle']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($hotel['price']) || !empty($hotel['unit'])): ?>
                        <p class="mt-4 font-jakarta text-xs text-gyc-plum/70">
                            <?php if (!empty($hotel['price'])): ?>
                                <span class="font-display text-3xl leading-none text-gyc-plum"><?php echo esc_html($hotel['price']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($hotel['unit'])): ?><?php echo esc_html($hotel['unit']); ?><?php endif; ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($hotel['note'])): ?>
                        <p class="mt-2 font-jakarta text-xs text-gyc-plum/70"><?php echo esc_html($hotel['note']); ?></p>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (count($tips) > 0): ?>
    <ul class="mt-4 md:mt-5 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" role="list">
        <?php foreach ($tips as $tip): ?>
            <li class="rounded-2xl bg-gyc-lilac p-5 md:p-6">
                <?php if (!empty($tip['title'])): ?>
                    <h3 class="font-jakarta text-sm font-semibold"><?php echo esc_html($tip['title']); ?></h3>
                <?php endif; ?>
                <?php if (!empty($tip['text'])): ?>
                    <p class="mt-2 font-jakarta text-sm leading-relaxed text-gyc-plum/80"><?php echo esc_html($tip['text']); ?></p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php
echo GycInfo::close();
