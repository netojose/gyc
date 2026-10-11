<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$staff_title = empty($attributes['staffTitle']) ? null : $attributes['staffTitle'];
$main = empty($attributes['main']) ? array() : $attributes['main'];
$staff = empty($attributes['staff']) ? array() : $attributes['staff'];

$main = array_values(array_filter($main, function ($person) {
    return !empty($person['name']);
}));
$staff = array_values(array_filter($staff, function ($person) {
    return !empty($person['name']);
}));

// First letters of the first two words, shown when a workshop speaker has no photo
$initials = function ($name) {
    $words = preg_split('/\s+/u', trim($name));
    $letters = '';
    foreach (array_slice($words, 0, 2) as $word) {
        $letters .= mb_strtoupper(mb_substr($word, 0, 1));
    }
    return $letters;
};
?>
<section
    id="speakers"
    class="scroll-mt-8 bg-gyc-mist text-gyc-plum py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-people-title"<?php endif; ?>
    x-data="{ activeModalId: null, openModal(id) { this.activeModalId = String(id); }, closeModal() { this.activeModalId = null; } }"
    @keydown.escape.window="closeModal()">
    <div class="max-w-content mx-auto px-6 md:px-12">
        <?php if ($title || $text): ?>
            <div class="max-w-2xl space-y-4">
                <?php if ($title): ?>
                    <h2 id="gyc-people-title" class="font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($text): ?>
                    <p class="font-jakarta text-sm md:text-base leading-relaxed text-gyc-plum/80"><?php echo esc_html($text); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (count($main) > 0): ?>
            <ul class="mt-10 grid grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-10" role="list">
                <?php foreach ($main as $person): ?>
                    <?php $subtitle = !empty($person['role']) ? $person['role'] : (empty($person['headline']) ? '' : $person['headline']); ?>
                    <li>
                        <button
                            type="button"
                            class="group block w-full cursor-pointer text-left rounded-2xl focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-plum"
                            data-id="<?php echo esc_attr((string) $person['id']); ?>"
                            aria-haspopup="dialog"
                            @click="openModal($event.currentTarget.dataset.id)">
                            <span class="relative block aspect-[7/8] overflow-hidden rounded-2xl bg-gyc-plum-mid">
                                <?php if (!empty($person['photo'])): ?>
                                    <img class="absolute inset-0 h-full w-full object-cover motion-safe:transition-transform duration-300 ease-out motion-safe:group-hover:scale-105" src="<?php echo esc_url($person['photo']); ?>" alt="" loading="lazy" decoding="async" draggable="false" />
                                <?php else: ?>
                                    <svg class="absolute inset-x-0 bottom-0 mx-auto h-3/4 text-white/10" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <circle cx="12" cy="8" r="4.5"/>
                                        <path d="M3 24c0-5.5 4-9.5 9-9.5s9 4 9 9.5z"/>
                                    </svg>
                                <?php endif; ?>
                            </span>
                            <span class="mt-4 block font-display small-caps text-lg leading-tight underline decoration-transparent group-hover:decoration-current motion-safe:transition-colors"><?php echo esc_html($person['name']); ?></span>
                            <?php if ($subtitle): ?>
                                <span class="mt-1 block font-jakarta text-xs text-gyc-plum/75"><?php echo esc_html($subtitle); ?></span>
                            <?php endif; ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php foreach ($main as $person): ?>
                <div
                    class="fixed inset-0 z-50 flex items-center justify-center p-4"
                    x-show="activeModalId === '<?php echo esc_js((string) $person['id']); ?>'"
                    x-transition:enter="transition ease-out duration-250"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click.self="closeModal()"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="gyc-people-modal-<?php echo esc_attr((string) $person['id']); ?>"
                    style="display: none;">
                    <div class="absolute inset-0 bg-black/70" @click="closeModal()"></div>

                    <div class="relative w-full max-w-2xl rounded-2xl bg-white p-6 md:p-8 text-gyc-plum shadow-2xl">
                        <button
                            type="button"
                            class="absolute top-3 right-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full text-gyc-plum/70 motion-safe:transition-colors hover:bg-gyc-plum/5 hover:text-gyc-plum focus-visible:outline-2 focus-visible:outline-gyc-plum"
                            @click="closeModal()"
                            aria-label="Close">
                            <span aria-hidden="true" class="text-2xl leading-none">&times;</span>
                        </button>

                        <h3 id="gyc-people-modal-<?php echo esc_attr((string) $person['id']); ?>" class="pr-10 font-display small-caps text-2xl leading-tight"><?php echo esc_html($person['name']); ?></h3>
                        <?php if (!empty($person['role'])): ?>
                            <p class="mt-1 font-jakarta text-sm text-gyc-plum/75"><?php echo esc_html($person['role']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($person['headline'])): ?>
                            <p class="mt-1 font-jakarta text-sm font-semibold"><?php echo esc_html($person['headline']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($person['description'])): ?>
                            <div class="mt-5 font-jakarta text-sm leading-relaxed whitespace-pre-line"><?php echo esc_html($person['description']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (count($staff) > 0): ?>
            <div class="mt-12 rounded-2xl border border-gyc-plum/10 bg-white/40 p-6 md:p-8">
                <?php if ($staff_title): ?>
                    <h3 class="font-display small-caps text-xl leading-tight"><?php echo esc_html($staff_title); ?></h3>
                <?php endif; ?>

                <ul class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-8 text-center" role="list">
                    <?php foreach ($staff as $person): ?>
                        <li class="flex flex-col items-center">
                            <?php if (!empty($person['photo'])): ?>
                                <img class="h-14 w-14 rounded-full object-cover" src="<?php echo esc_url($person['photo']); ?>" alt="" loading="lazy" decoding="async" draggable="false" />
                            <?php else: ?>
                                <span class="flex h-14 w-14 items-center justify-center rounded-full bg-gyc-plum/10 font-jakarta text-sm font-semibold text-gyc-plum" aria-hidden="true"><?php echo esc_html($initials($person['name'])); ?></span>
                            <?php endif; ?>
                            <span class="mt-3 font-jakarta text-sm font-medium"><?php echo esc_html($person['name']); ?></span>
                            <?php if (!empty($person['role'])): ?>
                                <span class="mt-0.5 font-jakarta text-xs text-gyc-plum/75"><?php echo esc_html($person['role']); ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</section>
