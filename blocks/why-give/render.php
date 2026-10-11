<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$items = empty($attributes['items']) ? array() : $attributes['items'];
$card_title = empty($attributes['cardTitle']) ? null : $attributes['cardTitle'];
$card_text = empty($attributes['cardText']) ? null : $attributes['cardText'];
$button_label = empty($attributes['buttonLabel']) ? null : $attributes['buttonLabel'];
$button_url = empty($attributes['buttonUrl']) ? null : GycUI::resolve_url($attributes['buttonUrl'], false);
$note = empty($attributes['note']) ? null : $attributes['note'];

$items = array_filter($items, function ($item) {
    return !empty($item['amount']) || !empty($item['title']) || !empty($item['text']);
});
$has_card = $card_title || $card_text || ($button_label && $button_url);
?>
<section
    id="give"
    class="scroll-mt-8 bg-gyc-cream text-gyc-ink py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-why-give-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-start">
        <div class="<?php echo $has_card ? 'lg:col-span-6' : 'lg:col-span-8'; ?> lg:pt-6">
            <?php if ($title): ?>
                <h2 id="gyc-why-give-title" class="max-w-md font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="mt-5 max-w-lg font-jakarta text-sm md:text-base leading-relaxed text-gyc-ink/80"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if (count($items) > 0): ?>
                <ul class="mt-6 divide-y divide-gyc-ink/10 border-b border-gyc-ink/10" role="list">
                    <?php foreach ($items as $item): ?>
                        <li class="grid grid-cols-[5rem_1fr] sm:grid-cols-[7rem_1fr] gap-4 sm:gap-6 py-7">
                            <p class="font-display text-3xl md:text-4xl leading-none text-gyc-teal"><?php echo esc_html(empty($item['amount']) ? '' : $item['amount']); ?></p>
                            <div class="space-y-1.5">
                                <?php if (!empty($item['title'])): ?>
                                    <h3 class="font-display small-caps text-xl leading-tight"><?php echo esc_html($item['title']); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($item['text'])): ?>
                                    <p class="font-jakarta text-sm leading-relaxed text-gyc-ink/80"><?php echo esc_html($item['text']); ?></p>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php if ($has_card): ?>
            <div class="lg:col-span-5 lg:col-start-8 rounded-3xl border border-gyc-ink/10 bg-white p-6 md:p-8">
                <?php if ($card_title): ?>
                    <h3 class="font-display small-caps text-2xl leading-none"><?php echo esc_html($card_title); ?></h3>
                <?php endif; ?>

                <?php if ($card_text): ?>
                    <p class="mt-3 font-jakarta text-sm md:text-base leading-relaxed text-gyc-ink/80"><?php echo esc_html($card_text); ?></p>
                <?php endif; ?>

                <?php if ($button_label && $button_url): ?>
                    <a
                        href="<?php echo esc_url($button_url); ?>"
                        class="mt-6 flex w-full items-center justify-center gap-2 rounded-full bg-gyc-teal px-6 py-4 font-jakarta text-sm font-semibold text-white motion-safe:transition-colors hover:bg-gyc-teal-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                        <?php echo esc_html($button_label); ?>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                <?php endif; ?>

                <?php if ($note): ?>
                    <p class="mt-3 text-center font-jakarta text-xs text-gyc-ink/70"><?php echo esc_html($note); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
