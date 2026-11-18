<?php
// Turned off in the block settings: nothing is shown, but the content is kept
if (!GycInfo::is_active($attributes)) {
    return;
}

$tiers = empty($attributes['tiers']) ? array() : $attributes['tiers'];
$extras = empty($attributes['extras']) ? array() : $attributes['extras'];
// Same button as the Register banner: greyed out until the opening time, hidden without a label or link
$button = GycInfo::button(
    empty($attributes['buttonLabel']) ? '' : $attributes['buttonLabel'],
    empty($attributes['buttonUrl']) ? '' : $attributes['buttonUrl'],
    empty($attributes['buttonOpensAt']) ? '' : $attributes['buttonOpensAt']
);

$tiers = array_filter($tiers, function ($tier) {
    return !empty($tier['label']) || !empty($tier['price']);
});
$extras = array_filter($extras, function ($extra) {
    return !empty($extra['label']) || !empty($extra['text']);
});

echo GycInfo::open($attributes, 'registration', 'cream');
?>
<?php if (count($tiers) > 0): ?>
    <ul class="mt-10 md:mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" role="list">
        <?php foreach ($tiers as $tier): ?>
            <?php $is_featured = !empty($tier['badge']); ?>
            <li class="flex flex-col rounded-3xl p-6 md:p-7 <?php echo $is_featured ? 'bg-gyc-plum-mid text-white' : 'border border-gyc-plum/10 bg-white'; ?>">
                <?php if ($is_featured): ?>
                    <span class="mb-3 self-start rounded-full bg-gyc-mint px-3 py-1 font-jakarta text-[0.65rem] font-bold uppercase tracking-wider text-gyc-plum"><?php echo esc_html($tier['badge']); ?></span>
                <?php endif; ?>
                <?php if (!empty($tier['label'])): ?>
                    <h3 class="font-jakarta text-xs font-bold tracking-[0.2em] uppercase <?php echo $is_featured ? 'text-gyc-mint' : 'text-gyc-teal'; ?>"><?php echo esc_html($tier['label']); ?></h3>
                <?php endif; ?>
                <?php if (!empty($tier['price'])): ?>
                    <p class="mt-4 font-display text-5xl leading-none <?php echo $is_featured ? 'text-gyc-ivory' : ''; ?>"><?php echo esc_html($tier['price']); ?></p>
                <?php endif; ?>
                <?php if (!empty($tier['date'])): ?>
                    <p class="mt-5 font-jakarta text-sm <?php echo $is_featured ? 'text-white/85' : 'text-gyc-plum/80'; ?>"><?php echo esc_html($tier['date']); ?></p>
                <?php endif; ?>
                <?php if (!empty($tier['note'])): ?>
                    <p class="mt-3 font-jakarta text-xs leading-relaxed <?php echo $is_featured ? 'text-white/70' : 'text-gyc-plum/70'; ?>"><?php echo esc_html($tier['note']); ?></p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (count($extras) > 0): ?>
    <ul class="mt-4 md:mt-5 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" role="list">
        <?php foreach ($extras as $extra): ?>
            <?php $is_white = isset($extra['style']) && $extra['style'] === 'white'; ?>
            <li class="rounded-3xl p-6 md:p-7 <?php echo $is_white ? 'border border-gyc-plum/10 bg-white' : 'bg-gyc-lilac'; ?>">
                <?php if (!empty($extra['label'])): ?>
                    <h3 class="font-jakarta text-xs font-bold tracking-[0.2em] uppercase text-gyc-teal"><?php echo esc_html($extra['label']); ?></h3>
                <?php endif; ?>
                <?php if (!empty($extra['value'])): ?>
                    <p class="mt-4 font-display small-caps text-3xl leading-none"><?php echo esc_html($extra['value']); ?></p>
                <?php endif; ?>
                <?php if (!empty($extra['text'])): ?>
                    <p class="mt-4 font-jakarta text-sm leading-relaxed text-gyc-plum/80"><?php echo esc_html($extra['text']); ?></p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($button): ?>
    <div class="mt-8 md:mt-10"><?php echo $button; ?></div>
<?php endif; ?>
<?php
echo GycInfo::close();
