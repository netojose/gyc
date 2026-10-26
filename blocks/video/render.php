<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$link_label = empty($attributes['linkLabel']) ? null : $attributes['linkLabel'];
$link_url = empty($attributes['linkUrl']) ? null : GycUI::resolve_url($attributes['linkUrl']);
// Links to other websites, such as the YouTube channel, open in a new tab.
$link_is_external = $link_url && preg_match('~^https?://~i', $link_url) && wp_parse_url($link_url, PHP_URL_HOST) !== wp_parse_url(home_url(), PHP_URL_HOST);
$video_url = empty($attributes['videoUrl']) ? null : $attributes['videoUrl'];
$poster = empty($attributes['poster']) ? null : $attributes['poster'];
$poster_alt = empty($attributes['posterAlt']) ? '' : $attributes['posterAlt'];

// YouTube and Vimeo links are played through their embed player, anything else as a video file.
$embed_url = null;
if ($video_url) {
    if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/))([\w-]{11})~', $video_url, $matches)) {
        $embed_url = 'https://www.youtube-nocookie.com/embed/' . $matches[1] . '?autoplay=1&rel=0';
    } elseif (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $video_url, $matches)) {
        $embed_url = 'https://player.vimeo.com/video/' . $matches[1] . '?autoplay=1';
    }
}
$player_label = $title ? sprintf('Play video: %s', $title) : 'Play video';
?>
<section
    class="bg-white text-gyc-ink"
    <?php if ($title): ?>aria-labelledby="gyc-video-title"<?php endif; ?>
    x-data="{ playing: false, play() { this.playing = true; this.$nextTick(function () { if (this.$refs.player) { this.$refs.player.focus(); } }.bind(this)); } }">
    <div class="max-w-content mx-auto md:px-12 grid grid-cols-1 lg:grid-cols-12">
        <div class="relative lg:col-span-7 aspect-video bg-[#0a1433] overflow-hidden">
            <?php if ($video_url): ?>
                <template x-if="playing">
                    <?php if ($embed_url): ?>
                        <iframe
                            x-ref="player"
                            class="absolute inset-0 h-full w-full"
                            src="<?php echo esc_url($embed_url); ?>"
                            title="<?php echo esc_attr($title ? $title : 'Video'); ?>"
                            allow="autoplay; encrypted-media; picture-in-picture; fullscreen"
                            allowfullscreen></iframe>
                    <?php else: ?>
                        <video
                            x-ref="player"
                            class="absolute inset-0 h-full w-full bg-black object-contain"
                            src="<?php echo esc_url($video_url); ?>"
                            controls
                            autoplay
                            playsinline></video>
                    <?php endif; ?>
                </template>
            <?php endif; ?>

            <<?php echo $video_url ? 'a' : 'div'; ?>
                <?php if ($video_url): ?>
                    href="<?php echo esc_url($video_url); ?>"
                    aria-label="<?php echo esc_attr($player_label); ?>"
                    @click.prevent="play()"
                <?php endif; ?>
                x-show="!playing"
                class="group absolute inset-0 block focus-visible:outline-4 focus-visible:-outline-offset-4 focus-visible:outline-gyc-aqua">
                <?php if ($poster): ?>
                    <img
                        class="absolute inset-0 h-full w-full object-cover motion-safe:transition-transform duration-500 ease-out motion-safe:group-hover:scale-105"
                        src="<?php echo esc_url($poster); ?>"
                        alt="<?php echo esc_attr($video_url ? '' : $poster_alt); ?>"
                        loading="lazy"
                        decoding="async"
                        draggable="false" />
                <?php else: ?>
                    <span class="absolute inset-0 bg-linear-to-br from-[#1d3fa8] via-[#0e1f5c] to-[#050b1c]" aria-hidden="true"></span>
                <?php endif; ?>

                <span class="absolute inset-0 bg-linear-to-t from-black/50 via-transparent to-transparent" aria-hidden="true"></span>

                <?php if ($video_url): ?>
                    <span class="absolute left-1/2 top-1/2 flex h-14 w-14 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full border-2 border-white/90 bg-black/20 text-white backdrop-blur-sm motion-safe:transition-colors group-hover:bg-gyc-teal group-hover:border-gyc-teal" aria-hidden="true">
                        <svg class="ml-0.5 h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5.5v13l11-6.5z"></path></svg>
                    </span>
                <?php endif; ?>
            </<?php echo $video_url ? 'a' : 'div'; ?>>
        </div>

        <div class="lg:col-span-5 flex items-center px-6 md:px-0 lg:pl-14 py-14 lg:py-10">
            <div class="max-w-md space-y-5">
                <?php if ($eyebrow): ?>
                    <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/80"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 id="gyc-video-title" class="font-display text-5xl md:text-6xl uppercase leading-none text-gyc-ink whitespace-pre-line"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($text): ?>
                    <p class="font-jakarta text-base leading-relaxed text-gyc-ink/85 whitespace-pre-line"><?php echo esc_html($text); ?></p>
                <?php endif; ?>

                <?php if ($link_label && $link_url): ?>
                    <a
                        href="<?php echo esc_url($link_url); ?>"
                        <?php if ($link_is_external): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
                        class="inline-flex items-center gap-3 border-b-2 border-gyc-teal pb-1.5 font-jakarta text-xs font-bold uppercase tracking-[0.2em] text-gyc-teal motion-safe:transition-colors hover:text-gyc-teal-dark hover:border-gyc-teal-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                        <?php echo esc_html($link_label); ?>
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"></path></svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
