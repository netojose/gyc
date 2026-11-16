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

// Either group can be turned off in the block settings; its content is kept. The title and text belong to the main speakers
if (isset($attributes['showMain']) && !$attributes['showMain']) {
    $title = null;
    $text = null;
    $main = array();
}
if (isset($attributes['showStaff']) && !$attributes['showStaff']) {
    $staff = array();
}
if (!$title && !$text && count($main) === 0 && count($staff) === 0) {
    return;
}

// First letters of the first two words, shown when a speaker has no photo
$initials = function ($name) {
    $words = preg_split('/\s+/u', trim($name));
    $letters = '';
    foreach (array_slice($words, 0, 2) as $word) {
        $letters .= mb_strtoupper(mb_substr($word, 0, 1));
    }
    return $letters;
};

// Everyone with a bio goes into one list for the pop-up, so visitors can step from one speaker to the next.
// Each gets a readable id from their name for the #speaker-<id> link
$people = array();
$used_ids = array();
// Pills at the bottom of the pop-up: one per talk or workshop, holding its title exactly as typed and, when set,
// its day and time. Without any, the older single headline is shown instead
$get_labels = function ($person) {
    $labels = array();
    foreach (array('sessions', 'workshops') as $key) {
        foreach (empty($person[$key]) ? array() : $person[$key] as $session) {
            if (empty($session['title']) && empty($session['time'])) {
                continue;
            }
            $labels[] = array(
                'title' => empty($session['title']) ? '' : $session['title'],
                'time' => empty($session['time']) ? '' : $session['time'],
            );
        }
    }
    if (count($labels) === 0 && !empty($person['headline'])) {
        $labels[] = array('title' => $person['headline'], 'time' => '');
    }
    return $labels;
};

$add_person = function ($person, $type) use (&$people, &$used_ids, $initials, $get_labels) {
    $id = sanitize_title($person['name']);
    $id = $id === '' ? 'speaker' : $id;
    $base_id = $id;
    for ($n = 2; isset($used_ids[$id]); $n++) {
        $id = $base_id . '-' . $n;
    }
    $used_ids[$id] = true;

    $people[] = array(
        'id' => $id,
        'type' => $type,
        'name' => $person['name'],
        'initials' => $initials($person['name']),
        'role' => empty($person['role']) ? '' : $person['role'],
        'country' => empty($person['country']) ? '' : $person['country'],
        'labels' => $get_labels($person),
        'description' => empty($person['description']) ? '' : $person['description'],
        'photo' => empty($person['photo']) ? '' : esc_url_raw($person['photo']),
    );
    return count($people) - 1;
};

// Main speakers always open a pop-up; workshop speakers only when they have a description or workshop to show
foreach ($main as $i => $person) {
    $main[$i]['index'] = $add_person($person, __('Main speaker', 'gyc'));
}
foreach ($staff as $i => $person) {
    $staff[$i]['index'] = (empty($person['description']) && count($get_labels($person)) === 0) ? null : $add_person($person, __('Workshop speaker', 'gyc'));
}

// Main speaker cards share the full width: two or three wide cards, four per row from four speakers on.
// The text under each card grows with the card, so it stays in proportion to the photo
$main_count = count($main);
if ($main_count <= 2) {
    $main_grid = $main_count === 1 ? 'grid-cols-1 max-w-xl gap-y-10' : 'grid-cols-1 sm:grid-cols-2 gap-x-6 lg:gap-x-8 gap-y-10';
    $main_photo = 'aspect-[4/3]';
    $main_name = 'text-[1.75rem] md:text-[2rem]';
    $main_role = 'text-sm md:text-base';
    $main_country = 'text-xs md:text-sm';
} elseif ($main_count === 3) {
    $main_grid = 'grid-cols-1 sm:grid-cols-3 gap-x-4 gap-y-10';
    $main_photo = 'aspect-[4/5]';
    $main_name = 'text-[1.75rem] lg:text-[2rem]';
    $main_role = 'text-sm';
    $main_country = 'text-xs';
} else {
    $main_grid = 'grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-10';
    $main_photo = 'aspect-[7/8]';
    $main_name = 'text-xl md:text-[1.625rem]';
    $main_role = 'text-xs md:text-sm';
    $main_country = 'text-xs';
}

// Mint "+" badge drawn with two bars, so it sits exactly in the middle at any size
$plus_icon = '<svg class="h-[45%] w-[45%]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M10 3v14M3 10h14"/></svg>';

// Location pin in front of the country, so it reads as a place and not as part of the role
$pin_icon = '<svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 18s6-5.2 6-10a6 6 0 0 0-12 0c0 4.8 6 10 6 10z"/><circle cx="10" cy="8" r="2.2"/></svg>';

// "Tap to open" hint shown above both speaker groups
$hint_pill = 'ml-auto inline-flex items-center gap-2 rounded-full border border-gyc-mint/60 py-1 pl-1 pr-3.5 font-jakarta text-xs';
$hint_circle = '<span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-gyc-mint text-gyc-plum" aria-hidden="true">' . $plus_icon . '</span>';
?>
<section
    id="speakers"
    class="scroll-mt-8 bg-gyc-mist text-gyc-plum py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-people-title"<?php endif; ?>
    x-data="gycPeople"
    @keydown.escape.window="close()"
    @keydown.arrow-left.window="step(-1)"
    @keydown.arrow-right.window="step(1)">
    <script type="application/json" x-ref="data"><?php echo wp_json_encode($people, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?></script>

    <div class="max-w-content mx-auto px-6 md:px-12">
        <?php if ($title || $text || count($main) > 0): ?>
            <div class="flex flex-wrap items-end justify-between gap-x-8 gap-y-6">
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
                    <p class="<?php echo esc_attr($hint_pill); ?> bg-gyc-plum-light text-white/90">
                        <?php echo $hint_circle; ?>
                        <?php esc_html_e('Tap a speaker to get to know them', 'gyc'); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (count($main) > 0): ?>
            <ul class="mt-10 grid <?php echo esc_attr($main_grid); ?>" role="list">
                <?php foreach ($main as $person): ?>
                    <?php $subtitle = !empty($person['role']) ? $person['role'] : (empty($person['headline']) ? '' : $person['headline']); ?>
                    <li>
                        <!-- Only the photo card opens the bio; the name below just follows its hover with an underline -->
                        <button
                            type="button"
                            class="group peer relative block w-full <?php echo esc_attr($main_photo); ?> cursor-pointer overflow-hidden rounded-2xl bg-gyc-plum-mid focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-plum"
                            data-person="<?php echo esc_attr((string) $person['index']); ?>"
                            aria-haspopup="dialog"
                            aria-label="<?php echo esc_attr(sprintf(__('Meet %s', 'gyc'), $person['name'])); ?>"
                            @click="open(Number($event.currentTarget.dataset.person), $event.currentTarget)">
                            <!-- The card keeps its size; only the picture inside zooms in a little -->
                            <span class="absolute inset-0 motion-safe:transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] group-hover:scale-[1.03] group-focus-visible:scale-[1.03]">
                                <?php if (!empty($person['photo'])): ?>
                                    <img class="absolute inset-0 h-full w-full object-cover object-top" src="<?php echo esc_url($person['photo']); ?>" alt="" loading="lazy" decoding="async" draggable="false" />
                                <?php else: ?>
                                    <svg class="absolute inset-x-0 bottom-0 mx-auto h-3/4 text-white/10" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <circle cx="12" cy="8" r="4.5"/>
                                        <path d="M3 24c0-5.5 4-9.5 9-9.5s9 4 9 9.5z"/>
                                    </svg>
                                <?php endif; ?>
                            </span>

                            <!-- On hover: mint border, darker bottom, and the "+" turns into a "Meet …" label -->
                            <span class="absolute inset-0 rounded-2xl bg-linear-to-b from-transparent from-40% to-gyc-plum/90 opacity-0 motion-safe:transition-opacity duration-500 ease-out group-hover:opacity-100 group-focus-visible:opacity-100" aria-hidden="true"></span>
                            <span class="absolute inset-0 rounded-2xl ring-3 ring-inset ring-transparent motion-safe:transition-shadow duration-500 ease-out group-hover:ring-gyc-mint group-focus-visible:ring-gyc-mint" aria-hidden="true"></span>
                            <span class="absolute right-5 bottom-5 md:right-6 md:bottom-6 flex h-10 w-10 md:h-11 md:w-11 items-center justify-center rounded-full bg-gyc-mint text-gyc-plum motion-safe:transition duration-300 group-hover:rotate-90 group-hover:scale-60 group-hover:opacity-0 group-focus-visible:rotate-90 group-focus-visible:scale-60 group-focus-visible:opacity-0" aria-hidden="true"><?php echo $plus_icon; ?></span>
                            <span class="absolute left-5 bottom-5 md:left-6 md:bottom-6 max-w-[calc(100%-2.5rem)] md:max-w-[calc(100%-3rem)] truncate rounded-full bg-gyc-mint px-4 py-2.5 font-jakarta text-sm font-semibold text-gyc-plum opacity-0 translate-y-2 motion-safe:transition duration-300 group-hover:opacity-100 group-hover:translate-y-0 group-focus-visible:opacity-100 group-focus-visible:translate-y-0" aria-hidden="true">
                                <?php echo esc_html(sprintf(__('Meet %s', 'gyc'), $person['name'])); ?> &rarr;
                            </span>
                        </button>
                        <p class="relative mt-4 inline-block pb-1 font-display small-caps <?php echo esc_attr($main_name); ?> leading-tight after:absolute after:left-0 after:bottom-0 after:h-1 after:w-0 after:rounded-full after:bg-gyc-mint motion-safe:after:transition-[width] after:duration-300 peer-hover:after:w-16 peer-focus-visible:after:w-16"><?php echo esc_html($person['name']); ?></p>
                        <?php if ($subtitle): ?>
                            <p class="mt-1 font-jakarta <?php echo esc_attr($main_role); ?> text-gyc-plum/75"><?php echo esc_html($subtitle); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($person['country'])): ?>
                            <p class="mt-2 flex items-center gap-1.5 font-jakarta <?php echo esc_attr($main_country); ?> font-semibold text-gyc-plum"><?php echo $pin_icon; ?><?php echo esc_html($person['country']); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (count($staff) > 0): ?>
            <div class="<?php echo ($title || $text || count($main) > 0) ? 'mt-12 ' : ''; ?>rounded-2xl border border-gyc-plum/10 bg-white/40 p-6 md:p-8">
                <?php $staff_has_bio = count(array_filter($staff, fn($p) => $p['index'] !== null)) > 0; ?>
                <?php if ($staff_title || $staff_has_bio): ?>
                    <div class="flex flex-wrap items-center justify-between gap-x-6 gap-y-3">
                        <?php if ($staff_title): ?>
                            <h3 class="font-display small-caps text-xl leading-tight"><?php echo esc_html($staff_title); ?></h3>
                        <?php endif; ?>
                        <?php if ($staff_has_bio): ?>
                            <p class="<?php echo esc_attr($hint_pill); ?> bg-gyc-plum/5 text-gyc-plum/75">
                                <?php echo $hint_circle; ?>
                                <?php esc_html_e('Tap a name to read their bio', 'gyc'); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <ul class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-4 text-center" role="list">
                    <?php foreach ($staff as $person): ?>
                        <?php $has_bio = $person['index'] !== null; ?>
                        <li>
                            <?php if ($has_bio): ?>
                                <button
                                    type="button"
                                    class="group flex w-full cursor-pointer flex-col items-center rounded-2xl px-1.5 py-3 motion-safe:transition-colors hover:bg-white focus-visible:bg-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-plum"
                                    data-person="<?php echo esc_attr((string) $person['index']); ?>"
                                    aria-haspopup="dialog"
                                    @click="open(Number($event.currentTarget.dataset.person), $event.currentTarget)">
                            <?php else: ?>
                                <div class="flex flex-col items-center px-1.5 py-3">
                            <?php endif; ?>
                                <span class="relative">
                                    <?php if (!empty($person['photo'])): ?>
                                        <img class="h-25 w-25 lg:h-31.25 lg:w-31.25 rounded-full object-cover" src="<?php echo esc_url($person['photo']); ?>" alt="" loading="lazy" decoding="async" draggable="false" />
                                    <?php else: ?>
                                        <span class="flex h-25 w-25 lg:h-31.25 lg:w-31.25 items-center justify-center rounded-full bg-gyc-plum/10 font-jakarta text-base font-semibold text-gyc-plum" aria-hidden="true"><?php echo esc_html($initials($person['name'])); ?></span>
                                    <?php endif; ?>
                                    <?php if ($has_bio): ?>
                                        <span class="absolute right-0.5 bottom-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-gyc-mint text-gyc-plum ring-3 ring-gyc-mist motion-safe:transition-transform duration-200 group-hover:scale-115 group-focus-visible:scale-115" aria-hidden="true"><?php echo $plus_icon; ?></span>
                                    <?php endif; ?>
                                </span>
                                <span class="mt-3 font-jakarta text-sm font-medium decoration-gyc-mint decoration-2 underline-offset-4 group-hover:underline group-focus-visible:underline"><?php echo esc_html($person['name']); ?></span>
                                <?php if (!empty($person['role'])): ?>
                                    <span class="mt-0.5 lg:max-w-[85%] font-jakarta text-xs text-gyc-plum/75"><?php echo esc_html($person['role']); ?></span>
                                <?php endif; ?>
                            <?php if ($has_bio): ?>
                                </button>
                            <?php else: ?>
                                </div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <?php if (count($people) > 0): ?>
        <!-- One bio pop-up for every speaker, filled in from the list above -->
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-6"
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            style="display: none;">
            <div class="absolute inset-0 bg-gyc-plum/70 backdrop-blur-sm" @click="close()" aria-hidden="true"></div>

            <div
                x-ref="dialog"
                class="relative flex max-h-[calc(100dvh-2rem)] w-full max-w-5xl flex-col gap-6 overflow-y-auto rounded-[1.75rem] bg-gyc-plum-mid p-6 text-gyc-ivory shadow-2xl md:max-h-[calc(100dvh-3rem)] md:flex-row md:items-center md:gap-12 md:p-10"
                role="dialog"
                aria-modal="true"
                aria-labelledby="gyc-people-modal-name"
                tabindex="-1"
                @keydown.tab="trapFocus($event)"
                @touchstart.passive="swipeStart($event)"
                @touchend="swipeEnd($event)">
                <button
                    type="button"
                    x-ref="close"
                    class="absolute top-4 right-4 z-10 flex h-11 w-11 cursor-pointer items-center justify-center rounded-full bg-gyc-ivory/10 text-gyc-ivory motion-safe:transition-colors hover:bg-gyc-ivory/25 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-mint md:top-6 md:right-6"
                    @click="close()"
                    aria-label="<?php esc_attr_e('Close', 'gyc'); ?>">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" aria-hidden="true"><path d="M5 5l10 10M15 5L5 15"/></svg>
                </button>

                <div class="relative aspect-[4/3] w-full shrink-0 overflow-hidden rounded-2xl bg-gyc-plum-light md:aspect-[8/9] md:w-80">
                    <img
                        class="absolute inset-0 h-full w-full object-cover object-top"
                        x-show="current.photo"
                        :src="current.photo || ''"
                        alt=""
                        decoding="async"
                        draggable="false" />
                    <span
                        class="absolute inset-0 flex items-center justify-center font-display text-7xl text-gyc-ivory/30"
                        x-show="!current.photo"
                        x-text="current.initials"
                        aria-hidden="true"></span>
                </div>

                <div class="min-w-0 flex-1 md:pr-10">
                    <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-mint" x-text="current.type"></p>
                    <h3 id="gyc-people-modal-name" class="mt-3 font-display small-caps text-4xl md:text-5xl leading-none break-words" x-text="current.name" aria-live="polite"></h3>
                    <!-- Same order for every speaker: type, name, role, bio, then their talks or workshops with day and time -->
                    <p class="mt-5 font-jakarta text-base font-semibold text-gyc-ivory" x-show="current.role" x-text="current.role"></p>
                    <p class="mt-2 flex items-center gap-1.5 font-jakarta text-sm font-semibold text-gyc-mint" x-show="current.country"><?php echo $pin_icon; ?><span x-text="current.country"></span></p>
                    <p class="mt-4 font-jakarta text-base leading-relaxed text-gyc-ivory/85 whitespace-pre-line" x-show="current.description" x-text="current.description"></p>
                    <ul class="mt-5 flex flex-col items-start gap-2.5" role="list" x-show="hasLabels">
                        <!-- Title and its day and time share one pill, split by a thin line, so they read as a pair -->
                        <template x-for="(label, n) in current.labels" :key="n">
                            <li class="flex max-w-full items-stretch overflow-hidden rounded-3xl border border-gyc-ivory/35 font-jakarta text-sm font-semibold">
                                <span class="px-4 py-2" x-show="label.title" x-text="label.title"></span>
                                <span class="flex items-center gap-1.5 border-l border-gyc-ivory/35 bg-gyc-ivory/5 px-4 py-2 text-gyc-mint whitespace-nowrap" :class="label.title ? '' : 'border-l-0'" x-show="label.time">
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="10" cy="10" r="7.5"/><path d="M10 6v4l2.5 2"/></svg>
                                    <span x-text="label.time"></span>
                                </span>
                            </li>
                        </template>
                    </ul>

                    <!-- Step through speakers without closing; arrow keys and swiping do the same -->
                    <div class="mt-8 flex items-center gap-3" x-show="hasMany">
                        <button
                            type="button"
                            class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-gyc-ivory/35 motion-safe:transition-colors hover:border-gyc-mint hover:bg-gyc-mint hover:text-gyc-plum focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-mint"
                            @click="step(-1)"
                            aria-label="<?php esc_attr_e('Previous speaker', 'gyc'); ?>">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M11 18l-6-6 6-6"/></svg>
                        </button>
                        <span class="min-w-14 text-center font-jakarta text-sm tabular-nums text-gyc-ivory/75" x-text="position"></span>
                        <button
                            type="button"
                            class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-gyc-ivory/35 motion-safe:transition-colors hover:border-gyc-mint hover:bg-gyc-mint hover:text-gyc-plum focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-mint"
                            @click="step(1)"
                            aria-label="<?php esc_attr_e('Next speaker', 'gyc'); ?>">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
