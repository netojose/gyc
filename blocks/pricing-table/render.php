<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$headline = empty($attributes['headline']) ? null : $attributes['headline'];
$items = empty($attributes['items']) ? array() : $attributes['items'];
$button_label = empty($attributes['buttonLabel']) ? 'Register now' : $attributes['buttonLabel'];
$contact_text = empty($attributes['contactText']) ? null : $attributes['contactText'];
$contact_email = empty($attributes['contactEmail']) ? null : sanitize_email($attributes['contactEmail']);

$items = array_filter($items, function ($item) {
    return !empty($item['title']) || (isset($item['price']) && $item['price'] !== '');
});
?>
<section
    id="register"
    class="scroll-mt-8 bg-gyc-mint text-gyc-plum py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-pricing-table-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 text-center">
        <?php if ($title): ?>
            <h2 id="gyc-pricing-table-title" class="font-display text-5xl md:text-7xl uppercase leading-none"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($headline): ?>
            <p class="mx-auto mt-6 max-w-2xl font-jakarta text-base md:text-lg leading-relaxed text-gyc-plum/90"><?php echo esc_html($headline); ?></p>
        <?php endif; ?>

        <?php if (count($items) > 0): ?>
            <ul class="mx-auto mt-12 grid max-w-4xl grid-cols-1 md:grid-cols-3 gap-6 md:gap-4 items-center" role="list">
                <?php foreach ($items as $item): ?>
                    <?php
                    $has_badge = !empty($item['badge']);
                    $link = empty($item['link']) ? null : GycUI::resolve_url($item['link'], false);
                    $price = isset($item['price']) ? trim((string) $item['price']) : '';
                    ?>
                    <li class="relative flex flex-col items-center bg-gyc-plum-mid px-6 text-white <?php echo $has_badge ? 'border-4 border-gyc-ivory py-10 md:py-12' : 'py-8 md:py-10'; ?>">
                        <?php if ($has_badge): ?>
                            <span class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gyc-ivory px-4 py-1 font-jakarta text-xs font-semibold uppercase tracking-wider text-gyc-plum"><?php echo esc_html($item['badge']); ?></span>
                        <?php endif; ?>

                        <?php if (!empty($item['title'])): ?>
                            <h3 class="font-display text-3xl md:text-4xl uppercase leading-none text-gyc-ivory"><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>

                        <?php if ($price !== ''): ?>
                            <p class="mt-3 font-jakarta text-4xl md:text-5xl font-light leading-none text-gyc-ivory">€<?php echo esc_html($price); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($item['date'])): ?>
                            <p class="mt-3 font-jakarta text-sm text-white/85"><?php echo esc_html($item['date']); ?></p>
                        <?php endif; ?>

                        <?php if ($link): ?>
                            <a href="<?php echo esc_url($link); ?>" class="mt-6 inline-block w-full max-w-52 bg-gyc-mint px-6 py-3 font-jakarta text-sm text-gyc-plum motion-safe:transition-colors hover:bg-gyc-mint-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint"<?php if (!empty($item['title'])): ?> aria-label="<?php echo esc_attr($button_label . ': ' . $item['title']); ?>"<?php endif; ?>><?php echo esc_html($button_label); ?></a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($contact_text || $contact_email): ?>
            <p class="mt-12 font-jakarta text-sm md:text-base text-gyc-plum/90">
                <?php if ($contact_text): ?><?php echo esc_html($contact_text); ?><?php endif; ?>
                <?php if ($contact_email): ?>
                    <a href="<?php echo esc_url('mailto:' . $contact_email); ?>" class="font-medium underline underline-offset-4 decoration-current hover:decoration-transparent motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-plum"><?php echo esc_html($contact_email); ?></a>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>
</section>
