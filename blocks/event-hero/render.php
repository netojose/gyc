<?php
$post_id = empty($block->context['postId']) ? get_the_ID() : $block->context['postId'];
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? get_the_title($post_id) : $attributes['title'];
$primary_label = empty($attributes['primaryLabel']) ? null : $attributes['primaryLabel'];
$primary_url = empty($attributes['primaryUrl']) ? null : GycUI::resolve_url($attributes['primaryUrl'], false);
$secondary_label = empty($attributes['secondaryLabel']) ? null : $attributes['secondaryLabel'];
$secondary_url = empty($attributes['secondaryUrl']) ? null : GycUI::resolve_url($attributes['secondaryUrl'], false);
$stats = empty($attributes['stats']) ? array() : $attributes['stats'];

$links = array();
if ($primary_label && $primary_url) {
    $links[] = array('label' => $primary_label, 'url' => $primary_url);
}
if ($secondary_label && $secondary_url) {
    $links[] = array('label' => $secondary_label, 'url' => $secondary_url);
}

$stats = array_filter($stats, function ($stat) {
    return !empty($stat['value']) && !empty($stat['label']);
});
?>
<header
    class="relative min-h-screen flex flex-col justify-between px-6 py-8 md:px-16 lg:px-24 bg-linear-to-b from-[#25152b] to-gyc-plum"
    <?php if ($title): ?>aria-labelledby="gyc-event-hero-title"<?php endif; ?>>
    <div class="flex-1 flex flex-col justify-center items-start text-left max-w-6xl w-full mx-auto my-12 gap-y-6">
        <?php if ($eyebrow): ?>
            <p class="flex items-center gap-3">
                <span class="w-10 h-px bg-gyc-mint" aria-hidden="true"></span>
                <span class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-mint"><?php echo esc_html($eyebrow); ?></span>
            </p>
        <?php endif; ?>

        <?php if ($title): ?>
            <h1 id="gyc-event-hero-title" class="font-jakarta font-extrabold text-gyc-ivory text-5xl md:text-7xl tracking-tight mb-6 uppercase break-words max-w-full"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>

        <?php if (count($links) > 0): ?>
            <div class="flex flex-wrap gap-x-12 gap-y-4 mb-12">
                <?php foreach ($links as $link): ?>
                    <a href="<?php echo esc_url($link['url']); ?>" class="rounded text-sm text-white font-bold tracking-widest uppercase hover:opacity-80 motion-safe:transition-opacity focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint">
                        <?php echo esc_html($link['label']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (count($stats) > 0): ?>
            <hr class="border-t border-white/20 mb-12 w-full" />

            <ul class="grid grid-cols-2 gap-8 md:flex md:justify-between md:gap-6 w-full" role="list">
                <?php foreach ($stats as $stat): ?>
                    <li class="flex flex-col gap-1">
                        <span class="text-4xl md:text-5xl lg:text-6xl font-serif text-[#A7F3D0]"><?php echo esc_html($stat['value']); ?></span>
                        <span class="text-xs md:text-sm font-bold tracking-widest font-jakarta uppercase text-white/70"><?php echo esc_html($stat['label']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</header>
