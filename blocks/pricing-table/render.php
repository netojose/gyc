<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$headline = empty($attributes['headline']) ? null : $attributes['headline'];
$items = empty($attributes['items']) ? array() : $attributes['items'];
?>
<section id="register" class="bg-[#5ce1ca] text-[#2d1b33] py-24 px-6 md:px-16 lg:px-24 text-center">
    <div class="max-w-6xl mx-auto">

        <?php if ($title): ?>
            <h2 class="font-anton uppercase text-4xl md:text-6xl tracking-wide mb-5">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif; ?>

        <?php if ($headline): ?>
            <p class="font-jakarta text-base md:text-lg max-w-2xl mx-auto mb-14 font-medium opacity-90">
                <?php echo esc_html($headline); ?>
            </p>
        <?php endif; ?>

        <?php if (count($items) > 0): ?>
            <div class="grid gap-8 md:grid-cols-3 items-stretch">
                <?php foreach ($items as $item): ?>
                    <?php
                    $hasBadge = !empty($item['badge']);
                    $class = $hasBadge ? 'relative border-2 border-[#5ce1ca] shadow-2xl scale-[1.02]' : 'border border-white/10 shadow-lg hover:shadow-2xl';
                    ?>
                    <div class="text-white rounded-2xl p-8 flex flex-col justify-between bg-[#2d1b33] transition-transform duration-300 hover:scale-[1.05] hover:rotate-1 <?php echo $class; ?>">
                        <?php if ($hasBadge): ?>
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#fffdf0] text-[#2d1b33] text-[11px] font-bold uppercase tracking-widest px-4 py-1 rounded-full">
                                <?php echo esc_html($item['badge']); ?>
                            </div>
                        <?php endif; ?>

                        <div>
                            <h3 class="font-anton text-lg tracking-widest text-purple-200 uppercase">
                                <?php echo esc_html($item['title']); ?>
                            </h3>

                            <div class="mt-6 font-anton uppercase text-5xl font-bold leading-none">
                                € <?php echo esc_html($item['price']); ?>
                            </div>

                            <p class="font-jakarta mt-2 text-xs text-purple-200/60">
                                <?php echo esc_html($item['date']); ?>
                            </p>
                        </div>

                        <a href="<?php echo esc_url($item['link']); ?>" target="_blank" class="mt-10 w-full bg-[#5ce1ca] text-[#2d1b33] font-anton uppercase font-bold py-3 rounded-xl text-sm hover:bg-[#49c0ab] focus:outline-none focus:ring-2 focus:ring-[#5ce1ca]/50 transition">
                            Register Now
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Footer -->
        <p class="font-jakarta mt-14 text-sm opacity-90">
            Questions? Contact us at
            <a href="mailto:info@gyceurope.org" class="underline font-medium hover:opacity-70 transition">
                info@gyceurope.org
            </a>
        </p>

    </div>
</section>