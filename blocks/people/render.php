<?php
$main = empty($attributes['main']) ? [] : $attributes['main'];
$staff = empty($attributes['staff']) ? [] : $attributes['staff'];
?>
<section class="bg-[#2d1b33] text-white py-20 px-6 md:px-16 lg:px-24">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="font-anton text-4xl font-bold tracking-wide mb-2 uppercase">Main Speakers</h2>
            <hr class="h-2 w-24 my-5 mx-auto bg-[#85F6D7] border-0" />
            <p class="font-jakarta text-purple-200/70 text-sm">Powerful voices for this generation</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-20">
            <?php foreach ($main as $person) : ?>
                <div class="text-center group">
                    <?php if (!empty($person['photo'])): ?>
                        <img class="bg-[#fffdf0] aspect-square rounded-none mb-4 max-w-xs mx-auto shadow-md object-cover" src="<?php echo esc_url($person['photo']); ?>" alt="<?php echo esc_attr($person['name']); ?>" draggable="false" />
                    <?php else: ?>
                        <div class="bg-[#fffdf0] text-[#2d1b33] aspect-square rounded-none flex items-center justify-center mb-4 max-w-xs mx-auto shadow-md">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <h3 class="font-anton uppercase text-xl font-bold tracking-wide"><?php echo esc_html($person['name']); ?></h3>
                    <p class="font-jakarta text-xs text-purple-200/50 tracking-widest mt-1"><?php echo esc_html($person['role']); ?></p>
                    <p class="font-jakarta text-sm text-purple-200/70 mt-2 px-4"><?php echo esc_html($person['headline']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="border-t border-purple-900/40 pt-16">
            <h3 class="font-anton uppercase text-2xl font-bold tracking-wide text-center">Workshop Leaders</h3>
            <hr class="h-1 w-16.5 mt-5 mb-7 mx-auto bg-[#85F6D7] border-0" />

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6 justify-center text-center">
                <?php foreach ($staff as $leader): ?>
                    <div class="flex flex-col items-center">
                        <?php if (!empty($leader['photo'])): ?>
                            <img class="bg-[#fffdf0] text-[#2d1b33] w-24 h-24 rounded-full mb-2 shadow object-cover" src="<?php echo esc_url($leader['photo']); ?>" alt="<?php echo esc_attr($leader['name']); ?>" draggable="false" />
                        <?php else: ?>
                            <div class="bg-[#fffdf0] text-[#2d1b33] w-24 h-24 rounded-full flex items-center justify-center mb-2 shadow">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        <?php endif; ?>
                        <span class="font-jakarta text-xs font-medium text-purple-100"><?php echo esc_html($leader['name']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>