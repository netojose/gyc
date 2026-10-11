<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$headline = empty($attributes['headline']) ? null : $attributes['headline'];
$items = empty($attributes['items']) ? array() : array_values($attributes['items']);
?>
<section
    id="schedule"
    class="scroll-mt-8 bg-gyc-plum-mid text-white py-16 md:py-24"
    <?php if ($headline): ?>aria-labelledby="gyc-agenda-title"<?php endif; ?>
    x-data="{ currentTab: 1 }">
    <div class="max-w-content mx-auto px-6 md:px-12">
        <div class="space-y-5">
            <?php if ($title): ?>
                <p class="font-jakarta text-sm font-semibold uppercase tracking-[0.15em] text-white/90"><?php echo esc_html($title); ?></p>
            <?php endif; ?>
            <?php if ($headline): ?>
                <h2 id="gyc-agenda-title" class="font-display text-5xl md:text-6xl uppercase leading-none text-gyc-mint whitespace-pre-line"><?php echo esc_html($headline); ?></h2>
            <?php endif; ?>
        </div>

        <?php if (count($items) > 1): ?>
            <!-- Day picker; without JavaScript every day is listed one after another -->
            <div class="mt-10 border-b border-white/30" role="group" aria-label="Choose a day">
                <div class="flex flex-wrap gap-x-10 gap-y-2">
                    <?php foreach ($items as $index => $day): ?>
                        <button
                            type="button"
                            class="-mb-px border-b-2 py-4 font-jakarta text-xs font-bold tracking-wider motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-mint"
                            :class="currentTab === <?php echo $index + 1; ?> ? 'border-gyc-mint text-gyc-mint' : 'border-transparent text-white hover:text-gyc-mint'"
                            :aria-pressed="(currentTab === <?php echo $index + 1; ?>).toString()"
                            aria-controls="gyc-agenda-day-<?php echo $index + 1; ?>"
                            @click="currentTab = <?php echo $index + 1; ?>">
                            <?php echo esc_html($day['date']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php foreach ($items as $index => $day): ?>
            <div
                id="gyc-agenda-day-<?php echo $index + 1; ?>"
                class="mt-6"
                <?php if (count($items) > 1): ?>x-show="currentTab === <?php echo $index + 1; ?>"<?php endif; ?>>
                <h3 class="sr-only"><?php echo esc_html($day['date']); ?></h3>
                <ul role="list">
                    <?php foreach ((empty($day['items']) ? array() : $day['items']) as $item): ?>
                        <?php $tags = empty($item['tags']) ? array() : array_filter(array_map('trim', explode(',', $item['tags']))); ?>
                        <li class="grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-6 py-7">
                            <p class="md:col-span-3 pt-1 font-jakarta text-xs font-bold uppercase tracking-wider text-white/85"><?php echo esc_html($item['time']); ?></p>
                            <div class="md:col-span-7 space-y-2">
                                <h4 class="font-jakarta text-lg md:text-xl font-semibold text-gyc-mint"><?php echo esc_html($item['title']); ?></h4>
                                <?php if (!empty($item['description'])): ?>
                                    <p class="max-w-xl font-jakarta text-sm leading-relaxed text-white/80"><?php echo esc_html($item['description']); ?></p>
                                <?php endif; ?>
                                <?php if (count($tags) > 0): ?>
                                    <p class="flex flex-wrap gap-2 pt-1">
                                        <?php foreach ($tags as $tag): ?>
                                            <span class="rounded-full bg-gyc-mint/15 px-2.5 py-1 font-jakarta text-[0.65rem] font-bold uppercase tracking-widest text-gyc-mint"><?php echo esc_html($tag); ?></span>
                                        <?php endforeach; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($item['responsible'])): ?>
                                <p class="md:col-span-2 pt-1 font-jakarta text-xs text-white/80 md:text-right"><?php echo esc_html($item['responsible']); ?></p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</section>
