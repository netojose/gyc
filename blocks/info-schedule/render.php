<?php
// Turned off in the block settings: nothing is shown, but the content is kept
if (!GycInfo::is_active($attributes)) {
    return;
}

$days = empty($attributes['days']) ? array() : $attributes['days'];
$link_label = empty($attributes['linkLabel']) ? null : $attributes['linkLabel'];
$link_url = empty($attributes['linkUrl']) ? null : GycUI::resolve_url($attributes['linkUrl'], false);

$days = array_filter($days, function ($day) {
    return !empty($day['weekday']) || !empty($day['date']);
});

echo GycInfo::open($attributes, 'schedule', 'white');
?>
<?php if (count($days) > 0): ?>
    <ol class="mt-10 md:mt-12 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4" role="list">
        <?php foreach ($days as $day): ?>
            <?php
            $is_highlight = !empty($day['highlight']);
            $lines = GycInfo::lines(empty($day['items']) ? '' : $day['items']);
            ?>
            <li class="rounded-2xl p-5 <?php echo $is_highlight ? 'bg-gyc-plum-mid text-white' : 'bg-gyc-cream'; ?>">
                <h3>
                    <?php if (!empty($day['weekday'])): ?>
                        <span class="block font-jakarta text-xs font-bold tracking-[0.2em] uppercase <?php echo $is_highlight ? 'text-gyc-mint' : 'text-gyc-teal'; ?>"><?php echo esc_html($day['weekday']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($day['date'])): ?>
                        <span class="mt-2 block font-display small-caps text-3xl leading-none <?php echo $is_highlight ? 'text-gyc-ivory' : ''; ?>"><?php echo esc_html($day['date']); ?></span>
                    <?php endif; ?>
                </h3>
                <span class="mt-4 block h-0.5 w-8 <?php echo $is_highlight ? 'bg-gyc-mint' : 'bg-gyc-teal'; ?>" aria-hidden="true"></span>
                <?php if (count($lines) > 0): ?>
                    <ul class="mt-4 space-y-2 font-jakarta text-sm leading-snug <?php echo $is_highlight ? 'text-white/85' : 'text-gyc-plum/80'; ?>" role="list">
                        <?php foreach ($lines as $line): ?>
                            <li><?php echo esc_html($line); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>

<?php if ($link_label): ?>
    <?php if ($link_url): ?>
        <a
            href="<?php echo esc_url($link_url); ?>"
            class="mt-8 md:mt-10 inline-flex items-center gap-2 font-jakarta text-sm font-semibold text-gyc-teal underline decoration-transparent underline-offset-4 hover:decoration-current motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal">
            <?php echo esc_html($link_label); ?>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    <?php else: ?>
        <p class="mt-8 md:mt-10 font-jakarta text-sm font-semibold text-gyc-teal"><?php echo esc_html($link_label); ?></p>
    <?php endif; ?>
<?php endif; ?>
<?php
echo GycInfo::close();
