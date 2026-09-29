<?php
$no_results_text = empty($attributes['noResultsText']) ? null : $attributes['noResultsText'];
$categories = empty($attributes['categories']) ? array() : $attributes['categories'];

$categories = array_filter(array_map(function ($category) {
    $category['items'] = empty($category['items']) ? array() : array_filter($category['items'], function ($item) {
        return !empty($item['question']);
    });
    return $category;
}, $categories), function ($category) {
    return count($category['items']) > 0;
});
?>
<section
    id="faq"
    class="bg-gyc-mist text-gyc-plum py-16 md:py-20 scroll-mt-4 focus:outline-none"
    aria-label="Questions"
    x-data="gycFaq"
    @gyc-faq-search.window="search($event)"
    tabindex="-1">
    <div class="max-w-6xl mx-auto px-6 md:px-12">
        <p class="sr-only" role="status" x-text="status"></p>

        <?php if ($no_results_text): ?>
            <p x-show="noResults" x-cloak class="font-jakarta text-base text-gyc-plum/85 mb-10"><?php echo esc_html($no_results_text); ?></p>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-12 md:gap-y-16">
            <?php foreach (array_values($categories) as $category_index => $category): ?>
                <?php $heading_id = 'gyc-faq-category-' . $category_index; ?>
                <div data-faq-category>
                    <?php if (!empty($category['title'])): ?>
                        <h2 id="<?php echo esc_attr($heading_id); ?>" class="font-jakarta text-xs font-extrabold uppercase tracking-[0.18em] mb-4"><?php echo esc_html($category['title']); ?></h2>
                    <?php endif; ?>

                    <ul class="border-b border-gyc-plum/15" role="list" <?php if (!empty($category['title'])): ?>aria-labelledby="<?php echo esc_attr($heading_id); ?>"<?php endif; ?>>
                        <?php foreach ($category['items'] as $item): ?>
                            <li class="border-t border-gyc-plum/15" data-faq-item>
                                <details class="group">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 rounded-sm py-3 font-jakarta text-sm text-gyc-plum/90 hover:text-gyc-plum [&::-webkit-details-marker]:hidden focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal">
                                        <span><?php echo esc_html($item['question']); ?></span>
                                        <svg class="h-3.5 w-3.5 shrink-0 motion-safe:transition-transform group-open:rotate-45" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 4v16M4 12h16"/>
                                        </svg>
                                    </summary>
                                    <?php if (!empty($item['answer'])): ?>
                                        <div class="pb-4 pr-8 font-jakarta text-sm leading-relaxed text-gyc-plum/80 space-y-3 [&_a]:underline [&_a]:text-gyc-teal">
                                            <?php echo wp_kses_post(wpautop($item['answer'])); ?>
                                        </div>
                                    <?php endif; ?>
                                </details>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
