<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$members = empty($attributes['members']) ? array() : $attributes['members'];

$members = array_values(array_filter($members, function ($member) {
    return !empty($member['name']);
}));
?>
<section
    class="bg-gyc-cream text-gyc-ink py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-committee-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12">
        <div class="max-w-xl space-y-5">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/80"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-committee-title" class="font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="font-jakarta text-sm md:text-base leading-relaxed text-gyc-ink/80"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if (count($members) > 0): ?>
            <ul class="mt-10 md:mt-12 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-10" role="list">
                <?php foreach ($members as $member): ?>
                    <?php
                    $email = empty($member['email']) ? null : sanitize_email($member['email']);
                    $handle = empty($member['instagram']) ? null : ltrim(trim($member['instagram']), '@');
                    ?>
                    <li>
                        <div class="relative aspect-square overflow-hidden rounded-2xl bg-gyc-ink/5">
                            <?php if (!empty($member['photo'])): ?>
                                <!-- The name below identifies the person, so the photo needs no alt text -->
                                <img
                                    class="absolute inset-0 h-full w-full object-cover"
                                    src="<?php echo esc_url($member['photo']); ?>"
                                    alt=""
                                    loading="lazy"
                                    decoding="async"
                                    draggable="false" />
                            <?php else: ?>
                                <svg class="absolute inset-x-0 bottom-0 mx-auto h-3/4 text-gyc-ink/10" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <circle cx="12" cy="8" r="4.5"/>
                                    <path d="M3 24c0-5.5 4-9.5 9-9.5s9 4 9 9.5z"/>
                                </svg>
                            <?php endif; ?>
                        </div>

                        <h3 class="mt-4 font-display small-caps text-lg leading-tight"><?php echo esc_html($member['name']); ?></h3>
                        <?php if (!empty($member['role'])): ?>
                            <p class="mt-1 font-jakarta text-xs font-semibold text-gyc-teal"><?php echo esc_html($member['role']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($member['country'])): ?>
                            <p class="mt-1 font-jakarta text-xs text-gyc-ink/75"><?php echo esc_html($member['country']); ?></p>
                        <?php endif; ?>

                        <?php if ($email || $handle): ?>
                            <ul class="mt-3 space-y-1.5 font-jakarta text-xs text-gyc-ink/75" role="list">
                                <?php if ($email): ?>
                                    <li>
                                        <a href="<?php echo esc_url('mailto:' . $email); ?>" class="inline-flex max-w-full items-center gap-2 rounded-sm hover:text-gyc-teal underline decoration-transparent hover:decoration-current motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal">
                                            <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="3" y="5" width="18" height="14" rx="1.5"/>
                                                <path d="M3.5 6l8.5 7 8.5-7"/>
                                            </svg>
                                            <span class="sr-only">Email:</span>
                                            <span class="truncate"><?php echo esc_html($email); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($handle): ?>
                                    <li>
                                        <a href="<?php echo esc_url('https://www.instagram.com/' . rawurlencode($handle) . '/'); ?>" class="inline-flex max-w-full items-center gap-2 rounded-sm hover:text-gyc-teal underline decoration-transparent hover:decoration-current motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal">
                                            <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="3" y="3" width="18" height="18" rx="5"/>
                                                <circle cx="12" cy="12" r="4"/>
                                                <circle cx="17.5" cy="6.5" r="0.8" fill="currentColor"/>
                                            </svg>
                                            <span class="sr-only">Instagram:</span>
                                            <span class="truncate">@<?php echo esc_html($handle); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
