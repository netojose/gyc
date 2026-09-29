<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$show_search = !empty($attributes['showSearch']);
$search_label = empty($attributes['searchLabel']) ? 'Search' : $attributes['searchLabel'];
$search_placeholder = empty($attributes['searchPlaceholder']) ? '' : $attributes['searchPlaceholder'];
?>
<section
    class="relative overflow-hidden bg-gyc-plum text-white"
    <?php if ($title): ?>aria-labelledby="gyc-page-hero-title"<?php endif; ?>>
    <div class="absolute -right-20 -top-16 h-64 w-64 rounded-full bg-white/5 md:right-0 md:h-96 md:w-96" aria-hidden="true"></div>
    <svg class="absolute inset-x-0 bottom-0 h-32 w-full md:h-48" viewBox="0 0 1440 200" preserveAspectRatio="none" aria-hidden="true">
        <path class="fill-white/5" d="M0 200V120l180-90 200 110 170-80 190 60 220-120 200 110 280-80v170z"/>
        <path class="fill-gyc-plum-light/60" d="M0 200v-40l240-70 260 90 210-60 230 50 250-110 250 80v60z"/>
    </svg>

    <div class="relative max-w-6xl mx-auto px-6 md:px-12 pt-16 pb-28 md:pt-24 md:pb-40">
        <div class="max-w-2xl space-y-5">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-white/85"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h1 id="gyc-page-hero-title" class="font-jakarta text-5xl md:text-7xl font-extrabold uppercase leading-none tracking-tight break-words"><?php echo esc_html($title); ?></h1>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-base md:text-lg leading-relaxed text-white/85"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if ($show_search): ?>
                <!-- Filters the FAQ block on the same page; hidden until Alpine loads because it needs JavaScript -->
                <form
                    role="search"
                    x-data="{ query: '' }"
                    x-cloak
                    @submit.prevent="$dispatch('gyc-faq-search', { query: query, submit: true })"
                    class="pt-4 max-w-md">
                    <label for="gyc-page-hero-search" class="sr-only"><?php echo esc_html($search_label); ?></label>
                    <div class="flex items-center rounded-sm bg-white p-1.5 pl-4 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-gyc-mint">
                        <input
                            id="gyc-page-hero-search"
                            type="search"
                            x-model="query"
                            @input.debounce.200ms="$dispatch('gyc-faq-search', { query: query })"
                            placeholder="<?php echo esc_attr($search_placeholder); ?>"
                            autocomplete="off"
                            class="min-w-0 flex-1 bg-transparent font-jakarta text-sm text-gyc-plum placeholder:text-gyc-plum/60 focus:outline-none" />
                        <button type="submit" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-gyc-mint text-gyc-plum hover:bg-gyc-mint-dark motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-plum">
                            <span class="sr-only"><?php echo esc_html($search_label); ?></span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="11" cy="11" r="6.5"/>
                                <path d="M16 16l4.5 4.5"/>
                            </svg>
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>
