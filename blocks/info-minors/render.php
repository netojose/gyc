<?php
// Turned off in the block settings: nothing is shown, but the content is kept
if (!GycInfo::is_active($attributes)) {
    return;
}

$groups = empty($attributes['groups']) ? array() : $attributes['groups'];
$note = empty($attributes['note']) ? null : $attributes['note'];

$groups = array_filter($groups, function ($group) {
    return !empty($group['ages']) || !empty($group['title']);
});

echo GycInfo::open($attributes, 'under-18', 'white');
?>
<?php if (count($groups) > 0): ?>
    <ul class="mt-10 md:mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" role="list">
        <?php foreach ($groups as $group): ?>
            <li class="rounded-3xl bg-gyc-cream p-6 md:p-7">
                <?php if (!empty($group['ages'])): ?>
                    <p class="font-display text-6xl leading-none"><?php echo esc_html($group['ages']); ?></p>
                <?php endif; ?>
                <?php if (!empty($group['unit'])): ?>
                    <p class="mt-5 font-jakarta text-xs font-bold tracking-[0.2em] uppercase text-gyc-teal"><?php echo esc_html($group['unit']); ?></p>
                <?php endif; ?>
                <?php if (!empty($group['title'])): ?>
                    <h3 class="mt-3 font-jakarta text-base font-semibold"><?php echo esc_html($group['title']); ?></h3>
                <?php endif; ?>
                <?php if (!empty($group['text'])): ?>
                    <p class="mt-2 font-jakarta text-sm leading-relaxed text-gyc-plum/80"><?php echo esc_html($group['text']); ?></p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
echo GycInfo::note($note, 'check');
echo GycInfo::close();
