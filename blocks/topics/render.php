<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$headline = empty($attributes['headline']) ? null : $attributes['headline'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$items = empty($attributes['items']) ? array() : $attributes['items'];
?>
<section class="bg-[#FEFFE9] flex items-center justify-center p-6 md:p-12 lg:p-24 font-sans text-[#3C2D3D]">
    <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">
        <div class="lg:col-span-6 space-y-6">
            <?php if ($title): ?>
                <div class="flex items-center gap-3">
                    <span class="w-10 h-px bg-[#3C2D3D]/40"></span>
                    <span class="text-xs font-bold tracking-widest uppercase text-[#3C2D3D]/70"><?php echo esc_html($title); ?></span>
                </div>
            <?php endif; ?>

            <?php if ($headline): ?>
                <h2 class="font-jakarta text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-[#3C2D3D]">
                    <?php echo esc_html($headline); ?>
                </h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <div class="font-jakarta space-y-6 text-[#3C2D3D]/80 leading-relaxed text-base md:text-lg">
                    <p class="whitespace-pre-wrap"><?php echo esc_html($text); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <?php if (count($items) > 0): ?>
            <div class="lg:col-span-6 space-y-6">
                <?php foreach ($items as $item): ?>
                    <div class="flex bg-[#F4F1E6] p-6 md:p-8 rounded-sm shadow-xs border-l-4 border-[#3C2D3D]">
                        <div class="space-y-2">
                            <h3 class="font-jakarta text-xl md:text-2xl font-semibold text-[#3C2D3D]">
                                <?php echo esc_html($item['title']); ?>
                            </h3>
                            <p class="font-jakarta text-[#3C2D3D]/80 leading-relaxed text-sm md:text-base">
                                <?php echo esc_html($item['text']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>