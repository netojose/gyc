<?php
$logo = empty($attributes['logo']) ? null : $attributes['logo'];
$logo_alt = empty($attributes['logoAlt']) ? '' : $attributes['logoAlt'];
$logo_url = empty($attributes['logoUrl']) ? home_url('/') : GycUI::resolve_url($attributes['logoUrl']);
$description = empty($attributes['description']) ? null : $attributes['description'];
$newsletter_title = empty($attributes['newsletterTitle']) ? null : $attributes['newsletterTitle'];
$newsletter_text = empty($attributes['newsletterText']) ? null : $attributes['newsletterText'];
$newsletter_action = empty($attributes['newsletterAction']) ? null : $attributes['newsletterAction'];
$newsletter_field_name = empty($attributes['newsletterFieldName']) ? 'email' : $attributes['newsletterFieldName'];
$newsletter_placeholder = empty($attributes['newsletterPlaceholder']) ? '' : $attributes['newsletterPlaceholder'];
$newsletter_button = empty($attributes['newsletterButton']) ? 'Subscribe' : $attributes['newsletterButton'];
$columns = empty($attributes['columns']) ? array() : $attributes['columns'];
$copyright = empty($attributes['copyright']) ? null : str_replace('{year}', wp_date('Y'), $attributes['copyright']);
$tagline = empty($attributes['tagline']) ? null : $attributes['tagline'];

$has_newsletter = $newsletter_title || $newsletter_text || $newsletter_action;
// Light by default; dark when the page turns on "Dark header and footer" (see GycUI::is_dark_chrome)
$c = GycUI::is_dark_chrome()
    ? array(
        'footer' => 'bg-gyc-plum text-white',
        'logo' => 'brightness-0 invert',
        'muted' => 'text-white/75',
        'heading' => 'text-gyc-mint',
        'link' => 'hover:decoration-gyc-mint hover:text-gyc-mint focus-visible:outline-gyc-mint',
        'focus' => 'focus-visible:outline-gyc-mint',
        'divider' => 'border-white/10',
        'title' => 'text-white',
        'bottom' => 'border-t border-white/10 pt-6',
        'button' => 'bg-gyc-mint hover:bg-gyc-mint-dark',
    )
    : array(
        'footer' => 'bg-gyc-cream text-gyc-ink',
        'logo' => 'brightness-0',
        'muted' => 'text-gyc-ink/80',
        'heading' => 'text-gyc-teal',
        'link' => 'hover:decoration-gyc-teal hover:text-gyc-teal focus-visible:outline-gyc-teal',
        'focus' => 'focus-visible:outline-gyc-teal',
        'divider' => 'border-gyc-ink/10',
        'title' => 'text-gyc-ink',
        'bottom' => '',
        'button' => 'bg-gyc-aqua hover:bg-gyc-aqua-dark',
    );
$link_class = 'underline decoration-transparent underline-offset-4 motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 ' . $c['link'];
?>
<footer id="contact" class="<?php echo esc_attr($c['footer']); ?> pt-16 pb-10">
    <div class="max-w-content mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-x-8 gap-y-12">
            <div class="xl:col-span-5 space-y-5">
                <a href="<?php echo esc_url($logo_url); ?>" class="inline-block rounded font-jakarta text-lg font-extrabold focus-visible:outline-2 focus-visible:outline-offset-4 <?php echo esc_attr($c['focus']); ?>">
                    <?php if ($logo): ?>
                        <img loading="lazy" decoding="async" src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($logo_alt); ?>" class="w-16 h-auto <?php echo esc_attr($c['logo']); ?>" draggable="false" />
                    <?php else: ?>
                        <?php echo esc_html(get_bloginfo('name')); ?>
                    <?php endif; ?>
                </a>
                <?php if ($description): ?>
                    <p class="font-jakarta text-sm leading-relaxed max-w-sm <?php echo esc_attr($c['muted']); ?>"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>

            <?php if (count($columns) > 0): ?>
                <div class="xl:col-span-7 grid grid-cols-2 sm:grid-cols-[repeat(4,auto)] sm:justify-between gap-x-8 gap-y-10">
                    <?php foreach (array_values($columns) as $index => $column): ?>
                        <?php
                        $links = empty($column['links']) ? array() : array_filter($column['links'], function ($link) {
                            return !empty($link['label']) && !empty($link['url']);
                        });
                        $heading_id = 'gyc-footer-column-' . $index;
                        ?>
                        <nav <?php if (!empty($column['title'])): ?>aria-labelledby="<?php echo esc_attr($heading_id); ?>"<?php endif; ?>>
                            <?php if (!empty($column['title'])): ?>
                                <h2 id="<?php echo esc_attr($heading_id); ?>" class="font-jakarta text-sm font-bold tracking-wide mb-4 <?php echo esc_attr($c['heading']); ?>"><?php echo esc_html($column['title']); ?></h2>
                            <?php endif; ?>
                            <?php if (count($links) > 0): ?>
                                <ul class="space-y-3 font-jakarta text-base break-words" role="list">
                                    <?php foreach ($links as $link): ?>
                                        <li><a href="<?php echo esc_url(GycUI::resolve_url($link['url'])); ?>" class="<?php echo esc_attr($link_class); ?>"><?php echo esc_html($link['label']); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </nav>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($has_newsletter): ?>
                <div class="xl:col-span-12 space-y-3 border-t pt-10 <?php echo esc_attr($c['divider']); ?>">
                    <?php if ($newsletter_title): ?>
                        <h2 class="font-jakarta text-2xl md:text-3xl font-extrabold tracking-tight <?php echo esc_attr($c['title']); ?>"><?php echo esc_html($newsletter_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($newsletter_text): ?>
                        <p id="gyc-newsletter-hint" class="font-jakarta text-sm <?php echo esc_attr($c['muted']); ?>"><?php echo esc_html($newsletter_text); ?></p>
                    <?php endif; ?>
                    <?php if ($newsletter_action): ?>
                        <form class="flex flex-col sm:flex-row gap-2 pt-2" action="<?php echo esc_url($newsletter_action); ?>" method="post">
                            <label for="gyc-newsletter-email" class="sr-only">Email address</label>
                            <input
                                id="gyc-newsletter-email"
                                name="<?php echo esc_attr($newsletter_field_name); ?>"
                                type="email"
                                required
                                autocomplete="email"
                                placeholder="<?php echo esc_attr($newsletter_placeholder); ?>"
                                <?php if ($newsletter_text): ?>aria-describedby="gyc-newsletter-hint"<?php endif; ?>
                                class="min-w-0 flex-1 rounded-full border border-gyc-ink/20 bg-white px-5 py-3 font-jakarta text-sm text-gyc-ink placeholder:text-gyc-ink/50 focus:border-gyc-teal focus:outline-2 focus:outline-offset-0 focus:outline-gyc-teal" />
                            <button
                                type="submit"
                                class="<?php echo $c['button']; ?> rounded-full px-7 py-3 font-jakarta text-sm font-semibold text-gyc-ink motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal">
                                <?php echo esc_html($newsletter_button); ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($copyright || $tagline): ?>
            <div class="mt-16 flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-between font-jakarta text-xs <?php echo esc_attr($c['bottom'] . ' ' . $c['muted']); ?>">
                <?php if ($copyright): ?>
                    <p><?php echo esc_html($copyright); ?></p>
                <?php endif; ?>
                <?php if ($tagline): ?>
                    <p><?php echo esc_html($tagline); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</footer>
