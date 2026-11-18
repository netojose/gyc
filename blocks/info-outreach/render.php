<?php
// Turned off in the block settings: nothing is shown, but the content is kept
if (!GycInfo::is_active($attributes)) {
    return;
}

$anchor = GycInfo::anchor($attributes, 'outreach');
$projects_title = empty($attributes['projectsTitle']) ? null : $attributes['projectsTitle'];
$projects_text = empty($attributes['projectsText']) ? null : $attributes['projectsText'];
// External registration portal; hidden when the label or link is empty
$projects_button = GycInfo::button(
    empty($attributes['projectsButtonLabel']) ? '' : $attributes['projectsButtonLabel'],
    empty($attributes['projectsButtonUrl']) ? '' : $attributes['projectsButtonUrl'],
    empty($attributes['projectsButtonOpensAt']) ? '' : $attributes['projectsButtonOpensAt']
);
$note = empty($attributes['note']) ? null : $attributes['note'];
$events = array_values(array_filter(empty($attributes['events']) ? array() : $attributes['events'], function ($event) {
    return !empty($event['title']) || !empty($event['text']) || !empty($event['items']);
}));
$projects = array_filter(empty($attributes['projects']) ? array() : $attributes['projects'], function ($project) {
    return !empty($project['title']) || !empty($project['text']);
});

echo GycInfo::open($attributes, 'outreach', 'lilac');
?>
<?php if (count($events) > 0): ?>
    <ul class="mt-10 md:mt-12 grid grid-cols-1 gap-4 md:gap-5 <?php echo count($events) > 1 ? 'lg:grid-cols-2' : ''; ?>" role="list">
        <?php foreach ($events as $event): ?>
            <?php
            $is_dark = !isset($event['style']) || $event['style'] !== 'white';
            $label = empty($event['label']) ? null : $event['label'];
            $dates = empty($event['dates']) ? null : $event['dates'];
            $place = empty($event['place']) ? null : $event['place'];
            $button = GycInfo::button(
                empty($event['buttonLabel']) ? '' : $event['buttonLabel'],
                empty($event['buttonUrl']) ? '' : $event['buttonUrl'],
                empty($event['buttonOpensAt']) ? '' : $event['buttonOpensAt'],
                $is_dark ? 'mint' : 'plum'
            );
            ?>
            <li class="flex flex-col overflow-hidden rounded-3xl <?php echo $is_dark ? 'bg-gyc-plum-mid text-white' : 'border border-gyc-plum/10 bg-white'; ?>">
                <?php if (!empty($event['image'])): ?>
                    <img src="<?php echo esc_url($event['image']); ?>" alt="<?php echo esc_attr(empty($event['imageAlt']) ? '' : $event['imageAlt']); ?>" loading="lazy" class="aspect-[16/7] w-full object-cover" />
                <?php endif; ?>

                <div class="flex flex-1 flex-col p-6 md:p-9">
                    <?php if ($label): ?>
                        <div>
                            <span class="inline-block rounded-full px-3 py-1 font-jakarta text-[0.65rem] font-bold uppercase tracking-wider <?php echo $is_dark ? 'bg-gyc-mint text-gyc-plum' : 'bg-gyc-lilac text-gyc-plum'; ?>"><?php echo esc_html($label); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($event['title'])): ?>
                        <h3 class="<?php echo $label ? 'mt-7 md:mt-8 ' : ''; ?>font-display small-caps text-3xl md:text-4xl leading-none <?php echo $is_dark ? 'text-gyc-ivory' : ''; ?>"><?php echo esc_html($event['title']); ?></h3>
                    <?php endif; ?>

                    <?php if ($dates || $place): ?>
                        <dl class="mt-4 flex flex-wrap gap-x-6 gap-y-2 font-jakarta text-sm font-semibold <?php echo $is_dark ? 'text-gyc-mint' : 'text-gyc-teal'; ?>">
                            <?php if ($dates): ?>
                                <div class="flex items-center gap-2">
                                    <dt class="shrink-0"><?php echo GycInfo::svg('calendar', 'h-4 w-4'); ?><span class="sr-only"><?php esc_html_e('When', 'gyc'); ?></span></dt>
                                    <dd><?php echo esc_html($dates); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if ($place): ?>
                                <div class="flex items-center gap-2">
                                    <dt class="shrink-0"><?php echo GycInfo::svg('pin', 'h-4 w-4'); ?><span class="sr-only"><?php esc_html_e('Where', 'gyc'); ?></span></dt>
                                    <dd><?php echo esc_html($place); ?></dd>
                                </div>
                            <?php endif; ?>
                        </dl>
                    <?php endif; ?>

                    <?php if (!empty($event['text'])): ?>
                        <p class="mt-5 max-w-xl font-jakarta text-sm md:text-base leading-relaxed whitespace-pre-line <?php echo $is_dark ? 'text-white/85' : 'text-gyc-plum/80'; ?>"><?php echo esc_html($event['text']); ?></p>
                    <?php endif; ?>

                    <?php echo GycInfo::bullets(empty($event['items']) ? '' : $event['items'], $is_dark); ?>

                    <?php if ($button): ?>
                        <div class="mt-auto pt-7"><?php echo $button; ?></div>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($projects_title || $projects_text || count($projects) > 0): ?>
    <div id="<?php echo esc_attr($anchor . '-projects'); ?>" class="scroll-mt-8 mt-12 md:mt-16">
        <?php if ($projects_title || $projects_text): ?>
            <div class="max-w-2xl space-y-3">
                <?php if ($projects_title): ?>
                    <h3 class="font-display small-caps text-2xl md:text-3xl leading-tight"><?php echo esc_html($projects_title); ?></h3>
                <?php endif; ?>
                <?php if ($projects_text): ?>
                    <p class="font-jakarta text-sm md:text-base leading-relaxed text-gyc-plum/80"><?php echo esc_html($projects_text); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (count($projects) > 0): ?>
            <ul class="mt-6 md:mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5" role="list">
                <?php foreach ($projects as $project): ?>
                    <?php $project_heading = $projects_title ? 'h4' : 'h3'; ?>
                    <li class="flex flex-col rounded-2xl bg-white p-5 md:p-6">
                        <?php $icon = GycInfo::icon_badge(empty($project['icon']) ? '' : $project['icon'], 'mint', 'md', empty($project['iconImage']) ? '' : $project['iconImage']); ?>
                        <?php if ($icon): ?>
                            <div class="mb-5"><?php echo $icon; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($project['title'])): ?>
                            <<?php echo $project_heading; ?> class="font-display small-caps text-xl leading-tight"><?php echo esc_html($project['title']); ?></<?php echo $project_heading; ?>>
                        <?php endif; ?>
                        <?php if (!empty($project['text'])): ?>
                            <p class="mt-3 font-jakarta text-sm leading-relaxed text-gyc-plum/80"><?php echo esc_html($project['text']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($project['tag'])): ?>
                            <!-- What to bring, along the bottom so the tags line up across a row -->
                            <p class="mt-auto pt-4">
                                <span class="inline-block rounded-full bg-gyc-lilac px-2.5 py-1 font-jakarta text-xs font-medium"><?php echo esc_html($project['tag']); ?></span>
                            </p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php echo GycInfo::note($note, 'info'); ?>

<?php if ($projects_button): ?>
    <!-- Last in the section: read the projects and the note, then register on the portal -->
    <div class="mt-8 md:mt-10 flex justify-center"><?php echo $projects_button; ?></div>
<?php endif; ?>
<?php
echo GycInfo::close();
