<?php
$logo = empty($attributes['logo']) ? null : $attributes['logo'];
$logo_alt = empty($attributes['logoAlt']) ? '' : $attributes['logoAlt'];
$logo_url = empty($attributes['logoUrl']) ? home_url('/') : GycUI::resolve_url($attributes['logoUrl']);
$menu = empty($attributes['menu']) ? array() : $attributes['menu'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl']);

$menu = array_filter($menu, function ($item) {
    return !empty($item['label']) && !empty($item['url']);
});

// Light by default; dark when the page turns on "Dark header and footer" (see GycUI::is_dark_chrome)
$c = GycUI::is_dark_chrome()
    ? array(
        'nav' => 'bg-gyc-plum border-b border-white/10',
        'text' => 'text-white',
        'logo' => 'brightness-0 invert',
        'hover' => 'hover:text-gyc-mint',
        'focus' => 'focus-visible:outline-gyc-mint',
        'current' => 'border-gyc-mint text-gyc-mint',
        'not_current' => 'border-transparent hover:border-gyc-mint/50',
        'mobile_current' => 'border-gyc-mint text-gyc-mint',
        'divider' => 'border-white/10',
        'button' => 'rounded-full bg-gyc-mint text-gyc-plum hover:bg-gyc-mint-dark',
    )
    : array(
        'nav' => 'bg-linear-to-r from-[#eef1f2] via-[#f3f5f5] to-white border-b border-gyc-ink/10',
        'text' => 'text-gyc-ink',
        'logo' => 'brightness-0',
        'hover' => 'hover:text-gyc-teal',
        'focus' => 'focus-visible:outline-gyc-teal',
        'current' => 'border-gyc-teal',
        'not_current' => 'border-transparent hover:border-gyc-teal/50',
        'mobile_current' => 'border-gyc-teal text-gyc-teal',
        'divider' => 'border-gyc-ink/10',
        'button' => 'rounded-sm border-2 border-gyc-ink text-gyc-ink hover:bg-gyc-ink hover:text-white',
    );
?>
<nav
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
    class="w-full <?php echo esc_attr($c['nav']); ?> py-3"
    aria-label="Main">
    <div class="max-w-content mx-auto px-6 md:px-12">
        <div class="flex items-center justify-between gap-6">
            <a href="<?php echo esc_url($logo_url); ?>" class="shrink-0 rounded font-jakarta text-xl font-extrabold <?php echo esc_attr($c['text'] . ' ' . $c['focus']); ?> focus-visible:outline-2 focus-visible:outline-offset-4">
                <?php if ($logo): ?>
                    <img decoding="async" src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($logo_alt); ?>" class="w-14 md:w-16 h-auto <?php echo esc_attr($c['logo']); ?>" draggable="false" />
                <?php else: ?>
                    <?php echo esc_html(get_bloginfo('name')); ?>
                <?php endif; ?>
            </a>

            <div class="hidden lg:flex items-center gap-8">
                <?php if (count($menu) > 0): ?>
                    <ul class="flex items-center gap-7 font-jakarta text-xs font-bold uppercase tracking-[0.15em] <?php echo esc_attr($c['text']); ?>" role="list">
                        <?php foreach ($menu as $item): ?>
                            <?php $is_current = GycUI::is_current_url($item['url']); ?>
                            <li>
                                <a
                                    href="<?php echo esc_url(GycUI::resolve_url($item['url'])); ?>"
                                    <?php if ($is_current): ?>aria-current="page"<?php endif; ?>
                                    class="block border-b-2 pb-1.5 pt-2 motion-safe:transition-colors <?php echo esc_attr($c['hover'] . ' ' . $c['focus']); ?> focus-visible:outline-2 focus-visible:outline-offset-4 <?php echo esc_attr($is_current ? $c['current'] : $c['not_current']); ?>">
                                    <?php echo esc_html($item['label']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ($button_label && $button_url): ?>
                    <a href="<?php echo esc_url($button_url); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 font-jakarta text-xs font-bold uppercase tracking-[0.15em] motion-safe:transition-colors <?php echo esc_attr($c['button'] . ' ' . $c['focus']); ?> focus-visible:outline-2 focus-visible:outline-offset-4">
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
                class="lg:hidden rounded p-1 <?php echo esc_attr($c['text'] . ' ' . $c['focus']); ?> focus-visible:outline-2">
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
            class="lg:hidden mt-3 border-t <?php echo esc_attr($c['divider']); ?> pt-4 pb-2">
            <?php if (count($menu) > 0): ?>
                <ul class="flex flex-col space-y-1 font-jakarta text-sm font-bold uppercase tracking-[0.15em] <?php echo esc_attr($c['text']); ?>" role="list">
                    <?php foreach ($menu as $item): ?>
                        <?php $is_current = GycUI::is_current_url($item['url']); ?>
                        <li>
                            <a
                                href="<?php echo esc_url(GycUI::resolve_url($item['url'])); ?>"
                                <?php if ($is_current): ?>aria-current="page"<?php endif; ?>
                                @click="open = false"
                                class="block border-l-2 py-2 pl-3 motion-safe:transition-colors <?php echo esc_attr($c['hover'] . ' ' . $c['focus']); ?> focus-visible:outline-2 focus-visible:outline-offset-2 <?php echo esc_attr($is_current ? $c['mobile_current'] : 'border-transparent'); ?>">
                                <?php echo esc_html($item['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if ($button_label && $button_url): ?>
                <div class="mt-4 border-t <?php echo esc_attr($c['divider']); ?> pt-4">
                    <a href="<?php echo esc_url($button_url); ?>" @click="open = false" class="inline-flex items-center gap-2 px-5 py-2.5 motion-safe:transition-colors font-jakarta text-xs font-bold uppercase tracking-[0.15em] <?php echo esc_attr($c['button'] . ' ' . $c['focus']); ?> focus-visible:outline-2 focus-visible:outline-offset-4">
                        <?php echo esc_html($button_label); ?>
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path></svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
