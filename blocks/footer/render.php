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
$link_class = 'underline underline-offset-4 decoration-gyc-ink/30 hover:text-gyc-teal hover:decoration-gyc-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal';
?>
<footer id="contact" class="bg-white text-gyc-ink border-t border-gyc-ink/10 pt-14 pb-8">
    <div class="max-w-6xl mx-auto px-6 md:px-12">
        <div class="grid grid-cols-2 md:grid-cols-6 lg:grid-cols-12 gap-x-8 gap-y-12">
            <div class="col-span-2 space-y-5">
                <a href="<?php echo esc_url($logo_url); ?>" class="inline-block rounded font-jakarta text-lg font-extrabold focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                    <?php if ($logo): ?>
                        <img loading="lazy" decoding="async" src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($logo_alt); ?>" class="w-12 h-auto brightness-0" draggable="false" />
                    <?php else: ?>
                        <?php echo esc_html(get_bloginfo('name')); ?>
                    <?php endif; ?>
                </a>
                <?php if ($description): ?>
                    <p class="font-jakarta text-sm leading-relaxed text-gyc-ink/70 max-w-xs"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>

            <?php if ($has_newsletter): ?>
                <div class="col-span-2 md:col-span-4 space-y-3">
                    <?php if ($newsletter_title): ?>
                        <h2 class="font-jakarta text-2xl md:text-3xl font-extrabold tracking-tight text-gyc-ink"><?php echo esc_html($newsletter_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($newsletter_text): ?>
                        <p id="gyc-newsletter-hint" class="font-jakarta text-sm text-gyc-ink/70"><?php echo esc_html($newsletter_text); ?></p>
                    <?php endif; ?>
                    <?php if ($newsletter_action): ?>
                        <form class="flex flex-col sm:flex-row pt-2" action="<?php echo esc_url($newsletter_action); ?>" method="post">
                            <label for="gyc-newsletter-email" class="sr-only">Email address</label>
                            <input
                                id="gyc-newsletter-email"
                                name="<?php echo esc_attr($newsletter_field_name); ?>"
                                type="email"
                                required
                                autocomplete="email"
                                placeholder="<?php echo esc_attr($newsletter_placeholder); ?>"
                                <?php if ($newsletter_text): ?>aria-describedby="gyc-newsletter-hint"<?php endif; ?>
                                class="min-w-0 flex-1 border border-gyc-ink/20 bg-white px-4 py-3 font-jakarta text-sm text-gyc-ink placeholder:text-gyc-ink/50 focus:border-gyc-teal focus:outline-2 focus:outline-offset-0 focus:outline-gyc-teal" />
                            <button
                                type="submit"
                                class="bg-gyc-mint px-6 py-3 font-jakarta text-xs font-extrabold uppercase tracking-[0.15em] text-gyc-ink motion-safe:transition-colors hover:bg-gyc-mint-dark focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal">
                                <?php echo esc_html($newsletter_button); ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php foreach (array_values($columns) as $index => $column): ?>
                <?php
                $links = empty($column['links']) ? array() : array_filter($column['links'], function ($link) {
                    return !empty($link['label']) && !empty($link['url']);
                });
                $heading_id = 'gyc-footer-column-' . $index;
                ?>
                <nav class="col-span-1 md:col-span-2 <?php echo $index === 0 ? 'lg:col-start-7' : ''; ?>" <?php if (!empty($column['title'])): ?>aria-labelledby="<?php echo esc_attr($heading_id); ?>"<?php endif; ?>>
                    <?php if (!empty($column['title'])): ?>
                        <h2 id="<?php echo esc_attr($heading_id); ?>" class="font-jakarta text-xs font-bold uppercase tracking-[0.2em] text-gyc-ink/70 mb-4"><?php echo esc_html($column['title']); ?></h2>
                    <?php endif; ?>
                    <?php if (count($links) > 0): ?>
                        <ul class="space-y-2.5 font-jakarta text-sm break-words" role="list">
                            <?php foreach ($links as $link): ?>
                                <li><a href="<?php echo esc_url(GycUI::resolve_url($link['url'])); ?>" class="<?php echo esc_attr($link_class); ?>"><?php echo esc_html($link['label']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </nav>
            <?php endforeach; ?>
        </div>

        <?php if ($copyright || $tagline): ?>
            <div class="mt-14 flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-between font-jakarta text-xs text-gyc-ink/70">
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
