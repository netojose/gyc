<?php
$title = empty($attributes['title']) ? null : $attributes['title'];
$cards = empty($attributes['cards']) ? array() : $attributes['cards'];
$socials = empty($attributes['socials']) ? array() : $attributes['socials'];
$form_title = empty($attributes['formTitle']) ? null : $attributes['formTitle'];
$form_text = empty($attributes['formText']) ? null : $attributes['formText'];
$recipient = empty($attributes['recipient']) ? '' : sanitize_email($attributes['recipient']);
$button_label = empty($attributes['buttonLabel']) ? 'Send message' : $attributes['buttonLabel'];
$note = empty($attributes['note']) ? null : $attributes['note'];
$success_message = empty($attributes['successMessage']) ? 'Thank you! Your message has been sent.' : $attributes['successMessage'];

$topics = empty($attributes['topics']) ? array() : array_values(array_filter(array_map('trim', explode("\n", $attributes['topics']))));

$icons = array(
    'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3.5 6.5 12 13l8.5-6.5"/>',
    'chat' => '<path d="M20 15a2 2 0 0 1-2 2H8l-4 4V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2z"/>',
    'location' => '<path d="M12 21s-7-6.1-7-11.5a7 7 0 0 1 14 0C19 14.9 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
    'phone' => '<path d="M5 3h3.5l1.5 5-2.2 1.4a11 11 0 0 0 6.8 6.8L16 14l5 1.5V19a2 2 0 0 1-2 2A16 16 0 0 1 3 5a2 2 0 0 1 2-2z"/>',
);

$social_names = array(
    'instagram' => 'Instagram',
    'youtube' => 'YouTube',
    'facebook' => 'Facebook',
    'tiktok' => 'TikTok',
);
$social_icons = array(
    'instagram' => '<path d="M17 2H7a5 5 0 0 0-5 5v10a5 5 0 0 0 5 5h10a5 5 0 0 0 5-5V7a5 5 0 0 0-5-5zm-5 15a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm5.5-9.5a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>',
    'youtube' => '<path d="M21.6 7.2a2.5 2.5 0 0 0-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.8 1.8c1.6.4 7.8.4 7.8.4s6.2 0 7.8-.4a2.5 2.5 0 0 0 1.8-1.8A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8zM10 15V9l5.2 3z"/>',
    'facebook' => '<path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12z"/>',
    'tiktok' => '<path d="M16.6 5.8A4.3 4.3 0 0 1 15.5 3h-3.1v12.4a2.6 2.6 0 1 1-2.6-2.6c.3 0 .5 0 .8.1V9.7a5.7 5.7 0 1 0 4.9 5.7V9a7.4 7.4 0 0 0 4.3 1.4V7.3a4.3 4.3 0 0 1-3.2-1.5z"/>',
);

$cards = array_filter($cards, function ($card) {
    return !empty($card['title']) || !empty($card['text']);
});
$socials = array_filter($socials, function ($social) use ($social_icons) {
    return !empty($social['url']) && !empty($social['network']) && isset($social_icons[$social['network']]);
});

$status = GycContact::status();
$status_messages = array(
    'sent' => $success_message,
    'invalid' => 'Please fill in your first name, a valid email address and a message, then try again.',
    'expired' => 'The form expired. Please send your message again.',
    'wait' => 'Please wait a minute before sending another message.',
    'failed' => 'Your message could not be sent. Please try again later or email us directly.',
);

$label_class = 'block font-jakarta text-xs font-medium text-gyc-ink mb-2';
$input_class = 'block w-full rounded-xl border border-gyc-ink/15 bg-white px-4 py-3 font-jakarta text-sm text-gyc-ink placeholder:text-gyc-ink/40 focus:border-gyc-teal focus:outline-2 focus:outline-offset-0 focus:outline-gyc-teal';
?>
<section
    class="bg-gyc-cream text-gyc-ink py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-contact-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
        <div class="lg:pt-10 space-y-8">
            <?php if ($title): ?>
                <h2 id="gyc-contact-title" class="max-w-md font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if (count($cards) > 0): ?>
                <ul class="max-w-lg space-y-3" role="list">
                    <?php foreach ($cards as $card): ?>
                        <?php $link_url = empty($card['linkUrl']) ? null : GycUI::resolve_url($card['linkUrl'], false); ?>
                        <li class="flex gap-4 rounded-2xl border border-gyc-ink/10 bg-white p-5">
                            <?php if (!empty($card['icon']) && isset($icons[$card['icon']])): ?>
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gyc-mint/20 text-gyc-teal" aria-hidden="true">
                                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><?php echo $icons[$card['icon']]; ?></svg>
                                </span>
                            <?php endif; ?>
                            <div class="min-w-0 space-y-1">
                                <?php if (!empty($card['title'])): ?>
                                    <h3 class="font-display small-caps text-lg leading-tight"><?php echo esc_html($card['title']); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($card['text'])): ?>
                                    <p class="font-jakarta text-sm leading-relaxed text-gyc-ink/80"><?php echo esc_html($card['text']); ?></p>
                                <?php endif; ?>
                                <?php if ($link_url && !empty($card['linkLabel'])): ?>
                                    <a href="<?php echo esc_url($link_url); ?>" class="inline-block break-all font-jakarta text-sm font-semibold text-gyc-teal underline decoration-transparent hover:decoration-current motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal"><?php echo esc_html($card['linkLabel']); ?></a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if (count($socials) > 0): ?>
                <ul class="max-w-lg flex items-center justify-center gap-5 text-gyc-ink" role="list">
                    <?php foreach ($socials as $social): ?>
                        <li>
                            <a href="<?php echo esc_url(GycUI::resolve_url($social['url'])); ?>" class="block h-7 w-7 rounded motion-safe:transition-colors hover:text-gyc-teal focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal" aria-label="<?php echo esc_attr($social_names[$social['network']]); ?>">
                                <svg class="h-full w-full" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><?php echo $social_icons[$social['network']]; ?></svg>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div id="contact-form" class="scroll-mt-8 rounded-3xl border border-gyc-ink/10 bg-white p-6 md:p-8">
            <?php if ($form_title): ?>
                <h2 id="gyc-contact-form-title" class="font-display small-caps text-2xl leading-none"><?php echo esc_html($form_title); ?></h2>
            <?php endif; ?>
            <?php if ($form_text): ?>
                <p class="mt-2 font-jakarta text-sm text-gyc-ink/75"><?php echo esc_html($form_text); ?></p>
            <?php endif; ?>

            <?php if ($status): ?>
                <p
                    role="<?php echo $status === 'sent' ? 'status' : 'alert'; ?>"
                    class="mt-6 rounded-xl px-4 py-3 font-jakarta text-sm <?php echo $status === 'sent' ? 'bg-gyc-mint/20 text-gyc-teal-dark' : 'bg-red-50 text-red-800'; ?>">
                    <?php echo esc_html($status_messages[$status]); ?>
                </p>
            <?php endif; ?>

            <?php if ($recipient): ?>
                <form class="mt-6 space-y-5" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                    <input type="hidden" name="action" value="<?php echo esc_attr(GycContact::ACTION); ?>" />
                    <input type="hidden" name="to" value="<?php echo esc_attr($recipient); ?>" />
                    <input type="hidden" name="to_signature" value="<?php echo esc_attr(GycContact::signature($recipient)); ?>" />
                    <?php wp_nonce_field(GycContact::ACTION, GycContact::NONCE_FIELD); ?>

                    <!-- Left empty by people; bots that fill it in are ignored -->
                    <div class="hidden" aria-hidden="true">
                        <label for="gyc-contact-website">Website</label>
                        <input id="gyc-contact-website" type="text" name="website" tabindex="-1" autocomplete="off" />
                    </div>

                    <?php if (count($topics) > 0): ?>
                        <fieldset>
                            <legend class="sr-only">What is your message about?</legend>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($topics as $index => $topic): ?>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="topic" value="<?php echo esc_attr($topic); ?>" class="peer sr-only" <?php checked($index, 0); ?> />
                                        <span class="block rounded-full border border-gyc-ink/15 px-3.5 py-2 font-jakarta text-xs text-gyc-ink motion-safe:transition-colors hover:border-gyc-teal peer-checked:border-gyc-teal peer-checked:bg-gyc-mint/20 peer-checked:text-gyc-teal-dark peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-gyc-teal"><?php echo esc_html($topic); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </fieldset>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="gyc-contact-first-name" class="<?php echo esc_attr($label_class); ?>">First name</label>
                            <input id="gyc-contact-first-name" type="text" name="first_name" required maxlength="100" autocomplete="given-name" placeholder="Anna" class="<?php echo esc_attr($input_class); ?>" />
                        </div>
                        <div>
                            <label for="gyc-contact-last-name" class="<?php echo esc_attr($label_class); ?>">Last name</label>
                            <input id="gyc-contact-last-name" type="text" name="last_name" maxlength="100" autocomplete="family-name" placeholder="Kowalska" class="<?php echo esc_attr($input_class); ?>" />
                        </div>
                    </div>

                    <div>
                        <label for="gyc-contact-email" class="<?php echo esc_attr($label_class); ?>">Email</label>
                        <input id="gyc-contact-email" type="email" name="email" required maxlength="200" autocomplete="email" placeholder="anna@email.com" class="<?php echo esc_attr($input_class); ?>" />
                    </div>

                    <div>
                        <label for="gyc-contact-message" class="<?php echo esc_attr($label_class); ?>">Message</label>
                        <textarea id="gyc-contact-message" name="message" required maxlength="5000" rows="5" placeholder="Write your message" class="<?php echo esc_attr($input_class); ?> resize-y"></textarea>
                    </div>

                    <div class="pt-2 space-y-3">
                        <button
                            type="submit"
                            class="w-full rounded-full bg-gyc-teal px-6 py-4 font-jakarta text-sm font-semibold text-white motion-safe:transition-colors hover:bg-gyc-teal-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                            <?php echo esc_html($button_label); ?>
                        </button>
                        <?php if ($note): ?>
                            <p class="text-center font-jakarta text-xs text-gyc-ink/70"><?php echo esc_html($note); ?></p>
                        <?php endif; ?>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>
