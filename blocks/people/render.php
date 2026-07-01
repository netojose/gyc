<?php
$main = empty($attributes['main']) ? [] : $attributes['main'];
$staff = empty($attributes['staff']) ? [] : $attributes['staff'];
?>
<section
    class="bg-[#2d1b33] text-white py-20 px-6 md:px-16 lg:px-24"
    x-data="{ activeModalId: null, openModal(id) { this.activeModalId = String(id); }, closeModal() { this.activeModalId = null; } }"
    @keydown.escape.window="closeModal()">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="font-anton text-4xl font-bold tracking-wide mb-2 uppercase">Main Speakers</h2>
            <hr class="h-2 w-24 my-5 mx-auto bg-[#85F6D7] border-0" />
            <p class="font-jakarta text-purple-200/70 text-sm">Powerful voices for this generation</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-20">
            <?php foreach ($main as $person) : ?>
                <button
                    type="button"
                    class="cursor-pointer text-center group"
                    data-id="<?php echo esc_attr((string) $person['id']); ?>"
                    @click="openModal($event.currentTarget.dataset.id)">
                    <?php if (!empty($person['photo'])): ?>
                        <div class="bg-[#fffdf0] aspect-square mb-4 max-w-xs mx-auto shadow-md overflow-hidden">
                            <img class="w-full h-full object-cover transition-transform duration-300 ease-out group-hover:scale-120" src="<?php echo esc_url($person['photo']); ?>" alt="<?php echo esc_attr($person['name']); ?>" draggable="false" />
                        </div>
                    <?php else: ?>
                        <div class="bg-[#fffdf0] text-[#2d1b33] aspect-square flex items-center justify-center mb-4 max-w-xs mx-auto shadow-md overflow-hidden">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <h3 class="font-anton uppercase text-xl font-bold tracking-wide"><?php echo esc_html($person['name']); ?></h3>
                    <p class="font-jakarta text-xs text-purple-200/50 tracking-widest mt-1"><?php echo esc_html($person['role']); ?></p>
                    <p class="font-jakarta text-sm text-purple-200/70 mt-2 px-4"><?php echo esc_html($person['headline']); ?></p>
                </button>
            <?php endforeach; ?>
        </div>

        <?php foreach ($main as $person) : ?>
            <div
                id="modal-<?php echo esc_attr((string) $person['id']); ?>"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                x-show="activeModalId === '<?php echo esc_js((string) $person['id']); ?>'"
                x-transition:enter="transition ease-out duration-250"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click.self="closeModal()"
                style="display: none;">
                <div class="absolute inset-0 bg-black/70"></div>

                <div
                    class="relative w-full max-w-2xl bg-[#fffdf0] text-[#2d1b33] shadow-2xl p-6 md:p-8"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-2">
                    <button
                        type="button"
                        class="cursor-pointer absolute top-3 right-3 h-8 w-8 flex items-center justify-center text-[#2d1b33]/70 hover:text-[#2d1b33]"
                        @click="closeModal()"
                        aria-label="Close modal">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4 class="font-anton uppercase text-2xl tracking-wide pr-8"><?php echo esc_html($person['name']); ?></h4>
                    <?php if (!empty($person['role'])) : ?>
                        <p class="font-jakarta text-xs tracking-widest mt-1 text-[#2d1b33]/70"><?php echo esc_html($person['role']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($person['description'])) : ?>
                        <div class="font-jakarta text-sm mt-5 leading-relaxed whitespace-pre-line"><?php echo esc_html($person['description']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

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