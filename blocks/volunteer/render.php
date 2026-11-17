<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$areas = empty($attributes['areas']) ? array() : $attributes['areas'];
$form_title = empty($attributes['formTitle']) ? null : $attributes['formTitle'];
$consent = empty($attributes['consent']) ? 'I agree that my details may be stored and used to contact me about volunteering.' : $attributes['consent'];
$recipient = GycVolunteer::recipient($attributes);
$button_label = empty($attributes['buttonLabel']) ? 'Send application' : $attributes['buttonLabel'];
$success_message = empty($attributes['successMessage']) ? 'Thank you for signing up!' : $attributes['successMessage'];

// A form from a plugin shortcode replaces the built-in form, but only when the field holds exactly one
// self-contained shortcode that is registered. Any other text is ignored, so nothing typed around the
// shortcode reaches the page and visitors never see the raw [shortcode] text
$form_shortcode = empty($attributes['formShortcode']) ? '' : trim($attributes['formShortcode']);
$use_shortcode = preg_match('/^\[([\w-]+)(\s[^\[\]<>]*)?\]$/', $form_shortcode, $shortcode_match) && shortcode_exists($shortcode_match[1]);

$skills = empty($attributes['skills']) ? array() : array_values(array_unique(array_filter(array_map('trim', explode("\n", $attributes['skills'])))));

$areas = array_filter($areas, function ($area) {
    return !empty($area['title']) || !empty($area['text']);
});

$status = GycVolunteer::status();
$status_messages = array(
    'sent' => $success_message,
    'invalid' => sprintf('Please fill in every field marked with *, choose at least one skill, enter an age between %d and %d and tick the agreement, then try again.', GycVolunteer::MIN_AGE, GycVolunteer::MAX_AGE),
    'expired' => 'The form expired. Please send your application again.',
    'wait' => 'Please wait a minute before sending another application.',
    'failed' => 'Your application could not be sent. Please try again later or email us directly.',
);

$label_class = 'block font-jakarta text-xs font-semibold text-gyc-ink mb-2';
$input_class = 'block w-full rounded-xl border border-gyc-ink/15 bg-white px-4 py-3 font-jakarta text-sm text-gyc-ink placeholder:text-gyc-ink/40 focus:border-gyc-teal focus:outline-2 focus:outline-offset-0 focus:outline-gyc-teal';
$required_mark = '<span class="text-gyc-ink/60" aria-hidden="true"> *</span>';
?>
<section
    class="bg-gyc-cream text-gyc-ink py-16 md:py-24"
    <?php if ($title): ?>aria-labelledby="gyc-volunteer-title"<?php endif; ?>>
    <div class="max-w-content mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
        <div class="lg:pt-10 space-y-6">
            <?php if ($eyebrow): ?>
                <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-teal"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 id="gyc-volunteer-title" class="max-w-md font-display small-caps text-4xl md:text-5xl leading-none"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text): ?>
                <p class="max-w-md font-jakarta text-sm md:text-base leading-relaxed text-gyc-ink/75"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if (count($areas) > 0): ?>
                <ul class="max-w-md pt-2" role="list">
                    <?php foreach ($areas as $area): ?>
                        <li class="flex gap-3 border-b border-gyc-ink/10 py-4">
                            <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-gyc-aqua/30 text-gyc-teal" aria-hidden="true">
                                <svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7"/></svg>
                            </span>
                            <div class="min-w-0 space-y-0.5">
                                <?php if (!empty($area['title'])): ?>
                                    <h3 class="font-jakarta text-sm font-semibold"><?php echo esc_html($area['title']); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($area['text'])): ?>
                                    <p class="font-jakarta text-xs leading-relaxed text-gyc-ink/70"><?php echo esc_html($area['text']); ?></p>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div id="volunteer-form" class="scroll-mt-8 rounded-3xl border border-gyc-ink/10 bg-white p-6 md:p-8 shadow-sm">
            <?php if ($form_title): ?>
                <h2 id="gyc-volunteer-form-title" class="font-display small-caps text-2xl md:text-3xl leading-none"><?php echo esc_html($form_title); ?></h2>
            <?php endif; ?>

            <?php if ($use_shortcode): ?>
                <div class="mt-6 font-jakarta text-sm text-gyc-ink">
                    <?php echo do_shortcode($form_shortcode); ?>
                </div>
            <?php else: ?>

            <?php if ($status): ?>
                <p
                    role="<?php echo $status === 'sent' ? 'status' : 'alert'; ?>"
                    class="mt-6 rounded-xl px-4 py-3 font-jakarta text-sm <?php echo $status === 'sent' ? 'bg-gyc-aqua/20 text-gyc-teal-dark' : 'bg-red-50 text-red-800'; ?>">
                    <?php echo esc_html($status_messages[$status]); ?>
                </p>
            <?php endif; ?>

            <form
                class="mt-6 space-y-5"
                action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
                method="post"
                <?php if ($form_title): ?>aria-labelledby="gyc-volunteer-form-title"<?php endif; ?>
                x-data="{ skills: 0, skillsError: false }"
                @submit="if (!skills) { $event.preventDefault(); skillsError = true; $refs.skills.querySelector('input').focus(); }">
                <input type="hidden" name="action" value="<?php echo esc_attr(GycVolunteer::ACTION); ?>" />
                <input type="hidden" name="to" value="<?php echo esc_attr($recipient); ?>" />
                <input type="hidden" name="to_signature" value="<?php echo esc_attr(GycVolunteer::signature($recipient)); ?>" />
                <?php wp_nonce_field(GycVolunteer::ACTION, GycVolunteer::NONCE_FIELD); ?>

                <!-- Left empty by people; bots that fill it in are ignored -->
                <div class="hidden" aria-hidden="true">
                    <label for="gyc-volunteer-website">Website</label>
                    <input id="gyc-volunteer-website" type="text" name="website" tabindex="-1" autocomplete="off" />
                </div>

                <div>
                    <label for="gyc-volunteer-name" class="<?php echo esc_attr($label_class); ?>">Full name<?php echo $required_mark; ?></label>
                    <input id="gyc-volunteer-name" type="text" name="full_name" required maxlength="200" autocomplete="name" placeholder="Your full name" class="<?php echo esc_attr($input_class); ?>" />
                </div>

                <div>
                    <label for="gyc-volunteer-email" class="<?php echo esc_attr($label_class); ?>">Email<?php echo $required_mark; ?></label>
                    <input id="gyc-volunteer-email" type="email" name="email" required maxlength="200" autocomplete="email" placeholder="you@example.com" class="<?php echo esc_attr($input_class); ?>" />
                </div>

                <div class="grid grid-cols-[1fr_6.5rem] sm:grid-cols-[1fr_8rem] gap-3">
                    <div>
                        <label for="gyc-volunteer-country" class="<?php echo esc_attr($label_class); ?>">Country<?php echo $required_mark; ?></label>
                        <input id="gyc-volunteer-country" type="text" name="country" required maxlength="100" autocomplete="country-name" placeholder="Where do you live?" class="<?php echo esc_attr($input_class); ?>" />
                    </div>
                    <div>
                        <label for="gyc-volunteer-age" class="<?php echo esc_attr($label_class); ?>">Age<?php echo $required_mark; ?></label>
                        <input id="gyc-volunteer-age" type="number" name="age" required min="<?php echo esc_attr(GycVolunteer::MIN_AGE); ?>" max="<?php echo esc_attr(GycVolunteer::MAX_AGE); ?>" step="1" inputmode="numeric" placeholder="Age" class="<?php echo esc_attr($input_class); ?>" />
                    </div>
                </div>

                <div>
                    <label for="gyc-volunteer-church" class="<?php echo esc_attr($label_class); ?>">Church membership<?php echo $required_mark; ?></label>
                    <input id="gyc-volunteer-church" type="text" name="church" required maxlength="200" placeholder="Name of the church you attend" class="<?php echo esc_attr($input_class); ?>" />
                </div>

                <fieldset aria-describedby="gyc-volunteer-skills-error">
                    <legend class="<?php echo esc_attr($label_class); ?>">Skills<?php echo $required_mark; ?> <span class="sr-only">(choose at least one)</span></legend>
                    <?php if (count($skills) > 0): ?>
                        <div x-ref="skills" class="flex flex-wrap gap-2">
                            <?php foreach ($skills as $skill): ?>
                                <label class="cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="skills[]"
                                        value="<?php echo esc_attr($skill); ?>"
                                        class="peer sr-only"
                                        @change="skills += $event.target.checked ? 1 : -1; if (skills) skillsError = false" />
                                    <span class="block rounded-full border border-gyc-ink/15 px-3.5 py-2 font-jakarta text-xs text-gyc-ink motion-safe:transition-colors hover:border-gyc-ink/40 peer-checked:border-gyc-ink peer-checked:bg-gyc-ink peer-checked:text-white peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-gyc-teal"><?php echo esc_html($skill); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <p id="gyc-volunteer-skills-error" x-show="skillsError" x-cloak class="mt-2 font-jakarta text-xs text-red-700">Please choose at least one skill.</p>

                    <label for="gyc-volunteer-details" class="sr-only">More about your skills and experience (optional)</label>
                    <textarea id="gyc-volunteer-details" name="details" maxlength="5000" rows="4" placeholder="Tell us more about your skills and experience (optional)" class="<?php echo esc_attr($input_class); ?> mt-3 resize-y"></textarea>
                </fieldset>

                <div class="flex items-start gap-3">
                    <input id="gyc-volunteer-consent" type="checkbox" name="consent" value="1" required class="mt-0.5 h-4 w-4 shrink-0 rounded border-gyc-ink/30 accent-gyc-ink focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gyc-teal" />
                    <label for="gyc-volunteer-consent" class="font-jakarta text-xs leading-relaxed text-gyc-ink/75"><?php echo esc_html($consent); ?></label>
                </div>

                <div class="pt-1">
                    <button
                        type="submit"
                        class="rounded-full bg-gyc-ink px-7 py-3.5 font-jakarta text-sm font-semibold text-white motion-safe:transition-colors hover:bg-gyc-night focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-ink">
                        <?php echo esc_html($button_label); ?>
                    </button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</section>
