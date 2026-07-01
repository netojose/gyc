<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$headline = empty($attributes['headline']) ? null : $attributes['headline'];
$items = empty($attributes['items']) ? array() : $attributes['items'];
?>
<section class="bg-[#f4f3f0] text-[#2d1b33] py-16 px-6 md:px-12 lg:px-24 font-sans" x-data="{ currentTab: 1 }">
    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="mb-12">
            <?php if ($title): ?>
                <div class="font-anton uppercase flex items-center gap-3 text-xs font-semibold tracking-widest text-gray-500 mb-4">
                    <span class="w-8 h-px bg-gray-400"></span> <?php echo esc_html($title); ?>
                </div>
            <?php endif; ?>
            <?php if ($headline): ?>
                <h2 class="font-jakarta text-5xl md:text-6xl font-normal tracking-tight leading-tight whitespace-pre-wrap"><?php echo esc_html($headline); ?></h2>
            <?php endif; ?>
        </div>

        <!-- Tabs Navigation -->
        <div class="border-b border-gray-300 mb-10">
            <div class="flex flex-wrap gap-8 md:gap-12 text-xs font-bold tracking-widest uppercase">
                <?php foreach ($items as $index => $day): ?>
                    <button class="font-jakarta cursor-pointer transition" :class="{ 'border-b-2 border-[#2d1b33] pb-4 text-[#2d1b33]': currentTab === <?php echo $index + 1; ?>, 'text-gray-400 pb-4 hover:text-[#2d1b33]': currentTab !== <?php echo $index + 1; ?> }" @click="currentTab = <?php echo $index + 1; ?>">
                        <?php echo esc_html($day['date']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <?php foreach ($items as $index => $day): ?>
            <div class="space-y-0" x-show="currentTab === <?php echo $index + 1; ?>">
                <?php foreach ($day['items'] as $item): ?>
                    <div class="grid md:grid-cols-4 py-8 items-start gap-4">
                        <div class="font-anton uppercase text-xs font-bold tracking-wider text-gray-400 pt-1">
                            <?php echo esc_html($item['time']); ?>
                        </div>
                        <div class="md:col-span-3 flex flex-col md:flex-row md:justify-between gap-2">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-jakarta text-xl font-medium text-[#2d1b33] mb-2">
                                        <?php echo esc_html($item['title']); ?>
                                    </h4>
                                    <?php if (!empty($item['description'])): ?>
                                        <p class="font-jakarta text-sm text-gray-500 font-normal leading-relaxed max-w-xl">
                                            <?php echo esc_html($item['description']); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <?php
                                $tags = !empty($item['tags']) ? explode(',', $item['tags']) : [];
                                if (count($tags) > 0):
                                ?>
                                    <div>
                                        <?php foreach ($tags as $tag): ?>
                                            <span class="inline-block bg-[#d2f3ec] text-[#1e7a68] text-[10px] font-bold tracking-widest font-jakarta uppercase px-2.5 py-1 rounded-xs">
                                                <?php echo esc_html($tag); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($item['responsible'])): ?>
                                <div class="font-jakarta text-xs font-medium text-gray-500 md:text-right pt-1 whitespace-nowrap">
                                    <?php echo esc_html($item['responsible']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>