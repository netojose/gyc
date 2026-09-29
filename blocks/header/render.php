<?php
$logo = empty($attributes['logo']) ? null : $attributes['logo'];
$logo_alt = empty($attributes['logoAlt']) ? '' : $attributes['logoAlt'];
$logo_url = empty($attributes['logoUrl']) ? home_url('/') : GycUI::resolve_url($attributes['logoUrl']);
$menu = empty($attributes['menu']) ? array() : $attributes['menu'];
$socials = empty($attributes['socials']) ? array() : $attributes['socials'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl']);

$social_names = array(
    'instagram' => 'Instagram',
    'tiktok' => 'TikTok',
    'youtube' => 'YouTube',
    'facebook' => 'Facebook',
);
$social_icons = array(
    'instagram' => '<svg class="h-full w-full" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="0.8" fill="currentColor"></circle></svg>',
    'tiktok' => '<svg class="h-full w-full" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M16.6 5.8A4.3 4.3 0 0 1 15.5 3h-3.1v12.4a2.6 2.6 0 1 1-2.6-2.6c.3 0 .5 0 .8.1V9.7a5.7 5.7 0 1 0 4.9 5.7V9a7.4 7.4 0 0 0 4.3 1.4V7.3a4.3 4.3 0 0 1-3.2-1.5z"></path></svg>',
    'youtube' => '<svg class="h-full w-full" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M21.6 7.2a2.5 2.5 0 0 0-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.8 1.8c1.6.4 7.8.4 7.8.4s6.2 0 7.8-.4a2.5 2.5 0 0 0 1.8-1.8A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8zM10 15V9l5.2 3z"></path></svg>',
    'facebook' => '<svg class="h-full w-full" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12z"></path></svg>',
);

$socials = array_filter($socials, function ($social) use ($social_icons) {
    return !empty($social['url']) && !empty($social['network']) && isset($social_icons[$social['network']]);
});
$menu = array_filter($menu, function ($item) {
    return !empty($item['label']) && !empty($item['url']);
});
?>
<nav
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
    class="w-full bg-linear-to-r from-[#eef1f2] via-[#f3f5f5] to-white border-b border-gyc-ink/10 py-3"
    aria-label="Main">
    <div class="max-w-6xl mx-auto px-6 md:px-12">
        <div class="flex items-center justify-between gap-6">
            <a href="<?php echo esc_url($logo_url); ?>" class="shrink-0 rounded font-jakarta text-xl font-extrabold text-gyc-ink focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                <?php if ($logo): ?>
                    <img decoding="async" src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($logo_alt); ?>" class="w-14 md:w-16 h-auto brightness-0" draggable="false" />
                <?php else: ?>
                    <?php echo esc_html(get_bloginfo('name')); ?>
                <?php endif; ?>
            </a>

            <div class="hidden lg:flex items-center gap-8">
                <?php if (count($menu) > 0): ?>
                    <ul class="flex items-center gap-7 font-jakarta text-xs font-bold uppercase tracking-[0.15em] text-gyc-ink" role="list">
                        <?php foreach ($menu as $item): ?>
                            <?php $is_current = GycUI::is_current_url($item['url']); ?>
                            <li>
                                <a
                                    href="<?php echo esc_url(GycUI::resolve_url($item['url'])); ?>"
                                    <?php if ($is_current): ?>aria-current="page"<?php endif; ?>
                                    class="block border-b-2 pb-1.5 pt-2 motion-safe:transition-colors hover:text-gyc-teal focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal <?php echo $is_current ? 'border-gyc-teal' : 'border-transparent hover:border-gyc-teal/50'; ?>">
                                    <?php echo esc_html($item['label']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if (count($socials) > 0): ?>
                    <ul class="flex items-center gap-3 text-gyc-ink" role="list">
                        <?php foreach ($socials as $social): ?>
                            <li>
                                <a href="<?php echo esc_url(GycUI::resolve_url($social['url'])); ?>" class="block h-6 w-6 rounded p-1 motion-safe:transition-colors hover:text-gyc-teal focus-visible:outline-2 focus-visible:outline-gyc-teal" aria-label="<?php echo esc_attr($social_names[$social['network']]); ?>">
                                    <?php echo $social_icons[$social['network']]; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ($button_label && $button_url): ?>
                    <a href="<?php echo esc_url($button_url); ?>" class="inline-flex items-center gap-2 rounded-sm border-2 border-gyc-ink px-5 py-2.5 font-jakarta text-xs font-bold uppercase tracking-[0.15em] text-gyc-ink motion-safe:transition-colors hover:bg-gyc-ink hover:text-white focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                        <?php echo esc_html($button_label); ?>
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path></svg>
                    </a>
                <?php endif; ?>
            </div>

            <button
                type="button"
                @click="open = !open"
                :aria-expanded="open.toString()"
                aria-expanded="false"
                aria-controls="gyc-header-mobile-menu"
                aria-label="Menu"
                class="lg:hidden rounded p-1 text-gyc-ink focus-visible:outline-2 focus-visible:outline-gyc-teal">
                <svg x-show="!open" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div
            id="gyc-header-mobile-menu"
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            x-cloak
            class="lg:hidden mt-3 border-t border-gyc-ink/10 pt-4 pb-2">
            <?php if (count($menu) > 0): ?>
                <ul class="flex flex-col space-y-1 font-jakarta text-sm font-bold uppercase tracking-[0.15em] text-gyc-ink" role="list">
                    <?php foreach ($menu as $item): ?>
                        <?php $is_current = GycUI::is_current_url($item['url']); ?>
                        <li>
                            <a
                                href="<?php echo esc_url(GycUI::resolve_url($item['url'])); ?>"
                                <?php if ($is_current): ?>aria-current="page"<?php endif; ?>
                                @click="open = false"
                                class="block border-l-2 py-2 pl-3 hover:text-gyc-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal <?php echo $is_current ? 'border-gyc-teal text-gyc-teal' : 'border-transparent'; ?>">
                                <?php echo esc_html($item['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if (count($socials) > 0 || ($button_label && $button_url)): ?>
                <div class="mt-4 flex flex-wrap items-center justify-between gap-4 border-t border-gyc-ink/10 pt-4">
                    <?php if (count($socials) > 0): ?>
                        <ul class="flex items-center gap-4 text-gyc-ink" role="list">
                            <?php foreach ($socials as $social): ?>
                                <li>
                                    <a href="<?php echo esc_url(GycUI::resolve_url($social['url'])); ?>" class="block h-7 w-7 rounded p-1 hover:text-gyc-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal" aria-label="<?php echo esc_attr($social_names[$social['network']]); ?>">
                                        <?php echo $social_icons[$social['network']]; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php if ($button_label && $button_url): ?>
                        <a href="<?php echo esc_url($button_url); ?>" @click="open = false" class="inline-flex items-center gap-2 rounded-sm border-2 border-gyc-ink px-5 py-2.5 font-jakarta text-xs font-bold uppercase tracking-[0.15em] text-gyc-ink hover:bg-gyc-ink hover:text-white focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                            <?php echo esc_html($button_label); ?>
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path></svg>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
