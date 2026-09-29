<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$items = empty($attributes['items']) ? array() : $attributes['items'];
$card_title_top = empty($attributes['cardTitleTop']) ? null : $attributes['cardTitleTop'];
$card_title = empty($attributes['cardTitle']) ? null : $attributes['cardTitle'];
$card_text = empty($attributes['cardText']) ? null : $attributes['cardText'];
$card_button_label = empty($attributes['cardButtonLabel']) ? null : $attributes['cardButtonLabel'];
$card_button_url = empty($attributes['cardButtonUrl']) ? null : GycUI::resolve_url($attributes['cardButtonUrl'], false);

$items = array_filter($items, function ($item) {
    return !empty($item['text']);
});
$has_card = $card_title_top || $card_title || $card_text || ($card_button_label && $card_button_url);
?>
<section
    class="bg-gyc-mist text-gyc-plum py-10 md:py-14"
    <?php if ($title): ?>aria-labelledby="gyc-whats-included-title"<?php endif; ?>>
    <div class="max-w-6xl mx-auto px-6 md:px-12">
        <?php if ($title): ?>
            <h2 id="gyc-whats-included-title" class="font-jakarta text-2xl md:text-3xl font-extrabold uppercase leading-tight tracking-tight mb-6"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if (count($items) > 0): ?>
                <ul class="space-y-4 rounded-sm border border-gyc-plum/10 bg-white p-6 md:p-8" role="list">
                    <?php foreach ($items as $item): ?>
                        <li class="flex items-start gap-3 font-jakarta text-sm md:text-base text-gyc-plum/90">
                            <svg class="mt-1 h-4 w-4 shrink-0 text-gyc-plum" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M5 12.5l4.5 4.5L19 7.5"/>
                            </svg>
                            <span><?php echo esc_html($item['text']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if ($has_card): ?>
                <div class="relative flex flex-col items-center justify-center overflow-hidden rounded-sm bg-gyc-plum-mid px-6 py-12 text-center text-white">
                    <div class="absolute left-1/2 top-1/2 h-48 w-48 -translate-x-1/2 -translate-y-[65%] rounded-full bg-white/10" aria-hidden="true"></div>

                    <div class="relative space-y-4">
                        <?php if ($card_title_top || $card_title): ?>
                            <p class="font-jakarta font-extrabold uppercase leading-tight tracking-tight">
                                <?php if ($card_title_top): ?>
                                    <span class="block text-lg md:text-xl"><?php echo esc_html($card_title_top); ?></span>
                                <?php endif; ?>
                                <?php if ($card_title): ?>
                                    <span class="block text-3xl md:text-4xl"><?php echo esc_html($card_title); ?></span>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($card_text): ?>
                            <p class="font-jakarta text-sm text-white/85"><?php echo esc_html($card_text); ?></p>
                        <?php endif; ?>

                        <?php if ($card_button_label && $card_button_url): ?>
                            <a
                                href="<?php echo esc_url($card_button_url); ?>"
                                class="group mt-2 inline-flex items-center gap-2 rounded-sm bg-gyc-mint px-7 py-3.5 font-jakarta text-xs font-bold uppercase tracking-[0.18em] text-gyc-plum hover:bg-gyc-mint-dark motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-mint">
                                <?php echo esc_html($card_button_label); ?>
                                <svg class="h-3.5 w-3.5 motion-safe:transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
